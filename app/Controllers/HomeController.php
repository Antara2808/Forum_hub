<?php

namespace Controllers;

use Core\Controller;

class HomeController extends Controller {
    
    /**
     * 3D Landing Page
     */
    public function landing() {
        if ($this->isLoggedIn()) {
            redirect('/home');
        }
        
        $this->view('landing/index', [
            'title' => 'ForumHub Pro - The Future of Online Communities'
        ]);
    }
    
    /**
     * Main dashboard
     */
    public function index() {
        $this->requireAuth();
        
        // Get recent threads
        $threadModel = new \Models\Thread();
        $categoryModel = new \Models\Category();
        $friendModel = new \Models\Friend();
        
        $threads = $threadModel->getRecent(10);
        $categories = $categoryModel->all('display_order ASC');
        
        // Get friends data
        $friends = $friendModel->getFriends($this->getUserId());
        $pendingRequests = $friendModel->getPendingRequests($this->getUserId());
        
        $this->view('home/index', [
            'title' => 'Home - ForumHub Pro',
            'threads' => $threads,
            'categories' => $categories,
            'friends' => $friends,
            'pendingRequests' => $pendingRequests
        ]);
    }
}
