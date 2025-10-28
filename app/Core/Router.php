<?php

namespace Core;

/**
 * Router Class
 * Handles routing and URL dispatching
 */
class Router {
    private $routes = [];
    private $notFoundCallback;

    /**
     * Add GET route
     */
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }

    /**
     * Add POST route
     */
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }

    /**
     * Add route with any method
     */
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    /**
     * Set 404 handler
     */
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
    }

    /**
     * Dispatch request
     */
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $requestUri = strtok($requestUri, '?');
        
        // Remove base path from URI (BASE_URL already includes /ForumHub/public)
        $basePath = BASE_URL;
        if (strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        
        // Ensure we have at least a forward slash
        if (empty($requestUri)) {
            $requestUri = '/';
        } else if ($requestUri[0] !== '/') {
            $requestUri = '/' . $requestUri;
        }
        
        // Normalize slashes
        $requestUri = '/' . trim($requestUri, '/');
        if ($requestUri !== '/') {
            // Keep it as is
        } else {
            $requestUri = '/';
        }
        
        // Match route
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = $this->convertToRegex($route['path']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove full match
                
                // Call the callback
                if (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $matches);
                } elseif (is_array($route['callback'])) {
                    $controller = new $route['callback'][0]();
                    $method = $route['callback'][1];
                    call_user_func_array([$controller, $method], $matches);
                }
                return;
            }
        }

        // No route matched - 404
        if ($this->notFoundCallback) {
            call_user_func($this->notFoundCallback);
        } else {
            http_response_code(404);
            echo "404 - Page Not Found";
        }
    }

    /**
     * Convert route path to regex pattern
     */
    private function convertToRegex($path) {
        // Escape forward slashes
        $pattern = preg_replace('/\//', '\\/', $path);
        
        // Convert :param to regex group
        $pattern = preg_replace('/\:([a-zA-Z0-9\_\-]+)/', '([a-zA-Z0-9\_\-]+)', $pattern);
        
        return '/^' . $pattern . '$/';
    }

    /**
     * Redirect to URL
     */
    public static function redirect($url) {
        if (strpos($url, 'http') !== 0) {
            $url = BASE_URL . $url;
        }
        header('Location: ' . $url);
        exit;
    }

    /**
     * Get current URL
     */
    public static function getCurrentUrl() {
        return $_SERVER['REQUEST_URI'];
    }
}
