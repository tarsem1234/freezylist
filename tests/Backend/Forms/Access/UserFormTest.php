<?php

namespace Tests\Backend\Forms\Access;

use App\Events\Backend\Access\User\UserCreated;
use App\Events\Backend\Access\User\UserDeleted;
use App\Events\Backend\Access\User\UserPasswordChanged;
use App\Events\Backend\Access\User\UserUpdated;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\BrowserKitTestCase;

/**
 * Class UserFormTest.
 */
class UserFormTest extends BrowserKitTestCase
{
    public function testCreateUserRequiredFields(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/create')
            ->type('', 'first_name')
            ->type('', 'last_name')
            ->type('', 'email')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('Create')
            ->see('The first name field is required.')
            ->see('The last name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.');
    }

    public function testCreateUserPasswordsDoNotMatch(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/create')
            ->type('Test', 'first_name')
            ->type('User', 'last_name')
            ->type('test@test.com', 'email')
            ->type('123456', 'password')
            ->type('1234567', 'password_confirmation')
            ->press('Create')
            ->see('The password confirmation does not match.');
    }

    public function testCreateUserConfirmedForm(): void
    {
        // Make sure our events are fired
        Event::fake();

        // Create any needed resources
        $faker = Faker\Factory::create();
        $firstName = $faker->firstName();
        $lastName = $faker->lastName();
        $email = $faker->safeEmail();
        $password = $faker->password(8);

        $this->actingAs($this->admin)
            ->visit('/admin/access/user/create')
            ->type($firstName, 'first_name')
            ->type($lastName, 'last_name')
            ->type($email, 'email')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->seeIsChecked('status')
            ->seeIsChecked('confirmed')
            ->dontSeeIsChecked('confirmation_email')
            ->check('assignees_roles[2]')
            ->check('assignees_roles[3]')
            ->press('Create')
            ->seePageIs('/admin/access/user')
            ->see('The user was successfully created.')
            ->seeInDatabase(config('access.users_table'),
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'status' => 1,
                    'confirmed' => 1,
                ])
            ->seeInDatabase(config('access.role_user_table'), ['user_id' => 4, 'role_id' => 2])
            ->seeInDatabase(config('access.role_user_table'), ['user_id' => 4, 'role_id' => 3]);

        Event::assertDispatched(UserCreated::class);
    }

    public function testCreateUserUnconfirmedForm(): void
    {
        // Make sure our events are fired
        Event::fake();

        // Make sure our notifications are sent
        Notification::fake();

        // Create any needed resources
        $faker = Faker\Factory::create();
        $firstName = $faker->firstName();
        $lastName = $faker->lastName();
        $email = $faker->safeEmail();
        $password = $faker->password(8);

        $this->actingAs($this->admin)
            ->visit('/admin/access/user/create')
            ->type($firstName, 'first_name')
            ->type($lastName, 'last_name')
            ->type($email, 'email')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->seeIsChecked('status')
            ->uncheck('confirmed')
            ->check('confirmation_email')
            ->check('assignees_roles[2]')
            ->check('assignees_roles[3]')
            ->press('Create')
            ->seePageIs('/admin/access/user')
            ->see('The user was successfully created.')
            ->seeInDatabase(config('access.users_table'),
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'status' => 1,
                    'confirmed' => 0,
                ])
            ->seeInDatabase(config('access.role_user_table'), ['user_id' => 4, 'role_id' => 2])
            ->seeInDatabase(config('access.role_user_table'), ['user_id' => 4, 'role_id' => 3]);

        // Get the user that was inserted into the database
        $user = User::where('email', $email)->first();

        // Check that the user was sent the confirmation email
        Notification::assertSentTo([$user],
            UserNeedsConfirmation::class);

        Event::assertDispatched(UserCreated::class);
    }

    public function testCreateUserFailsIfEmailExists(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/create')
            ->type('User', 'first_name')
            ->type('Surname', 'last_name')
            ->type('user@user.com', 'email')
            ->type('123456', 'password')
            ->type('123456', 'password_confirmation')
            ->press('Create')
            ->seePageIs('/admin/access/user/create')
            ->see('The email has already been taken.');
    }

    public function testUpdateUserRequiredFields(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/3/edit')
            ->type('', 'first_name')
            ->type('', 'last_name')
            ->type('', 'email')
            ->press('Update')
            ->see('The first name field is required.')
            ->see('The last name field is required.')
            ->see('The email field is required.');
    }

    public function testUpdateUserForm(): void
    {
        // Make sure our events are fired
        Event::fake();

        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/edit')
            ->see($this->user->first_name)
            ->see($this->user->last_name)
            ->see($this->user->email)
            ->type('User', 'first_name')
            ->type('New', 'last_name')
            ->type('user2@user.com', 'email')
            ->uncheck('status')
            ->check('assignees_roles[2]')
            ->uncheck('assignees_roles[3]')
            ->press('Update')
            ->seePageIs('/admin/access/user')
            ->see('The user was successfully updated.')
            ->seeInDatabase(config('access.users_table'),
                [
                    'id' => $this->user->id,
                    'first_name' => 'User',
                    'last_name' => 'New',
                    'email' => 'user2@user.com',
                    'status' => 0,
                ])
            ->seeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => 2])
            ->notSeeInDatabase(config('access.role_user_table'), ['user_id' => $this->user->id, 'role_id' => 3]);

        Event::assertDispatched(UserUpdated::class);
    }

    public function testDeleteUserForm(): void
    {
        // Make sure our events are fired
        Event::fake();

        $this->actingAs($this->admin)
            ->delete('/admin/access/user/'.$this->user->id)
            ->assertRedirectedTo('/admin/access/user/deleted')
            ->notSeeInDatabase(config('access.users_table'), ['id' => $this->user->id, 'deleted_at' => null]);

        Event::assertDispatched(UserDeleted::class);
    }

    public function testUserCanNotDeleteSelf(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user')
            ->delete('/admin/access/user/'.$this->admin->id)
            ->assertRedirectedTo('/admin/access/user')
            ->seeInDatabase(config('access.users_table'), ['id' => $this->admin->id, 'deleted_at' => null])
            ->seeInSession(['flash_danger' => 'You can not delete yourself.']);
    }

    public function testChangeUserPasswordRequiredFields(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('Change Password for '.$this->user->name)
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('Update')
            ->seePageIs('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('The password field is required.');
    }

    public function testChangeUserPasswordForm(): void
    {
        // Make sure our events are fired
        Event::fake();

        $password = '87654321';

        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('Change Password for '.$this->user->name)
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press('Update')
            ->seePageIs('/admin/access/user')
            ->see('The user\'s password was successfully updated.');

        Event::assertDispatched(UserPasswordChanged::class);
    }

    public function testChangeUserPasswordDoNotMatch(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('Change Password for '.$this->user->name)
            ->type('123456', 'password')
            ->type('1234567', 'password_confirmation')
            ->press('Update')
            ->seePageIs('/admin/access/user/'.$this->user->id.'/password/change')
            ->see('The password confirmation does not match.');
    }
}
