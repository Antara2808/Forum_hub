<?php

namespace Models;

use Core\Model;

class Tag extends Model {
    protected $table = 'tags';

    /**
     * Create a new tag
     */
    public function createTag($name) {
        // Check if tag already exists
        $existing = $this->whereFirst('name', $name);
        if ($existing) {
            return $existing['id'];
        }
        
        // Create new tag
        return $this->insert([
            'name' => strtolower(trim($name))
        ]);
    }

    /**
     * Get tag by name
     */
    public function getByName($name) {
        return $this->whereFirst('name', strtolower(trim($name)));
    }

    /**
     * Get tags for a thread
     */
    public function getTagsForThread($threadId) {
        $sql = "SELECT t.* 
                FROM tags t
                JOIN thread_tags tt ON t.id = tt.tag_id
                WHERE tt.thread_id = ?
                ORDER BY t.name";
        
        return $this->query($sql, [$threadId]);
    }

    /**
     * Get threads by tag
     */
    public function getThreadsByTag($tagId, $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT th.*, 
                u.username, u.avatar,
                c.name as category_name, c.slug as category_slug,
                (SELECT COUNT(*) FROM posts WHERE thread_id = th.id AND is_deleted = 0) as reply_count
                FROM threads th
                JOIN thread_tags tt ON th.id = tt.thread_id
                JOIN users u ON th.user_id = u.id
                JOIN categories c ON th.category_id = c.id
                WHERE tt.tag_id = ? AND th.is_deleted = 0
                ORDER BY th.created_at DESC
                LIMIT ? OFFSET ?";
        
        return $this->query($sql, [$tagId, $perPage, $offset]);
    }

    /**
     * Add tags to thread
     */
    public function addTagsToThread($threadId, $tags) {
        // First remove existing tags for this thread
        $this->db->prepare("DELETE FROM thread_tags WHERE thread_id = ?")->execute([$threadId]);
        
        // Add new tags
        foreach ($tags as $tagName) {
            $tagId = $this->createTag($tagName);
            if ($tagId) {
                $stmt = $this->db->prepare("INSERT IGNORE INTO thread_tags (thread_id, tag_id) VALUES (?, ?)");
                $stmt->execute([$threadId, $tagId]);
            }
        }
    }

    /**
     * Search tags
     */
    public function searchTags($query, $limit = 10) {
        $sql = "SELECT * FROM tags WHERE name LIKE ? ORDER BY name LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%{$query}%", $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Get popular tags
     */
    public function getPopularTags($limit = 20) {
        $sql = "SELECT t.*, COUNT(tt.thread_id) as thread_count
                FROM tags t
                JOIN thread_tags tt ON t.id = tt.tag_id
                GROUP BY t.id
                ORDER BY thread_count DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}