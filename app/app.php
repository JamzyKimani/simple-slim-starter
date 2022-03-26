<?php 

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use App\Providers\ServiceProvider;

$app = SlimAppFactory::create(new Container);

ServiceProvider::setup($app, config('app.providers'));

$app->setBasePath('/'.env( 'APP_FOLDER', '' ));

return $app;
