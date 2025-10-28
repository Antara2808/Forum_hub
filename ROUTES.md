# 🗺️ ForumHub Pro - Routes & URLs

## Complete URL Reference Guide

Base URL: `http://localhost/ForumHub/public`

---

## 🏠 Public Routes (No Login Required)

### Landing & Home
```
GET  /                    → 3D Landing Page
GET  /home                → Main Dashboard (requires login)
```

### Authentication
```
GET  /auth/login          → Login Form
POST /auth/login          → Process Login
GET  /auth/register       → Registration Form
POST /auth/register       → Process Registration
GET  /auth/logout         → Logout User
```

---

## 💬 Thread Routes

### Browse Threads
```
GET  /threads             → List All Threads
GET  /threads?category=slug → Filter by Category
GET  /threads?page=2      → Pagination
```

### View Thread
```
GET  /threads/:id         → View Single Thread
                           Example: /threads/1
```

### Manage Threads (Login Required)
```
GET  /threads/create      → Create Thread Form
POST /threads/create      → Submit New Thread
GET  /threads/:id/edit    → Edit Thread Form
POST /threads/:id/edit    → Update Thread
POST /threads/:id/delete  → Delete Thread
```

---

## 💭 Post Routes (Login Required)

```
POST /posts/create        → Create Reply
POST /posts/:id/edit      → Edit Post
POST /posts/:id/delete    → Delete Post
```

---

## 👤 User Profile Routes

```
GET  /profile/:id         → View User Profile
GET  /profile/:id/edit    → Edit Profile Form (own profile only)
POST /profile/:id/edit    → Update Profile
```

---

## 💌 Message Routes (Login Required)

```
GET  /messages            → Message Inbox
GET  /messages/:id        → Conversation with User
POST /messages/send       → Send Message
GET  /messages/unread     → Get Unread Count (API)
```

---

## 📅 Event Routes

```
GET  /events              → List All Events
GET  /events/create       → Create Event Form (login required)
POST /events/create       → Submit New Event
GET  /events/:id          → View Event Details
```

---

## 🔍 Search Routes

```
GET  /search              → Search Page
GET  /search?q=keyword    → Search Results
```

---

## 📊 Analytics Routes (Admin/Moderator Only)

```
GET  /analytics           → Analytics Dashboard
GET  /analytics/users     → User Statistics
GET  /analytics/threads   → Thread Statistics
GET  /analytics/activity  → Activity Charts
```

---

## ⚙️ Admin Routes (Admin Only)

### Admin Dashboard
```
GET  /admin               → Admin Dashboard
```

### User Management
```
GET  /admin/users         → User List
POST /admin/users/:id/ban → Ban User
POST /admin/users/:id/unban → Unban User
POST /admin/users/:id/role → Change User Role
```

### Category Management
```
GET  /admin/categories         → Category List
POST /admin/categories/create  → Create Category
POST /admin/categories/:id/edit → Edit Category
POST /admin/categories/:id/delete → Delete Category
```

### Reports (Moderation)
```
GET  /admin/reports       → View Reports
POST /admin/reports/:id/resolve → Resolve Report
```

---

## 🔧 API Routes (AJAX)

### Theme
```
POST /api/update-theme    → Update User Theme
     Body: { theme: 'dark' | 'light' }
     Returns: { success: true }
```

### Messages
```
GET  /messages/unread     → Get Unread Count
     Returns: { count: 5 }
```

### Live Search (Future)
```
GET  /api/search/live?q=  → Live Search Results
     Returns: { results: [...] }
```

---

## 📋 Route Parameters

### Thread ID
```
:id = Thread ID (integer)
Example: /threads/5
```

### User ID
```
:id = User ID (integer)
Example: /profile/3
```

### Category Slug
```
?category=slug
Example: /threads?category=technology
```

### Page Number
```
?page=number
Example: /threads?page=2
```

---

## 🔐 Access Control

### Public Access ✅
- Landing page
- Login/Register
- View threads (may be restricted)
- View profiles

### Authenticated Users 🔑
- Create threads
- Post replies
- Send messages
- Edit own content
- Bookmark threads
- RSVP to events

### Moderators 👮
- All user permissions
- Pin/Lock threads
- Delete any content
- View analytics
- Ban users
- Review reports

### Administrators 👑
- All moderator permissions
- User management
- Category management
- System settings
- Full analytics
- Audit logs

---

## 📱 Example URLs

### Landing Page
```
http://localhost/ForumHub/public/
```

### Login
```
http://localhost/ForumHub/public/auth/login
```

### Register
```
http://localhost/ForumHub/public/auth/register
```

