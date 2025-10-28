# ForumHub Pro - Admin Dashboard Documentation

## 🎯 Overview

The ForumHub Pro Admin Dashboard is a comprehensive management system built with PHP (MVC), TailwindCSS, and Chart.js. It provides full control over your community platform with an intuitive, modern interface.

## 🚀 Features

### ✅ **Dashboard Overview**
- **Real-time Statistics**: Total users, threads, posts, polls, file uploads, and daily views
- **Interactive Charts**:
  - **Bar Chart**: Top Contributors by post count
  - **Pie Chart**: Most viewed threads (Hot Threads)
  - **Line Chart**: Weekly post activity
- **Live Counters**: Online users, today's signups, and activity metrics
- **Recent Activities Feed**: Latest threads, posts, and user registrations
- **Top Users Leaderboard**: Ranked by reputation points

### 👥 **User Management**
- View all registered users with detailed information
- Change user roles (User → Moderator → Admin)
- Add or deduct reputation points
- Ban/unban users with reasons
- Search and filter users
- View user activity history

### 🧵 **Thread Management**
- View all forum threads with stats (views, replies)
- Pin/unpin important threads
- Edit or delete threads
- Filter by category, status, and sort options
- Search threads by title or content
- Bulk actions support

### 🏷️ **Category Management**
- Create, edit, and delete categories
- Assign icons and colors to categories
- Reorder categories by drag-and-drop
- View thread count per category

### 🗳️ **Poll Management**
- Create new polls with multiple options
- View poll results with visual progress bars
- Activate/deactivate polls
- Delete polls
- Track total votes and participation rates
- Set poll duration (7, 14, 30 days, or no expiration)

### ⚙️ **Site Settings**
- **General Settings**: Site title, tagline, description, contact email
- **Email Configuration**: SMTP settings (host, port, username, password, encryption)
- **Forum Settings**: Posts per page, threads per page, max upload size
- **Feature Toggles**: Enable/disable registration, email verification, reputation system, polls
- **Branding**: Upload site logo and favicon

## 📊 Analytics & Charts

All charts support **dark mode** and automatically adjust colors based on the current theme.

### Chart Types

1. **Top Contributors (Bar Chart)**
   - X-axis: Usernames
   - Y-axis: Number of posts
   - Filterable by: This Week, This Month, All Time

2. **Hot Threads (Doughnut Chart)**
   - Segments: Top 5 most viewed threads
   - Shows view count percentage
   - Color-coded for easy distinction

3. **Weekly Post Activity (Line Chart)**
   - X-axis: Days (Mon-Sun)
   - Y-axis: Post count
   - Smooth gradient fill
   - Toggle between Posts, Users, Threads

## 🎨 Design Features

### Responsive Layout
- **Desktop**: Full sidebar + main content
- **Tablet**: Collapsible sidebar
- **Mobile**: Hidden sidebar with toggle button

### Theme Support
- **Light Mode**: Clean, bright interface
- **Dark Mode**: Eye-friendly dark theme
- **Persistent**: Saved to localStorage and database

### Navigation
- Fixed sidebar with highlighted active page
- Quick links to main forum
- User profile in sidebar footer
- Mobile-friendly hamburger menu

### UI Components
- Modern card-based design
- Gradient headers for sections
- Smooth transitions and hover effects
- Toast notifications (no browser alerts)
- Custom confirm dialogs
- Loading states and animations

## 🔒 Security & Access Control

### Role-Based Access
- Only **Admins** and **Moderators** can access admin panel
- Redirects unauthorized users to login
- CSRF token protection on all forms
- Session-based authentication

### Permissions
| Feature | Admin | Moderator | User |
|---------|-------|-----------|------|
| Dashboard Access | ✅ | ✅ | ❌ |
| User Management | ✅ | ✅ | ❌ |
| Thread Management | ✅ | ✅ | ❌ |
| Category Management | ✅ | ❌ | ❌ |
| Poll Management | ✅ | ✅ | ❌ |
| Site Settings | ✅ | ❌ | ❌ |

## 📁 File Structure

