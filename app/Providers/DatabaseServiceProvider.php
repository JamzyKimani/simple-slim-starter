<?php 
namespace App\Providers;

use Medoo\Medoo;


class DatabaseServiceProvider extends ServiceProvider
{
    public function register()

    {
        $this->app->getContainer()->set(Medoo::class, function () {

        	return new Medoo([
					'type' => env('DB_TYPE', 'mysql') ,
					'host' => env('DB_HOST', 'localhost'),
					'database' => env('DB_NAME', 'test'),
					'username' => env('DB_USERNAME', 'test'),
					'password' => env('DB_PASSWORD', 'Test@123?!'),
				]);

   //          try {
   //          	$db = new Medoo([
			// 		'type' => env('DB_TYPE', 'mysql') ,
			// 		'host' => env('DB_HOST', 'localhost'),
			// 		'database' => env('DB_NAME', 'test'),
			// 		'username' => env('DB_USERNAME', 'test'),
			// 		'password' => env('DB_PASSWORD', 'Test@123?!'),
			// 	]);

			// 	return $db;

			// } catch ( Exception $e) {
			// 	dd($e->getMessage);
			// }
        });
    }

    public function boot()
    {

    }
}
