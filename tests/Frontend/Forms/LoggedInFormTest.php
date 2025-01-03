<?php

namespace Tests\Frontend\Forms;

use Tests\BrowserKitTestCase;

/**
 * Class LoggedInFormTest.
 */
class LoggedInFormTest extends BrowserKitTestCase
{
    /**
     * Test that the errors work if nothing is filled in the update account form.
     */
    public function testUpdateProfileRequiredFields(): void
    {
        if (config('access.users.change_email')) {
            $this->actingAs($this->user)
                ->visit('/account')
                ->type('', 'first_name')
                ->type('', 'last_name')
                ->type('', 'email')
                ->press('update-profile')
                ->seePageIs('/account')
                ->see('The first name field is required.')
                ->see('The last name field is required.')
                ->see('The email field is required.');
        } else {
            $this->actingAs($this->user)
                ->visit('/account')
                ->type('', 'first_name')
                ->type('', 'last_name')
                ->press('update-profile')
                ->seePageIs('/account')
                ->see('The first name field is required.')
                ->see('The last name field is required.');
        }
    }

    /**
     * Test that we can target the update profile form and update the profile
     * Based on whether the user is allowed to alter their email address or not.
     */
    public function testUpdateProfileForm(): void
    {
        $rand = rand();

        if (config('access.users.change_email')) {
            $this->actingAs($this->user)
                ->visit('/account')
                ->see('My Account')
                ->type($this->user->first_name.'_'.$rand, 'first_name')
                ->type($this->user->last_name.'_'.$rand, 'last_name')
                ->type('2_'.$this->user->email, 'email')
                ->press('update-profile')
                ->seePageIs('/account')
                ->see('Profile successfully updated.')
                ->seeInDatabase(config('access.users_table'),
                    [
                        'email' => '2_'.$this->user->email,
                        'first_name' => $this->user->first_name.'_'.$rand,
                        'last_name' => $this->user->last_name.'_'.$rand,
                    ]);
        } else {
            $this->actingAs($this->user)
                ->visit('/account')
                ->see('My Account')
                ->type($this->user->first_name.'_'.$rand, 'first_name')
                ->type($this->user->last_name.'_'.$rand, 'last_name')
                ->press('update-profile')
                ->seePageIs('/account')
                ->see('Profile successfully updated.')
                ->seeInDatabase(config('access.users_table'),
                    [
                        'first_name' => $this->user->first_name.'_'.$rand,
                        'last_name' => $this->user->last_name.'_'.$rand,
                    ]);
        }
    }

    /**
     * Test that the errors work if nothing is filled in the change password form.
     */
    public function testChangePasswordRequiredFields(): void
    {
        $this->actingAs($this->user)
            ->visit('/account')
            ->type('', 'old_password')
            ->type('', 'password')
            ->type('', 'password_confirmation')
            ->press('change-password')
            ->seePageIs('/account')
            ->see('The old password field is required.')
            ->see('The password field is required.');
    }

    /**
     * Test that the frontend change password form works.
     */
    public function testChangePasswordForm(): void
    {
        $password = '87654321';

        $this->actingAs($this->user)
            ->visit('/account')
            ->see('My Account')
            ->type('1234', 'old_password')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press('change-password')
            ->seePageIs('/account')
            ->see('Password successfully updated.');
    }
}
