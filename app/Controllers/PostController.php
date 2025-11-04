<?php

namespace Controllers;

use Core\Controller;
use Models\Post;
use Models\Thread;
use Models\User;
use Models\ReputationLog;
use Models\Notification;

class PostController extends Controller {
    private $postModel;
    private $threadModel;
    private $userModel;
    private $repLogModel;
    private $notificationModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->threadModel = new Thread();
        $this->userModel = new User();
        $this->repLogModel = new ReputationLog();
        $this->notificationModel = new Notification();
    }

    /**
     * Store new post
     */
    public function store() {
        $this->requireAuth();
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            setFlash('error', 'Invalid request');
            redirect('/threads');
        }
        
        $threadId = $this->post('thread_id');
        $content = $this->post('content');
        
        if (empty($threadId) || empty($content)) {
            setFlash('error', 'Content is required');
            redirect('/threads/' . $threadId);
        }
        
        // Check if thread exists and is not locked
        $thread = $this->threadModel->find($threadId);
        if (!$thread) {
            setFlash('error', 'Thread not found');
            redirect('/threads');
        }
        
        if ($thread['is_locked'] && !$this->isModerator()) {
            setFlash('error', 'Thread is locked');
            redirect('/threads/' . $threadId);
        }
        
        // Create post
        $postId = $this->postModel->create([
            'thread_id' => $threadId,
            'user_id' => $this->getUserId(),
            'content' => $content
        ]);
        
        if ($postId) {
            // Add reputation
            $this->userModel->addReputation($this->getUserId(), POINTS_CREATE_POST);
            
            // Log reputation
            $this->repLogModel->create([
                'user_id' => $this->getUserId(),
                'points' => POINTS_CREATE_POST,
                'reason' => 'Posted reply',
                'reference_type' => 'post',
                'reference_id' => $postId
            ]);
            
            // Send notification to thread owner
            $this->notificationModel->notifyThreadReply($threadId, $thread['user_id'], $this->getUserId(), $postId);
            
            setFlash('success', 'Reply posted successfully!');
        } else {
            setFlash('error', 'Failed to post reply');
        }
        
        redirect('/threads/' . $threadId);
    }

    /**
     * Update post
     */
    public function update($id) {
        $this->requireAuth();
        
        $post = $this->postModel->find($id);
        
        if (!$post || ($post['user_id'] != $this->getUserId() && !$this->isModerator())) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        if (!$this->validateCsrfToken($this->post('csrf_token'))) {
            $this->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
        
        $content = $this->post('content');
        
        if ($this->postModel->update($id, ['content' => $content])) {
            $this->postModel->markEdited($id);
            $this->json(['success' => true, 'message' => 'Post updated']);
        } else {
            $this->json(['success' => false, 'message' => 'Update failed'], 500);
        }
    }

    /**
     * Delete post
     */
    public function delete($id) {
        $this->requireAuth();
        
        $post = $this->postModel->find($id);
        
        if (!$post || ($post['user_id'] != $this->getUserId() && !$this->isModerator())) {
            $this->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        if ($this->postModel->update($id, ['is_deleted' => 1])) {
            setFlash('success', 'Post deleted');
            redirect('/threads/' . $post['thread_id']);
        } else {
            setFlash('error', 'Failed to delete post');
            redirect('/threads/' . $post['thread_id']);
        }
    }
}
