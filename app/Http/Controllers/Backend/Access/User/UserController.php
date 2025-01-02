<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\User\StoreUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Models\Access\User\User;
use App\Models\BusinessProfile;
use App\Models\Industry;
use App\Models\Property;
use App\Models\RentOffer;
use App\Models\SaleOffer;
use App\Models\UserProfile;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var RoleRepository
     */
    protected $roles;

    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request): View
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->with('user_profile')->where('status', 1)->get();

        return view('backend.access.index', compact('users'));
    }

    //    public function index(ManageUserRequest $request)
    //    {
    //        return view('backend.access.index');
    //    }

    public function create(ManageUserRequest $request): View
    {
        return view('backend.access.create')
            ->with('roles', $this->roles->getAll());
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->users->create(
            [
                'data' => $request->only(
                    'first_name', 'last_name', 'email', 'password', 'status', 'confirmed', 'confirmation_email'
                ),
                'roles' => $request->only('assignees_roles'),
            ]);
        if ($request->submit == 'Administrator') {

            return redirect()->route('admin.access.admin.index')->withFlashSuccess(trans('alerts.backend.users.created'));
        }
        if ($request->submit == 'Support') {

            return redirect()->route('admin.access.support.index')->withFlashSuccess('Support user created.');
        }

        return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.created'));
    }

    public function show(User $user, ManageUserRequest $request): View
    {
        $admin = false;
        $business = false;
        $support = false;
        if ($user->hasRole(config('constant.user_type.4'))) {
            $support = true;
        }
        if ($user->hasRole(config('constant.user_type.3')) && ! ($user->hasRole(config('constant.user_type.2')))) {

        }
        if ($user->hasRole(config('constant.user_type.2')) && ! $user->hasRole(config('constant.user_type.3'))) {
            $business = true;
        }
        if ($user->hasRole(config('constant.user_type.2')) && $user->hasRole(config('constant.user_type.3'))) {
            $admin = true;
        }
        $user = User::where('id', $user->id)->with('user_profile', 'user_profile.user_interests', 'business_profile.industry.services')->first();

        return view('backend.access.show', compact('admin', 'support', 'business'))
            ->with('user', $user);
    }

    public function edit(User $user, ManageUserRequest $request): View
    {
        $userFullData = $user->where('id', $user->id)->whereHas('user_profile')->with('user_profile')->first();
        $userWithBusiness = $user->where('id', $user->id)->whereHas('business_profile')->with('business_profile')->first();

        $userWithUser = '';
        $businessIndustry = '';
        if ($userFullData) {
            $userWithUser = $userFullData;
        }
        if ($userWithBusiness) {
            $userWithUser = $userWithBusiness;
            //            dd($userWithBusiness);
            $businessIndustry = Industry::where('id', $userWithBusiness->business_profile['industry_id'])->first();
        }
        $industries = Industry::get();
        //        dd($user->hasRole(config('constant.user_type.2')));
        $admin = false;
        $business = false;
        $support = false;
        if ($user->hasRole(config('constant.user_type.4'))) {
            $support = true;
        }
        if ($user->hasRole(config('constant.user_type.3')) && ! ($user->hasRole(config('constant.user_type.2')))) {

        }
        if ($user->hasRole(config('constant.user_type.2')) && ! $user->hasRole(config('constant.user_type.3'))) {
            $business = true;
        }
        if ($user->hasRole(config('constant.user_type.2')) && $user->hasRole(config('constant.user_type.3'))) {
            $admin = true;
        }

        // dd($userWithUser);
        return view('backend.access.edit', ['userWithUser' => $userWithUser, 'industries' => $industries,
            'businessIndustry' => $businessIndustry, 'business' => $business, 'admin' => $admin, 'support' => $support])
            ->with('user', $user)
            ->with('user_roles', $user->roles->pluck('id')->all())
            ->with('roles', $this->roles->getAll());
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {
        $userWithBusiness = $user->where('id', $user->id)->with('business_profile')->first();
        $userFullData = $user->where('id', $user->id)->with('user_profile')->first();

        foreach ($request->assignees_roles as $role) {
            //create or update business
            if ($role == config('constant.inverse_user_type.Business')) {
                //                if ($userWithBusiness->business_profile) {
                $checkIfIndustry = Industry::where('id', $request->industry)->first();
                if ($checkIfIndustry) {
                    $input['industry_id'] = $checkIfIndustry->id;
                }

                $input['company_name'] = $request->company_name;
                $input['user_id'] = $user->id;

                if (BusinessProfile::updateOrCreate(['id' => $userWithBusiness->business_profile->id ?? 0], $input)) {
                    $this->users->update($user, ['data' => $request->only(
                        'first_name', 'last_name', 'email', 'city', 'status', 'confirmed'
                    ),
                        'roles' => $request->only('assignees_roles'),
                    ]);

                    return redirect()->route('admin.access.business.index')->withFlashSuccess(trans('alerts.backend.users.updated'));
                }

                return redirect()->back()->withFlashDanger('User is not updated.');
            }

            //create or update user/admin
            if ($role == config('constant.inverse_user_type.User')) {
                $input['full_name'] = $request->name;
                $input['user_id'] = $user->id;
                UserProfile::updateOrCreate(['id' => $userFullData->user_profile->id ?? 0], $input);
            }

            $this->users->update($user, [
                'data' => $request->only(
                    'first_name', 'last_name', 'email', 'city', 'phone_no', 'status', 'confirmed'
                ),
                'roles' => $request->only('assignees_roles'),
            ]);
            if ($request->submit == 'Administrator') {
                $admin = true;

                return redirect()->route('admin.access.admin.index')->with(compact('admin'))->withFlashSuccess(trans('alerts.backend.users.updated'));
            } elseif ($request->submit == 'Support') {
                $support = true;

                return redirect()->route('admin.access.support.index')->with(compact('support'))->withFlashSuccess(trans('alerts.backend.users.updated'));
            }

            return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.updated'));
        }

        $this->users->update($user, [
            'data' => $request->only(
                'first_name', 'last_name', 'email', 'status', 'confirmed'
            ),
            'roles' => $request->only('assignees_roles'),
        ]);

        return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.updated'));
    }

    public function destroy(User $user, ManageUserRequest $request): RedirectResponse
    {
        $rentOffer = RentOffer::where('status', config('constant.inverse_rent_offer_status.accepted'))
            ->whereHas('property', function ($query) {
                $query->where('status', config('constant.inverse_property_status.In Progress'));
            })
            ->where(function ($query) use ($user) {
                $query->where('owner_id', $user->id)
                    ->orWhere('buyer_id', $user->id)
                    ->orWhere(function ($query) use ($user) {
                        $query->whereHas('landlordQuestionnaire', function ($query) use ($user) {
                            $query->whereIn('partners', [$user->id]);
                        })->orWhereHas('tenantQuestionnaire', function ($query) use ($user) {
                            $query->whereIn('partners', [$user->id]);
                        });
                    });
            })
            ->get();

        $saleOffer = SaleOffer::where('status', config('constant.inverse_offer_status.accepted'))
            ->whereHas('property', function ($query) {
                $query->where('status', config('constant.inverse_property_status.In Progress'));
            })
            ->where(function ($query) use ($user) {
                $query->where('owner_id', $user->id)
                    ->orWhere('sender_id', $user->id)
                    ->orWhere(function ($query) use ($user) {
                        $query->whereHas('sellerQuestionnaire', function ($query) use ($user) {
                            $query->whereIn('partners', [$user->id]);
                        })->orWhereHas('buyerQuestionnaire', function ($query) use ($user) {
                            $query->whereIn('partners', [$user->id]);
                        });
                    });
            })
            ->get();

        // Start transaction
        DB::beginTransaction();
        try {

            if (! empty($saleOffer)) {
                foreach ($saleOffer as $soffer) {

                    //update property table
                    Property::where('id', $soffer->property_id)->update(['status' => config('constant.inverse_property_status.Available')]);
                    //update sale offer
                    SaleOffer::where('id', $soffer->id)->update(['status' => config('constant.inverse_offer_status.user_deleted')]);
                }

            }

            if (! empty($rentOffer)) {
                foreach ($rentOffer as $roffer) {
                    Property::where('id', $roffer->property_id)->update(['status' => config('constant.inverse_property_status.Available')]);
                    //update sale offer
                    RentOffer::where('id', $roffer->id)->update(['status' => config('constant.inverse_rent_offer_status.user_deleted')]);
                }
            }
            $this->users->delete($user);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            // dd($e->getMessage());
            return redirect()->back()->withFlashSuccess("Oops Something went wrong!!! Please try again later , user can't deleted");
        }

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.deleted'));
    }
}
