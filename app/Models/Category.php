<?php

namespace Models;

use Core\Model;

class Category extends Model {
    protected $table = 'categories';

    /**
     * Create category
     */
    public function create($data) {
        return $this->insert($data);
    }

    /**
     * Get all active categories
     */
    public function getActive() {
        return $this->where('is_active', 1);
    }

    /**
     * Get category by slug
     */
    public function findBySlug($slug) {
        return $this->whereFirst('slug', $slug);
    }

    /**
     * Get category with thread count
     */
    public function getWithStats() {
        $sql = "SELECT c.*, 
                COUNT(t.id) as thread_count,
                (SELECT COUNT(*) FROM posts p 
                 JOIN threads th ON p.thread_id = th.id 
                 WHERE th.category_id = c.id) as post_count
                FROM categories c
                LEFT JOIN threads t ON c.id = t.category_id AND t.is_deleted = 0
                WHERE c.is_active = 1
                GROUP BY c.id
                ORDER BY c.display_order ASC";
        
        return $this->query($sql);
    }
}
