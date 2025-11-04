# ⚡ ForumHub Pro - How to Start

## 🚀 Quick Start Guide

### Step 1: Database Setup (1 minute)

**Option A: Automatic (Recommended)**
1. Double-click `database/install.bat`
2. Press any key when prompted
3. Wait for "Database setup complete!"

**Option B: Manual**
1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Create new database: `forumhub_mvc`
3. Import `database/forumhub_mvc.sql`
4. Import `database/sample_data.sql`

### Step 2: Start Development Server (30 seconds)

Run the development server:
```bash
npm run dev
```

Wait for Vite to start and show the local server URL.

### Step 3: Access ForumHub (30 seconds)

Open in browser:
```
http://localhost/ForumHub/public
```

You should see the stunning **3D Landing Page**!

### Step 4: Login (30 seconds)

Click "Join Now" or "Explore Community" and login with:

**Admin Account:**
- Email: `admin@forumhub.com`
- Password: `password`

**Regular User:**
- Email: `user@forumhub.com`
- Password: `password`

---

## ✅ Quick Verification Checklist

Visit these URLs to verify everything works:

- [ ] **Landing**: `http://localhost/ForumHub/public/`
  - ✓ 3D particles animate
  - ✓ Mouse interaction works
  - ✓ Scroll animations smooth

- [ ] **Login**: `http://localhost/ForumHub/public/auth/login`
  - ✓ Login form displays
  - ✓ Can login with demo account
  - ✓ Redirects to dashboard

- [ ] **Dashboard**: `http://localhost/ForumHub/public/home`
  - ✓ Stats cards show
  - ✓ Categories list
  - ✓ Recent threads display

- [ ] **Threads**: `http://localhost/ForumHub/public/threads`
  - ✓ Thread list shows
  - ✓ Can filter by category
  - ✓ Can create new thread

- [ ] **Theme Toggle**: Click moon/sun icon (top right)
  - ✓ Theme switches
  - ✓ All elements update
  - ✓ Preference saves

---

## 🎯 Try These Features

### 1. Create a Thread (2 minutes)
1. Click "New Thread" button
2. Enter title: "My First Thread"
3. Select a category
4. Write some content
5. Click "Create Thread"
6. ✅ Check your reputation increased by +5 points!

### 2. Reply to Thread (1 minute)
1. Click any thread
2. Scroll to reply form
3. Write a reply
4. Submit
5. ✅ Check your reputation increased by +2 points!

### 3. Test Dark Mode (30 seconds)
1. Click the moon icon (top right)
2. Watch everything smoothly transition to dark
3. Click sun icon to go back to light
4. ✅ Your preference is saved!

### 4. Browse Categories (1 minute)
1. On homepage, click any category
2. See threads filtered by category
3. Try different categories
4. ✅ Beautiful icons and colors!

### 5. View Profile (30 seconds)
1. Click your username in navbar
2. Select "Profile"
3. See your stats and activity
4. ✅ Click "Edit Profile" to customize!

### 6. Admin Panel (Admin only)
1. Login as `admin@forumhub.com`
2. Click "Admin" in navbar
3. Explore user management
4. Try managing categories
5. ✅ Full admin control!

---

## 🎨 Explore the UI

### Landing Page Features
- 🌌 **3D Particle System** - 1500+ interactive particles
- ✨ **Glowing Spheres** - 20 animated spheres
- 🖱️ **Mouse Tracking** - Camera follows your cursor
- 📜 **Scroll Effects** - GSAP animations on scroll
- 📱 **Fully Responsive** - Looks great on any device

### Dashboard Features
- 📊 **Stats Cards** - Threads, Users, Activity
- 📁 **Category Browser** - Color-coded categories
- 🔥 **Recent Threads** - Latest discussions
- 👥 **Online Users** - Live user count
- 🏆 **Top Contributors** - Leaderboard

### Thread Features
- 📝 **Rich Text** - Format your posts
- 🔖 **Bookmarks** - Save favorite threads
- 📌 **Pin Threads** - Moderator feature
- 🔒 **Lock Threads** - Prevent new replies
- 👁️ **View Counter** - Track popularity

