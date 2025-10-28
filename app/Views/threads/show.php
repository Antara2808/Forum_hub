<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumb -->
    <div class="mb-6 flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
        <a href="<?php echo url('/home'); ?>" class="hover:text-blue-600">
            <i class="fas fa-home"></i> Home
        </a>
        <span>/</span>
        <a href="<?php echo url('/threads'); ?>" class="hover:text-blue-600">Threads</a>
        <span>/</span>
        <span class="text-gray-900 dark:text-white"><?php echo e($thread['title']); ?></span>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Thread -->
            <div class="card mb-6">
                <div class="card-header flex items-center justify-between">
                    <div>
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
                        <h1 class="text-2xl font-bold mt-2"><?php echo e($thread['title']); ?></h1>
                        
                        <!-- Tags -->
                        <?php if (!empty($thread['tags'])): ?>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <?php foreach ($thread['tags'] as $tag): ?>
                            <a href="<?php echo url('/tags/' . $tag['id']); ?>" 
                               class="badge badge-secondary text-sm">
                                <i class="fas fa-tag"></i> <?php echo e($tag['name']); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (isLoggedIn() && (userId() == $thread['user_id'] || isModerator())): ?>
                    <div class="flex space-x-2">
                        <a href="<?php echo url('/threads/' . $thread['id'] . '/edit'); ?>" 
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                    <?php elseif (isLoggedIn()): ?>
                    <div class="flex space-x-2">
                        <button onclick="openReportModal('thread', <?php echo $thread['id']; ?>)" 
                                class="btn btn-secondary btn-sm">
                            <i class="fas fa-flag"></i> Report
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start space-x-4 mb-6">
                        <img src="<?php echo $thread['avatar'] ? upload('avatars/' . $thread['avatar']) : asset('images/default-avatar.svg'); ?>" 
                             alt="Avatar" class="w-16 h-16 rounded-full">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3">
                                <a href="<?php echo url('/profile/' . $thread['user_id']); ?>" 
                                   class="font-bold text-lg hover:text-blue-600">
                                    <?php echo e($thread['username']); ?>
                                </a>
                                <span class="badge badge-primary"><?php echo getReputationRank($thread['reputation']); ?></span>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                <i class="fas fa-clock"></i> <?php echo timeAgo($thread['created_at']); ?>
                                <span class="mx-2">•</span>
                                <i class="fas fa-eye"></i> <?php echo $thread['views']; ?> views
                                <span class="mx-2">•</span>
                                <i class="fas fa-comments"></i> <?php echo $thread['reply_count']; ?> replies
                            </div>
                        </div>
                    </div>
                    
                    <div class="prose dark:prose-invert max-w-none">
                        <?php echo processContentWithMedia($thread['content']); ?>
                    </div>
                </div>
            </div>
            
            <!-- Replies -->
            <div class="card mb-6">
                <div class="card-header">
                    <h2 class="text-xl font-bold">
                        <i class="fas fa-comments"></i> Replies (<?php echo count($posts); ?>)
                    </h2>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if (empty($posts)): ?>
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-comment-slash text-4xl mb-3"></i>
                        <p>No replies yet. Be the first to reply!</p>
                    </div>
                    <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <img src="<?php echo $post['avatar'] ? upload('avatars/' . $post['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                 alt="Avatar" class="w-12 h-12 rounded-full">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center space-x-3">
                                        <a href="<?php echo url('/profile/' . $post['user_id']); ?>" 
                                           class="font-bold hover:text-blue-600">
                                            <?php echo e($post['username']); ?>
                                        </a>
                                        <span class="badge badge-primary"><?php echo getReputationRank($post['reputation']); ?></span>
                                        <?php if ($post['role'] === 'admin'): ?>
                                        <span class="badge badge-danger">Admin</span>
                                        <?php elseif ($post['role'] === 'moderator'): ?>
                                        <span class="badge badge-warning">Moderator</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-clock"></i> <?php echo timeAgo($post['created_at']); ?>
                                        <?php if ($post['is_edited']): ?>
                                        <span class="ml-2">(edited)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div class="prose dark:prose-invert max-w-none">
                                    <?php echo processContentWithMedia($post['content']); ?>
                                </div>
                                
                                <?php if (isLoggedIn() && userId() != $post['user_id']): ?>
                                <div class="mt-3">
                                    <button onclick="openReportModal('post', <?php echo $post['id']; ?>)" 
                                            class="text-xs text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400">
                                        <i class="fas fa-flag"></i> Report
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Reply Form -->
            <?php if (isLoggedIn()): ?>
            <?php if (!$thread['is_locked'] || isModerator()): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold">
                        <i class="fas fa-reply"></i> Post a Reply
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo url('/posts/create'); ?>">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="thread_id" value="<?php echo $thread['id']; ?>">
                        
                        <textarea name="content" rows="6" required
                                  class="form-input mb-4"
                                  placeholder="Write your reply..."></textarea>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Post Reply
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="card-body text-center text-gray-500">
                    <i class="fas fa-lock text-3xl mb-3"></i>
                    <p>This thread is locked. No new replies are allowed.</p>
                </div>
            </div>
            <?php endif; ?>
            <?php else: ?>
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-4">Please login to reply to this thread.</p>
                    <a href="<?php echo url('/auth/login'); ?>" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Thread Info -->
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">Thread Info</h3>
                </div>
                <div class="card-body space-y-3">
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Category</div>
                        <a href="<?php echo url('/threads?category=' . $thread['category_slug']); ?>" 
                           class="font-bold text-blue-600 hover:underline">
                            <?php echo e($thread['category_name']); ?>
                        </a>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Created</div>
                        <div class="font-bold"><?php echo formatDate($thread['created_at']); ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Views</div>
                        <div class="font-bold"><?php echo number_format($thread['views']); ?></div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Replies</div>
                        <div class="font-bold"><?php echo number_format($thread['reply_count']); ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <?php if (isLoggedIn()): ?>
            <div class="card mb-6">
                <div class="card-header">
                    <h3 class="font-bold">Actions</h3>
                </div>
                <div class="card-body space-y-2">
                    <button onclick="toggleBookmark(<?php echo $thread['id']; ?>)" 
                            id="bookmark-btn" 
                            class="w-full btn btn-secondary text-left">
                        <i class="fas fa-bookmark" id="bookmark-icon"></i> 
                        <span id="bookmark-text"><?php echo $isBookmarked ? 'Bookmarked' : 'Bookmark'; ?></span>
                    </button>
                    <button onclick="shareThread()" class="w-full btn btn-secondary text-left">
                        <i class="fas fa-share"></i> Share
                    </button>
                    <button onclick="reportThread(<?php echo $thread['id']; ?>)" class="w-full btn btn-secondary text-left">
                        <i class="fas fa-flag"></i> Report
                    </button>
                </div>
            </div>
            
            <script>
            // Bookmark functionality
            let isBookmarked = <?php echo $isBookmarked ? 'true' : 'false'; ?>;
            
            async function toggleBookmark(threadId) {
                try {
                    const response = await fetch('<?php echo url('/threads/bookmark'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `thread_id=${threadId}`
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        isBookmarked = data.bookmarked;
                        document.getElementById('bookmark-text').textContent = isBookmarked ? 'Bookmarked' : 'Bookmark';
                        document.getElementById('bookmark-icon').className = isBookmarked ? 'fas fa-bookmark' : 'far fa-bookmark';
                        Toast.success(data.message);
                    } else {
                        Toast.error(data.message);
                    }
                } catch (error) {
                    Toast.error('Failed to toggle bookmark');
                }
            }
            
            // Share functionality
            function shareThread() {
                const url = window.location.href;
                const title = <?php echo json_encode($thread['title']); ?>;
                
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).catch(() => {
                        copyToClipboard(url);
                    });
                } else {
                    copyToClipboard(url);
                }
            }
            
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    Toast.success('Link copied to clipboard!');
                }).catch(() => {
                    Toast.error('Failed to copy link');
                });
            }
            
            // Report functionality
            async function reportThread(threadId) {
                const confirmed = await showConfirm({
                    title: 'Report Thread',
                    message: 'Are you sure you want to report this thread?',
                    icon: '⚠️',
                    confirmText: 'Report'
                });
                
                if (!confirmed) return;
                
                // Show report reason dialog
                const reasons = [
                    { value: 'spam', label: 'Spam' },
                    { value: 'abuse', label: 'Abuse' },
                    { value: 'inappropriate', label: 'Inappropriate Content' },
                    { value: 'harassment', label: 'Harassment' },
                    { value: 'other', label: 'Other' }
                ];
                
                const overlay = document.createElement('div');
                overlay.className = 'confirm-overlay';
                
                const modal = document.createElement('div');
                modal.className = 'confirm-modal';
                modal.style.maxWidth = '500px';
                
                let reasonsHtml = reasons.map(r => 
                    `<label class="block mb-2">
                        <input type="radio" name="report_reason" value="${r.value}" class="mr-2">
                        ${r.label}
                    </label>`
                ).join('');
                
                modal.innerHTML = `
                    <h3 class="confirm-title">Report Reason</h3>
                    <div class="mb-4">
                        ${reasonsHtml}
                    </div>
                    <textarea id="report-description" placeholder="Additional details (optional)" 
                              class="form-input mb-4" rows="3"></textarea>
                    <div class="confirm-buttons">
                        <button class="confirm-btn confirm-btn-cancel" data-action="cancel">Cancel</button>
                        <button class="confirm-btn confirm-btn-confirm" data-action="submit">Submit Report</button>
                    </div>
                `;
                
                overlay.appendChild(modal);
                document.body.appendChild(overlay);
                
                modal.addEventListener('click', async (e) => {
                    if (e.target.dataset.action === 'submit') {
                        const reason = modal.querySelector('input[name="report_reason"]:checked')?.value;
                        const description = document.getElementById('report-description').value;
                        
                        if (!reason) {
                            Toast.warning('Please select a reason');
                            return;
                        }
                        
                        overlay.remove();
                        
                        try {
                            const response = await fetch('<?php echo url('/threads/report'); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `thread_id=${threadId}&reason=${reason}&description=${encodeURIComponent(description)}`
                            });
                            
                            const data = await response.json();
                            
                            if (data.success) {
                                Toast.success(data.message);
                            } else {
                                Toast.error(data.message);
                            }
                        } catch (error) {
                            Toast.error('Failed to submit report');
                        }
                    } else if (e.target.dataset.action === 'cancel') {
                        overlay.remove();
                    }
                });
                
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) {
                        overlay.remove();
                    }
                });
            }
            </script>
            <?php endif; ?>
            
            <!-- Similar Threads -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-bold">Similar Threads</h3>
                </div>
                <div class="card-body space-y-3">
                    <p class="text-sm text-gray-500">No similar threads found</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>

