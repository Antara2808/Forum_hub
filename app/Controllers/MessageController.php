<?php

namespace Controllers;

use Core\Controller;
use Models\Message;
use Models\User;

class MessageController extends Controller {
    private $messageModel;
    private $userModel;

    public function __construct() {
        $this->messageModel = new \Models\Message();
        $this->userModel = new User();
    }

    /**
     * List conversations
     */
    public function index() {
        $this->requireAuth();
        
        $conversations = $this->messageModel->getConversations($this->getUserId());
        
        $this->view('messages/index', [
            'title' => 'Messages - ForumHub Pro',
            'conversations' => $conversations
        ]);
    }

    /**
     * View conversation with user
     */
    public function conversation($userId) {
        $this->requireAuth();
        
        if ($userId == $this->getUserId()) {
            redirect('/messages');
        }
        
        $user = $this->userModel->find($userId);
        if (!$user) {
            redirect('/messages');
        }
        
        $messages = $this->messageModel->getConversation($this->getUserId(), $userId);
        
        // Mark messages as read
        $this->messageModel->markAsRead($this->getUserId(), $userId);
        
        $this->view('messages/conversation', [
            'title' => 'Chat with ' . $user['username'],
            'user' => $user,
            'messages' => $messages
        ]);
    }

    /**
     * Send message
     */
    public function send() {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $receiverId = $this->post('receiver_id');
        $message = $this->post('message');
        
        if (empty($receiverId) || empty($message)) {
            $this->json(['success' => false, 'message' => 'All fields required'], 400);
        }
        
        $messageId = $this->messageModel->create([
            'sender_id' => $this->getUserId(),
            'receiver_id' => $receiverId,
            'message' => $message
        ]);
        
        if ($messageId) {
            $this->json(['success' => true, 'message' => 'Message sent']);
        } else {
            $this->json(['success' => false, 'message' => 'Failed to send'], 500);
        }
    }

    /**
     * Get unread count
     */
    public function unreadCount() {
        if (!$this->isLoggedIn()) {
            $this->json(['count' => 0]);
        }
        
        $count = $this->messageModel->getUnreadCount($this->getUserId());
        $this->json(['count' => $count]);
    }
}
