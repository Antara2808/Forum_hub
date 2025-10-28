# ForumHub Pro - Setup Instructions

## Quick Start Guide

### 1. Database Setup

Open phpMyAdmin (`http://localhost/phpmyadmin`) and follow these steps:

#### Create Database
```sql
CREATE DATABASE forumhub_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Import Schema
- Click on `forumhub_mvc` database
- Go to "Import" tab
- Choose file: `database/forumhub_mvc.sql`
- Click "Go"

#### Load Sample Data
- Go to "Import" tab again
- Choose file: `database/sample_data.sql`
- Click "Go"

### 2. Verify Installation

Visit: `http://localhost/ForumHub/public`

You should see the stunning 3D landing page!

### 3. Login

Use any of these demo accounts:

**Admin Account:**
- Email: `admin@forumhub.com`
- Password: `password`

**Regular User:**
- Email: `user@forumhub.com`
- Password: `password`

## Features Tour

### 1. Landing Page
- 3D particle system with mouse tracking
- Scroll-triggered animations
- Responsive design

### 2. Dashboard (`/home`)
- Stats overview
- Category browsing
- Recent discussions
- Online users
- Top contributors

### 3. Create Thread (`/threads/create`)
- Select category
- Rich text content
- File attachments (coming soon)
- Polls (coming soon)

### 4. View Thread (`/threads/:id`)
- Read full discussion
- Reply to thread
- Bookmark
- Share

### 5. Profile (`/profile/:id`)
- View user info
- See threads and posts
- Reputation rank
- Edit your profile

### 6. Messages (`/messages`)
- Private conversations
- Real-time updates
- Notification badges

### 7. Events (`/events`)
- Browse upcoming events
- Create new events
- RSVP to events

### 8. Analytics (`/analytics`)
- Charts and statistics
- Community insights
- Admin/Moderator only

### 9. Admin Panel (`/admin`)
- User management
- Category management
- Content moderation
- System settings
- Admin only

## Configuration Options

Edit `config/config.php` to customize:

```php
// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'forumhub_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');

// File Uploads
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Pagination
define('THREADS_PER_PAGE', 15);
define('POSTS_PER_PAGE', 20);

// Reputation Points
define('POINTS_CREATE_THREAD', 5);
define('POINTS_CREATE_POST', 2);
```

## Folder Permissions

Ensure these folders are writable:

```bash
chmod -R 777 public/uploads/
chmod -R 777 public/uploads/avatars/
chmod -R 777 public/uploads/files/
chmod -R 777 public/uploads/banners/
```

## Apache Configuration

Ensure `mod_rewrite` is enabled in `httpd.conf`:

```apache
LoadModule rewrite_module modules/mod_rewrite.so
```

And allow `.htaccess` overrides:

```apache
<Directory "C:/xampp/htdocs">
    AllowOverride All
</Directory>
```

## Testing the Application

### Test User Registration
1. Go to `/auth/register`
2. Create a new account
3. Login with your credentials

### Test Thread Creation
1. Login as any user
2. Click "New Thread"
3. Fill in title and content
4. Select a category
5. Submit

### Test Private Messaging
1. Login as one user
2. Go to another user's profile
3. Click "Send Message"
4. Type your message
5. Check `/messages`

### Test Admin Features
1. Login as admin@forumhub.com
2. Go to `/admin`
3. Try managing categories
4. View user list

## Troubleshooting

### Cannot connect to database
- Start MySQL in XAMPP Control Panel
- Check database credentials
- Verify database exists

### 404 on all pages
- Check `.htaccess` files exist
- Enable `mod_rewrite` in Apache
- Restart Apache

### Blank white screen
- Enable error reporting in `config/config.php`
- Check PHP error logs
- Verify PHP version (7.4+)

### Theme not changing
- Clear browser cache
- Check browser console for errors
- Verify JavaScript is enabled

## Next Steps

1. **Customize Design**
   - Edit `public/assets/css/style.css`
   - Modify TailwindCSS classes in views

2. **Add Categories**
   - Login as admin
   - Go to `/admin/categories`
   - Create your own categories

3. **Invite Users**
   - Share registration link
   - Create welcome threads
   - Set up community guidelines

4. **Configure Events**
   - Create your first event
   - Link events to threads
   - Send notifications

## Support

If you encounter any issues:

1. Check the README.md
2. Review this setup guide
3. Check browser console for errors
4. Review Apache/PHP error logs

## Enjoy ForumHub Pro! 🚀
