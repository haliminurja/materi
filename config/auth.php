<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'company'),
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'company',
        ],
    ],
    'providers' => [
        'company' => [
            'driver' => 'eloquent',
            'model' => App\Models\company::class,
        ],
    ],
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