```
app/
├── Views/
│   ├── layouts/
│   │   ├── admin_header.php      # Admin layout header with sidebar
│   │   └── admin_footer.php      # Admin layout footer
│   └── admin/
│       ├── dashboard.php         # Main dashboard with charts
│       ├── users.php             # User management
│       ├── threads.php           # Thread management
│       ├── categories.php        # Category management
│       ├── polls.php             # Poll management
│       └── settings.php          # Site settings
├── Controllers/
│   └── AdminController.php       # All admin logic
└── routes.php                    # Admin routes

public/
└── assets/
    ├── js/app.js                 # Toast notifications & interactions
    └── css/style.css             # Custom styles
```

## 🛠️ Installation & Setup

### 1. Access the Admin Panel
Visit: `http://localhost/ForumHub/public/admin`

### 2. Login as Admin
Use admin credentials (created during installation)

### 3. Configure Settings
1. Go to **Site Settings**
2. Set up SMTP for email notifications
3. Configure forum preferences
4. Upload logo and favicon

### 4. Create Categories
1. Navigate to **Manage Categories**
2. Click "Create Category"
3. Set name, icon, color, and description

### 5. Manage Users
1. Go to **Manage Users**
2. Assign moderator roles
3. Manage reputation points

## 💡 Usage Examples

### Creating a Poll
```php
1. Click "Create Poll" button
2. Enter poll question
3. Add 2+ options
4. Set duration (days)
5. Click "Create Poll"
```

### Pinning a Thread
```php
1. Go to "Manage Threads"
2. Find thread to pin
3. Click pin icon (📌)
4. Confirm action
5. Thread appears at top
```

### Changing User Role
```php
1. Go to "Manage Users"
2. Find user
3. Click role dropdown
4. Select new role
5. Confirm change
```

## 🎨 Customization

### Chart Colors
Edit in `admin/dashboard.php`:
```javascript
const chartColors = {
    primary: isDark ? '#60a5fa' : '#3b82f6',
    success: isDark ? '#34d399' : '#10b981',
    // ... more colors
};
```

### Stats Cards
Add new stat cards in `admin/dashboard.php`:
```php
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm">New Stat</p>
            <p class="text-3xl font-bold"><?php echo $stats['new_stat']; ?></p>
        </div>
        <i class="fas fa-icon text-4xl text-blue-600"></i>
    </div>
</div>
```

## 📱 Mobile Features

- Touch-friendly buttons and controls
- Swipe gesture support for sidebar
- Responsive tables with horizontal scroll
- Collapsible sections for small screens
- Optimized chart sizes

## 🔔 Notifications

### Toast Notifications
Replace browser alerts with modern toasts:
```javascript
Toast.success('Action completed!');
Toast.error('Something went wrong');
Toast.warning('Please review this');
Toast.info('New information available');
```

### Custom Confirm Dialogs
```javascript
const confirmed = await showConfirm({
    icon: '🗑️',
    title: 'Delete Item',
    message: 'Are you sure?',
    confirmText: 'Delete'
});
```

## 🚀 Performance

- **Lazy Loading**: Charts load only when needed
- **Caching**: Database queries cached
- **Optimized Images**: Compressed assets
- **Minified CSS/JS**: Production ready
- **GPU Acceleration**: Smooth animations

## 🐛 Troubleshooting

### Charts Not Displaying
```bash
# Check Chart.js is loaded
View browser console for errors
Ensure Chart.js CDN is accessible
```

### Sidebar Not Collapsing
```javascript
// Check Alpine.js is loaded
// Verify toggle function exists
function toggleSidebar() { ... }
```

### Theme Not Persisting
```php
// Check localStorage
localStorage.getItem('theme')
// Verify API endpoint
/api/update-theme
```

## 📈 Future Enhancements

- [ ] Export data to CSV/PDF
- [ ] Advanced analytics with date ranges
- [ ] Email campaign management
- [ ] Automated moderation tools
- [ ] Plugin/extension system
- [ ] Multi-language support
- [ ] Two-factor authentication
- [ ] Activity audit logs
- [ ] Scheduled posts
- [ ] Newsletter integration

## 📞 Support

For questions or issues:
- Email: admin@forumhub.com
- Documentation: `/community/guidelines`
- GitHub: [ForumHub Pro Repository]

## 📄 License

ForumHub Pro v2.0.0 - All rights reserved
Built with ❤️ using PHP, TailwindCSS, and Chart.js

---

**Version**: 2.0.1  
**Last Updated**: October 2025  
**Author**: ForumHub Pro Team
