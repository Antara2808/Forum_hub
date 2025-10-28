<?php

namespace Models;

use Core\Model;

class Post extends Model {
    protected $table = 'posts';

    /**
     * Create post
     */
    public function create($data) {
        return $this->insert($data);
    }

    /**
     * Get posts by thread
     */
    public function getByThread($threadId) {
        $sql = "SELECT p.*, 
                u.username, u.avatar, u.reputation, u.role, u.created_at as member_since
                FROM posts p
                JOIN users u ON p.user_id = u.id
                WHERE p.thread_id = ? AND p.is_deleted = 0
                ORDER BY p.created_at ASC";
        
        return $this->query($sql, [$threadId]);
    }

    /**
     * Get recent posts by user
     */
    public function getByUser($userId, $limit = 20) {
        $sql = "SELECT p.*, t.title as thread_title, t.slug as thread_slug
                FROM posts p
                JOIN threads t ON p.thread_id = t.id
                WHERE p.user_id = ? AND p.is_deleted = 0
                ORDER BY p.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Count posts by user
     */
    public function countByUser($userId) {
        return $this->count('user_id = ? AND is_deleted = 0', [$userId]);
    }

    /**
     * Mark as edited
     */
    public function markEdited($id) {
        // Save current content to edit history before marking as edited
        $post = $this->find($id);
        if ($post) {
            $editModel = new \Models\PostEdit();
            $editModel->createEdit($id, $post['user_id'], $post['content']);
        }
        
        return $this->update($id, [
            'is_edited' => 1,
            'edited_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get edit history for post
     */
    public function getEditHistory($postId) {
        $editModel = new \Models\PostEdit();
        return $editModel->getEditHistory($postId);
    }
}
