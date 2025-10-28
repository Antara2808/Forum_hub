-- Update users table with new profile customization fields
ALTER TABLE users ADD linkedin VARCHAR(100) DEFAULT NULL;
ALTER TABLE users ADD instagram VARCHAR(100) DEFAULT NULL;
ALTER TABLE users ADD profile_theme VARCHAR(20) DEFAULT 'default';
ALTER TABLE users ADD banner_style VARCHAR(20) DEFAULT 'gradient';
ALTER TABLE users ADD show_email BOOLEAN DEFAULT TRUE;
ALTER TABLE users ADD show_online BOOLEAN DEFAULT TRUE;
ALTER TABLE users ADD profile_visibility VARCHAR(20) DEFAULT 'public';

-- Add indexes for new fields
ALTER TABLE users ADD INDEX idx_profile_theme (profile_theme);
ALTER TABLE users ADD INDEX idx_profile_visibility (profile_visibility);