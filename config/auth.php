<?php

use App\Models\Access\User\User;

return [

    'guards' => [
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

];
