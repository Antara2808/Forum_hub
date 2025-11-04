-- Migration to add thread_likes table and likes_count column to threads table

-- Add likes_count column to threads table if it doesn't exist
ALTER TABLE threads ADD COLUMN IF NOT EXISTS likes_count INT UNSIGNED DEFAULT 0;

-- Create thread_likes table if it doesn't exist
CREATE TABLE IF NOT EXISTS thread_likes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    thread_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES threads(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_thread (user_id, thread_id),
    INDEX idx_user_id (user_id),
    INDEX idx_thread_id (thread_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;