<?php
/**
 * Application Routes
 */

use Core\Router;

// Load helpers
require_once APP_PATH . '/Core/Helpers.php';

// ============================================
// Landing Page
// ============================================
$router->get('/', ['Controllers\HomeController', 'landing']);
$router->get('/home', ['Controllers\HomeController', 'index']);

// ============================================
// Authentication Routes
// ============================================
$router->get('/auth/login', ['Controllers\AuthController', 'login']);
$router->post('/auth/login', ['Controllers\AuthController', 'loginPost']);
$router->get('/auth/register', ['Controllers\AuthController', 'register']);
$router->post('/auth/register', ['Controllers\AuthController', 'registerPost']);
$router->get('/auth/logout', ['Controllers\AuthController', 'logout']);

// ============================================
// Thread Routes
// ============================================
$router->get('/threads', ['Controllers\ThreadController', 'index']);
$router->get('/threads/create', ['Controllers\ThreadController', 'create']);
$router->post('/threads/create', ['Controllers\ThreadController', 'store']);
$router->get('/threads/:id', ['Controllers\ThreadController', 'show']);
$router->get('/threads/:id/edit', ['Controllers\ThreadController', 'edit']);
$router->post('/threads/:id/edit', ['Controllers\ThreadController', 'update']);
$router->post('/threads/:id/delete', ['Controllers\ThreadController', 'delete']);
$router->post('/threads/bookmark', ['Controllers\ThreadController', 'toggleBookmark']);
$router->post('/threads/report', ['Controllers\ThreadController', 'report']);

// ============================================
// Tag Routes
// ============================================
$router->get('/tags/:id', ['Controllers\TagController', 'show']);
$router->get('/tags/search', ['Controllers\TagController', 'search']);
$router->get('/tags/popular', ['Controllers\TagController', 'popular']);

// ============================================
// Post Routes
// ============================================
$router->post('/posts/create', ['Controllers\PostController', 'store']);
$router->post('/posts/:id/edit', ['Controllers\PostController', 'update']);
$router->post('/posts/:id/delete', ['Controllers\PostController', 'delete']);

// ============================================
// User Profile Routes
// ============================================
$router->get('/profile/:id', ['Controllers\ProfileController', 'show']);
$router->get('/profile/:id/edit', ['Controllers\ProfileController', 'edit']);
$router->post('/profile/:id/edit', ['Controllers\ProfileController', 'update']);
$router->post('/profile/:id/remove-avatar', ['Controllers\ProfileController', 'removeAvatar']);
$router->post('/profile/:id/remove-banner', ['Controllers\ProfileController', 'removeBanner']);

// ============================================
// Message Routes
// ============================================
$router->get('/messages', ['Controllers\MessageController', 'index']);
$router->get('/messages/:id', ['Controllers\MessageController', 'conversation']);
$router->post('/messages/send', ['Controllers\MessageController', 'send']);
$router->get('/messages/unread', ['Controllers\MessageController', 'unreadCount']);

// ============================================
// Event Routes
// ============================================
$router->get('/events', ['Controllers\EventController', 'index']);
$router->get('/events/create', ['Controllers\EventController', 'create']);
$router->post('/events/create', ['Controllers\EventController', 'store']);
$router->get('/events/:id', ['Controllers\EventController', 'show']);

// ============================================
// Search Route
// ============================================
$router->get('/search', ['Controllers\SearchController', 'index']);

// ============================================
// Friend Routes
// ============================================
$router->get('/friends', ['Controllers\FriendController', 'index']);
$router->post('/friends/send', ['Controllers\FriendController', 'sendRequest']);
$router->post('/friends/accept', ['Controllers\FriendController', 'acceptRequest']);
$router->post('/friends/reject', ['Controllers\FriendController', 'rejectRequest']);
$router->post('/friends/remove', ['Controllers\FriendController', 'removeFriend']);

// ============================================
// API Routes
// ============================================
$router->get('/api/search-users', ['Controllers\FriendController', 'searchUsers']);

