<?php

namespace App\Repositories\Backend\Access\User;

use App\Events\Backend\Access\User\UserConfirmed;
use App\Events\Backend\Access\User\UserCreated;
use App\Events\Backend\Access\User\UserDeactivated;
use App\Events\Backend\Access\User\UserDeleted;
use App\Events\Backend\Access\User\UserPasswordChanged;
use App\Events\Backend\Access\User\UserPermanentlyDeleted;
use App\Events\Backend\Access\User\UserReactivated;
use App\Events\Backend\Access\User\UserRestored;
use App\Events\Backend\Access\User\UserUnconfirmed;
use App\Events\Backend\Access\User\UserUpdated;
use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Notifications\Backend\Access\UserAccountActive;
use App\Notifications\Frontend\Auth\BusinessNeedsRegistration;
use App\Notifications\Frontend\Auth\SenderNeedsRegistration;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = User::class;

    /**
     * @var RoleRepository
     */
    protected $role;

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getByPermission($permissions, string $by = 'name')
    {
        if (! is_array($permissions)) {
            $permissions = [$permissions];
        }

        return $this->query()->whereHas('roles.permissions',
            function ($query) use ($permissions, $by) {
                $query->whereIn('permissions.'.$by, $permissions);
            })->get();
    }

    /**
     * @return mixed
     */
    public function getByRole($roles, string $by = 'name')
    {
        if (! is_array($roles)) {
            $roles = [$roles];
        }

        return $this->query()->whereHas('roles',
            function ($query) use ($roles, $by) {
                $query->whereIn('roles.'.$by, $roles);
            })->get();
    }

    /**
     * @return mixed
     */
    public function getForDataTable(int $status = 1, bool $trashed = false)
    {
        /**
         * Note: You must return deleted_at or the User getActionButtonsAttribute won't
         * be able to differentiate what buttons to show for each row.
         */
        $dataTableQuery = $this->query()
            ->with('roles', 'business_profile')
            ->select([
                config('access.users_table').'.id',
                config('access.users_table').'.first_name',
                config('access.users_table').'.last_name',
                config('access.users_table').'.email',
                config('access.users_table').'.status',
                config('access.users_table').'.confirmed',
                config('access.users_table').'.created_at',
                config('access.users_table').'.updated_at',
                config('access.users_table').'.deleted_at',
            ]);

        if ($trashed == 'true') {
            return $dataTableQuery->onlyTrashed();
        }

        // active() is a scope on the UserScope trait
        return $dataTableQuery->active($status);
    }

    /**
     * @return mixed
     */
    public function getUnconfirmedCount()
    {
        return $this->query()->where('confirmed', 0)->count();
    }

    public function create(array $input)
    {
        $data = $input['data'];
        $roles = $input['roles'];

        $user = $this->createUserStub($data);

        DB::transaction(function () use ($user, $roles) {
            if ($user->save()) {
                //User Created, Validate Roles
                if (! count($roles['assignees_roles'])) {
                    throw new GeneralException(trans('exceptions.backend.access.users.role_needed_create'));
                }

                //Attach new roles
                $user->attachRoles($roles['assignees_roles']);

                //Send confirmation email if requested and account approval is off
                //                if (isset($data['confirmation_email']) && $user->confirmed == 0 && ! config('access.users.requires_approval')) {
                //                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                //                }

                event(new UserCreated($user));
                //send registration email
                if ($user && $roles) {
                    //                    foreach ($roles as $role) {
                    //                        $givenRole = $role;
                    //                    }
                    if (isset($roles['assignees_roles'][3]) && $roles['assignees_roles'][3]
                        == config('constant.inverse_user_type.User')) {
                        $user->notify(new SenderNeedsRegistration($user));
                    }
                    if (isset($roles['assignees_roles'][2]) && $roles['assignees_roles'][2]
                        == config('constant.inverse_user_type.Business')) {
                        $user->notify(new BusinessNeedsRegistration($user));
                    }
                }

                return $user;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @throws GeneralException
     */
    public function update(Model $user, array $input)
    {
        $data = $input['data'];
        $roles = $input['roles'];
        // dd($data);
        // dd($user->hasRole(config('constant.inverse_user_type.Support')));
        $this->checkUserByEmail($data, $user);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = strtolower($data['email']);
        $user->status = isset($data['status']) ? 1 : 0;
        $user->city = $data['city'] ?? null;
        if (! ($user->hasRole(config('constant.inverse_user_type.Business')))) {
            if ($user->hasRole(config('constant.inverse_user_type.Support'))) {

            } else {
                $user->phone_no = $data['phone_no'];
            }

        }
        DB::transaction(function () use ($user, $roles) {
            if ($user->save()) {
                $this->checkUserRolesCount($roles);
                $this->flushRoles($roles, $user);

                event(new UserUpdated($user));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @throws GeneralException
     */
    public function updatePassword(Model $user, $input): bool
    {
        $user->password = Hash::make($input['password']);

        if ($user->save()) {
            event(new UserPasswordChanged($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.update_password_error'));
    }

    /**
     * @throws GeneralException
     */
    public function delete(Model $user): bool
    {
        if (access()->id() == $user->id) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_delete_self'));
        }

        if ($user->id == 1) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_delete_admin'));
        }

        if ($user->delete()) {
            //event(new UserDeleted($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
    }

    /**
     * @throws GeneralException
     */
    public function forceDelete(Model $user)
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.delete_first'));
        }

        DB::transaction(function () use ($user) {
            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return true;
            }

            throw new GeneralException(trans('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @throws GeneralException
     */
    public function restore(Model $user): bool
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            // event(new UserRestored($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @throws GeneralException
     */
    public function mark(Model $user, $status): bool
    {
        if (access()->id() == $user->id && $status == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.cant_deactivate_self'));
        }

        $user->status = $status;

        switch ($status) {
            case 0:
                event(new UserDeactivated($user));
                break;

            case 1:
                event(new UserReactivated($user));
                break;
        }

        if ($user->save()) {
            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.mark_error'));
    }

    /**
     * @throws GeneralException
     */
    public function confirm(Model $user): bool
    {
        if ($user->confirmed == 1) {
            throw new GeneralException(trans('exceptions.backend.access.users.already_confirmed'));
        }

        $user->confirmed = 1;
        $confirmed = $user->save();

        if ($confirmed) {
            event(new UserConfirmed($user));

            // Let user know their account was approved
            if (config('access.users.requires_approval')) {
                $user->notify(new UserAccountActive);
            }

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.cant_confirm'));
    }

    /**
     * @throws GeneralException
     */
    public function unconfirm(Model $user): bool
    {
        if ($user->confirmed == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.not_confirmed'));
        }

        if ($user->id == 1) {
            // Cant un-confirm admin
            throw new GeneralException(trans('exceptions.backend.access.users.cant_unconfirm_admin'));
        }

        if ($user->id == access()->id()) {
            // Cant un-confirm self
            throw new GeneralException(trans('exceptions.backend.access.users.cant_unconfirm_self'));
        }

        $user->confirmed = 0;
        $unconfirmed = $user->save();

        if ($unconfirmed) {
            event(new UserUnconfirmed($user));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.cant_unconfirm')); // TODO
    }

    /**
     * @throws GeneralException
     */
    protected function checkUserByEmail($input, $user)
    {
        //Figure out if email is not the same
        if ($user->email != $input['email']) {
            //Check to see if email exists
            if ($this->query()->where('email', '=', $input['email'])->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }

    protected function flushRoles($roles, $user)
    {
        //Flush roles out, then add array of new ones
        $user->detachRoles($user->roles);
        $user->attachRoles($roles['assignees_roles']);
    }

    /**
     * @throws GeneralException
     */
    protected function checkUserRolesCount($roles)
    {
        //User Updated, Update Roles
        //Validate that there's at least one role chosen
        if (count($roles['assignees_roles']) == 0) {
            throw new GeneralException(trans('exceptions.backend.access.users.role_needed'));
        }
    }

    /**
     * @return mixed
     */
    protected function createUserStub($input)
    {
        $user = self::MODEL;
        $user = new $user;
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = strtolower($input['email']);
        $user->password = Hash::make($input['password']);
        $user->status = isset($input['status']) ? 1 : 0;
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;

        return $user;
    }
}
