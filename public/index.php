<?php
/**
 * ForumHub Pro - Front Controller
 * Main entry point for all requests
 */

// Load configuration
require_once '../config/config.php';

// Autoloader
spl_autoload_register(function ($class) {
    $file = APP_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialize core classes
use Core\Router;
use Core\Database;

// Create router instance
$router = new Router();

// Route definitions will be loaded here
require_once APP_PATH . '/routes.php';

// Dispatch the request
$router->dispatch();
