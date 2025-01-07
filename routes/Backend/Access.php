<?php

use App\Http\Controllers\Access;
use App\Http\Controllers\Backend\Access\Role\RoleController;
use App\Http\Controllers\Backend\Access\Role\RoleTableController;
use App\Http\Controllers\Backend\Access\User\AdminController;
use App\Http\Controllers\Backend\Access\User\BusinessController;
use App\Http\Controllers\Backend\Access\User\SupportController;
use App\Http\Controllers\Backend\Access\User\UserAccessController;
// use App\Http\Controllers\Backend\Access\User\UserController;
use App\Http\Controllers\Backend\Access\User\UserConfirmationController;
use App\Http\Controllers\Backend\Access\User\UserController;
use App\Http\Controllers\Backend\Access\User\UserPasswordController;
use App\Http\Controllers\Backend\Access\User\UserSessionController;
use App\Http\Controllers\Backend\Access\User\UserStatusController;
use App\Http\Controllers\Backend\Access\User\UserTableController;
use Illuminate\Support\Facades\Route;

/**
 * All route names are prefixed with 'admin.access'.
 */
Route::prefix('access')->name('access.')->group(function () {

    /*
     * User Management
     */
    Route::middleware('access.routeNeedsRole:1')->group(function () {
        /*
         * For DataTables
         */
        Route::post('user/get', UserTableController::class)->name('user.get');

        /*
         * User Status'
         */
        Route::get('user/deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
        Route::get('user/deleted', [UserStatusController::class, 'getDeleted'])->name('user.deleted');

        /*
         * User CRUD
         */
        Route::resource('user', UserController::class);

        Route::get('business', [BusinessController::class, 'index'])->name('business.index');
        Route::get('business/create', [BusinessController::class, 'create'])->name('business.create');
        Route::post('business/store', [BusinessController::class, 'store'])->name('business.store');
        Route::get('business/show/{user}', [UserController::class, 'show'])->name('business.show');
        Route::get('business/{user}/edit', [UserController::class, 'edit'])->name('business.edit');
        Route::post('business/update', [BusinessController::class, 'update'])->name('business.update');
        Route::get('business/deactivated', [BusinessController::class, 'deactivated'])->name('business.deactivated');
        Route::get('business/deleted', [BusinessController::class, 'deleted'])->name('business.deleted');

        Route::get('admin/show/{user}', [UserController::class, 'show'])->name('admin.show');
        Route::get('admin/{user}/edit', [UserController::class, 'edit'])->name('admin.edit');
        Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::get('admin/deactivated', [AdminController::class, 'deactivated'])->name('admin.deactivated');
        Route::get('admin/deleted', [AdminController::class, 'deleted'])->name('admin.deleted');

        Route::get('support/show/{user}', [UserController::class, 'show'])->name('support.show');
        Route::get('support/{user}/edit', [UserController::class, 'edit'])->name('support.edit');
        Route::get('support', [SupportController::class, 'index'])->name('support.index');
        Route::get('support/create', [SupportController::class, 'create'])->name('support.create');
        Route::get('support/deactivated', [SupportController::class, 'deactivated'])->name('support.deactivated');
        Route::get('support/deleted', [SupportController::class, 'deleted'])->name('support.deleted');

        /*
         * Specific User
         */
        Route::prefix('user/{user}')->group(function () {
            // Account
            Route::get('account/confirm/resend', [UserConfirmationController::class, 'sendConfirmationEmail'])->name('user.account.confirm.resend');

            // Status
            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);

            // Social
            Route::delete('social/{social}/unlink', [UserSocialController::class, 'unlink'])->name('user.social.unlink');

            // Confirmation
            Route::get('confirm', [UserConfirmationController::class, 'confirm'])->name('user.confirm');
            Route::get('unconfirm', [UserConfirmationController::class, 'unconfirm'])->name('user.unconfirm');

            // Password
            Route::get('password/change', [UserPasswordController::class, 'edit'])->name('user.change-password');
            Route::patch('password/change', [UserPasswordController::class, 'update'])->name('user.change-password.post');

            // Access
            Route::get('login-as', [UserAccessController::class, 'loginAs'])->name('user.login-as');

            // Session
            Route::get('clear-session', [UserSessionController::class, 'clearSession'])->name('user.clear-session');
        });

        /*
         * Deleted User
         */
        Route::prefix('user/{deletedUser}')->group(function () {
            Route::get('delete', [UserStatusController::class, 'delete'])->name('user.delete-permanently');
            Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');
        });

        /*
        * Role Management
        */
        Route::resource('role', RoleController::class)->except('show');

        //For DataTables
        Route::post('role/get', RoleTableController::class)->name('role.get');
    });
});
