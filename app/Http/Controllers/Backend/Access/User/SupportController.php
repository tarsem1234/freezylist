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

class SupportController extends Controller
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
        $supportUsers = User::whereHas('roles',
            function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Support'));
            })->where('status', 1)->get();

        return view('backend.access.support_index', compact('supportUsers'));
    }

    public function create(): View
    {
        $support = true;

        return view('backend.access.support_create', compact('support'))
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

        return redirect()->route('admin.access.support.index')->withFlashSuccess(trans('alerts.backend.users.created'));
    }

    public function deactivated(ManageUserRequest $request): View
    {
        $support = true;
        $supportUsers = User::whereHas('roles',
            function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Support'));
            })->where('status', 0)->get();

        return view('backend.access.support_deactivated', compact('support', 'supportUsers'));
    }

    public function deleted(ManageUserRequest $request): View
    {
        $support = true;
        $supportUsers = User::whereHas('roles',
            function ($query) {
                $query->where('role_id', config('constant.inverse_user_type.Support'));
            })->onlyTrashed()->get();

        return view('backend.access.support_deleted', compact('support', 'supportUsers'));
    }
}
