<?php

namespace Tests\Backend\Access\User;

use Tests\BrowserKitTestCase;

/**
 * Class UserAccessTest.
 */
class UserAccessTest extends BrowserKitTestCase
{
    public function testUserCantAccessAdminDashboard(): void
    {
        $this->visit('/')
            ->actingAs($this->user)
            ->visit('/admin/dashboard')
            ->seePageIs('/dashboard')
            ->see('You do not have access to do that.');
    }

    public function testExecutiveCanAccessAdminDashboard(): void
    {
        $this->visit('/')
            ->actingAs($this->executive)
            ->visit('/admin/dashboard')
            ->seePageIs('/admin/dashboard')
            ->see($this->executive->name);
    }

    public function testExecutiveCantAccessManageRoles(): void
    {
        $this->visit('/')
            ->actingAs($this->executive)
            ->visit('/admin/dashboard')
            ->seePageIs('/admin/dashboard')
            ->visit('/admin/access/role')
            ->seePageIs('/admin/dashboard')
            ->see('You do not have access to do that.');
    }
}
