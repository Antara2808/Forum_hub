<?php

namespace Models;

use Core\Model;

class User extends Model {
    protected $table = 'users';

    /**
     * Find user by email
     */
    public function findByEmail($email) {
        return $this->whereFirst('email', $email);
    }

    /**
     * Find user by username
     */
    public function findByUsername($username) {
        return $this->whereFirst('username', $username);
    }

    /**
     * Create new user
     */
    public function create($data) {
        // Hash password
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    /**
     * Verify password
     */
    public function verifyPassword($plainPassword, $hashedPassword) {
        return password_verify($plainPassword, $hashedPassword);
    }

    /**
     * Update user
     */
    public function updateUser($id, $data) {
        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        
        return $this->update($id, $data);
    }

    /**
     * Update reputation
     */
    public function addReputation($userId, $points) {
        $user = $this->find($userId);
        if ($user) {
            $newReputation = $user['reputation'] + $points;
            return $this->update($userId, ['reputation' => $newReputation]);
        }
        return false;
    }

    /**
     * Get user stats
     */
    public function getStats($userId) {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM threads WHERE user_id = ? AND is_deleted = 0) as thread_count,
                    (SELECT COUNT(*) FROM posts WHERE user_id = ? AND is_deleted = 0) as post_count,
                    u.reputation,
                    u.created_at
                FROM users u WHERE u.id = ?";
        
        return $this->queryFirst($sql, [$userId, $userId, $userId]);
    }

    /**
     * Get top users by reputation
     */
    public function getTopUsers($limit = 10) {
        $sql = "SELECT id, username, email, avatar, reputation, created_at 
                FROM users 
                WHERE is_banned = 0 
                ORDER BY reputation DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Search users
     */
    public function search($query) {
        $sql = "SELECT id, username, email, avatar, reputation 
                FROM users 
                WHERE (username LIKE ? OR email LIKE ?) 
                AND is_banned = 0 
                LIMIT 20";
        
        $searchTerm = "%{$query}%";
        return $this->query($sql, [$searchTerm, $searchTerm]);
    }

    /**
     * Get user details with activity
     */
    public function getUserDetails($userId) {
        $sql = "SELECT u.*, 
                (SELECT COUNT(*) FROM threads WHERE user_id = u.id AND is_deleted = 0) as thread_count,
                (SELECT COUNT(*) FROM posts WHERE user_id = u.id AND is_deleted = 0) as post_count,
                (SELECT COUNT(*) FROM friends WHERE (user_id = u.id OR friend_id = u.id) AND status = 'accepted') as friend_count
                FROM users u 
                WHERE u.id = ?";
        
        return $this->queryFirst($sql, [$userId]);
    }
    
    /**
     * Get user activity
     */
    public function getUserActivity($userId, $limit = 10) {
        $sql = "SELECT 'thread' as type, id, title as content, created_at FROM threads WHERE user_id = ? AND is_deleted = 0
                UNION ALL
                SELECT 'post' as type, id, LEFT(content, 100) as content, created_at FROM posts WHERE user_id = ? AND is_deleted = 0
                ORDER BY created_at DESC LIMIT ?";
        
        return $this->query($sql, [$userId, $userId, $limit]);
    }

    /**
     * Ban user
     */
    public function banUser($userId, $reason) {
        return $this->update($userId, [
            'is_banned' => 1,
            'ban_reason' => $reason
        ]);
    }

    /**
     * Unban user
     */
    public function unbanUser($userId) {
        return $this->update($userId, [
            'is_banned' => 0,
            'ban_reason' => null
        ]);
    }
    
    /**
     * Update last seen
     */
    public function updateLastSeen($userId) {
        return $this->update($userId, [
            'last_seen' => date('Y-m-d H:i:s'),
            'is_online' => 1
        ]);
    }
}
