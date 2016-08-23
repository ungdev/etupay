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
                ],
    'paypal' => [
                'clientId'      => env('PAYPAL_CLIENTID'),
                'clientSecret'  => env('PAYPAL_SECRET'),
    ],
    'gateway' => [
        \App\PaymentProvider\AtosProvider::class,
        \App\PaymentProvider\PaypalProvider::class,
    ],

];