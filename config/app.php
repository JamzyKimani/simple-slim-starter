<?php

return [
    'providers' => [
        \App\Providers\EnvironmentVariablesServiceProvider::class, 
        \App\Providers\DatabaseServiceProvider::class,
        \App\Providers\LoggerServiceProvider::class,
        \App\Providers\ErrorMiddlewareServiceProvider::class //always place lowest so that it can catch errors generated by highier service providers
    ],

    'errors' => [
        'displayErrorDetails' => true, // Should be set to false in production
        'logError'            => true,
        'logErrorDetails'     => true,
        'logger' => [
            'name' => 'starterapp',
            'path' =>  __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ]
    ],
];
