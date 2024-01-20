<?php

// root.php

// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Import necessary classes and namespaces
use Controllers\ApiController;
use Routing\Router;
use Models\Item; // Make sure to include the Item class

// Get request method and URI
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Get the path without query parameters
$path = parse_url($requestUri, PHP_URL_PATH);
$parts = explode('/', trim($path, '/'));

// Keep only the first two parts
$filteredParts = array_slice($parts, 3, 4);

// Reconstruct the path
$filteredPath = implode('/', $filteredParts);

// Define your routes
$routes = include_once __DIR__ . '/routes/routes.php';

// Instantiate the Router and ApiController with routes
$router = new Router($routes);
$itemModel = new Item(); // Instantiate the Item class

// Instantiate the ApiController with dependency injection
$apiController = new ApiController($router, $itemModel);

// Handle the request
$apiController->handleRequest($requestMethod, $filteredPath);
