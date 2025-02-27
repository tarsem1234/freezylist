<?php

namespace Tests\Backend\Routes\Access;

use Tests\BrowserKitTestCase;

/**
 * Class RoleRouteTest.
 */
class RoleRouteTest extends BrowserKitTestCase
{
    public function testRolesIndex(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/role')->see('Role Management');
    }

    public function testCreateRole(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/role/create')->see('Create Role');
    }

    public function testEditRole(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/role/'.$this->adminRole->id.'/edit')
            ->see('Edit Role')
            ->see($this->adminRole->name);
    }
}
