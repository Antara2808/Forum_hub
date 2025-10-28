# ForumHub Pro v2.0.0

🌌 **The Future of Online Communities** - A next-generation community discussion platform with stunning 3D visuals, built using PHP (OOP + MVC), MySQL, and TailwindCSS.

## 🚀 Features

### Core Features
- ✅ **3D Interactive Landing Page** - Immersive Three.js particle system with GSAP animations
- ✅ **Authentication System** - Secure login/register with session management
- ✅ **Thread Management** - Create, edit, delete discussions with categories
- ✅ **Post/Reply System** - Engage in conversations with rich text
- ✅ **User Profiles** - Customizable profiles with avatars and bios
- ✅ **Reputation System** - Earn points and badges for participation
- ✅ **Dark/Light Theme** - Beautiful themes with persistence
- ✅ **Private Messaging** - One-on-one real-time chat
- ✅ **Events System** - Create and attend community events
- ✅ **Analytics Dashboard** - Beautiful Chart.js visualizations
- ✅ **Admin Panel** - Full management system
- ✅ **Moderation Tools** - Reports, bans, and content management
- ✅ **Advanced Search** - Filters and instant results
- ✅ **Responsive Design** - Mobile-friendly TailwindCSS UI

## 🧱 Tech Stack

- **Backend**: PHP 7.4+ (OOP, MVC pattern)
- **Frontend**: HTML5, TailwindCSS, JavaScript ES6
- **3D Engine**: Three.js
- **Animations**: GSAP (GreenSock)
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP)
- **Charts**: Chart.js
- **Icons**: Font Awesome 6

## 📦 Installation

### Prerequisites
- XAMPP (or similar) with PHP 7.4+ and MySQL 5.7+
- Modern web browser

### Step-by-Step Setup

1. **Clone/Extract to XAMPP**
   ```bash
   # Extract ForumHub to:
   C:\xampp\htdocs\ForumHub
   ```

2. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Import the database schema:
     ```
     database/forumhub_mvc.sql
     ```

3. **Load Sample Data**
   - Import sample data (optional but recommended):
     ```
     database/sample_data.sql
     ```

4. **Configure Database**
   - Edit `config/config.php` if needed (default settings work for XAMPP)
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'forumhub_mvc');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

5. **Set Permissions**
   - Ensure `public/uploads/` is writable
   ```bash
   chmod -R 777 public/uploads/
   ```

6. **Access the Application**
   - Landing Page: `http://localhost/ForumHub/public`
   - Or: `http://localhost/ForumHub/` (redirects to public)

## 👤 Demo Accounts

| Role      | Email                  | Password  | Reputation |
|-----------|------------------------|-----------|------------|
| Admin     | admin@forumhub.com     | password  | 1500       |
| Moderator | mod@forumhub.com       | password  | 800        |
| User      | user@forumhub.com      | password  | 250        |
| User      | john@example.com       | password  | 350        |
| User      | jane@example.com       | password  | 420        |

## 📁 Project Structure

```
ForumHub/
├── app/
│   ├── Controllers/        # Application controllers
│   │   ├── AuthController.php
│   │   ├── ThreadController.php
│   │   ├── HomeController.php
│   │   └── ...
│   ├── Models/            # Database models
│   │   ├── User.php
│   │   ├── Thread.php
│   │   ├── Post.php
│   │   └── ...
│   ├── Views/             # View templates
│   │   ├── layouts/       # Header, Footer
│   │   ├── auth/          # Login, Register
│   │   ├── home/          # Dashboard
│   │   ├── threads/       # Thread views
│   │   ├── landing/       # 3D Landing page
│   │   └── ...
│   ├── Core/              # Framework core
│   │   ├── Router.php     # URL routing
│   │   ├── Database.php   # Database connection
│   │   ├── Controller.php # Base controller
│   │   ├── Model.php      # Base model
│   │   └── Helpers.php    # Helper functions
│   └── routes.php         # Route definitions
├── config/
│   └── config.php         # Application configuration
├── database/
│   ├── forumhub_mvc.sql   # Database schema
│   └── sample_data.sql    # Sample data
├── public/                # Public web root
│   ├── assets/
│   │   ├── css/          # Stylesheets
│   │   ├── js/           # JavaScript files
│   │   └── images/       # Images
│   ├── uploads/          # User uploads
│   │   ├── avatars/
│   │   ├── files/
│   │   └── banners/
│   ├── .htaccess         # URL rewriting
│   └── index.php         # Front controller
├── .htaccess             # Root htaccess
└── README.md             # This file
```

