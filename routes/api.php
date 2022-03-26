<?php 

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\WelcomeController;

return function (App $app ) {
	$app->group('/api', function (RouteCollectorProxy $group) {

	    $group->get('/check', function ($request, $response) {
	        $response->getBody()->write("The API is live");
            return $response;
	    })->setName('api-is-live');

	    $group->get('/bind/{name}', [WelcomeController::class, 'show']);

	});

};

?>