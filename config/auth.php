<?php

return [



    'defaults' => [
        'guard' => 'ANNTStore',
        'passwords' => 'users',
    ],


    // dùng để xác định guard nào sẽ được sử dụng
    'guards' => [
        'ANNTStore' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

    ],



    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Users::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],




    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],



    'password_timeout' => 10800,

];
