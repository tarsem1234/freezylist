<?php

namespace Tests\Backend\Access;

use Tests\BrowserKitTestCase;

/**
 * Class AccessHelperTest.
 */
class AccessHelperTest extends BrowserKitTestCase
{
    public function testAccessUser(): void
    {
        $this->actingAs($this->user);
        $this->assertEquals(auth()->user(), access()->user());
    }

    public function testAccessGuest(): void
    {
        $this->assertEquals(auth()->guest(), access()->guest());
    }

    public function testAccessLogout(): void
    {
        $this->actingAs($this->user);
        $this->assertFalse(access()->guest());
        access()->logout();
        $this->assertTrue(access()->guest());
    }

    public function testAccessGetsUserId(): void
    {
        $this->actingAs($this->user);
        $this->assertEquals(auth()->id(), access()->id());
    }

    public function testAccessLogsUserInById(): void
    {
        access()->loginUsingId(3);
        $this->assertEquals(auth()->user(), access()->user());
    }

    public function testAccessHasRole(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->hasRole('Executive'));
        $this->assertFalse(access()->hasRole('Administrator'));
        $this->assertTrue(access()->hasRole(2));
        $this->assertFalse(access()->hasRole(1));
    }

    public function testAdminHasAllRoles(): void
    {
        $this->actingAs($this->admin);
        $this->assertTrue(access()->hasRole('Administrator'));
        $this->assertTrue(access()->hasRole('Non-Existing Role'));
        $this->assertTrue(access()->hasRole(1));
        $this->assertTrue(access()->hasRole(123));
    }

    public function testAccessHasRoles(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->hasRoles(['Executive', 'User']));
        $this->assertTrue(access()->hasRoles([2, 3]));
    }

    public function testAccessHasRolesNeedsAll(): void
    {
        $this->actingAs($this->executive);
        $this->assertFalse(access()->hasRoles(['Executive', 'User'], true));
        $this->assertFalse(access()->hasRoles([2, 3], true));
    }

    public function testAccessAllow(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->allow('view-backend'));
        $this->assertTrue(access()->allow(1));
    }

    public function testAdminHasAllAccess(): void
    {
        $this->actingAs($this->admin);
        $this->assertTrue(access()->allow('view-backend'));
        $this->assertTrue(access()->allow('view-something-that-doesnt-exist'));
        $this->assertTrue(access()->allow(1));
        $this->assertTrue(access()->allow(123));
    }

    public function testAccessAllowMultiple(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->allowMultiple(['view-backend']));
        $this->assertTrue(access()->allowMultiple([1]));
    }

    public function testAccessAllowMultipleNeedsAll(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->allowMultiple(['view-backend'], true));
        $this->assertTrue(access()->allowMultiple([1], true));
    }

    public function testAccessHasPermission(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->hasPermission('view-backend'));
        $this->assertTrue(access()->hasPermission(1));
    }

    public function testAccessHasPermissions(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->hasPermissions(['view-backend']));
        $this->assertTrue(access()->hasPermissions([1]));
    }

    public function testAccessHasPermissionsNeedsAll(): void
    {
        $this->actingAs($this->executive);
        $this->assertTrue(access()->hasPermissions(['view-backend'], true));
        $this->assertTrue(access()->hasPermissions([1], true));
    }
}
