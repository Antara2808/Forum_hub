<?php

namespace Models;

use Core\Model;

class Thread extends Model {
    protected $table = 'threads';

    /**
     * Create thread
     */
    public function create($data) {
        return $this->insert($data);
    }

    /**
     * Get thread by ID with user and category
     */
    public function getThread($id) {
        $sql = "SELECT t.*, 
                u.username, u.avatar, u.reputation,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.id = ? AND t.is_deleted = 0";
        
        return $this->queryFirst($sql, [$id]);
    }

    /**
     * Get thread by slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT t.*, 
                u.username, u.avatar, u.reputation,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.slug = ? AND t.is_deleted = 0";
        
        return $this->queryFirst($sql, [$slug]);
    }

    /**
     * Get recent threads
     */
    public function getRecent($limit = 20) {
        $sql = "SELECT t.*, 
                u.username, u.avatar,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.is_deleted = 0
                ORDER BY t.is_pinned DESC, t.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get recent threads with pagination
     */
    public function getRecentPaginated($page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT t.*, 
                u.username, u.avatar,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.is_deleted = 0
                ORDER BY t.is_pinned DESC, t.created_at DESC
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * Get threads by category
     */
    public function getByCategory($categoryId, $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT t.*, 
                u.username, u.avatar,
                c.name as category_name,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.category_id = ? AND t.is_deleted = 0
                ORDER BY t.is_pinned DESC, t.created_at DESC
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $perPage, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * Get threads by user
     */
    public function getByUser($userId) {
        $sql = "SELECT t.*, 
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN categories c ON t.category_id = c.id
                WHERE t.user_id = ? AND t.is_deleted = 0
                ORDER BY t.created_at DESC";
        
        return $this->query($sql, [$userId]);
    }

    /**
     * Increment views
     */
    public function incrementViews($id) {
        $sql = "UPDATE threads SET views = views + 1 WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    /**
     * Pin/Unpin thread
     */
    public function togglePin($id) {
        $thread = $this->find($id);
        if ($thread) {
            return $this->update($id, ['is_pinned' => !$thread['is_pinned']]);
        }
        return false;
    }

    /**
     * Lock/Unlock thread
     */
    public function toggleLock($id) {
        $thread = $this->find($id);
        if ($thread) {
            return $this->update($id, ['is_locked' => !$thread['is_locked']]);
        }
        return false;
    }

    /**
     * Search threads
     */
    public function search($query, $categoryId = null) {
        $sql = "SELECT t.*, 
                u.username, u.avatar,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE (t.title LIKE ? OR t.content LIKE ?) 
                AND t.is_deleted = 0";
        
        $params = ["%{$query}%", "%{$query}%"];
        
        if ($categoryId) {
            $sql .= " AND t.category_id = ?";
            $params[] = $categoryId;
        }
        
        $sql .= " ORDER BY t.created_at DESC LIMIT 50";
        
        return $this->query($sql, $params);
    }

    /**
     * Get hot threads (by views and replies)
     */
    public function getHot($limit = 10) {
        $sql = "SELECT t.*, 
                u.username, u.avatar,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = t.id AND is_deleted = 0) as reply_count
                FROM threads t
                JOIN users u ON t.user_id = u.id
                JOIN categories c ON t.category_id = c.id
                WHERE t.is_deleted = 0
                AND t.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                ORDER BY (t.views + (SELECT COUNT(*) FROM posts WHERE thread_id = t.id) * 10) DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Add tags to thread
     */
    public function addTags($threadId, $tags) {
        // Get tag model
        $tagModel = new \Models\Tag();
        $tagModel->addTagsToThread($threadId, $tags);
    }
    
    /**
     * Get thread with tags
     */
    public function getThreadWithTags($id) {
        $thread = $this->getThread($id);
        if ($thread) {
            $tagModel = new \Models\Tag();
            $thread['tags'] = $tagModel->getTagsForThread($id);
        }
        return $thread;
    }
}
