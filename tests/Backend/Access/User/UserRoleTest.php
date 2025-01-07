<?php

namespace Tests\Backend\Access\User;

use Tests\BrowserKitTestCase;

/**
 * Class UserRoleTest.
 */
class UserRoleTest extends BrowserKitTestCase
{
    public function testAttachRoleToUserById(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->attachRole($this->adminRole->id);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
    }

    public function testAttachRoleToUserByObject(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->attachRole($this->adminRole);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
    }

    public function testDetachRoleByIdFromUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->attachRole($this->adminRole->id);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->detachRole($this->adminRole->id);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
    }

    public function testDetachRoleByObjectFromUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->attachRole($this->adminRole);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->user->detachRole($this->adminRole);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
    }

    public function testAttachRolesByIdToUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->attachRoles([$this->adminRole->id, $this->executiveRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
    }

    public function testAttachRolesByObjectToUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->attachRoles([$this->adminRole, $this->executiveRole]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
    }

    public function testDetachRolesByIdFromUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->attachRoles([$this->adminRole->id, $this->executiveRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->detachRoles([$this->adminRole->id, $this->executiveRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
    }

    public function testDetachRolesByObjectFromUser(): void
    {
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->attachRoles([$this->adminRole, $this->executiveRole]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
        $this->user->detachRoles([$this->adminRole, $this->executiveRole]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->adminRole->id]);
        $this->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => $this->executiveRole->id]);
    }
}
