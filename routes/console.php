<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::command('inspire')
//          ->hourly();
Schedule::call('\App\Http\Controllers\Frontend\CronController@checkBackToMarket')->daily();


// Schedule::command('inspire')
//          ->hourly();
Schedule::call('\App\Http\Controllers\Frontend\CronController@checkBackToMarket')->daily();
