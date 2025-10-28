<?php

namespace Controllers;

use Core\Controller;
use Models\User;
use Models\Thread;
use Models\Post;
use Models\Category;

class AdminController extends Controller {
    private $userModel;
    private $threadModel;
    private $postModel;
    private $categoryModel;

    public function __construct() {
        $this->userModel = new User();
        $this->threadModel = new Thread();
        $this->postModel = new Post();
        $this->categoryModel = new Category();
    }

    /**
     * Admin dashboard
     */
    public function index() {
        $this->requireAdmin();
        
        $stats = [
            'total_users' => $this->userModel->count(),
            'total_threads' => $this->threadModel->count(),
            'total_posts' => $this->postModel->count(),
            'total_categories' => $this->categoryModel->count(),
            'users_online' => $this->userModel->count('is_online = 1'),
            'users_today' => $this->userModel->count('DATE(created_at) = CURDATE()'),
            'threads_today' => $this->threadModel->count('DATE(created_at) = CURDATE()'),
            'posts_today' => $this->postModel->count('DATE(created_at) = CURDATE()'),
            'total_polls' => 0, // Placeholder
            'active_polls' => 0, // Placeholder
            'total_uploads' => 0, // Placeholder
            'daily_views' => rand(500, 2000), // Placeholder
            'admins' => $this->userModel->count('role = "admin"'),
            'moderators' => $this->userModel->count('role = "moderator"'),
            'regular_users' => $this->userModel->count('role = "user"')
        ];
        
        $recentUsers = $this->userModel->all('created_at DESC', 5);
        $topUsers = $this->userModel->all('reputation DESC', 5);
        
        // Sample data for charts
        $topContributors = $this->userModel->all('reputation DESC', 5);
        $hotThreads = $this->threadModel->all('views DESC', 5);
        $weeklyPosts = [12, 19, 15, 25, 22, 30, 28]; // Placeholder
        
        // Recent activities
        $recentActivities = [];
        $recentThreadsData = $this->threadModel->all('created_at DESC', 5);
        foreach ($recentThreadsData as $thread) {
            $recentActivities[] = [
                'type' => 'thread',
                'message' => e($thread['username']) . ' created a new thread: ' . e($thread['title']),
                'created_at' => $thread['created_at']
            ];
        }
        
        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard',
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'topUsers' => $topUsers,
            'topContributors' => array_map(function($user) {
                return [
                    'username' => $user['username'],
                    'post_count' => rand(10, 100) // Placeholder
                ];
            }, $topContributors),
            'hotThreads' => array_map(function($thread) {
                return [
                    'title' => substr($thread['title'], 0, 20) . '...',
                    'views' => $thread['views']
                ];
            }, $hotThreads),
            'weeklyPosts' => $weeklyPosts,
            'recentActivities' => $recentActivities
        ]);
    }

    /**
     * User management
     */
    public function users() {
        $this->requireAdmin();
        
        // Get filter parameters
        $role = $this->get('role', 'all');
        $status = $this->get('status', 'all');
        $search = $this->get('search', '');
        $page = max(1, intval($this->get('page', 1)));
        $perPage = 20;
        
        // Build query conditions
        $conditions = [];
        $params = [];
        
        if ($role !== 'all') {
            $conditions[] = "role = ?";
            $params[] = $role;
        }
        
        if ($status === 'banned') {
            $conditions[] = "is_banned = 1";
        } elseif ($status === 'online') {
            $conditions[] = "is_online = 1";
        } elseif ($status === 'offline') {
            $conditions[] = "is_online = 0";
        }
        
        if (!empty($search)) {
            $conditions[] = "(username LIKE ? OR email LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' AND ', $conditions);
        }
        
        // Get total count
        $countSql = "SELECT COUNT(*) as count FROM users {$whereClause}";
        $countResult = $this->userModel->queryFirst($countSql, $params);
        $totalUsers = $countResult['count'];
        
        // Calculate pagination
        $totalPages = ceil($totalUsers / $perPage);
        $offset = ($page - 1) * $perPage;
        
        // Get users with pagination
        $sql = "SELECT * FROM users {$whereClause} ORDER BY created_at DESC LIMIT {$perPage} OFFSET {$offset}";
        $users = $this->userModel->query($sql, $params);
        
        $this->view('admin/users', [
            'title' => 'User Management',
            'users' => $users,
            'totalUsers' => $totalUsers,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'roleFilter' => $role,
            'statusFilter' => $status,
            'searchQuery' => $search
        ]);
    }

    /**
     * Category management
     */
    public function categories() {
        $this->requireAdmin();
        
        $categories = $this->categoryModel->all('display_order ASC');
        
        $this->view('admin/categories', [
            'title' => 'Category Management',
            'categories' => $categories
        ]);
    }

    /**
     * Create category
     */
    public function createCategory() {
        $this->requireAdmin();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/admin/categories');
            return;
        }
        
        $name = $this->sanitize($this->post('name'));
        $slug = slug($name);
        $description = $this->sanitize($this->post('description'));
        $icon = $this->sanitize($this->post('icon'));
        $color = $this->sanitize($this->post('color'));
        
        $categoryId = $this->categoryModel->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'icon' => $icon,
            'color' => $color,
            'display_order' => 999,
            'is_active' => 1
        ]);
        
        if ($categoryId) {
            setFlash('success', 'Category created successfully');
        } else {
            setFlash('error', 'Failed to create category');
        }
        
        redirect('/admin/categories');
    }

    /**
     * Edit category
     */
    public function editCategory($id) {
        $this->requireAdmin();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/admin/categories');
            return;
        }
        
        $name = $this->sanitize($this->post('name'));
        $slug = slug($name);
        $description = $this->sanitize($this->post('description'));
        $icon = $this->sanitize($this->post('icon'));
        $color = $this->sanitize($this->post('color'));
        
        if ($this->categoryModel->update($id, [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'icon' => $icon,
            'color' => $color
        ])) {
            setFlash('success', 'Category updated successfully');
        } else {
            setFlash('error', 'Failed to update category');
        }
        
        redirect('/admin/categories');
    }

    /**
     * Delete category
     */
    public function deleteCategory($id) {
        $this->requireAdmin();
        
        if ($this->categoryModel->delete($id)) {
            setFlash('success', 'Category deleted successfully');
        } else {
            setFlash('error', 'Failed to delete category');
        }
        
        redirect('/admin/categories');
    }
    
    /**
     * Update user role
     */
    public function updateUserRole() {
        $this->requireAdmin();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $userId = $this->post('user_id');
        $role = $this->post('role');
        
        if (!in_array($role, ['user', 'moderator', 'admin'])) {
            $this->json(['success' => false, 'message' => 'Invalid role'], 400);
        }
        
        if ($this->userModel->update($userId, ['role' => $role])) {
            $this->json(['success' => true, 'message' => 'Role updated successfully']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update role'], 500);
        }
    }
    
    /**
     * Add reputation points
     */
    public function addReputation() {
        $this->requireAdmin();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $userId = $this->post('user_id');
        $points = intval($this->post('points'));
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            $this->json(['success' => false, 'message' => 'User not found'], 404);
        }
        
        $newReputation = $user['reputation'] + $points;
        
        if ($this->userModel->update($userId, ['reputation' => $newReputation])) {
            $this->json(['success' => true, 'message' => 'Reputation updated', 'new_reputation' => $newReputation]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update reputation'], 500);
        }
    }
    
    /**
     * Ban/Unban user
     */
    public function toggleBan() {
        $this->requireAdmin();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $userId = $this->post('user_id');
        $reason = $this->sanitize($this->post('reason'));
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            $this->json(['success' => false, 'message' => 'User not found'], 404);
        }
        
        $isBanned = $user['is_banned'] ? 0 : 1;
        
        if ($this->userModel->update($userId, [
            'is_banned' => $isBanned,
            'ban_reason' => $isBanned ? $reason : null
        ])) {
            $message = $isBanned ? 'User banned successfully' : 'User unbanned successfully';
            $this->json(['success' => true, 'message' => $message, 'is_banned' => $isBanned]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update ban status'], 500);
        }
    }
    
    /**
     * Thread management page
     */
    public function threads() {
        $this->requireAdmin();
        
        // Fetch threads with user and category data
        $sql = "SELECT t.*, 
                u.username, u.avatar as user_avatar,
                c.name as category_name,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.is_deleted = 0
                ORDER BY t.is_pinned DESC, t.created_at DESC";
        
        $threads = $this->threadModel->query($sql);
        $categories = $this->categoryModel->all();
        
        $this->view('admin/threads', [
            'title' => 'Manage Threads',
            'pageTitle' => 'Manage Threads',
            'threads' => $threads,
            'categories' => $categories,
            'totalThreads' => count($threads)
        ]);
    }
    
    /**
     * Polls management page
     */
    public function polls() {
        $this->requireAdmin();
        
        // Sample poll data - in production, fetch from database
        $polls = [
            [
                'id' => 1,
                'question' => 'What\'s your favorite programming language?',
                'creator_name' => 'Admin',
                'created_at' => date('Y-m-d H:i:s'),
                'total_votes' => 150,
                'is_active' => true,
                'options' => [
                    ['option_text' => 'PHP', 'votes' => 45],
                    ['option_text' => 'Python', 'votes' => 60],
                    ['option_text' => 'JavaScript', 'votes' => 30],
                    ['option_text' => 'Java', 'votes' => 15]
                ]
            ]
        ];
        
        $stats = [
            'total_polls' => 1,
            'active_polls' => 1,
            'total_votes' => 150,
            'avg_votes' => 150
        ];
        
        $this->view('admin/polls', [
            'title' => 'Manage Polls',
            'pageTitle' => 'Manage Polls',
            'polls' => $polls,
            'stats' => $stats
        ]);
    }
    
    /**
     * Site settings page
     */
    public function settings() {
        $this->requireAdmin();
        
        // Default settings - in production, fetch from database
        $settings = [
            'site_title' => 'ForumHub Pro',
            'site_tagline' => 'Connect, Discuss, Grow',
            'site_description' => 'The future of online communities',
            'contact_email' => 'admin@forumhub.com',
            'default_theme' => 'dark',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_username' => '',
            'smtp_password' => '',
            'smtp_encryption' => 'tls',
            'posts_per_page' => 20,
            'threads_per_page' => 15,
            'max_upload_size' => 5,
            'allow_registration' => true,
            'require_email_verification' => false,
            'enable_reputation' => true,
            'enable_polls' => true,
            'logo' => ''
        ];
        
        $this->view('admin/settings', [
            'title' => 'Site Settings',
            'pageTitle' => 'Site Settings',
            'settings' => $settings
        ]);
    }
    
    /**
     * Update site settings
     */
    public function updateSettings() {
        $this->requireAdmin();
        
        // In production, save settings to database
        setFlash('success', 'Settings updated successfully!');
        redirect('/admin/settings');
    }
    
    /**
     * Activity Overview with demo charts
     */
    public function activityOverview() {
        $this->requireAdmin();
        
        $this->view('admin/activity_overview', [
            'title' => 'Activity Overview',
            'pageTitle' => 'Activity Overview'
        ]);
    }

    /**
     * Toggle pin thread
     */
    public function togglePin() {
        $this->requireModerator();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }
        
        $threadId = $this->post('thread_id');
        
        if (!$threadId) {
            $this->json(['success' => false, 'message' => 'Thread ID required'], 400);
            return;
        }
        
        $thread = $this->threadModel->find($threadId);
        if (!$thread) {
            $this->json(['success' => false, 'message' => 'Thread not found'], 404);
            return;
        }
        
        $isPinned = $thread['is_pinned'] ? 0 : 1;
        
        if ($this->threadModel->update($threadId, ['is_pinned' => $isPinned])) {
            $message = $isPinned ? 'Thread pinned successfully' : 'Thread unpinned successfully';
            $this->json(['success' => true, 'message' => $message, 'is_pinned' => $isPinned]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update thread'], 500);
        }
    }

    /**
     * Toggle lock thread
     */
    public function toggleLock() {
        $this->requireModerator();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
            return;
        }
        
        $threadId = $this->post('thread_id');
        
        if (!$threadId) {
            $this->json(['success' => false, 'message' => 'Thread ID required'], 400);
            return;
        }
        
        $thread = $this->threadModel->find($threadId);
        if (!$thread) {
            $this->json(['success' => false, 'message' => 'Thread not found'], 404);
            return;
        }
        
        $isLocked = $thread['is_locked'] ? 0 : 1;
        
        if ($this->threadModel->update($threadId, ['is_locked' => $isLocked])) {
            $message = $isLocked ? 'Thread locked successfully' : 'Thread unlocked successfully';
            $this->json(['success' => true, 'message' => $message, 'is_locked' => $isLocked]);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to update thread'], 500);
        }
    }
    
    /**
     * Get user details for admin panel
     */
    public function getUserDetails($userId) {
        $this->requireAdmin();
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            setFlash('error', 'User not found');
            redirect('/admin/users');
        }
        
        // Get user stats
        $stats = $this->userModel->getUserDetails($userId);
        
        // Get recent activity
        $recentActivity = $this->userModel->getUserActivity($userId);
        
        $this->view('admin/user_profile', [
            'title' => 'User Profile - ' . $user['username'],
            'user' => $user,
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }
    
    /**
     * View user profile
     */
    public function viewUser($userId) {
        $this->requireAdmin();
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            setFlash('error', 'User not found');
            redirect('/admin/users');
        }
        
        // Get user stats
        $stats = $this->userModel->getUserDetails($userId);
        
        // Get recent activity
        $recentActivity = $this->userModel->getUserActivity($userId);
        
        $this->view('admin/user_profile', [
            'title' => 'User Profile - ' . $user['username'],
            'user' => $user,
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }
}
