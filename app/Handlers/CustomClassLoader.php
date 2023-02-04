<?php 

namespace App\Handlers;

use App\Container;
use App\Session;

use Medoo\Medoo;

use DI\ContainerBuilder;
use function DI\object as di_object;
use function DI\factory;
use function DI\get;
use function DI\create;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;

use Pecee\SimpleRouter\ClassLoader\IClassLoader;

use Pecee\SimpleRouter\Exceptions\ClassNotFoundHttpException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class CustomClassLoader implements IClassLoader
{

    protected $container;

    public function __construct()
    {
        // Create our new php-di container
        $this->container = (new ContainerBuilder())
            ->useAutowiring(true)
            ->addDefinitions([

	            Medoo::class => function () 
	            {
	                return new Medoo([
	                    'type' => env('DB_TYPE', 'mysql') ,
						'host' => env('DB_HOST', 'localhost'),
						'database' => env('DB_NAME', 'test'),
						'username' => env('DB_USERNAME', 'test'),
						'password' => env('DB_PASSWORD', 'Test@123?!'),
	                ]);
	            },

	            'logger' =>  function () 
	            {
	                $loggerSettings = config('app.errors.logger'); 
	                $logger = new Logger($loggerSettings['name']);
	    
	                $processor = new UidProcessor();
	                $logger->pushProcessor($processor);
	    
	                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);               
	                $logger->pushHandler($handler);
	                return $logger;
        		}, 

                'Session' => function () {
                    return new Session();
                }

	        ])
            ->build();

            Container::setInstance($this->container);
    }

    /**
     * Load class
     *
     * @param string $class
     * @return object
     * @throws NotFoundHttpException
     */
    public function loadClass(string $class)
    {
        if (class_exists($class) === false) {
            throw new NotFoundHttpException(sprintf('Class "%s" does not exist', $class), 404);
        }

		try {
			return $this->container->get($class);
		} catch (\Exception $e) {
			throw new NotFoundHttpException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
		}
    }
    
    /**
     * Called when loading class method
     * @param object $class
     * @param string $method
     * @param array $parameters
     * @return object
     */
    public function loadClassMethod($class, string $method, array $parameters)
    {
		try {
			return $this->container->call([$class, $method], $parameters);
		} catch (\Exception $e) {
			throw new NotFoundHttpException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
		}
    }

    /**
     * Load closure
     *
     * @param Callable $closure
     * @param array $parameters
     * @return mixed
     */
    public function loadClosure(callable $closure, array $parameters)
    {
		try {
			return $this->container->call($closure, $parameters);
		} catch (\Exception $e) {
			throw new NotFoundHttpException($e->getMessage(), (int)$e->getCode(), $e->getPrevious());
		}
    }
}