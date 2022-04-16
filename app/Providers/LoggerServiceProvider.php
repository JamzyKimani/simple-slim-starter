<?php 

namespace App\Providers;

use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

class LoggerServiceProvider extends ServiceProvider 
{
    public function register() {
        $this->app->getContainer()->set(LoggerInterface::class, function () {

                $loggerSettings = config('app.errors.logger'); 
                $logger = new Logger($loggerSettings['name']);
    
                $processor = new UidProcessor();
                $logger->pushProcessor($processor);
    
                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);                
                $logger->pushHandler($handler);
    
                return $logger;
           
        });
    }

    public function boot() {

    }

}