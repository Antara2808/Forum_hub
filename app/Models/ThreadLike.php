<?php

namespace Models;

use Core\Model;

class ThreadLike extends Model
{
    protected $table = 'thread_likes';

    /**
     * Check if user has liked a thread
     */
    public function hasLiked($threadId, $userId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE thread_id = ? AND user_id = ?
        ");
        $stmt->execute([$threadId, $userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    /**
     * Toggle like for a thread
     */
    public function toggleLike($threadId, $userId)
    {
        if ($this->hasLiked($threadId, $userId)) {
            return $this->unlike($threadId, $userId);
        } else {
            return $this->like($threadId, $userId);
        }
    }

    /**
     * Like a thread
     */
    public function like($threadId, $userId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} (thread_id, user_id) 
            VALUES (?, ?)
        ");
        
        if ($stmt->execute([$threadId, $userId])) {
            // Update likes count
            $this->updateLikesCount($threadId);
            return true;
        }
        return false;
    }

    /**
     * Unlike a thread
     */
    public function unlike($threadId, $userId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE thread_id = ? AND user_id = ?
        ");
        
        if ($stmt->execute([$threadId, $userId])) {
            // Update likes count
            $this->updateLikesCount($threadId);
            return true;
        }
        return false;
    }

    /**
     * Update likes count for a thread
     */
    private function updateLikesCount($threadId)
    {
        $stmt = $this->db->prepare("
            UPDATE threads 
            SET likes_count = (
                SELECT COUNT(*) 
                FROM {$this->table} 
                WHERE thread_id = ?
            )
            WHERE id = ?
        ");
        $stmt->execute([$threadId, $threadId]);
    }

    /**
     * Get likes count for a thread
     */
    public function getLikesCount($threadId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE thread_id = ?
        ");
        $stmt->execute([$threadId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    /**
     * Get users who liked a thread
     */
    public function getLikesByThread($threadId, $limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT u.id, u.username, u.avatar 
            FROM {$this->table} tl
            JOIN users u ON tl.user_id = u.id
            WHERE tl.thread_id = ?
            ORDER BY tl.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$threadId, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
