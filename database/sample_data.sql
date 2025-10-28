-- Sample Data for ForumHub Pro

USE forumhub_mvc;

-- Insert demo users (Password for all: 'password')
INSERT INTO users (username, email, password, role, reputation, avatar, bio, location, website, twitter, github, theme, is_online, last_seen, email_verified, created_at) VALUES
('admin', 'admin@forumhub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1500, NULL, 'System Administrator managing ForumHub Pro', 'San Francisco, CA', 'https://forumhub.com', 'forumhubadmin', 'forumhubpro', 'dark', 1, NOW(), 1, NOW()),
('moderator', 'mod@forumhub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moderator', 800, NULL, 'Community Moderator keeping discussions friendly', 'New York, NY', NULL, 'modforumhub', NULL, 'dark', 1, NOW(), 1, NOW()),
('user', 'user@forumhub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 250, NULL, 'Regular user account for testing features', 'Los Angeles, CA', NULL, NULL, NULL, 'light', 0, DATE_SUB(NOW(), INTERVAL 1 HOUR), 1, NOW()),
('johndoe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 350, NULL, 'Tech enthusiast and full-stack developer. Love coding and coffee!', 'Austin, TX', 'https://johndoe.dev', 'johndoedev', 'johndoe', 'dark', 0, DATE_SUB(NOW(), INTERVAL 2 HOUR), 1, DATE_SUB(NOW(), INTERVAL 2 DAY)),
('janedoe', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 420, NULL, 'Designer and creative thinker. UI/UX specialist.', 'Seattle, WA', 'https://janedesigns.com', 'janedesigner', 'janedoe', 'light', 0, DATE_SUB(NOW(), INTERVAL 3 HOUR), 1, DATE_SUB(NOW(), INTERVAL 3 DAY));

-- Note: Password for all users is 'password'

-- Insert categories
INSERT INTO categories (name, slug, description, icon, color, display_order, is_active) VALUES
('General Discussion', 'general-discussion', 'General topics and casual conversations', 'fa-comments', '#3B82F6', 1, 1),
('Technology', 'technology', 'All about tech, programming, and innovation', 'fa-laptop-code', '#8B5CF6', 2, 1),
('Gaming', 'gaming', 'Video games, esports, and gaming culture', 'fa-gamepad', '#10B981', 3, 1),
('Creative Arts', 'creative-arts', 'Design, art, music, and creative projects', 'fa-palette', '#F59E0B', 4, 1),
('Science & Education', 'science-education', 'Learning, research, and academic discussions', 'fa-graduation-cap', '#EF4444', 5, 1),
('Entertainment', 'entertainment', 'Movies, TV shows, books, and media', 'fa-film', '#EC4899', 6, 1),
('Help & Support', 'help-support', 'Get help and support from the community', 'fa-question-circle', '#6366F1', 7, 1);

-- Insert threads (sample discussions)
INSERT INTO threads (user_id, category_id, title, slug, content, views, is_pinned, is_locked, created_at) VALUES
(1, 1, 'Welcome to ForumHub Pro!', 'welcome-to-forumhub-pro', 'Welcome to ForumHub Pro - the next generation community platform! Feel free to introduce yourself and explore all the amazing features we have to offer. Don''t hesitate to ask questions or start discussions. Let''s build an amazing community together!', 245, 1, 0, NOW()),
(4, 2, 'Best Programming Languages in 2025', 'best-programming-languages-2025', 'What do you think are the most important programming languages to learn in 2025? I''m particularly interested in web development, AI, and mobile development. Share your thoughts and experiences!', 189, 0, 0, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 4, 'Share Your Creative Projects', 'share-your-creative-projects', 'This is a thread for showcasing your creative work! Whether it''s digital art, music, photography, or any other creative endeavor, share it here and get feedback from the community.', 156, 0, 0, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, 3, 'Top 10 Games of the Year', 'top-10-games-of-the-year', 'What are your favorite games this year? Let''s create a community top 10 list! Share your picks and why you love them.', 203, 0, 0, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(2, 7, 'How to Use ForumHub Features', 'how-to-use-forumhub-features', 'This guide will help you navigate all the amazing features of ForumHub Pro:\n\n- Creating and managing threads\n- Private messaging\n- Reputation system\n- Events and calendar\n- Dark mode\n\nFeel free to ask questions!', 312, 1, 0, DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(4, 2, 'Building Web Apps with Modern JavaScript', 'building-web-apps-modern-javascript', 'Let''s discuss modern JavaScript frameworks and best practices for building scalable web applications. What are your favorite tools and frameworks?', 167, 0, 0, DATE_SUB(NOW(), INTERVAL 5 HOUR)),
(5, 5, 'Latest Developments in AI and Machine Learning', 'latest-ai-ml-developments', 'Artificial Intelligence is advancing rapidly. What recent developments have caught your attention? Let''s discuss the implications and possibilities.', 198, 0, 0, DATE_SUB(NOW(), INTERVAL 8 HOUR)),
(3, 6, 'Best Movies to Watch This Month', 'best-movies-this-month', 'Looking for movie recommendations? Share your recent favorites and discover new films recommended by the community!', 134, 0, 0, DATE_SUB(NOW(), INTERVAL 12 HOUR));

-- Insert posts (replies to threads)
INSERT INTO posts (thread_id, user_id, content, created_at) VALUES
(1, 3, 'Thanks for the warm welcome! I''m excited to be part of this community. The interface looks amazing!', DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(1, 4, 'Hey everyone! Looking forward to great discussions here. The 3D landing page is mind-blowing!', DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(1, 5, 'Hello! This platform has everything I was looking for. Can''t wait to explore more!', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(2, 3, 'Python and JavaScript are definitely must-learns. Python for AI/ML and JavaScript for web development.', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, 5, 'Don''t forget Rust! It''s gaining a lot of traction, especially for systems programming.', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, 1, 'TypeScript is also becoming essential for large-scale applications. Great discussion!', DATE_SUB(NOW(), INTERVAL 23 HOUR)),
(3, 4, 'I''ll start! Here''s my latest digital illustration project. Would love to get feedback.', DATE_SUB(NOW(), INTERVAL 20 HOUR)),
(3, 3, 'Wow, that''s impressive! The color scheme is really eye-catching.', DATE_SUB(NOW(), INTERVAL 18 HOUR)),
(4, 5, 'My top pick is definitely that new RPG that came out last month. The storytelling is incredible!', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(4, 4, 'I''ve been playing a lot of indie games lately. Some hidden gems out there!', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 3, 'Thanks for this guide! Very helpful for new users like me.', DATE_SUB(NOW(), INTERVAL 30 MINUTE)),
(5, 5, 'The dark mode is fantastic! Works perfectly with the charts too.', DATE_SUB(NOW(), INTERVAL 45 MINUTE)),
(6, 3, 'React and Vue.js are my go-to frameworks. Both are excellent for different use cases.', DATE_SUB(NOW(), INTERVAL 4 HOUR)),
(6, 5, 'I''ve been exploring Next.js lately. The server-side rendering capabilities are amazing!', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(7, 4, 'The recent breakthroughs in large language models are fascinating. We''re living in exciting times!', DATE_SUB(NOW(), INTERVAL 7 HOUR)),
(7, 3, 'AI-powered code generation tools are changing how we develop software.', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
(8, 5, 'Just watched that new sci-fi thriller. Mind-bending plot twists!', DATE_SUB(NOW(), INTERVAL 10 HOUR)),
(8, 4, 'Thanks for the recommendation! Adding it to my watchlist.', DATE_SUB(NOW(), INTERVAL 9 HOUR));

-- Insert events
INSERT INTO events (user_id, title, description, event_date, is_online, created_at) VALUES
(1, 'ForumHub Pro Launch Party', 'Join us for the official launch of ForumHub Pro! Meet the team, network with other community members, and learn about upcoming features.', DATE_ADD(NOW(), INTERVAL 7 DAY), 1, NOW()),
(2, 'Web Development Workshop', 'A hands-on workshop covering modern web development practices, frameworks, and tools. Open to all skill levels!', DATE_ADD(NOW(), INTERVAL 14 DAY), 1, NOW()),
(4, 'Gaming Tournament - Battle Royale', 'Community gaming tournament! Sign up to compete and win prizes. All platforms welcome.', DATE_ADD(NOW(), INTERVAL 10 DAY), 1, NOW()),
(5, 'Creative Showcase Evening', 'Share your creative work with the community in this live showcase event. Art, music, photography, and more!', DATE_ADD(NOW(), INTERVAL 21 DAY), 1, NOW());

-- Insert reputation log entries
INSERT INTO reputation_log (user_id, points, reason, reference_type, reference_id, created_at) VALUES
(1, 5, 'Created thread: Welcome to ForumHub Pro!', 'thread', 1, NOW()),
(4, 5, 'Created thread: Best Programming Languages in 2025', 'thread', 2, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 5, 'Created thread: Share Your Creative Projects', 'thread', 3, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, 2, 'Posted reply', 'post', 1, DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(4, 2, 'Posted reply', 'post', 2, DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(5, 2, 'Posted reply', 'post', 3, DATE_SUB(NOW(), INTERVAL 3 HOUR));

-- Insert some notifications
INSERT INTO notifications (user_id, type, title, message, link, created_at) VALUES
(3, 'system', 'Welcome to ForumHub Pro!', 'Thanks for joining our community. Start by exploring threads and introducing yourself!', '/home', NOW()),
(4, 'reply', 'New reply to your thread', 'Someone replied to your thread "Best Programming Languages in 2025"', '/threads/2', DATE_SUB(NOW(), INTERVAL 1 DAY)),
(5, 'mention', 'You were mentioned', 'You were mentioned in a discussion', '/threads/3', DATE_SUB(NOW(), INTERVAL 2 HOUR));

-- Insert some messages
INSERT INTO messages (sender_id, receiver_id, message, is_read, created_at) VALUES
(1, 3, 'Welcome to ForumHub Pro! If you have any questions, feel free to reach out.', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(3, 1, 'Thanks! I''m loving the platform so far. The 3D landing page is incredible!', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(4, 5, 'Hey! Saw your creative work. Really impressive stuff!', 0, DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(2, 3, 'Thanks for participating in the discussions. You''re a great addition to the community!', 0, DATE_SUB(NOW(), INTERVAL 3 HOUR));

-- Insert bookmarks
INSERT INTO bookmarks (user_id, thread_id, created_at) VALUES
(3, 5, NOW()),
(4, 1, NOW()),
(5, 2, NOW());

-- Insert thread subscriptions
INSERT INTO thread_subscriptions (user_id, thread_id, created_at) VALUES
(3, 1, NOW()),
(4, 2, NOW()),
(5, 3, NOW());

-- Verification queries
SELECT 'Users created:' as Status, COUNT(*) as Count FROM users;
SELECT 'Categories created:' as Status, COUNT(*) as Count FROM categories;
SELECT 'Threads created:' as Status, COUNT(*) as Count FROM threads;
SELECT 'Posts created:' as Status, COUNT(*) as Count FROM posts;
SELECT 'Events created:' as Status, COUNT(*) as Count FROM events;

-- Display demo accounts
SELECT '=== DEMO ACCOUNTS ===' as Info;
SELECT 
    username,
    email,
    role,
    'password' as password_hint,
    reputation
FROM users
ORDER BY role DESC, reputation DESC;
