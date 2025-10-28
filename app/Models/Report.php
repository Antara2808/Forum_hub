<?php

namespace Models;

use Core\Model;

class Report extends Model {
    protected $table = 'reports';

    /**
     * Create a new report
     */
    public function createReport($data) {
        return $this->insert($data);
    }

    /**
     * Get reports with pagination
     */
    public function getReports($status = 'pending', $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT r.*, u.username as reporter_username
                FROM reports r
                JOIN users u ON r.reporter_id = u.id";
        
        $params = [];
        
        if ($status !== 'all') {
            $sql .= " WHERE r.status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY r.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;
        
        return $this->query($sql, $params);
    }

    /**
     * Get report by ID with details
     */
    public function getReportWithDetails($id) {
        $sql = "SELECT r.*, 
                u.username as reporter_username,
                resolver.username as resolver_username,
                reported_user.username as reported_username
                FROM reports r
                JOIN users u ON r.reporter_id = u.id
                LEFT JOIN users resolver ON r.reviewed_by = resolver.id
                LEFT JOIN users reported_user ON r.reported_user_id = reported_user.id
                WHERE r.id = ?";
        
        return $this->queryFirst($sql, [$id]);
    }

    /**
     * Resolve a report
     */
    public function resolveReport($id, $userId, $status = 'resolved') {
        return $this->update($id, [
            'status' => $status,
            'reviewed_at' => date('Y-m-d H:i:s'),
            'reviewed_by' => $userId
        ]);
    }

    /**
     * Dismiss a report
     */
    public function dismissReport($id, $userId) {
        return $this->resolveReport($id, $userId, 'dismissed');
    }

    /**
     * Get report counts by status
     */
    public function getReportCounts() {
        $sql = "SELECT 
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
                SUM(CASE WHEN status = 'dismissed' THEN 1 ELSE 0 END) as dismissed,
                COUNT(*) as total
                FROM reports";
        
        return $this->queryFirst($sql);
    }

    /**
     * Check if user has already reported content
     */
    public function hasUserReported($userId, $type, $id) {
        $sql = "SELECT id FROM reports WHERE reporter_id = ?";
        $params = [$userId];
        
        switch ($type) {
            case 'thread':
                $sql .= " AND thread_id = ?";
                break;
            case 'post':
                $sql .= " AND post_id = ?";
                break;
            case 'user':
                $sql .= " AND reported_user_id = ?";
                break;
            default:
                return false;
        }
        
        $params[] = $id;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch() !== false;
    }
}