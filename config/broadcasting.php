<?php


return [

    'default' => env('BROADCAST_DRIVER', 'null'),

    'connections' => [

        'reverb' => [
            'driver' => 'pusher',
            'key' => env('REVERB_APP_KEY'),
            'secret' => env('REVERB_APP_SECRET'),
            'app_id' => env('REVERB_APP_ID'),
            'options' => [
                'host' => env('REVERB_HOST', '127.0.0.1'),
                'port' => env('REVERB_PORT', 8080),
                'useTLS' => env('REVERB_USE_TLS', false),
            ]
        ],

    ],

];
