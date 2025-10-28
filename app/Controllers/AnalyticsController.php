<?php

namespace Controllers;

use Core\Controller;
use Models\Thread;
use Models\Post;
use Models\User;

class AnalyticsController extends Controller {
    private $threadModel;
    private $postModel;
    private $userModel;

    public function __construct() {
        $this->threadModel = new Thread();
        $this->postModel = new Post();
        $this->userModel = new User();
    }

    /**
     * Analytics dashboard
     */
    public function index() {
        $this->requireModerator();
        
        // Get statistics
        $stats = [
            'total_threads' => $this->threadModel->count('is_deleted = 0'),
            'total_posts' => $this->postModel->count('is_deleted = 0'),
            'total_users' => $this->userModel->count('is_banned = 0'),
            'hot_threads' => $this->threadModel->getHot(5),
            'top_users' => $this->userModel->getTopUsers(10)
        ];
        
        $this->view('analytics/index', [
            'title' => 'Analytics Dashboard',
            'stats' => $stats
        ]);
    }
}
