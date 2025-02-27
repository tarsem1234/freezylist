<?php

namespace Tests\Backend\Routes\Access;

use App\Events\Backend\Access\User\UserDeactivated;
use App\Events\Backend\Access\User\UserPermanentlyDeleted;
use App\Events\Backend\Access\User\UserReactivated;
use App\Events\Backend\Access\User\UserRestored;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\BrowserKitTestCase;

/**
 * Class UserRouteTest.
 */
class UserRouteTest extends BrowserKitTestCase
{
    public function testActiveUsers(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/user')->see('Active Users');
    }

    public function testDeactivatedUsers(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/user/deactivated')->see('Deactivated Users');
    }

    public function testDeletedUsers(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/user/deleted')->see('Deleted Users');
    }

    public function testCreateUser(): void
    {
        $this->actingAs($this->admin)->visit('/admin/access/user/create')->see('Create User');
    }

    public function testViewUser(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id)
            ->see('View User')
            ->see('Overview')
            ->see('History')
            ->see($this->user->first_name)
            ->see($this->user->last_name)
            ->see($this->user->email);
    }

    public function testEditUser(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/edit')
            ->see('Edit User')
            ->see($this->user->first_name)
            ->see($this->user->last_name)
            ->see($this->user->email);
    }

    public function testChangeUserPassword(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('Change Password for '.$this->user->full_name);
    }

    public function testResendUserConfirmationEmail(): void
    {
        config(['access.users.confirm_email' => true]);
        config(['access.users.requires_approval' => false]);

        Notification::fake();
        $this->actingAs($this->admin)
            ->visit('/admin/access/user')
            ->visit('/admin/access/user/'.$this->user->id.'/account/confirm/resend')
            ->seePageIs('/admin/access/user')
            ->see('A new confirmation e-mail has been sent to the address on file.');
        Notification::assertSentTo($this->user, UserNeedsConfirmation::class);
    }

    public function testLoginAsUser(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/login-as')
            ->seePageIs('/dashboard')
            ->see('You are currently logged in as '.$this->user->full_name.'.')
            ->see($this->admin->full_name)
            ->assertTrue(access()->id() == $this->user->id);
    }

    public function testCantLoginAsSelf(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->admin->id.'/login-as')
            ->see('Do not try to login as yourself.');
    }

    public function testLogoutAsUser(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/login-as')
            ->seePageIs('/dashboard')
            ->see('You are currently logged in as '.$this->user->full_name.'.')
            ->click('Re-Login as '.$this->admin->full_name)
            ->seePageIs('/admin/access/user')
            ->assertTrue(access()->id() == $this->admin->id);
    }

    public function testDeactivateReactivateUser(): void
    {
        // Make sure our events are fired
        Event::fake();

        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/mark/0')
            ->seePageIs('/admin/access/user/deactivated')
            ->see('The user was successfully updated.')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'status' => 0])
            ->visit('/admin/access/user/'.$this->user->id.'/mark/1')
            ->seePageIs('/admin/access/user')
            ->see('The user was successfully updated.')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'status' => 1]);

        Event::assertDispatched(UserDeactivated::class);
        Event::assertDispatched(UserReactivated::class);
    }

    public function testRestoreUser(): void
    {
        // Make sure our events are fired
        Event::fake();

        $this->user->deleted_at = Carbon::now();
        $this->user->save();

        $this->actingAs($this->admin)
            ->notSeeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null])
            ->visit('/admin/access/user/'.$this->user->id.'/restore')
            ->seePageIs('/admin/access/user')
            ->see('The user was successfully restored.')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null]);

        Event::assertDispatched(UserRestored::class);
    }

    public function testUserIsDeletedBeforeBeingRestored(): void
    {
        $this->actingAs($this->admin)
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null])
            ->visit('/admin/access/user')
            ->visit('/admin/access/user/'.$this->user->id.'/restore')
            ->seePageIs('/admin/access/user')
            ->see('This user is not deleted so it can not be restored.')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null]);
    }

    public function testPermanentlyDeleteUser(): void
    {
        // Make sure our events are fired
        Event::fake();

        $this->actingAs($this->admin)
            ->delete('/admin/access/user/'.$this->user->id)
            ->notSeeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null])
            ->visit('/admin/access/user/'.$this->user->id.'/delete')
            ->seePageIs('/admin/access/user/deleted')
            ->see('The user was deleted permanently.')
            ->notSeeInDatabase(config('access.users_table'), ['id' => $this->user->id]);

        Event::assertDispatched(UserPermanentlyDeleted::class);
    }

    public function testUserIsDeletedBeforeBeingPermanentlyDeleted(): void
    {
        $this->actingAs($this->admin)
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null])
            ->visit('/admin/access/user')
            ->visit('/admin/access/user/'.$this->user->id.'/delete')
            ->seePageIs('/admin/access/user')
            ->see('This user must be deleted first before it can be destroyed permanently.')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null]);
    }

    public function testCantNotDeactivateSelf(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user')
            ->visit('/admin/access/user/'.$this->admin->id.'/mark/0')
            ->seePageIs('/admin/access/user')
            ->see('You can not do that to yourself.');
    }
}
