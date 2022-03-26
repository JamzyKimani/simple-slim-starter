<?php
use App\Application;

/**
 * Autoload global dependencies and allow for auto-loading local dependencies via use
 */
require __DIR__ . '/../vendor/autoload.php';


/**
 * Initialize the app and use PHP-DI to inject dependancies
 */
$app = require __DIR__ . '/../app/app.php';


/**
 * Web routes 
 */
$web_routes = require __DIR__ . '/../routes/web.php';
$web_routes($app);

/**
 * API routes 
 */
$API_routes = require __DIR__ . '/../routes/api.php';
$API_routes($app);



$app->run();

