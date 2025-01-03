<?php

namespace Tests\Frontend\Routes;

use App\Events\Frontend\Auth\UserConfirmed;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\BrowserKitTestCase;

/**
 * Class LoggedOutRouteTest.
 */
class LoggedOutRouteTest extends BrowserKitTestCase
{
    /**
     * User Logged Out Frontend.
     */

    /**
     * Test the homepage works.
     */
    public function testHomePage(): void
    {
        $this->visit('/')->assertResponseOk();
    }

    /**
     * Test the macro page works.
     */
    public function testMacroPage(): void
    {
        $this->visit('/macros')->see('Macro Examples');
    }

    public function testContactPage(): void
    {
        $this->visit('/contact')->see('Contact Us');
    }

    /**
     * Test the login page works.
     */
    public function testLoginPage(): void
    {
        $this->visit('/login')->see('Login');
    }

    /**
     * Test the register page works.
     */
    public function testRegisterPage(): void
    {
        $this->visit('/register')->see('Register');
    }

    /**
     * Test the forgot password page works.
     */
    public function testForgotPasswordPage(): void
    {
        $this->visit('password/reset')->see('Reset Password');
    }

    /**
     * Test the dashboard page redirects to login.
     */
    public function testDashboardPageLoggedOut(): void
    {
        $this->visit('/dashboard')->seePageIs('/login');
    }

    /**
     * Test the account page redirects to login.
     */
    public function testAccountPageLoggedOut(): void
    {
        $this->visit('/account')->seePageIs('/login');
    }

    /**
     * Create an unconfirmed user and assure the user gets
     * confirmed when hitting the confirmation route.
     */
    public function testConfirmAccountRoute(): void
    {
        Event::fake();

        // Create default user to test with
        $unconfirmed = User::factory()->unconfirmed()->create();
        $unconfirmed->attachRole(3); //User

        $this->visit('/account/confirm/'.$unconfirmed->confirmation_code)
            ->seePageIs('/login')
            ->see('Your account has been successfully confirmed!')
            ->seeInDatabase(config('access.users_table'), ['email' => $unconfirmed->email, 'confirmed' => 1]);

        Event::assertDispatched(UserConfirmed::class);
    }

    /**
     * Assure the user gets resent a confirmation email
     * after hitting the resend confirmation route.
     */
    public function testResendConfirmAccountRoute(): void
    {
        Notification::fake();

        $this->visit('/account/confirm/resend/'.$this->user->id)
            ->seePageIs('/login')
            ->see('A new confirmation e-mail has been sent to the address on file.');

        Notification::assertSentTo([$this->user],
            UserNeedsConfirmation::class);
    }

    /**
     * Test the language switcher changes the desired language in the session.
     */
    public function testLanguageSwitcher(): void
    {
        if (config('locale.status')) {
            $this->visit('lang/es')
                ->see('Registrarse')
                ->assertSessionHas('locale', 'es');

            App::setLocale('en');
        }
    }

    /**
     * Test the generic 404 page.
     */
    public function test404Page(): void
    {
        $response = $this->call('GET', '7g48hwbfw9eufj');
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertContains('Page Not Found', $response->getContent());
    }
}
