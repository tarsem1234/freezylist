<?php

use Illuminate\Support\Facades\Facade;

return [

    'locale_php' => env('APP_LOCALE_PHP', 'en_US'),

    'log' => env('APP_LOG', 'daily'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    'aliases' => Facade::defaultAliases()->merge([
        'Active' => HieuLe\Active\Facades\Active::class,
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Location' => Stevebauman\Location\Facades\Location::class,
        'NoCaptcha' => Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
        'PDF' => Barryvdh\Snappy\Facades\SnappyPdf::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'SnappyImage' => Barryvdh\Snappy\Facades\SnappyImage::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'DataTables' => Yajra\DataTables\Facades\DataTables::class,
    ])->toArray(),

];
