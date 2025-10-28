<?php

namespace Models;

use Core\Model;

class Friend extends Model {
    protected $table = 'friendships';

    /**
     * Send friend request
     */
    public function sendRequest($userId, $friendId) {
        // Check if friendship already exists
        $existing = $this->query(
            "SELECT * FROM friendships WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)",
            [$userId, $friendId, $friendId, $userId]
        );
        
        if (!empty($existing)) {
            return false; // Already exists
        }
        
        return $this->insert([
            'user_id' => $userId,
            'friend_id' => $friendId,
            'status' => 'pending'
        ]);
    }

    /**
     * Accept friend request
     */
    public function acceptRequest($requestId) {
        return $this->update($requestId, ['status' => 'accepted']);
    }

    /**
     * Reject friend request
     */
    public function rejectRequest($requestId) {
        return $this->update($requestId, ['status' => 'rejected']);
    }

    /**
     * Remove friend
     */
    public function removeFriend($userId, $friendId) {
        return $this->query(
            "DELETE FROM friendships WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)",
            [$userId, $friendId, $friendId, $userId]
        );
    }

    /**
     * Get friend status between two users
     */
    public function getFriendStatus($userId, $friendId) {
        $result = $this->queryFirst(
            "SELECT * FROM friendships WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)",
            [$userId, $friendId, $friendId, $userId]
        );
        
        return $result;
    }

    /**
     * Get all friends of a user
     */
    public function getFriends($userId) {
        $sql = "SELECT u.id, u.username, u.avatar, u.reputation, u.is_online, u.last_seen
                FROM friendships f
                JOIN users u ON (f.friend_id = u.id OR f.user_id = u.id)
                WHERE (f.user_id = ? OR f.friend_id = ?) 
                AND f.status = 'accepted'
                AND u.id != ?
                ORDER BY u.username ASC";
        
        return $this->query($sql, [$userId, $userId, $userId]);
    }

    /**
     * Get pending friend requests received by user
     */
    public function getPendingRequests($userId) {
        $sql = "SELECT f.id as request_id, u.id, u.username, u.avatar, u.reputation, f.created_at
                FROM friendships f
                JOIN users u ON f.user_id = u.id
                WHERE f.friend_id = ? AND f.status = 'pending'
                ORDER BY f.created_at DESC";
        
        return $this->query($sql, [$userId]);
    }

    /**
     * Get pending friend requests sent by user
     */
    public function getSentRequests($userId) {
        $sql = "SELECT f.id as request_id, u.id, u.username, u.avatar, u.reputation, f.created_at
                FROM friendships f
                JOIN users u ON f.friend_id = u.id
                WHERE f.user_id = ? AND f.status = 'pending'
                ORDER BY f.created_at DESC";
        
        return $this->query($sql, [$userId]);
    }

    /**
     * Count friends
     */
    public function countFriends($userId) {
        $result = $this->queryFirst(
            "SELECT COUNT(*) as count FROM friendships 
             WHERE (user_id = ? OR friend_id = ?) AND status = 'accepted'",
            [$userId, $userId]
        );
        
        return $result ? $result['count'] : 0;
    }

    /**
     * Check if users are friends
     */
    public function areFriends($userId, $friendId) {
        $result = $this->queryFirst(
            "SELECT * FROM friendships 
             WHERE ((user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?))
             AND status = 'accepted'",
            [$userId, $friendId, $friendId, $userId]
        );
        
        return !empty($result);
    }
}
