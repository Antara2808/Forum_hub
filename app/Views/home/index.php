<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Welcome back, <?php echo e($user['username'] ?? 'User'); ?>!</h1>
            <p class="text-gray-600 dark:text-gray-400">What's happening in your community today?</p>
        </div>
        <a href="<?php echo url('/threads/create'); ?>" 
           class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-all transform hover:scale-105">
            <i class="fas fa-plus mr-2"></i> New Thread
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Total Threads</p>
                    <p class="text-3xl font-bold mt-1">1,234</p>
                </div>
                <div class="text-4xl text-blue-600 dark:text-blue-400">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Active Users</p>
                    <p class="text-3xl font-bold mt-1">567</p>
                </div>
                <div class="text-4xl text-green-600 dark:text-green-400">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">New Today</p>
                    <p class="text-3xl font-bold mt-1">89</p>
                </div>
                <div class="text-4xl text-purple-600 dark:text-purple-400">
                    <i class="fas fa-fire"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Your Reputation</p>
                    <p class="text-3xl font-bold mt-1"><?php echo $_SESSION['user']['reputation'] ?? 0; ?></p>
                </div>
                <div class="text-4xl text-yellow-600 dark:text-yellow-400">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Categories -->
            <div class="card mb-6">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Categories</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($categories as $category): ?>
                    <a href="<?php echo url('/threads?category=' . $category['slug']); ?>" 
                       class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center text-2xl mr-4"
                                 style="background-color: <?php echo $category['color']; ?>20; color: <?php echo $category['color']; ?>">
                                <i class="<?php echo $category['icon']; ?>"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold"><?php echo e($category['name']); ?></h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($category['description']); ?></p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    <?php echo $category['thread_count'] ?? 0; ?>
                                </div>
                                <div class="text-xs text-gray-500">threads</div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Recent Threads -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Recent Discussions</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($threads as $thread): ?>
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-start space-x-4">
                            <img src="<?php echo $thread['avatar'] ? upload('avatars/' . $thread['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                 alt="Avatar" class="w-12 h-12 rounded-full">
                            <div class="flex-1">
                                <?php if ($thread['is_pinned']): ?>
                                <span class="badge badge-warning mr-2">
                                    <i class="fas fa-thumbtack"></i> Pinned
                                </span>
                                <?php endif; ?>
                                <?php if ($thread['is_locked']): ?>
                                <span class="badge badge-danger mr-2">
                                    <i class="fas fa-lock"></i> Locked
                                </span>
                                <?php endif; ?>
                                
                                <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                                   class="text-lg font-bold hover:text-blue-600 dark:hover:text-blue-400">
                                    <?php echo e($thread['title']); ?>
                                </a>
                                
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <span>
                                        <i class="fas fa-user"></i> <?php echo e($thread['username']); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-folder"></i> <?php echo e($thread['category_name']); ?>
                                    </span>
                                    <span>
                                        <i class="fas fa-eye"></i> <?php echo $thread['views']; ?> views
                                    </span>
                                    <span>
                                        <i class="fas fa-comments"></i> <?php echo $thread['reply_count'] ?? 0; ?> replies
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i> <?php echo timeAgo($thread['created_at']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Friend Requests -->
            <?php if (!empty($pendingRequests)): ?>
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-user-plus text-blue-600"></i> Friend Requests
                        <span class="badge badge-primary ml-2"><?php echo count($pendingRequests); ?></span>
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <?php foreach (array_slice($pendingRequests, 0, 3) as $request): ?>
                    <div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <img src="<?php echo $request['avatar'] ? upload('avatars/' . $request['avatar']) : asset('images/default-avatar.svg'); ?>" 
                             alt="<?php echo e($request['username']); ?>" 
                             class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="font-bold text-sm"><?php echo e($request['username']); ?></div>
                            <div class="text-xs text-gray-500"><?php echo timeAgo($request['created_at']); ?></div>
                        </div>
                        <div class="flex gap-1">
                            <button onclick="acceptRequest(<?php echo $request['request_id']; ?>)" 
                                    class="p-1 text-green-600 hover:bg-green-100 dark:hover:bg-green-900/30 rounded" 
                                    title="Accept">
                                <i class="fas fa-check text-sm"></i>
                            </button>
                            <button onclick="rejectRequest(<?php echo $request['request_id']; ?>)" 
                                    class="p-1 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/30 rounded" 
                                    title="Reject">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php if (count($pendingRequests) > 3): ?>
                    <a href="<?php echo url('/friends'); ?>" class="text-blue-600 dark:text-blue-400 text-sm hover:underline block text-center">
                        View all (<?php echo count($pendingRequests); ?>)
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Friends List -->
            <?php if (!empty($friends)): ?>
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-user-friends text-purple-600"></i> Friends
                        <span class="badge badge-primary ml-2"><?php echo count($friends); ?></span>
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <?php foreach (array_slice($friends, 0, 5) as $friend): ?>
                    <a href="<?php echo url('/profile/' . $friend['id']); ?>" 
                       class="flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 p-2 rounded-lg transition">
                        <img src="<?php echo $friend['avatar'] ? upload('avatars/' . $friend['avatar']) : asset('images/default-avatar.svg'); ?>" 
                             alt="<?php echo e($friend['username']); ?>" 
                             class="w-10 h-10 rounded-full">
                        <div class="flex-1">
                            <div class="font-bold text-sm"><?php echo e($friend['username']); ?></div>
                            <div class="text-xs text-gray-500">
                                <?php if ($friend['is_online']): ?>
                                    <i class="fas fa-circle text-green-500 text-xs"></i> Online
                                <?php else: ?>
                                    Last seen <?php echo timeAgo($friend['last_seen']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                    <?php if (count($friends) > 5): ?>
                    <a href="<?php echo url('/friends'); ?>" class="text-blue-600 dark:text-blue-400 text-sm hover:underline block text-center">
                        View all friends (<?php echo count($friends); ?>)
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Online Users -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-circle text-green-500 text-xs"></i> Online Now
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        <strong class="text-2xl text-green-600">247</strong> users online
                    </p>
                </div>
            </div>
            
            <!-- Upcoming Events -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-calendar"></i> Upcoming Events
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <a href="<?php echo url('/events'); ?>" class="block p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:shadow-md transition-shadow">
                        <div class="font-bold text-sm">Launch Party</div>
                        <div class="text-xs text-gray-600 dark:text-gray-400">in 7 days</div>
                    </a>
                    <a href="<?php echo url('/events'); ?>" class="text-blue-600 dark:text-blue-400 text-sm hover:underline">
                        View all events →
                    </a>
                </div>
            </div>
            
            <!-- Top Contributors -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-trophy"></i> Top Contributors
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <?php 
                    $topUsers = [
                        ['username' => 'admin', 'reputation' => 1500],
                        ['username' => 'moderator', 'reputation' => 800],
                        ['username' => 'janedoe', 'reputation' => 420],
                    ];
                    foreach ($topUsers as $index => $topUser): 
                    ?>
                    <div class="flex items-center space-x-3">
                        <div class="text-2xl font-bold text-gray-400">#<?php echo $index + 1; ?></div>
                        <div class="flex-1">
                            <div class="font-bold text-sm"><?php echo e($topUser['username']); ?></div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                <?php echo $topUser['reputation']; ?> points
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
// Friend request actions
async function acceptRequest(requestId) {
    try {
        const response = await fetch('<?php echo url('/friends/accept'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `request_id=${requestId}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message);
        }
    } catch (error) {
        Toast.error('Failed to accept request');
    }
}

async function rejectRequest(requestId) {
    try {
        const response = await fetch('<?php echo url('/friends/reject'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `request_id=${requestId}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message);
        }
    } catch (error) {
        Toast.error('Failed to reject request');
    }
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
