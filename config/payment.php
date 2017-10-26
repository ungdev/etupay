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
    'payline' => [
                'env' => env('PAYLINE_ENV', 'PROD'),
                'merchant_id' => env('PAYLINE_MERCHANT_ID'),
                'acces_key' =>  env('PAYLINE_ACCESS_KEY'),
                'contract_number'   => env('PAYLINE_CONTRACT'),
                'max_amount'    => 150000,
                'min_amount'    => 100,
    ],
    'gateway' => [
        //\App\PaymentProvider\AtosProvider::class,
        'Paypal'    =>  \App\PaymentProvider\PaypalProvider::class,
        'devMode'   =>  \App\PaymentProvider\DevProvider::class,
        'Payline'   =>  \App\PaymentProvider\PaylineProvider::class,
    ],

];