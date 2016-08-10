<?php

return [
    'atos' => [
                'merchand_id'   => env('ATOS_MARCHANTID'),
                'pathfile'      => env('ATOS_PATHFILE'),
                'requestPath'   => env('ATOS_REQUEST'),
                'responsePath'  => env('ATOS_RESPONSE'),
                'isDebug'       => env('ATOS_DEBUG', false),
                'currencies'    => env('ATOS_CURRENCIES', 'EUR'),
                'max_amount'    => 1000000,
                'min_amount'    => 100,
                'callback_url'  => env('APP_URL').'/atos/callback',
                'cancel_url'    => env('APP_URL').'/atos/callback',
                'return_url'    => env('APP_URL').'/atos/callback',
                ],
    'gateway' => [
        \App\PaymentProvider\AtosProvider::class,
    ],

];