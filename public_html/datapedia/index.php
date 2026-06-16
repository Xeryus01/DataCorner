<?php

/**
 * Shared hosting deployment entry point.
 *
 * Expected structure:
 * ~/sistem_app/datapedia          => application code
 * ~/public_html/datapedia        => public web root
 */

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../../sistem_app/datapedia/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../../sistem_app/datapedia/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../../sistem_app/datapedia/bootstrap/app.php';

$app->handleRequest(\Illuminate\Http\Request::capture());
