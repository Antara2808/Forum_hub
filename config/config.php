<?php
/**
 * ForumHub Pro - Configuration File
 * Database and application settings
 */

// Environment
define('ENVIRONMENT', 'development'); // development | production

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'forumhub_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Settings
define('APP_NAME', 'ForumHub Pro');
define('APP_URL', 'http://localhost/ForumHub/public');
define('APP_VERSION', '2.0.0');

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('ASSET_PATH', PUBLIC_PATH . '/assets');

// URLs
define('BASE_URL', '/ForumHub/public');
define('ASSET_URL', BASE_URL . '/assets');
define('UPLOAD_URL', BASE_URL . '/uploads');

// Security
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_LIFETIME', 7200); // 2 hours

// File Upload Settings
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_DOC_TYPES', ['pdf', 'doc', 'docx', 'txt']);

// Pagination
define('THREADS_PER_PAGE', 15);
define('POSTS_PER_PAGE', 20);
define('MESSAGES_PER_PAGE', 25);

// Reputation Points
define('POINTS_CREATE_THREAD', 5);
define('POINTS_CREATE_POST', 2);
define('POINTS_RECEIVE_UPVOTE', 1);
define('POINTS_RECEIVE_DOWNVOTE', -1);

// Reputation Ranks
define('REPUTATION_RANKS', [
    'Newbie' => 0,
    'Bronze' => 50,
    'Silver' => 150,
    'Gold' => 300,
    'Platinum' => 600,
    'Diamond' => 1000,
    'Legend' => 2000
]);

// User Roles
define('ROLE_USER', 'user');
define('ROLE_MODERATOR', 'moderator');
define('ROLE_ADMIN', 'admin');

// Timezone
date_default_timezone_set('UTC');

// Error Reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Session Configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Strict');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
