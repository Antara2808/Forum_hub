<?php

namespace Controllers;

use Core\Controller;
use Models\Friend;
use Models\User;

class FriendController extends Controller {
    private $friendModel;
    private $userModel;

    public function __construct() {
        $this->friendModel = new Friend();
        $this->userModel = new User();
    }

    /**
     * Send friend request
     */
    public function sendRequest() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $friendId = $this->post('friend_id');
        $userId = $this->getUserId();
        
        if (!$friendId || $friendId == $userId) {
            $this->json(['success' => false, 'message' => 'Invalid friend ID'], 400);
            return;
        }
        
        // Check if user exists
        $friend = $this->userModel->find($friendId);
        if (!$friend) {
            $this->json(['success' => false, 'message' => 'User not found'], 404);
            return;
        }
        
        // Send friend request
        $result = $this->friendModel->sendRequest($userId, $friendId);
        
        if ($result) {
            $this->json(['success' => true, 'message' => 'Friend request sent']);
        } else {
            $this->json(['success' => false, 'message' => 'Friend request already exists'], 400);
        }
    }

    /**
     * Accept friend request
     */
    public function acceptRequest() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $requestId = $this->post('request_id');
        
        if (!$requestId) {
            $this->json(['success' => false, 'message' => 'Invalid request ID'], 400);
            return;
        }
        
        // Verify the request is for the current user
        $request = $this->friendModel->find($requestId);
        if (!$request || $request['friend_id'] != $this->getUserId()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }
        
        if ($this->friendModel->acceptRequest($requestId)) {
            $this->json(['success' => true, 'message' => 'Friend request accepted']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to accept request'], 500);
        }
    }

    /**
     * Reject friend request
     */
    public function rejectRequest() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $requestId = $this->post('request_id');
        
        if (!$requestId) {
            $this->json(['success' => false, 'message' => 'Invalid request ID'], 400);
            return;
        }
        
        // Verify the request is for the current user
        $request = $this->friendModel->find($requestId);
        if (!$request || $request['friend_id'] != $this->getUserId()) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
            return;
        }
        
        if ($this->friendModel->rejectRequest($requestId)) {
            $this->json(['success' => true, 'message' => 'Friend request rejected']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to reject request'], 500);
        }
    }

    /**
     * Remove friend
     */
    public function removeFriend() {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Invalid request method'], 405);
            return;
        }
        
        $friendId = $this->post('friend_id');
        $userId = $this->getUserId();
        
        if (!$friendId) {
            $this->json(['success' => false, 'message' => 'Invalid friend ID'], 400);
            return;
        }
        
        if ($this->friendModel->removeFriend($userId, $friendId)) {
            $this->json(['success' => true, 'message' => 'Friend removed']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to remove friend'], 500);
        }
    }

    /**
     * Get friend list
     */
    public function index($userId = null) {
        $userId = $userId ?? $this->getUserId();
        
        if (!$userId) {
            redirect('/auth/login');
            return;
        }
        
        $friends = $this->friendModel->getFriends($userId);
        $pendingRequests = [];
        $sentRequests = [];
        
        // Only show pending/sent requests if viewing own profile
        if ($this->isLoggedIn() && $userId == $this->getUserId()) {
            $pendingRequests = $this->friendModel->getPendingRequests($userId);
            $sentRequests = $this->friendModel->getSentRequests($userId);
        }
        
        $this->view('friends/index', [
            'title' => 'Friends - ForumHub Pro',
            'friends' => $friends,
            'pendingRequests' => $pendingRequests,
            'sentRequests' => $sentRequests,
            'userId' => $userId
        ]);
    }

    /**
     * Search users by username (API endpoint)
     */
    public function searchUsers() {
        $this->requireAuth();
        
        $query = $_GET['q'] ?? '';
        $currentUserId = $this->getUserId();
        
        if (strlen($query) < 2) {
            $this->json(['success' => false, 'message' => 'Query too short', 'users' => []]);
            return;
        }
        
        // Search users excluding current user
        $sql = "SELECT id, username, avatar, reputation 
                FROM users 
                WHERE username LIKE ? 
                AND id != ? 
                AND is_banned = 0 
                ORDER BY reputation DESC 
                LIMIT 10";
        
        $users = $this->userModel->query($sql, ["%{$query}%", $currentUserId]);
        
        $this->json(['success' => true, 'users' => $users]);
    }
}
