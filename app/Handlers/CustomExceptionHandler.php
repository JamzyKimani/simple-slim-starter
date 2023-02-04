<?php
namespace App\Handlers;

use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;

use Monolog\Logger;

class CustomExceptionHandler implements IExceptionHandler
{   

    /**
     * @param Request $request
     * @param \Exception $error
     * @throws \Exception
     */
    public function handleError( Request $request, \Exception $error): void
	{
       
       if(env('APP_DEBUG', false) === true) {

  
            /**
             * DEV ENV: if APP_DEBUG is true in .env, display errors on screen
             * */
            throw $error;

        } else {
				
        	/**
             * PROD ENV: if APP_DEBUG is false in .env, display custom error page, log errors in logs/app.log
             * */

        	/* You can use the exception handler to format errors depending on the request and type. */
        	/* log error in a log file */
			
			

			if ($request->getUrl()->contains('/api')) {

				response()->json([
					'error' => $error->getMessage(),
					'code'  => $error->getCode(),
				]);

			}

			/* The router will throw the NotFoundHttpException on 404 */
			if($error instanceof NotFoundHttpException) {

				/*
				 * Render your own custom 404-view, rewrite the request to another route,
				 * or simply return the $request object to ignore the error and continue on rendering the route.
				 *
				 * The code below will make the router render our page.notfound route.
				 */


				$request->setRewriteCallback('DefaultController@notFound');
				return;

			}
			
			$logger = container('logger');
			$logger->error($error->getMessage());
			throw $error;

			
            
            
        }

		

	}

}