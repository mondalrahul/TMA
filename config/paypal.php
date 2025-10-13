<?php
return [
    // Client ID
    'client_id' => env('PAYPAL_CLIENT_ID'),
    // Secret app
    'secret' => env('PAYPAL_SECRET'),
    'settings' => [
        // PayPal mode, sanbox or live
        'mode' => env('PAYPAL_MODE'),
        // Seconds time connect
        'http.ConnectionTimeOut' => 30,
        // Write log
        'log.logEnabled' => true,
        // Log path
        'log.FileName' => storage_path() . '/logs/paypal.log',
        // Log type
        'log.LogLevel' => 'FINE'
    ],
];