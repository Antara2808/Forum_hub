<?php

namespace Core;

/**
 * Base Controller Class
 * All controllers extend this class
 */
class Controller {
    
    /**
     * Load view
     */
    protected function view($view, $data = []) {
        // Extract data array to variables
        extract($data);
        
        // Check if view file exists
        $viewFile = APP_PATH . '/Views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View not found: " . $view);
        }
    }

    /**
     * Load model
     */
    protected function model($model) {
        $modelFile = APP_PATH . '/Models/' . $model . '.php';
        
        if (file_exists($modelFile)) {
            require_once $modelFile;
            $modelClass = 'Models\\' . $model;
            return new $modelClass();
        } else {
            die("Model not found: " . $model);
        }
    }

    /**
     * JSON response
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Check if user is logged in
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get current user ID
     */
    protected function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current user data
     */
    protected function getUser() {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Check if user has role
     */
    protected function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        return $_SESSION['user']['role'] === $role;
    }

    /**
     * Check if user is admin
     */
    protected function isAdmin() {
        return $this->hasRole(ROLE_ADMIN);
    }

    /**
     * Check if user is moderator or admin
     */
    protected function isModerator() {
        return $this->hasRole(ROLE_MODERATOR) || $this->isAdmin();
    }

    /**
     * Require authentication
     */
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            Router::redirect('/auth/login');
        }
    }

    /**
     * Require admin role
     */
    protected function requireAdmin() {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            http_response_code(403);
            die('Access Denied');
        }
    }

    /**
     * Require moderator role
     */
    protected function requireModerator() {
        $this->requireAuth();
        if (!$this->isModerator()) {
            http_response_code(403);
            die('Access Denied');
        }
    }

    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken() {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
        }
        return $_SESSION[CSRF_TOKEN_NAME];
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrfToken($token) {
        if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
            return false;
        }
        return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
    }

    /**
     * Sanitize input
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate email
     */
    protected function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Flash message
     */
    protected function flash($key, $message = null) {
        if ($message === null) {
            $message = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $message;
        }
        $_SESSION['flash'][$key] = $message;
    }

    /**
     * Get POST data
     */
    protected function post($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Get GET data
     */
    protected function get($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
}
