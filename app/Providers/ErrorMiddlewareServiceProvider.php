<?php

namespace App\Providers;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Psr\Log\LoggerInterface;

use Throwable;

use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

class ErrorMiddlewareServiceProvider extends ServiceProvider
{
    public function register()
    {   
        if(env('APP_DEBUG', false)) {
            /**
             * DEV ENV: if APP_DEBUG is true in .env, display pretty errors on screen
             * */
            $this->app->add(new WhoopsMiddleware());
        } else {
            /**
             * PROD ENV: if APP_DEBUG is false in .env, display custom error page, log errors in logs/app.log
             * */

            // Define Custom Error Handler
            $app = $this->app;
            $customErrorHandler = function (
                ServerRequestInterface $request,
                Throwable $exception,
                bool $displayErrorDetails,
                bool $logErrors,
                bool $logErrorDetails,
                ?LoggerInterface $logger = null
            ) 
            use ($app) 
            {
                //logger supplied by logger service provider
                $logger = $app->getContainer()->get(LoggerInterface::class);
                $logger->error($exception->getMessage());
                
                $response = $app->getResponseFactory()->createResponse();
                if ($exception instanceof HttpNotFoundException) {
                    return view($response, '404');
                }

                return view($response, '500');

            };

            // Add Error Middleware
            $errorSettings = config('app.errors');
            $errorMiddleware = $app->addErrorMiddleware($errorSettings['displayErrorDetails'],$errorSettings['logError'],$errorSettings['logErrorDetails']);
            $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
        }

    }

    public function boot()
    {
        //
    }
}
