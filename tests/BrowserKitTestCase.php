<?php

namespace Tests;

use App\Models\Access\Role\Role;
use App\Models\Access\User\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

/**
 * Class TestCase.
 */
abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://l5boilerplate.dev';

    protected $admin;

    protected $executive;

    protected $user;

    protected $adminRole;

    protected $executiveRole;

    protected $userRole;

    /**
     * Set up tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->baseUrl = config('app.url', 'http://l5boilerplate.dev');

        // Set up the database
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        // Run the tests in English
        App::setLocale('en');

        /*
         * Create class properties to be used in tests
         */
        $this->admin = User::find(1);
        $this->executive = User::find(2);
        $this->user = User::find(3);
        $this->adminRole = Role::find(1);
        $this->executiveRole = Role::find(2);
        $this->userRole = Role::find(3);
    }

    protected function tearDown(): void
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }
}
