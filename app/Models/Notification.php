<?php

namespace Models;

use Core\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    /**
     * Create a notification
     */
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (user_id, actor_id, type, thread_id, post_id, message) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        return $stmt->execute([
            $data['user_id'],
            $data['actor_id'] ?? null,
            $data['type'],
            $data['thread_id'] ?? null,
            $data['post_id'] ?? null,
            $data['message']
        ]);
    }

    /**
     * Get notifications for a user
     */
    public function getByUser($userId, $limit = 20, $unreadOnly = false)
    {
        $sql = "
            SELECT n.*, 
                   u.username as actor_username, 
                   u.avatar as actor_avatar,
                   t.title as thread_title,
                   t.slug as thread_slug
            FROM {$this->table} n
            LEFT JOIN users u ON n.actor_id = u.id
            LEFT JOIN threads t ON n.thread_id = t.id
            WHERE n.user_id = ?
        ";
        
        if ($unreadOnly) {
            $sql .= " AND n.is_read = 0";
        }
        
        $sql .= " ORDER BY n.created_at DESC LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount($userId)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM {$this->table} 
            WHERE user_id = ? AND is_read = 0
        ");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET is_read = 1, read_at = NOW() 
            WHERE id = ?
        ");
        return $stmt->execute([$notificationId]);
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE {$this->table} 
            SET is_read = 1, read_at = NOW() 
            WHERE user_id = ? AND is_read = 0
        ");
        return $stmt->execute([$userId]);
    }

    /**
     * Delete notification
     */
    public function delete($notificationId)
    {
        $stmt = $this->db->prepare("
            DELETE FROM {$this->table} 
            WHERE id = ?
        ");
        return $stmt->execute([$notificationId]);
    }

    /**
     * Create notification for thread like
     */
    public function notifyThreadLike($threadId, $threadOwnerId, $actorId)
    {
        // Don't notify if user likes their own thread
        if ($threadOwnerId == $actorId) {
            return;
        }

        $stmt = $this->db->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$actorId]);
        $actor = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $this->create([
            'user_id' => $threadOwnerId,
            'actor_id' => $actorId,
            'type' => 'thread_like',
            'thread_id' => $threadId,
            'message' => "{$actor['username']} liked your thread"
        ]);
    }

    /**
     * Create notification for thread comment/reply
     */
    public function notifyThreadReply($threadId, $threadOwnerId, $actorId, $postId)
    {
        // Don't notify if user replies to their own thread
        if ($threadOwnerId == $actorId) {
            return;
        }

        $stmt = $this->db->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$actorId]);
        $actor = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $this->create([
            'user_id' => $threadOwnerId,
            'actor_id' => $actorId,
            'type' => 'thread_reply',
            'thread_id' => $threadId,
            'post_id' => $postId,
            'message' => "{$actor['username']} replied to your thread"
        ]);
    }
}
