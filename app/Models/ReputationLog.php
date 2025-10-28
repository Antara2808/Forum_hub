<?php

namespace Models;

use Core\Model;

class ReputationLog extends Model {
    protected $table = 'reputation_log';

    /**
     * Create reputation log entry
     */
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    /**
     * Get user reputation history
     */
    public function getUserHistory($userId, $limit = 50) {
        $sql = "SELECT * FROM reputation_log 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Get recent reputation changes
     */
    public function getRecent($limit = 20) {
        $sql = "SELECT rl.*, u.username, u.avatar
                FROM reputation_log rl
                JOIN users u ON rl.user_id = u.id
                ORDER BY rl.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}
