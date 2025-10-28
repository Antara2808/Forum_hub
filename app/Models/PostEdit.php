<?php

namespace Models;

use Core\Model;

class PostEdit extends Model {
    protected $table = 'post_edits';

    /**
     * Create a post edit record
     */
    public function createEdit($postId, $userId, $content) {
        return $this->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content
        ]);
    }

    /**
     * Get edit history for a post
     */
    public function getEditHistory($postId) {
        $sql = "SELECT pe.*, u.username, u.avatar
                FROM post_edits pe
                JOIN users u ON pe.user_id = u.id
                WHERE pe.post_id = ?
                ORDER BY pe.edited_at DESC";
        
        return $this->query($sql, [$postId]);
    }

    /**
     * Get recent edits by user
     */
    public function getRecentEditsByUser($userId, $limit = 10) {
        $sql = "SELECT pe.*, u.username, p.thread_id, t.title as thread_title
                FROM post_edits pe
                JOIN users u ON pe.user_id = u.id
                JOIN posts p ON pe.post_id = p.id
                JOIN threads t ON p.thread_id = t.id
                WHERE pe.user_id = ?
                ORDER BY pe.edited_at DESC
                LIMIT ?";
        
        return $this->query($sql, [$userId, $limit]);
    }
}