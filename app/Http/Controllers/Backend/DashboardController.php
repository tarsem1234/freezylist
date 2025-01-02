<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Models\Property;
use App\Models\VacationProperty;
use Illuminate\View\View;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        $usersObject = new User;
        //get business users
        $businessUsers = $usersObject->where('status', 1)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Business'));
            })->count();
        //get users
        $users = $usersObject->where('status', 1)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.User'));
            })->count();
        $adminUsers = $usersObject->where('status', 1)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Administrator'));
            })->count();

        //deactivated users
        $deactivatedUsers = $usersObject->where('status', 0)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.User'));
            })->count();
        $deactivatedAdminUsers = $usersObject->where('status', 0)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Administrator'));
            })->count();
        $deactivatedBusinessUsers = $usersObject->where('status', 0)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Business'));
            })->count();

        //get rent property
        $rents = Property::where('property_type',
            config('constant.inverse_property_type.Rent'))
            ->whereHas('architechture')
            ->whereHas('images')
            ->whereHas('additional_information')
            ->with(['architechture', 'images', 'additional_information'])->count();

        //get sale property
        $sales = Property::where('property_type',
            config('constant.inverse_property_type.Sale'))
            ->whereHas('architechture')
            ->whereHas('images')
            ->whereHas('additional_information')
            ->with(['architechture', 'images', 'additional_information'])->count();

        //get vacation property
        $vacations = VacationProperty::whereHas('images')->whereHas('availableWeeks')
            ->with('images', 'availableWeeks')->get()->count();

        return view('backend.dashboard',
            ['businessUsers' => $businessUsers, 'users' => $users, 'adminUsers' => $adminUsers,
                'rents' => $rents, 'sales' => $sales, 'vacations' => $vacations, 'deactivatedUsers' => $deactivatedUsers,
                'deactivatedAdminUsers' => $deactivatedAdminUsers, 'deactivatedBusinessUsers' => $deactivatedBusinessUsers]);
    }
}
