<?php

use App\Http\Controllers\Search;
use Illuminate\Support\Facades\Route;

Route::prefix('search')->name('search.')->group(function () {

    /*
     * Search Specific Functionality
     */
    Route::get('/', [Search\SearchController::class, 'index'])->name('index');
});
