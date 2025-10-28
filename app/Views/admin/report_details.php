<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <a href="<?php echo url('/admin/reports'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to Reports
        </a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            <i class="fas fa-flag"></i> Report Details
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            Report #<?php echo $report['id']; ?> - <?php echo ucfirst($report['reported_type']); ?>
        </p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Report Info -->
        <div class="lg:col-span-2">
            <div class="card mb-6">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Report Information</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Report ID</label>
                            <p class="font-medium">#<?php echo $report['id']; ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <p>
                                <?php if ($report['status'] === 'pending'): ?>
                                <span class="badge badge-warning">Pending</span>
                                <?php elseif ($report['status'] === 'resolved'): ?>
                                <span class="badge badge-success">Resolved</span>
                                <?php else: ?>
                                <span class="badge badge-secondary">Dismissed</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reported By</label>
                            <p class="font-medium">
                                <a href="<?php echo url('/profile/' . $report['reporter_id']); ?>" 
                                   class="text-blue-600 hover:underline">
                                    <?php echo e($report['reporter_username']); ?>
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reported At</label>
                            <p class="font-medium"><?php echo formatDate($report['created_at']); ?></p>
                            <p class="text-sm text-gray-500"><?php echo timeAgo($report['created_at']); ?></p>
                        </div>
                        <?php if ($report['resolved_at']): ?>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Resolved By</label>
                            <p class="font-medium">
                                <?php if ($report['resolver_username']): ?>
                                <a href="<?php echo url('/profile/' . $report['resolved_by']); ?>" 
                                   class="text-blue-600 hover:underline">
                                    <?php echo e($report['resolver_username']); ?>
                                </a>
                                <?php else: ?>
                                Unknown User
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Resolved At</label>
                            <p class="font-medium"><?php echo formatDate($report['resolved_at']); ?></p>
                            <p class="text-sm text-gray-500"><?php echo timeAgo($report['resolved_at']); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Reason</label>
                        <p class="font-medium mt-1"><?php echo e($report['reason']); ?></p>
                    </div>
                    
                    <?php if ($report['description']): ?>
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <p class="mt-1"><?php echo nl2br(e($report['description'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Reported Content -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Reported Content</h2>
                </div>
                <div class="p-6">
                    <?php if ($content): ?>
                        <?php if ($report['reported_type'] === 'thread'): ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h3 class="font-bold text-lg mb-2">
                                <a href="<?php echo url('/threads/' . $content['id']); ?>" 
                                   class="text-blue-600 hover:underline">
                                    <?php echo e($content['title']); ?>
                                </a>
                            </h3>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                by <?php echo e($content['username']); ?> • <?php echo timeAgo($content['created_at']); ?>
                            </div>
                            <div class="prose dark:prose-invert max-w-none">
                                <?php echo nl2br(e($content['content'])); ?>
                            </div>
                        </div>
                        <?php elseif ($report['reported_type'] === 'post'): ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                Posted by <?php echo e($content['username']); ?> • <?php echo timeAgo($content['created_at']); ?>
                                <?php if (isset($content['thread_title'])): ?>
                                <span class="mx-2">•</span>
                                in <a href="<?php echo url('/threads/' . $content['thread_id']); ?>" 
                                      class="text-blue-600 hover:underline">
                                    <?php echo e($content['thread_title']); ?>
                                </a>
                                <?php endif; ?>
                            </div>
                            <div class="prose dark:prose-invert max-w-none">
                                <?php echo nl2br(e($content['content'])); ?>
                            </div>
                        </div>
                        <?php elseif ($report['reported_type'] === 'user'): ?>
                        <div class="flex items-center space-x-4 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <img src="<?php echo $content['avatar'] ? upload('avatars/' . $content['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                 alt="Avatar" class="w-16 h-16 rounded-full">
                            <div>
                                <h3 class="font-bold text-lg">
                                    <a href="<?php echo url('/profile/' . $content['id']); ?>" 
                                       class="text-blue-600 hover:underline">
                                        <?php echo e($content['username']); ?>
                                    </a>
                                </h3>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Joined <?php echo formatDate($content['created_at']); ?>
                                </div>
                                <div class="text-sm">
                                    <span class="badge badge-primary"><?php echo getReputationRank($content['reputation']); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php else: ?>
                    <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                        <i class="fas fa-exclamation-circle text-3xl mb-3"></i>
                        <p>Reported content not found or has been deleted</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Actions</h2>
                </div>
                <div class="p-6">
                    <?php if ($report['status'] === 'pending'): ?>
                    <div class="space-y-4">
                        <form method="POST" action="<?php echo url('/admin/reports/' . $report['id'] . '/resolve'); ?>">
                            <?php echo csrfField(); ?>
                            <button type="submit" 
                                    class="w-full btn btn-success"
                                    onclick="return confirm('Are you sure you want to resolve this report?')">
                                <i class="fas fa-check mr-2"></i> Mark as Resolved
                            </button>
                        </form>
                        
                        <form method="POST" action="<?php echo url('/admin/reports/' . $report['id'] . '/dismiss'); ?>">
                            <?php echo csrfField(); ?>
                            <button type="submit" 
                                    class="w-full btn btn-secondary"
                                    onclick="return confirm('Are you sure you want to dismiss this report?')">
                                <i class="fas fa-times mr-2"></i> Dismiss Report
                            </button>
                        </form>
                    </div>
                    <?php else: ?>
                    <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                        <i class="fas fa-check-circle text-3xl mb-3 text-green-500"></i>
                        <p>This report has been <?php echo $report['status']; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card mt-6">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <?php if ($content): ?>
                        <?php if ($report['reported_type'] === 'thread'): ?>
                        <a href="<?php echo url('/threads/' . $content['id'] . '/edit'); ?>" 
                           class="btn btn-secondary w-full">
                            <i class="fas fa-edit mr-2"></i> Edit Thread
                        </a>
                        <a href="<?php echo url('/admin/user/' . $content['user_id']); ?>" 
                           class="btn btn-secondary w-full">
                            <i class="fas fa-user mr-2"></i> View User
                        </a>
                        <?php elseif ($report['reported_type'] === 'post'): ?>
                        <a href="<?php echo url('/threads/' . $content['thread_id']); ?>" 
                           class="btn btn-secondary w-full">
                            <i class="fas fa-comment mr-2"></i> View Post
                        </a>
                        <a href="<?php echo url('/admin/user/' . $content['user_id']); ?>" 
                           class="btn btn-secondary w-full">
                            <i class="fas fa-user mr-2"></i> View User
                        </a>
                        <?php elseif ($report['reported_type'] === 'user'): ?>
                        <a href="<?php echo url('/admin/user/' . $content['id']); ?>" 
                           class="btn btn-secondary w-full">
                            <i class="fas fa-user mr-2"></i> Manage User
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>