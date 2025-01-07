<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;
use App\Models\Property;
use App\Models\RentOffer;
use App\Models\SaleOffer;
use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class UserStatusController.
 */
class UserStatusController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function getDeactivated(ManageUserRequest $request): View
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->with('user_profile')->where('status', 0)->get();

        return view('backend.access.deactivated', compact('users'));
    }

    public function getDeleted(ManageUserRequest $request): View
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })->with('user_profile')->onlyTrashed()->get();

        return view('backend.access.deleted', compact('users'));
    }

    public function mark(User $user, $status, ManageUserRequest $request): RedirectResponse
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

            $this->users->mark($user, $status);
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withFlashSuccess("Oops Something went wrong!!! Please try again later , user can't deleted");
        }

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.updated'));
    }

    public function delete(User $deletedUser, ManageUserRequest $request): RedirectResponse
    {
        $this->users->forceDelete($deletedUser);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.deleted_permanently'));
    }

    public function restore(User $deletedUser, ManageUserRequest $request): RedirectResponse
    {
        $this->users->restore($deletedUser);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.restored'));
    }
}