// Thread Interactions
$router->post('/api/threads/like', ['Controllers\ThreadController', 'toggleLike']);
$router->post('/api/threads/bookmark', ['Controllers\ThreadController', 'toggleBookmark']);

// Notifications
$router->get('/api/notifications', ['Controllers\NotificationController', 'index']);
$router->get('/api/notifications/unread-count', ['Controllers\NotificationController', 'unreadCount']);
$router->post('/api/notifications/:id/read', ['Controllers\NotificationController', 'markAsRead']);
$router->post('/api/notifications/mark-all-read', ['Controllers\NotificationController', 'markAllAsRead']);
$router->post('/api/notifications/:id/delete', ['Controllers\NotificationController', 'delete']);

// ============================================
// Report Routes
// ============================================
$router->post('/reports/create', ['Controllers\ReportController', 'create']);

// ============================================
// Admin Report Routes
// ============================================
$router->get('/admin/reports', ['Controllers\ReportController', 'index']);
$router->get('/admin/reports/:id', ['Controllers\ReportController', 'show']);
$router->post('/admin/reports/:id/resolve', ['Controllers\ReportController', 'resolve']);
$router->post('/admin/reports/:id/dismiss', ['Controllers\ReportController', 'dismiss']);

// ============================================
// Community Routes
// ============================================
$router->get('/community/guidelines', ['Controllers\CommunityController', 'guidelines']);
$router->get('/community/help', ['Controllers\CommunityController', 'help']);
$router->get('/community/contact', ['Controllers\CommunityController', 'contact']);

// ============================================
// Analytics Dashboard
// ============================================
$router->get('/analytics', ['Controllers\AnalyticsController', 'index']);

// ============================================
// Admin Routes
// ============================================
$router->get('/admin', ['Controllers\AdminController', 'index']);
$router->get('/admin/users', ['Controllers\AdminController', 'users']);
$router->get('/admin/user/:id', ['Controllers\AdminController', 'viewUser']);
$router->get('/admin/threads', ['Controllers\AdminController', 'threads']);
$router->get('/admin/categories', ['Controllers\AdminController', 'categories']);
$router->post('/admin/categories/create', ['Controllers\AdminController', 'createCategory']);
$router->post('/admin/categories/:id/edit', ['Controllers\AdminController', 'editCategory']);
$router->post('/admin/categories/:id/delete', ['Controllers\AdminController', 'deleteCategory']);
$router->get('/admin/polls', ['Controllers\AdminController', 'polls']);
$router->get('/admin/settings', ['Controllers\AdminController', 'settings']);
$router->post('/admin/settings/update', ['Controllers\AdminController', 'updateSettings']);
$router->get('/admin/activity', ['Controllers\AdminController', 'activityOverview']);
$router->post('/admin/user/role', ['Controllers\AdminController', 'updateUserRole']);
$router->post('/admin/user/reputation', ['Controllers\AdminController', 'addReputation']);
$router->post('/admin/user/ban', ['Controllers\AdminController', 'toggleBan']);
$router->post('/admin/user/delete', ['Controllers\AdminController', 'deleteUser']);
$router->post('/admin/thread/pin', ['Controllers\AdminController', 'togglePin']);
$router->post('/admin/thread/lock', ['Controllers\AdminController', 'toggleLock']);

// ============================================
// 404 Handler
// ============================================
$router->notFound(function() {
    http_response_code(404);
    if (ENVIRONMENT === 'development') {
        echo '<html><body style="font-family: sans-serif; padding: 40px;">';
        echo '<h1>404 - Page Not Found</h1>';
        echo '<p><strong>Request URI:</strong> ' . htmlspecialchars($_SERVER['REQUEST_URI']) . '</p>';
        echo '<p><strong>Request Method:</strong> ' . $_SERVER['REQUEST_METHOD'] . '</p>';
        echo '<p><a href="' . BASE_URL . '">← Go to Home</a></p>';
        echo '</body></html>';
    } else {
        echo "404 - Page Not Found";
    }
});