---

## 🛠️ Common Customizations

### Change Site Name
Edit `config/config.php`:
```php
define('APP_NAME', 'Your Forum Name');
```

### Add New Category (Admin)
1. Login as admin
2. Go to `/admin/categories`
3. Click "Add Category"
4. Choose name, icon, color
5. Save

### Customize Theme Colors
Edit `public/assets/css/style.css`:
```css
/* Change primary blue to your color */
.btn-primary {
    background: #your-color;
}
```

---

## 📱 Test on Mobile

### iOS Safari
```
http://your-computer-ip/ForumHub/public
```

### Android Chrome
```
http://your-computer-ip/ForumHub/public
```

**Tips:**
- Navbar collapses on mobile
- Cards stack vertically
- Touch-friendly buttons
- Swipe gestures work

---

## 🎓 Learning Resources

### Understanding MVC Structure
```
app/
├── Controllers/  → Handle requests
├── Models/       → Database operations
└── Views/        → Display HTML
```

### Adding a New Page
1. Create controller in `app/Controllers/`
2. Create model in `app/Models/` (if needed)
3. Create view in `app/Views/`
4. Add route in `app/routes.php`

### Database Queries
All models extend `Core\Model` with methods:
- `find($id)` - Get by ID
- `all()` - Get all records
- `where($column, $value)` - Filter records
- `insert($data)` - Create new
- `update($id, $data)` - Update existing

---

## 🐛 Troubleshooting

### "Database Connection Error"
→ Start MySQL in XAMPP Control Panel

### "404 Not Found"
→ Check `.htaccess` files exist
→ Enable `mod_rewrite` in Apache

### "White Screen"
→ Set `ENVIRONMENT` to `development` in `config/config.php`
→ Check PHP error logs

### "Theme Not Switching"
→ Clear browser cache
→ Enable JavaScript
→ Check browser console

### "Can't Upload Avatar"
→ Check `public/uploads/avatars/` exists
→ Set folder permissions to writable

---

## ⚡ Performance Tips

### Optimize 3D Landing
- Reduce particle count for slower devices
- Edit `app/Views/landing/index.php`
- Change `particleCount` from 1500 to 1000

### Speed Up Queries
- Indexes already added
- Use pagination (implemented)
- Cache frequent queries

### Reduce Load Time
- Enable gzip compression
- Minify CSS/JS (production)
- Use CDN for libraries

---

## 🎉 What's Next?

### For Users
1. ✅ Create your first thread
2. ✅ Join discussions
3. ✅ Earn reputation points
4. ✅ Customize your profile
5. ✅ Send private messages

### For Admins
1. ✅ Add custom categories
2. ✅ Invite users
3. ✅ Moderate content
4. ✅ Review analytics
5. ✅ Customize settings

### For Developers
1. ✅ Study the MVC structure
2. ✅ Add custom features
3. ✅ Extend models
4. ✅ Create new controllers
5. ✅ Deploy to production

---

## 📞 Need Help?

1. **Check Documentation**
   - README.md - Full guide
   - SETUP.md - Detailed setup
   - TESTING.md - Testing procedures

2. **Review Code**
   - All code is commented
   - Follow MVC patterns
   - Check similar features

3. **Debug**
   - Enable error reporting
   - Check browser console
   - Review server logs

---

## 🏁 Final Checklist

Before showing to others:

- [ ] Change default passwords
- [ ] Add your own categories
- [ ] Create welcome threads
- [ ] Set up community rules
- [ ] Customize theme colors
- [ ] Add your branding
- [ ] Test on mobile
- [ ] Check all features work

---

## 🎊 Congratulations!

You now have a **fully functional, production-ready forum platform** with:

✨ Stunning 3D landing page
💬 Complete discussion system
🎨 Beautiful dark/light themes
🔒 Enterprise-level security
📱 Mobile responsive design
⚡ Lightning-fast performance

**Start building your community today!**

---

**ForumHub Pro v2.0.0**
*The Future of Online Communities*

🚀 **Happy Coding!**