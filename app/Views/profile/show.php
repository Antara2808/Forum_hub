<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Profile Header -->
    <div class="card mb-6 overflow-hidden <?php echo getProfileThemeClass($user['profile_theme'] ?? 'default'); ?>">
        <!-- Banner -->
        <div class="h-48 <?php echo getBannerStyleClass($user['banner_style'] ?? 'gradient', $user); ?>" 
             style="<?php echo getBannerStyle($user); ?>">
        </div>
        
        <!-- Profile Info -->
        <div class="p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                <!-- Avatar -->
                <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                     alt="Avatar" class="w-32 h-32 rounded-full border-4 border-white -mt-16 shadow-lg">
                
                <!-- User Details -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold"><?php echo e($user['username']); ?></h1>
                        
                        <?php if ($user['role'] === 'admin'): ?>
                        <span class="badge badge-danger">
                            <i class="fas fa-crown"></i> Admin
                        </span>
                        <?php elseif ($user['role'] === 'moderator'): ?>
                        <span class="badge badge-warning">
                            <i class="fas fa-shield"></i> Moderator
                        </span>
                        <?php endif; ?>
                        
                        <span class="badge badge-primary">
                            <i class="fas fa-star"></i> <?php echo $rank; ?>
                        </span>
                    </div>
                    
                    <?php if ($user['bio']): ?>
                    <p class="text-gray-600 dark:text-gray-400 mb-4"><?php echo e($user['bio']); ?></p>
                    <?php endif; ?>
                    
                    <!-- Social Links -->
                    <div class="flex flex-wrap gap-4 text-sm">
                        <?php if ($user['location']): ?>
                        <span class="text-gray-600 dark:text-gray-400">
                            <i class="fas fa-map-marker-alt"></i> <?php echo e($user['location']); ?>
                        </span>
                        <?php endif; ?>
                        
                        <?php if ($user['website']): ?>
                        <a href="<?php echo e($user['website']); ?>" target="_blank" 
                           class="text-blue-600 hover:underline">
                            <i class="fas fa-globe"></i> Website
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($user['twitter']): ?>
                        <a href="https://twitter.com/<?php echo e($user['twitter']); ?>" target="_blank" 
                           class="text-blue-400 hover:underline">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($user['github']): ?>
                        <a href="https://github.com/<?php echo e($user['github']); ?>" target="_blank" 
                           class="text-gray-700 dark:text-gray-300 hover:underline">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($user['linkedin']): ?>
                        <a href="https://linkedin.com/in/<?php echo e($user['linkedin']); ?>" target="_blank" 
                           class="text-blue-700 hover:underline">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($user['instagram']): ?>
                        <a href="https://instagram.com/<?php echo e($user['instagram']); ?>" target="_blank" 
                           class="text-pink-500 hover:underline">
                            <i class="fab fa-instagram"></i> Instagram
                        </a>
                        <?php endif; ?>
                        
                        <span class="text-gray-600 dark:text-gray-400">
                            <i class="fas fa-calendar"></i> Joined <?php echo formatDate($user['created_at'], 'M Y'); ?>
                        </span>
                    </div>
                </div>
                
                <!-- Actions -->
                <?php if (isLoggedIn()): ?>
                <div class="flex gap-2">
                    <?php if (userId() == $user['id']): ?>
                    <a href="<?php echo url('/profile/' . $user['id'] . '/edit'); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <?php else: ?>
                    <a href="<?php echo url('/messages/' . $user['id']); ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Message
                    </a>
                    
                    <!-- Friend Actions -->
                    <?php if (!$friendStatus): ?>
                        <button onclick="sendFriendRequest(<?php echo $user['id']; ?>)" 
                                class="btn btn-secondary" id="friend-btn">
                            <i class="fas fa-user-plus"></i> Add Friend
                        </button>
                    <?php elseif ($friendStatus['status'] === 'pending' && $friendStatus['user_id'] == userId()): ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="fas fa-clock"></i> Request Sent
                        </button>
                    <?php elseif ($friendStatus['status'] === 'pending' && $friendStatus['friend_id'] == userId()): ?>
                        <button onclick="acceptFriendRequest(<?php echo $friendStatus['id']; ?>)" class="btn btn-primary">
                            <i class="fas fa-check"></i> Accept
                        </button>
                        <button onclick="rejectFriendRequest(<?php echo $friendStatus['id']; ?>)" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    <?php elseif ($friendStatus['status'] === 'accepted'): ?>
                        <button onclick="removeFriend(<?php echo $user['id']; ?>)" 
                                class="btn btn-secondary" id="friend-btn">
                            <i class="fas fa-user-times"></i> Remove Friend
                        </button>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Stats Sidebar -->
        <div class="lg:col-span-1">
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-chart-bar"></i> Statistics
                    </h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Reputation</span>
                        <span class="text-2xl font-bold text-yellow-600"><?php echo $user['reputation']; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Threads</span>
                        <span class="text-2xl font-bold text-blue-600"><?php echo $stats['thread_count'] ?? 0; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Posts</span>
                        <span class="text-2xl font-bold text-green-600"><?php echo $stats['post_count'] ?? 0; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Friends</span>
                        <span class="text-2xl font-bold text-purple-600"><?php echo $friendCount; ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Friends Section -->
            <?php if (!empty($friends)): ?>
            <div class="card mb-6">
                <div class="card-header flex items-center justify-between">
                    <h3 class="font-bold">
                        <i class="fas fa-user-friends text-purple-600"></i> Friends (<?php echo count($friends); ?>)
                    </h3>
                    <?php if (count($friends) > 6): ?>
                    <a href="<?php echo url('/friends'); ?>" class="text-sm text-blue-600 hover:underline">
                        View All
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <?php foreach (array_slice($friends, 0, 6) as $friend): ?>
                        <a href="<?php echo url('/profile/' . $friend['id']); ?>" 
                           class="flex flex-col items-center gap-2 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition group">
                            <div class="relative">
                                <img src="<?php echo $friend['avatar'] ? upload('avatars/' . $friend['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                     alt="<?php echo e($friend['username']); ?>" 
                                     class="w-16 h-16 rounded-full border-2 border-gray-200 dark:border-gray-700 group-hover:border-blue-500 transition">
                                <?php if ($friend['is_online']): ?>
                                <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                <?php endif; ?>
                            </div>
                            <div class="text-center">
                                <div class="font-bold text-sm truncate max-w-full"><?php echo e($friend['username']); ?></div>
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-star text-yellow-500"></i> <?php echo $friend['reputation']; ?>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php elseif (userId() == $user['id']): ?>
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-user-friends text-purple-600"></i> Friends
                    </h3>
                </div>
                <div class="card-body text-center py-8">
                    <i class="fas fa-user-friends text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">You don't have any friends yet</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500">Use the "Add Friend" button in the navbar to find and connect with other users!</p>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Activity Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-clock"></i> Activity
                    </h3>
                </div>
                <div class="card-body">
                    <?php if ($user['is_online']): ?>
                    <div class="flex items-center gap-2 text-green-600">
                        <i class="fas fa-circle text-xs"></i>
                        <span class="font-bold">Online Now</span>
                    </div>
                    <?php else: ?>
                    <div class="text-gray-600 dark:text-gray-400">
                        Last seen: <?php echo $user['last_seen'] ? timeAgo($user['last_seen']) : 'Never'; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Tabs -->
            <div class="card mb-6">
                <div class="flex border-b border-gray-200 dark:border-gray-700">
                    <button class="tab-button active px-6 py-3 font-bold" onclick="showTab('threads')">
                        <i class="fas fa-comments"></i> Threads (<?php echo count($threads); ?>)
                    </button>
                    <button class="tab-button px-6 py-3 font-bold" onclick="showTab('posts')">
                        <i class="fas fa-reply"></i> Recent Posts
                    </button>
                </div>
            </div>
            
            <!-- Threads Tab -->
            <div id="threads-tab" class="tab-content">
                <?php if (empty($threads)): ?>
                <div class="card">
                    <div class="card-body text-center py-12 text-gray-500">
                        <i class="fas fa-inbox text-6xl mb-4"></i>
                        <p>No threads yet</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($threads as $thread): ?>
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                               class="text-xl font-bold hover:text-blue-600 block mb-2">
                                <?php echo e($thread['title']); ?>
                            </a>
                            <div class="flex gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <span><i class="fas fa-folder"></i> <?php echo e($thread['category_name']); ?></span>
                                <span><i class="fas fa-eye"></i> <?php echo $thread['views']; ?> views</span>
                                <span><i class="fas fa-comments"></i> <?php echo $thread['reply_count']; ?> replies</span>
                                <span><i class="fas fa-clock"></i> <?php echo timeAgo($thread['created_at']); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Posts Tab -->
            <div id="posts-tab" class="tab-content hidden">
                <?php if (empty($posts)): ?>
                <div class="card">
                    <div class="card-body text-center py-12 text-gray-500">
                        <i class="fas fa-comment-slash text-6xl mb-4"></i>
                        <p>No posts yet</p>
                    </div>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($posts as $post): ?>
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo url('/threads/' . $post['thread_id']); ?>" 
                               class="text-sm text-blue-600 hover:underline mb-2 block">
                                in: <?php echo e($post['thread_title']); ?>
                            </a>
                            <p class="text-gray-700 dark:text-gray-300 mb-2">
                                <?php echo truncate(e($post['content']), 200); ?>
                            </p>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-clock"></i> <?php echo timeAgo($post['created_at']); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Friend management functions
