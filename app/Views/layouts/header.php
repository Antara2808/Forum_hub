<!DOCTYPE html>
<html lang="en" class="<?php echo $_SESSION['user']['theme'] ?? 'dark'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'ForumHub Pro'; ?></title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo asset('css/style.css'); ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
</head>
<body class="bg-gray-100 dark:bg-[#0F1419] text-gray-900 dark:text-gray-100 transition-colors duration-200">

<?php if (isset($_SESSION['user_id'])): ?>
    <!-- Navbar for logged-in users -->
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed top-0 left-0 right-0 z-50 shadow-sm dark:shadow-lg transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14 gap-3">
                <!-- Left: Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="<?php echo url('/home'); ?>" 
                       class="flex items-center space-x-2 hover:opacity-80 transition-opacity focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 rounded-lg px-2 py-1">
                        <i class="fas fa-comments text-2xl text-[#FF4500]"></i>
                        <span class="text-xl font-bold hidden lg:inline text-gray-900 dark:text-gray-50 transition-colors duration-300">ForumHub</span>
                    </a>
                </div>
                
                <!-- Center: Search -->
                <div class="flex-1 max-w-xl mx-2 sm:mx-4 hidden md:block">
                    <form action="<?php echo url('/search'); ?>" method="GET">
                        <div class="relative">
                            <input type="text" name="q" 
                                   placeholder="Search ForumHub" 
                                   class="w-full px-4 py-2 pl-10 rounded-full 
                                          bg-gray-100 dark:bg-gray-800 
                                          border border-gray-300 dark:border-gray-700 
                                          text-gray-900 dark:text-gray-100 
                                          placeholder-gray-500 dark:placeholder-gray-400 
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent 
                                          transition-all duration-300 text-sm">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                        </div>
                    </form>
                </div>
                
                <!-- Right: Actions -->
                <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0">
                    <!-- Add Friend -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                                title="Add Friend">
                            <i class="fas fa-user-plus text-gray-600 dark:text-gray-300"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 p-4 z-50"
                             style="display: none;">
                            <h3 class="font-bold mb-3 text-gray-900 dark:text-white">
                                <i class="fas fa-user-plus text-blue-600"></i> Add Friend
                            </h3>
                            <form onsubmit="searchAndAddFriend(event)" class="space-y-3">
                                <input type="text" 
                                       id="friend-search-input"
                                       placeholder="Enter username..." 
                                       class="w-full px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                       autocomplete="off">
                                <div id="friend-search-results" class="max-h-60 overflow-y-auto space-y-2"></div>
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>Search User
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" 
                            class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        <i class="fas fa-moon dark:hidden text-gray-600"></i>
                        <i class="fas fa-sun hidden dark:inline text-yellow-400"></i>
                    </button>
                    
                    <!-- Messages -->
                    <a href="<?php echo url('/messages'); ?>" 
                       class="relative p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        <i class="fas fa-envelope text-gray-600 dark:text-gray-300"></i>
                        <span class="absolute -top-1 -right-1 bg-[#FF4500] text-white text-xs rounded-full w-4 h-4 flex items-center justify-center unread-count" style="display: none;"></span>
                    </a>
                    
                    <!-- Create Post -->
                    <a href="<?php echo url('/threads/create'); ?>" 
                       class="hidden sm:flex items-center px-4 py-2 bg-[#FF4500] hover:bg-[#FF5722] text-white rounded-full text-sm font-semibold transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-[#FF4500] focus:ring-offset-2 dark:focus:ring-offset-gray-900 hover:shadow-lg">
                        <i class="fas fa-plus mr-1"></i> Create
                    </a>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-300 
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <img src="<?php echo userAvatar(); ?>" 
                                 alt="Avatar" class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600">
                            <i class="fas fa-chevron-down text-xs text-gray-600 dark:text-gray-300"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50 transition-all duration-300"
                             style="display: none;">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <div class="font-semibold text-gray-900 dark:text-gray-50"><?php echo e($_SESSION['user']['username'] ?? 'User'); ?></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-star text-yellow-500"></i> <?php echo userReputation(); ?> points
                                </div>
                            </div>
                            
                            <a href="<?php echo url('/profile/' . $_SESSION['user']['id']); ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700">
                                <i class="fas fa-user w-5"></i> Profile
                            </a>
                            <a href="<?php echo url('/profile/' . $_SESSION['user']['id'] . '/edit'); ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700">
                                <i class="fas fa-edit w-5"></i> Edit Profile
                            </a>
                            <?php if (hasRole('admin') || isModerator()): ?>
                            <a href="<?php echo url('/analytics'); ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700">
                                <i class="fas fa-chart-line w-5"></i> Analytics
                            </a>
                            <?php endif; ?>
                            <?php if (isAdmin()): ?>
                            <a href="<?php echo url('/admin'); ?>" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700">
                                <i class="fas fa-cog w-5"></i> Admin
                            </a>
                            <?php endif; ?>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <a href="<?php echo url('/auth/logout'); ?>" 
                               class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-300 focus:outline-none focus:bg-red-50 dark:focus:bg-red-900/20">
                                <i class="fas fa-sign-out-alt w-5"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Spacer for fixed navbar -->
    <div class="h-14"></div>
<?php endif; ?>

<!-- Main Content -->
<main class="min-h-screen">
