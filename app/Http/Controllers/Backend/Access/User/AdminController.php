<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected $users;

    protected $roles;

    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function index(Request $request): View
    {
        $adminUsers = User::whereHas('roles',
            function ($query) {
                $query->where('name', 'Administrator');
            })
            ->with('business_profile', 'user_profile')->where('status', 1)->get();

        return view('backend.access.admin_index', compact('adminUsers'));
    }

    public function create(): View
    {
        $admin = true;

        return view('backend.access.admin_create', compact('admin'))
            ->with('roles', $this->roles->getAll());
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->users->create(
            [
                'data' => $request->only(
                    'first_name', 'last_name', 'email', 'password', 'status',
                    'confirmed', 'confirmation_email'
                ),
                'roles' => $request->only('assignees_roles'),
            ]);

        return redirect()->route('admin.access.admin.index')->withFlashSuccess(trans('alerts.backend.users.created'));
    }

    public function deactivated(ManageUserRequest $request): View
    {
        $admin = true;
        $adminUsers = User::whereHas('roles',
            function ($query) {
                $query->where('name', 'Administrator');
            })
            ->with('business_profile', 'user_profile')->where('status', 0)->get();

        return view('backend.access.admin_deactivated', compact('admin', 'adminUsers'));
    }

    public function deleted(ManageUserRequest $request): View
    {
        $admin = true;
        $adminUsers = User::whereHas('roles',
            function ($query) {
                $query->where('name', 'Administrator');
            })
            ->with('business_profile', 'user_profile')->onlyTrashed()->get();

        return view('backend.access.admin_deleted', compact('admin', 'adminUsers'));
    }
}