### Dashboard
```
http://localhost/ForumHub/public/home
```

### Browse Threads
```
http://localhost/ForumHub/public/threads
```

### View Thread #1
```
http://localhost/ForumHub/public/threads/1
```

### Create Thread
```
http://localhost/ForumHub/public/threads/create
```

### Technology Category
```
http://localhost/ForumHub/public/threads?category=technology
```

### User Profile #1
```
http://localhost/ForumHub/public/profile/1
```

### Messages
```
http://localhost/ForumHub/public/messages
```

### Events
```
http://localhost/ForumHub/public/events
```

### Search
```
http://localhost/ForumHub/public/search?q=programming
```

### Analytics
```
http://localhost/ForumHub/public/analytics
```

### Admin Panel
```
http://localhost/ForumHub/public/admin
```

---

## 🔀 Redirects

### Root to Landing
```
/  →  /landing page (if not logged in)
/  →  /home (if logged in)
```

### Auth Required
```
/threads/create  →  /auth/login (if not logged in)
/messages        →  /auth/login (if not logged in)
/profile/edit    →  /auth/login (if not logged in)
```

### Role Required
```
/admin           →  403 Forbidden (if not admin)
/analytics       →  403 Forbidden (if not admin/mod)
```

---

## ⚡ URL Rewriting

### Clean URLs Enabled
Thanks to `.htaccess` rewriting:

**Before:**
```
/public/index.php?url=threads/1
```

**After:**
```
/threads/1
```

### Rules Applied
1. Remove `index.php` from URL
2. Route all requests through front controller
3. Maintain query parameters
4. Handle static assets correctly

---

## 🎯 Route Testing

Test these routes after installation:

### Basic Navigation
- [ ] `/` - Landing page loads
- [ ] `/home` - Dashboard (after login)
- [ ] `/threads` - Thread list
- [ ] `/auth/login` - Login form

### Thread Operations
- [ ] `/threads/create` - Create form
- [ ] `/threads/1` - View thread
- [ ] Post reply works

### User Features
- [ ] `/profile/1` - View profile
- [ ] `/messages` - Message inbox
- [ ] `/events` - Events list

### Admin Features
- [ ] `/admin` - Admin panel (admin only)
- [ ] `/analytics` - Analytics (admin/mod)

### API Endpoints
- [ ] `/messages/unread` - Returns JSON
- [ ] Theme toggle saves preference

---

## 🚫 404 Handling

Invalid routes return 404:

```
/invalid-route        → 404 Page Not Found
/threads/99999        → Redirects to /threads
/profile/99999        → Redirects to /home
```

---

## 🔄 HTTP Methods

### GET Requests
Used for:
- Displaying pages
- Fetching data
- Public content

### POST Requests
Used for:
- Form submissions
- Creating content
- Updating data
- Delete operations

### AJAX Requests
Used for:
- Live updates
- API calls
- Real-time features

---

## 📊 Response Types

### HTML Pages
```
Content-Type: text/html
Returns: Full HTML page with header/footer
```

### JSON API
```
Content-Type: application/json
Returns: { "success": true, "data": {...} }
```

### Redirects
```
Status: 302 Found
Location: /target-url
```

---

## 🛠️ Custom Routes

To add a new route, edit `app/routes.php`:

```php
// GET route
$router->get('/my-route', ['Controllers\MyController', 'index']);

// POST route
$router->post('/my-route', ['Controllers\MyController', 'store']);

// Route with parameter
$router->get('/items/:id', ['Controllers\ItemController', 'show']);
```

---

## 📝 Route Naming Convention

```
Resource     | GET (List) | GET (View) | POST (Create) | POST (Update) | POST (Delete)
-------------|------------|------------|---------------|---------------|-------------
Threads      | /threads   | /threads/:id | /threads/create | /threads/:id/edit | /threads/:id/delete
Posts        | -          | -          | /posts/create | /posts/:id/edit | /posts/:id/delete
Messages     | /messages  | /messages/:id | /messages/send | - | -
Events       | /events    | /events/:id | /events/create | /events/:id/edit | -
Users        | -          | /profile/:id | - | /profile/:id/edit | -
```

---

## 🎉 Summary

**Total Routes:** 35+
**Public Routes:** 8
**Auth Required:** 20+
**Admin Only:** 7+
**API Endpoints:** 5+

**All routes are:**
- ✅ Clean and semantic
- ✅ RESTful where applicable
- ✅ Secure (CSRF protected)
- ✅ Role-based access controlled
- ✅ Well documented

---

**ForumHub Pro v2.0.0**
*Complete Route Reference*

For more details, see `app/routes.php`
