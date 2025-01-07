<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Repositories\Backend\Access\User\UserRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class UserTableController.
 */
class UserTableController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function __invoke(ManageUserRequest $request)
    {
        $users = $this->users->getForDataTable($request->get('status'),
            $request->get('trashed'));
        if ($request->get('role', 0) != '') {
            $role = $request->get('role');
            $users->whereHas('roles',
                function ($query) use ($role) {
                    return $query->where('role_id', $role);
                });
        }

        // dd($users);
        return DataTables::of($users)
            ->escapeColumns(['first_name', 'last_name', 'email'])
            ->addColumn('company_name', function ($user) {
                return getFullName($user);
            })
            ->addColumn('full_name', function ($user) {
                return getFullName($user);
            })
            ->editColumn('confirmed',
                function ($user) {
                    return $user->confirmed_label;
                })
            ->addColumn('roles',
                function ($user) {
                    return $user->roles->count() ?
                        implode('<br/>', $user->roles->pluck('name')->toArray())
                            :
                        trans('labels.general.none');
                })
            ->addColumn('social',
                function ($user) {
                    $accounts = [];

                    // Note: If you have a provider that does not have a corresponding
                    // font-awesome icon, you can override it here
                    foreach ($user->providers as $social) {
                        $accounts[] = '<a href="'.route('admin.access.user.social.unlink',
                            [$user, $social]).'" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.unlink').'" data-method="delete"><i class="fa fa-'.$social->provider.'"></i></a>';
                    }

                    return count($accounts) ? implode(' ', $accounts) : 'None';
                })
            ->addColumn('actions',
                function ($user) {
                    return $user->action_buttons;
                })
            ->setRowClass(function ($user) {
                return ! $user->isConfirmed() && config('access.users.requires_approval')
                        ? 'danger' : '';
            })
            ->withTrashed()
            ->make(true);
    }
}
