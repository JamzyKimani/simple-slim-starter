<?php
use Slim\App;
use App\Controllers\WelcomeController;
use App\Controllers\ErrorController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



return function (App $app) {
	
	    $app->get('/', function (Request $request, Response $response) {
		    $name = 'James';
	        return view($response, 'home', compact('name'));
		});

		$app->get('/bind/{name}', [WelcomeController::class, 'show']);

		$app->get('/test-db', [WelcomeController::class, 'db']);
        
		//error pages
		$app->get('/404', [ErrorController::class, 'notFoundError'])->setName('404');
		$app->get('/500', [ErrorController::class, 'internalServerError'])->setName('500');
	
};