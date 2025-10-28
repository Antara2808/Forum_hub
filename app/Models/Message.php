<?php

namespace Models;

use Core\Model;

class Message extends Model {
    protected $table = 'messages';

    /**
     * Create message
     */
    public function create($data) {
        return $this->insert($data);
    }

    /**
     * Get conversations for user
     */
    public function getConversations($userId) {
        $sql = "SELECT 
                    CASE 
                        WHEN m.sender_id = ? THEN m.receiver_id
                        ELSE m.sender_id
                    END as other_user_id,
                    u.username, 
                    u.avatar,
                    m.message,
                    m.created_at,
                    m.is_read,
                    (SELECT COUNT(*) FROM messages 
                     WHERE receiver_id = ? AND sender_id = u.id AND is_read = 0) as unread_count
                FROM messages m
                JOIN users u ON u.id = CASE 
                    WHEN m.sender_id = ? THEN m.receiver_id 
                    ELSE m.sender_id 
                END
                WHERE (m.sender_id = ? OR m.receiver_id = ?)
                AND m.id IN (
                    SELECT MAX(id) FROM messages
                    WHERE (sender_id = ? AND receiver_id = u.id) 
                       OR (receiver_id = ? AND sender_id = u.id)
                    GROUP BY LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)
                )
                GROUP BY other_user_id, u.username, u.avatar, m.message, m.created_at, m.is_read
                ORDER BY m.created_at DESC";
        
        return $this->query($sql, [$userId, $userId, $userId, $userId, $userId, $userId, $userId]);
    }

    /**
     * Get conversation between two users
     */
    public function getConversation($userId1, $userId2) {
        $sql = "SELECT m.*, 
                u.username, u.avatar
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE (sender_id = ? AND receiver_id = ? AND is_deleted_by_sender = 0)
                   OR (sender_id = ? AND receiver_id = ? AND is_deleted_by_receiver = 0)
                ORDER BY created_at ASC";
        
        return $this->query($sql, [$userId1, $userId2, $userId2, $userId1]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead($receiverId, $senderId) {
        $sql = "UPDATE messages SET is_read = 1, read_at = NOW()
                WHERE receiver_id = ? AND sender_id = ? AND is_read = 0";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$receiverId, $senderId]);
    }

    /**
     * Get unread count
     */
    public function getUnreadCount($userId) {
        return $this->count('receiver_id = ? AND is_read = 0', [$userId]);
    }
}
