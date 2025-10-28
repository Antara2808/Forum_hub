<!DOCTYPE html>
<html lang="en" class="<?php echo $_SESSION['user']['theme'] ?? 'dark'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard - ForumHub Pro'; ?></title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // Theme initialization
        const theme = localStorage.getItem('theme') || '<?php echo $_SESSION['user']['theme'] ?? 'dark'; ?>';
        document.documentElement.classList.toggle('dark', theme === 'dark');
        
        // Flash messages as toasts
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($success = flash('success')): ?>
            Toast.success(<?php echo json_encode($success); ?>);
            <?php endif; ?>
            
            <?php if ($error = flash('error')): ?>
            Toast.error(<?php echo json_encode($error); ?>);
            <?php endif; ?>
            
            <?php if ($warning = flash('warning')): ?>
            Toast.warning(<?php echo json_encode($warning); ?>);
            <?php endif; ?>
            
            <?php if ($info = flash('info')): ?>
            Toast.info(<?php echo json_encode($info); ?>);
            <?php endif; ?>
        });
    </script>
    
    <style>
        /* Admin-specific gradient background */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        
        .dark ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #764ba2 0%, #667eea 100%);
        }
        
        /* Sidebar transition */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark #sidebar {
            background: linear-gradient(180deg, #1a1a2e 0%, #0f3460 100%);
        }
        
        @media (max-width: 1024px) {
            #sidebar.closed {
                transform: translateX(-100%);
            }
        }
        
        /* Glassmorphism effect for cards */
        .admin-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .dark .admin-card {
            background: rgba(26, 32, 53, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Animated gradient text */
        .gradient-text {
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-shift 3s ease infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }
        
        /* Navigation hover effects */
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #667eea, #764ba2);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .nav-item:hover::before,
        .nav-item.active::before {
            transform: translateX(0);
        }
    </style>
</head>
<body class="transition-colors duration-300">

<div class="flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 border-r border-white/10 flex flex-col shadow-2xl transition-all duration-300">
        
        <!-- Logo -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-white/10">
            <a href="<?php echo url('/admin'); ?>" class="flex items-center space-x-3">
                <i class="fas fa-shield-alt text-2xl text-white"></i>
                <div>
                    <h1 class="text-xl font-bold text-white">Admin Panel</h1>
                    <p class="text-xs text-white/70">ForumHub Pro</p>
                </div>
            </a>
            <button onclick="toggleSidebar()" class="lg:hidden text-white hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="<?php echo url('/admin'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo ($_SERVER['REQUEST_URI'] == '/admin' || $_SERVER['REQUEST_URI'] == '/admin/') 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-chart-line text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <!-- Manage Users -->
                <a href="<?php echo url('/admin/users'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-users text-lg"></i>
                    <span class="font-medium">Manage Users</span>
                </a>
                
                <!-- Manage Threads -->
                <a href="<?php echo url('/admin/threads'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/threads') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-comments text-lg"></i>
                    <span class="font-medium">Manage Threads</span>
                </a>
                
                <!-- Manage Categories -->
                <a href="<?php echo url('/admin/categories'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-folder text-lg"></i>
                    <span class="font-medium">Manage Categories</span>
                </a>
                
                <!-- Manage Polls -->
                <a href="<?php echo url('/admin/polls'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/polls') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-poll text-lg"></i>
                    <span class="font-medium">Manage Polls</span>
                </a>
                
                <!-- Content Reports -->
                <a href="<?php echo url('/admin/reports'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-flag text-lg"></i>
                    <span class="font-medium">Content Reports</span>
                </a>
                
                <!-- Activity Overview -->
                <a href="<?php echo url('/admin/activity'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/activity') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-chart-area text-lg"></i>
                    <span class="font-medium">Activity Overview</span>
                </a>
                
                <!-- Analytics -->
                <a href="<?php echo url('/analytics'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300 text-white/80 hover:bg-white/10 hover:text-white">
                    <i class="fas fa-chart-bar text-lg"></i>
                    <span class="font-medium">Analytics</span>
                </a>
                
                <!-- Site Settings -->
                <a href="<?php echo url('/admin/settings'); ?>" 
                   class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300
                          <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false) 
                              ? 'active bg-white/20 text-white shadow-lg' 
                              : 'text-white/80 hover:bg-white/10 hover:text-white'; ?>">
                    <i class="fas fa-cog text-lg"></i>
                    <span class="font-medium">Site Settings</span>
                </a>
            </div>
            
            <!-- Divider -->
            <div class="my-4 border-t border-white/10"></div>
            
            <!-- Quick Links -->
            <div class="space-y-1">
                <p class="px-4 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">Quick Links</p>
                
                <a href="<?php echo url('/home'); ?>" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm text-white/70 hover:bg-white/10 hover:text-white transition-all duration-300">
                    <i class="fas fa-home"></i>
                    <span>View Forum</span>
                </a>
                
                <a href="<?php echo url('/profile/' . $_SESSION['user']['id']); ?>" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg text-sm text-white/70 hover:bg-white/10 hover:text-white transition-all duration-300">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </div>
        </nav>
        
        <!-- User Info & Logout -->
        <div class="border-t border-white/10 p-4">
            <div class="flex items-center space-x-3 mb-3">
                <img src="<?php echo userAvatar(); ?>" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-white/30">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">
                        <?php echo e($_SESSION['user']['username']); ?>
                    </p>
                    <p class="text-xs text-white/60 capitalize">
                        <?php echo $_SESSION['user']['role']; ?>
                    </p>
                </div>
            </div>
            
            <a href="<?php echo url('/auth/logout'); ?>" 
               class="flex items-center justify-center space-x-2 w-full px-4 py-2 bg-red-600/80 hover:bg-red-600 text-white rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                <i class="fas fa-sign-out-alt"></i>
                <span class="font-medium">Logout</span>
            </a>
        </div>
    </aside>
    
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Top Navbar -->
        <header class="h-16 admin-card border-b border-gray-200 dark:border-gray-700/50 flex items-center justify-between px-6 shadow-lg">
            <!-- Mobile Menu Toggle -->
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                <i class="fas fa-bars text-xl text-gray-600 dark:text-gray-300"></i>
            </button>
            
            <!-- Page Title (Mobile Hidden) -->
            <div class="hidden md:block">
                <h2 class="text-2xl font-bold gradient-text">
                    <?php echo $pageTitle ?? 'Dashboard'; ?>
                </h2>
            </div>
            
            <!-- Right Actions -->
            <div class="flex items-center space-x-3">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" 
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-moon dark:hidden text-gray-600 text-lg"></i>
                    <i class="fas fa-sun hidden dark:inline text-yellow-400 text-lg"></i>
                </button>
                
                <!-- Notifications -->
                <button class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-bell text-gray-600 dark:text-gray-300 text-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                </button>
                
                <!-- Admin Badge -->
                <span class="hidden sm:inline-flex px-3 py-1.5 text-xs font-semibold rounded-full bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg">
                    <i class="fas fa-crown mr-1"></i> Admin
                </span>
            </div>
        </header>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
