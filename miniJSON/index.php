<?php

/**
 * miniJSON
 * - a very super simple, basic json php framework.
 */

error_reporting(E_ALL);

// New app
require 'app.php';
$app = new App();

// Set doc root
$root = '/miniJSONApp/miniJSON'; // Prod
$root = '/angularjs-crud-test/miniJSON'; // Dev

// Init routes, create router and route
require 'routes.php';
require 'router.php';
$router = new router($app, $root, $routes);
$router->route();

// PDO debug
//require 'pdo-debug.php';
