<?php

namespace App\Http\Controllers\Backend\Access\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Access\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Access\Role\UpdateRoleRequest;
use App\Models\Access\Role\Role;
use App\Repositories\Backend\Access\Permission\PermissionRepository;
use App\Repositories\Backend\Access\Role\RoleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class RoleController.
 */
class RoleController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    public function __construct(RoleRepository $roles, PermissionRepository $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    public function index(ManageRoleRequest $request): View
    {
        $roles = Role::latest()->get();

        return view('backend.access.roles.index', ['roles' => $roles]);
    }

    public function create(ManageRoleRequest $request): View
    {
        return view('backend.access.roles.create')
            ->with('permissions', $this->permissions->getAll())
            ->with('role_count', $this->roles->getCount());
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->roles->create($request->only('name', 'associated-permissions', 'permissions', 'sort'));

        return redirect()->route('admin.access.role.index')->withFlashSuccess(trans('alerts.backend.roles.created'));
    }

    public function edit(Role $role, ManageRoleRequest $request): View
    {
        return view('backend.access.roles.edit')
            ->with('role', $role)
            ->with('role_permissions', $role->permissions->pluck('id')->all())
            ->with('permissions', $this->permissions->getAll());
    }

    public function update(Role $role, UpdateRoleRequest $request): RedirectResponse
    {
        $this->roles->update($role, $request->only('name', 'associated-permissions', 'permissions', 'sort'));

        return redirect()->route('admin.access.role.index')->withFlashSuccess(trans('alerts.backend.roles.updated'));
    }

    public function destroy(Role $role, ManageRoleRequest $request): RedirectResponse
    {
        $this->roles->delete($role);

        return redirect()->route('admin.access.role.index')->withFlashSuccess(trans('alerts.backend.roles.deleted'));
    }
}
