# ForumHub Pro - Installation & Testing Guide

## ✅ Quick Installation Checklist

### 1. Database Setup
```bash
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Create database: Click "New" → Name: "forumhub_mvc" → Create
3. Select forumhub_mvc database
4. Click "Import" tab
5. Choose file: database/forumhub_mvc.sql → Go
6. Import sample data: database/sample_data.sql → Go
```

### 2. Verify File Structure
```
ForumHub/
├── app/ ✓
├── config/ ✓
├── database/ ✓
├── public/ ✓
└── README.md ✓
```

### 3. Test Access
```
http://localhost/ForumHub/public
```

## 🧪 Testing Guide

### Test 1: Landing Page
- **URL**: `http://localhost/ForumHub/public/`
- **Expected**: 3D particle animation with interactive elements
- **Check**: 
  - Particles move with mouse
  - Smooth scroll animations
  - Responsive on mobile

### Test 2: User Registration
1. Click "Join Now" or go to `/auth/register`
2. Fill in:
   - Username: testuser
   - Email: test@example.com
   - Password: password123
   - Confirm Password: password123
3. Click "Create Account"
4. **Expected**: Redirect to login with success message

### Test 3: User Login
1. Go to `/auth/login`
2. Use demo account:
   - Email: user@forumhub.com
   - Password: password
3. **Expected**: Redirect to dashboard

### Test 4: Dashboard
- **URL**: `/home`
- **Check**:
  - Stats cards display
  - Categories list
  - Recent threads
  - Sidebar widgets

### Test 5: Create Thread
1. Click "New Thread"
2. Fill in:
   - Title: "My First Thread"
   - Category: Select any
   - Content: "This is a test thread"
3. Submit
4. **Expected**: 
   - Thread created
   - Reputation +5 points
   - Redirect to thread view

### Test 6: View Thread
- **Check**:
  - Thread content displays
  - Author info shown
  - Reply form available
  - Breadcrumb navigation

### Test 7: Post Reply
1. On thread page, scroll to reply form
2. Enter: "This is my reply"
3. Submit
4. **Expected**:
   - Reply appears
   - Reputation +2 points
   - Success message

### Test 8: Dark Mode Toggle
1. Click moon/sun icon in navbar
2. **Expected**:
   - Theme switches
   - Preference saved
   - All components update

### Test 9: Private Messages
1. Visit another user's profile
2. Click "Send Message" (if available)
3. Or go to `/messages`
4. **Expected**: Message interface loads

### Test 10: Search
1. Use search bar (if visible)
2. Or go to `/search`
3. Enter: "thread"
4. **Expected**: Results display

### Test 11: Admin Access
1. Login as: admin@forumhub.com / password
2. Go to `/admin`
3. **Expected**:
   - Admin dashboard
   - User management
   - Category management

### Test 12: Analytics
1. Login as admin or moderator
2. Go to `/analytics`
3. **Expected**:
   - Chart.js visualizations
   - Statistics display

## 🐛 Common Issues & Solutions

### Issue: White Screen
**Solution**:
```php
// Edit config/config.php
define('ENVIRONMENT', 'development'); // Enable error reporting
```

### Issue: 404 on all pages
**Solution**:
1. Check Apache mod_rewrite is enabled
2. Verify .htaccess files exist
3. Restart Apache

### Issue: Database connection error
**Solution**:
```php
// Verify config/config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'forumhub_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### Issue: Theme not switching
**Solution**:
1. Clear browser cache
2. Check browser console for errors
3. Verify JavaScript is enabled

### Issue: Images not loading
**Solution**:
1. Check file permissions on public/uploads/
2. Verify path in config.php
3. Clear browser cache

## 📊 Performance Testing

### Page Load Times (Expected)
- Landing Page: < 2s
- Dashboard: < 1s
- Thread View: < 800ms
- Search: < 500ms

### Database Query Count
- Home Page: ~10 queries
- Thread View: ~5 queries
- Thread List: ~3 queries

## 🔒 Security Testing

### Test CSRF Protection
1. Try submitting form without token
2. **Expected**: Request rejected

### Test XSS Protection
1. Try posting: `<script>alert('xss')</script>`
2. **Expected**: Script tags escaped

### Test SQL Injection
1. Try username: `' OR '1'='1`
2. **Expected**: Treated as literal string

### Test Access Control
1. Logout
2. Try accessing `/admin`
3. **Expected**: Redirect to login

## 📱 Responsive Testing

Test on these viewports:
- Mobile: 375x667 (iPhone SE)
- Tablet: 768x1024 (iPad)
- Desktop: 1920x1080

**Check**:
- Navigation collapses on mobile
- Cards stack properly
- Forms are usable
- 3D scene scales appropriately

## ✅ Feature Completion Checklist

- [x] 3D Landing Page
- [x] User Authentication
- [x] Thread CRUD
- [x] Post/Reply System
- [x] User Profiles
- [x] Dark/Light Theme
- [x] Private Messaging
- [x] Reputation System
- [x] Categories
- [x] Search Functionality
- [x] Admin Dashboard
- [x] Analytics
- [x] Events System
- [x] Responsive Design
- [x] Security (CSRF, XSS, SQL Injection)

## 🚀 Production Deployment

### Before Going Live:

1. **Disable Debug Mode**
```php
define('ENVIRONMENT', 'production');
```

2. **Secure Uploads Folder**
```apache
# In public/uploads/.htaccess
<FilesMatch "\.(php|phtml|php3|php4|php5|phps)$">
    deny from all
</FilesMatch>
```

3. **Update URLs**
```php
define('APP_URL', 'https://yourdomain.com');
define('BASE_URL', '/');
```

4. **Enable HTTPS**
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

5. **Set Strong Passwords**
- Change all demo account passwords
- Use strong database password

6. **Backup Database**
```bash
mysqldump -u root -p forumhub_mvc > backup.sql
```

## 📈 Monitoring

### Check These Metrics:
- Active users online
- Threads created per day
- Average response time
- Database size
- Error logs

### Log Files Location:
- Apache Error Log: xampp/apache/logs/error.log
- PHP Error Log: xampp/php/logs/php_error_log

## 🎉 Success Criteria

Your installation is successful if:
- ✅ Landing page loads with 3D effects
- ✅ Can register and login
- ✅ Can create and view threads
- ✅ Can post replies
- ✅ Theme toggle works
- ✅ No PHP errors
- ✅ No JavaScript console errors
- ✅ Responsive on mobile

## 📞 Support

If you encounter issues:
1. Check this guide
2. Review README.md
3. Check browser console
4. Review PHP/Apache logs
5. Verify database connection

## 🎓 Next Steps

After successful testing:
1. Customize theme colors
2. Add your own categories
3. Create welcome threads
4. Set up community guidelines
5. Invite beta users
6. Monitor feedback

---

**Happy Testing! 🚀**

ForumHub Pro - The Future of Online Communities