<!-- Report Modal -->
<div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold dark:text-white">Report Content</h3>
            <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="reportForm">
            <?php echo csrfField(); ?>
            <input type="hidden" id="reportType" name="type">
            <input type="hidden" id="reportId" name="id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Reason</label>
                <select name="reason" class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    <option value="">Select a reason...</option>
                    <option value="spam">Spam</option>
                    <option value="harassment">Harassment</option>
                    <option value="inappropriate">Inappropriate Content</option>
                    <option value="copyright">Copyright Violation</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Description (Optional)</label>
                <textarea name="description" rows="3" 
                          class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                          placeholder="Provide additional details..."></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReportModal()" 
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentType = '';
let currentId = 0;

function openReportModal(type, id) {
    currentType = type;
    currentId = id;
    
    document.getElementById('reportType').value = type;
    document.getElementById('reportId').value = id;
    document.getElementById('reportForm').reset();
    
    document.getElementById('reportModal').classList.remove('hidden');
    document.getElementById('reportModal').classList.add('flex');
}

function closeReportModal() {
    document.getElementById('reportModal').classList.add('hidden');
    document.getElementById('reportModal').classList.remove('flex');
}

document.getElementById('reportForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('<?php echo url('/reports/create'); ?>', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            closeReportModal();
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Failed to submit report');
    }
});
</script>
