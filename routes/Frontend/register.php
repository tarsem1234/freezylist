<?php

use App\Http\Controllers\Frontend\RegisterController;
use Illuminate\Support\Facades\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::get('user/signup', [RegisterController::class, 'userCreate'])->name('userCreate');
Route::post('user/store', [RegisterController::class, 'userstore'])->name('userStore');
Route::get('business/signup', [RegisterController::class, 'businessCreate'])->name('businessCreate');
//ajax industries --> services
Route::get('business/services', [RegisterController::class, 'businessServices'])->name('businessServices');

//Route::get('rent/create', 'PropertyController@rentCreate')->name('rentCreate');
//Route::post('rent/store', 'PropertyController@propertyStore')->name('rentStore');
//
//Route::get('sale/create', 'PropertyController@saleCreate')->name('saleCreate');
//Route::post('sale/store', 'PropertyController@propertyStore')->name('saleStore');
//
//Route::get('vacation/create', 'PropertyController@vacationCreate')->name('vacationCreate');
//Route::post('vacation/store', 'PropertyController@propertyStore')->name('vacationStore');
