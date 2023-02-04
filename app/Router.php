<?php
/**
 * Custom router which handles default middlewares, default exceptions and things
 * that should be happen before and after the router is initialised.
 */
namespace App;

use Pecee\SimpleRouter\SimpleRouter;
use Dotenv\Dotenv;

class Router extends SimpleRouter
{
    /**
     * @throws \Exception
     * @throws \Pecee\Http\Middleware\Exceptions\TokenMismatchException
     * @throws \Pecee\SimpleRouter\Exceptions\HttpException
     * @throws \Pecee\SimpleRouter\Exceptions\NotFoundHttpException
     */
    public static function start(): void
	{   
		// Load our helpers
		require_once 'helpers.php';

		//load ENV variables form .env file
        try {
            $env = Dotenv::createImmutable(base_path());
            $env->load();
        } catch (InvalidPathException $e) { }

		// Load our custom routes
		require_once '../routes/web.php';

		// Do initial stuff
		parent::start();
	}

}