## 🎨 3D Landing Page

The landing page features:
- **Particle System**: 1500+ interactive particles
- **Glowing Spheres**: 20 animated 3D spheres
- **Mouse Tracking**: Camera follows cursor
- **Scroll Animations**: GSAP ScrollTrigger effects
- **Responsive**: Optimized for all devices
- **Performance**: GPU-accelerated rendering

## 🗄 Database Schema

### Main Tables
- `users` - User accounts and profiles
- `categories` - Thread categories
- `threads` - Discussion threads
- `posts` - Thread replies
- `messages` - Private messages
- `events` - Community events
- `polls` - Thread polls
- `files` - File attachments
- `reports` - Moderation reports
- `reputation_log` - Point tracking
- `notifications` - User alerts
- `bookmarks` - Saved threads
- `audit_log` - Admin actions

## 🔐 Security Features

- ✅ CSRF Protection on all forms
- ✅ XSS Prevention (output escaping)
- ✅ SQL Injection Protection (PDO prepared statements)
- ✅ Password Hashing (bcrypt)
- ✅ Session Security (httponly, samesite)
- ✅ Input Validation & Sanitization
- ✅ Role-Based Access Control (RBAC)
- ✅ Secure File Upload Validation

## 📊 Reputation System

### How to Earn Points
- Create Thread: **+5 points**
- Reply to Thread: **+2 points**
- Receive Upvote: **+1 point**
- Receive Downvote: **-1 point**

### Ranks
- **Newbie**: 0-49 points
- **Bronze**: 50-149 points
- **Silver**: 150-299 points
- **Gold**: 300-599 points
- **Platinum**: 600-999 points
- **Diamond**: 1000-1999 points
- **Legend**: 2000+ points

## 🎨 Theme System

- Toggle between Light/Dark modes
- Saves preference to database and localStorage
- Auto-updates Chart.js colors
- Smooth transitions

## 🚀 Advanced Features

### Implemented
- 3D Landing Page with Three.js
- Real-time message notifications
- File upload system (images, docs)
- Pinned/Locked threads
- Thread bookmarking
- User reputation badges
- Event calendar
- Advanced search with filters
- Admin dashboard
- Moderation queue

### API Endpoints
- `/messages/unread` - Get unread message count
- `/api/update-theme` - Update user theme preference

## 🛠 Development

### Adding a New Feature

1. **Create Model** (if needed)
   ```php
   // app/Models/YourModel.php
   namespace Models;
   use Core\Model;
   
   class YourModel extends Model {
       protected $table = 'your_table';
   }
   ```

2. **Create Controller**
   ```php
   // app/Controllers/YourController.php
   namespace Controllers;
   use Core\Controller;
   
   class YourController extends Controller {
       public function index() {
           $this->view('your/view');
       }
   }
   ```

3. **Add Route**
   ```php
   // app/routes.php
   $router->get('/your-route', ['Controllers\YourController', 'index']);
   ```

4. **Create View**
   ```php
   // app/Views/your/view.php
   <?php require_once APP_PATH . '/Views/layouts/header.php'; ?>
   <!-- Your content -->
   <?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
   ```

## 📱 Responsive Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🎯 Performance Optimization

- Lazy loading for images
- Debounced search
- Paginated results
- Optimized database queries
- Minified assets (in production)
- GPU-accelerated 3D rendering

## 🐛 Troubleshooting

### Database Connection Error
- Check MySQL is running in XAMPP
- Verify database credentials in `config/config.php`
- Ensure database exists

### 404 Errors
- Check Apache `mod_rewrite` is enabled
- Verify `.htaccess` files exist
- Clear browser cache

### Theme Not Saving
- Check browser localStorage is enabled
- Verify database connection
- Check PHP sessions are working

### File Upload Fails
- Check `public/uploads/` permissions
- Verify PHP `upload_max_filesize` setting
- Check file type is allowed

## 📄 License

This project is open-source and available under the MIT License.

## 👨‍💻 Credits

- **Framework**: Custom PHP MVC
- **UI**: TailwindCSS
- **3D**: Three.js
- **Animations**: GSAP
- **Icons**: Font Awesome
- **Charts**: Chart.js

## 🎉 Version History

### v2.0.0 (Current)
- 3D Interactive Landing Page
- Complete MVC architecture
- Dark/Light theme system
- Analytics dashboard
- Event system
- Private messaging
- Advanced search
- Moderation tools
- Reputation system

---

**ForumHub Pro** - Connect. Discuss. Grow. 🚀

For support or questions, create a thread in the Help & Support category!
