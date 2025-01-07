<?php

namespace Tests\Backend\Access\Role;

use App\Models\Access\Permission\Permission;
use Tests\BrowserKitTestCase;

class RolePermissionTest extends BrowserKitTestCase
{
    public function testSavePermissionsToRole(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->permissions()->sync([1]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testEmptyPermissionsFromRole(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->permissions()->sync([1]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->permissions()->sync([]);
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testAttachPermissionToRoleById(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermission(1);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testAttachPermissionToRoleByObject(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermission(Permission::findOrFail(1));
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testDetachPermissionFromRoleById(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermission(1);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->detachPermission(1);
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testDetachPermissionFromRoleByObject(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermission(Permission::findOrFail(1));
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->detachPermission(Permission::findOrFail(1));
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testAttachPermissionsToRoleById(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermissions([1]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testAttachPermissionsToRoleByObject(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermissions([Permission::findOrFail(1)]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testDetachPermissionsFromRoleById(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermissions([1]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->detachPermissions([1]);
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }

    public function testDetachPermissionsFromRoleByObject(): void
    {
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->attachPermissions([Permission::findOrFail(1)]);
        $this->seeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
        $this->userRole->detachPermissions([Permission::findOrFail(1)]);
        $this->notSeeInDatabase(config('access.permission_role_table'), ['permission_id' => 1, 'role_id' => $this->userRole->id]);
    }
}
