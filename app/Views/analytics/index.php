<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-chart-line"></i> Analytics Dashboard
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Platform statistics and insights</p>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Threads</p>
                    <p class="text-3xl font-bold mt-1"><?php echo $stats['total_threads']; ?></p>
                </div>
                <div class="text-4xl text-blue-600">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Posts</p>
                    <p class="text-3xl font-bold mt-1"><?php echo $stats['total_posts']; ?></p>
                </div>
                <div class="text-4xl text-green-600">
                    <i class="fas fa-reply"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Active Users</p>
                    <p class="text-3xl font-bold mt-1"><?php echo $stats['total_users']; ?></p>
                </div>
                <div class="text-4xl text-purple-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Hot Threads -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-fire"></i> Hot Threads
                </h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($stats['hot_threads'] as $thread): ?>
                <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                   class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <h3 class="font-bold mb-1"><?php echo e($thread['title']); ?></h3>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span><i class="fas fa-eye"></i> <?php echo $thread['views']; ?></span>
                        <span><i class="fas fa-comments"></i> <?php echo $thread['reply_count'] ?? 0; ?></span>
                        <span><i class="fas fa-user"></i> <?php echo e($thread['username']); ?></span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Top Contributors -->
        <div class="card">
            <div class="card-header">
                <h2 class="text-xl font-bold">
                    <i class="fas fa-trophy"></i> Top Contributors
                </h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($stats['top_users'] as $index => $user): ?>
                <div class="p-4 flex items-center space-x-4">
                    <div class="text-2xl font-bold text-gray-400 w-8">#<?php echo $index + 1; ?></div>
                    <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-12 h-12 rounded-full">
                    <div class="flex-1">
                        <a href="<?php echo url('/profile/' . $user['id']); ?>" class="font-bold hover:text-blue-600">
                            <?php echo e($user['username']); ?>
                        </a>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo getReputationRank($user['reputation']); ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo $user['reputation']; ?></div>
                        <div class="text-xs text-gray-500">points</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Chart Placeholder -->
    <div class="card mt-8">
        <div class="card-header">
            <h2 class="text-xl font-bold">
                <i class="fas fa-chart-bar"></i> Activity Overview
            </h2>
        </div>
        <div class="card-body">
            <div class="text-center py-12 text-gray-500">
                <i class="fas fa-chart-line text-6xl mb-4"></i>
                <p>Chart.js integration ready for activity visualization</p>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
