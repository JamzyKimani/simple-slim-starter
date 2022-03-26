<?php

return [
    'providers' => [
        \App\Providers\EnvironmentVariablesServiceProvider::class, //always place higher than error middleware
        \App\Providers\ErrorMiddlewareServiceProvider::class,
        \App\Providers\DatabaseServiceProvider::class
    ]
];