async function sendFriendRequest(friendId) {
    try {
        const response = await fetch('<?php echo url('/friends/send'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `friend_id=${friendId}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(data.message);
            document.getElementById('friend-btn').innerHTML = '<i class="fas fa-clock"></i> Request Sent';
            document.getElementById('friend-btn').disabled = true;
        } else {
            Toast.error(data.message);
        }
    } catch (error) {
        Toast.error('Failed to send friend request');
    }
}

async function acceptFriendRequest(requestId) {
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

async function rejectFriendRequest(requestId) {
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

async function removeFriend(friendId) {
    const confirmed = await showConfirm({
        title: 'Remove Friend',
        message: 'Are you sure you want to remove this friend?',
        confirmText: 'Remove',
        icon: '👋'
    });
    
    if (!confirmed) return;
    
    try {
        const response = await fetch('<?php echo url('/friends/remove'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `friend_id=${friendId}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message);
        }
    } catch (error) {
        Toast.error('Failed to remove friend');
    }
}

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-b-2', 'border-blue-600');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to clicked button
    event.target.closest('button').classList.add('active', 'border-b-2', 'border-blue-600');
}
</script>

<style>
.tab-button.active {
    border-bottom: 2px solid #3B82F6;
    color: #3B82F6;
}
</style>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
