<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-envelope"></i> Messages
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Your private conversations</p>
    </div>
    
    <?php if (empty($conversations)): ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-4">No messages yet</p>
            <p class="text-sm text-gray-500">Start a conversation by visiting someone's profile</p>
        </div>
    </div>
    <?php else: ?>
    <div class="card">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php foreach ($conversations as $conversation): ?>
            <a href="<?php echo url('/messages/' . $conversation['other_user_id']); ?>" 
               class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors <?php echo isset($conversation['is_read']) && !$conversation['is_read'] ? 'bg-blue-50 dark:bg-blue-900/20' : ''; ?>">
                <div class="flex items-center space-x-4">
                    <img src="<?php echo $conversation['avatar'] ? upload('avatars/' . $conversation['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-12 h-12 rounded-full">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="font-bold"><?php echo e($conversation['username']); ?></h3>
                            <span class="text-xs text-gray-500">
                                <?php echo isset($conversation['created_at']) ? timeAgo($conversation['created_at']) : 'Just now'; ?>
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                            <?php echo isset($conversation['message']) ? truncate(e($conversation['message']), 100) : 'No messages yet'; ?>
                        </p>
                    </div>
                    <?php if (isset($conversation['unread_count']) && $conversation['unread_count'] > 0): ?>
                    <div class="flex flex-col items-center">
                        <span class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">
                            <?php echo $conversation['unread_count']; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
