<?php

use App\Http\Controllers\Frontend\CronController;
use App\Http\Controllers\Frontend\LearningCenterController;
use App\Http\Controllers\Frontend\MessageController;
use App\Http\Controllers\Frontend\NetworkController;
use App\Http\Controllers\Frontend\PropertyController;
use App\Http\Controllers\Frontend\XmlFeedController;
use Illuminate\Support\Facades\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::get('cron-back-to-market', [CronController::class, 'checkBackToMarket'])->name('checkBackToMarket');
Route::middleware('auth')->group(function () {
    Route::middleware('OnlyUsers')->group(function () {
        /* Learning Center */
        Route::get('learning-center', [LearningCenterController::class, 'index'])->name('learning.center');
        Route::get('learning-center/learning_topic/{id}', [LearningCenterController::class, 'learningTopic'])->name('learning.topic');
        Route::get('learning-center/learning_session/{id}', [LearningCenterController::class, 'learningSession'])->name('learning.session');
        Route::get('learning-center/session/{id}/bonus', [LearningCenterController::class, 'learningSession'])->name('learning.bonus_session');
        Route::post('learning-center/learning_session/submit_answer', [LearningCenterController::class, 'submitAnswer'])->name('submit.answer');
        Route::get('property/{id}/manage-availablity/', [PropertyController::class, 'manageAvailabilty'])->name('manageAvailablity');
        Route::get('get-availability/{id}', [PropertyController::class, 'getVacationAvailability'])->name('getVacationAvailability');
    });
    /* Listing Availability */
    Route::post('property/add_availability', [PropertyController::class, 'addAvailability'])->name('property.add_availability');
    Route::post('property/get_availability', [PropertyController::class, 'getAvailability'])->name('property.getAvailabilities');
    Route::get('property/delete_availability/{id}', [PropertyController::class, 'destroyAvailability'])->name('property.destroyAvailability');
    Route::get('property/{id}/manage-vacation-availablity/', [PropertyController::class, 'manageVacationAvailabilty'])->name('manageVacationAvailabilty');
    Route::post('property/{id}/updateVacationDates/', [PropertyController::class, 'updateVacationDates'])->name('updateVacationDates');
    Route::get('property/confirm_availability/{id}', [PropertyController::class, 'confirmAvailability'])->name('confirmAvailability');

    /* Messages */
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
    Route::match(['post', 'get'], 'messages/new', [MessageController::class, 'composeNew'])->name('messages.new');
    Route::match(['post', 'get'], 'conversation/{id}', [MessageController::class, 'conversation'])->name('messages.conversation');
    Route::get('delete/{id}', [MessageController::class, 'delete'])->name('messages.delete');

    /* Rating */
    Route::post('business/rate_user', [MessageController::class, 'rateUser'])->name('rateUser');
    Route::get('business/reviews/{id}', [MessageController::class, 'userReviews'])->name('userReviews');
    /* Recommendation */
    Route::get('business/recommend/{id}', [NetworkController::class, 'recommendBusiness'])->name('recommendBusiness');
});

Route::match(['get', 'post'], 'xmlfeed', [XmlFeedController::class, 'index'])->name('xmlfeed');
