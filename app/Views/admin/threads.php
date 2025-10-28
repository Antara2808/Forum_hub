<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        <i class="fas fa-comments text-green-600"></i> Manage Threads
    </h2>
    <p class="text-gray-600 dark:text-gray-400">View, edit, or delete forum threads</p>
</div>

<!-- Filters & Search -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
            <input type="text" id="searchThreads" placeholder="Search threads..." 
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
            <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option>All Categories</option>
                <?php foreach ($categories ?? [] as $category): ?>
                <option value="<?php echo $category['id']; ?>"><?php echo e($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option>All Status</option>
                <option>Pinned</option>
                <option>Normal</option>
                <option>Reported</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
            <select class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option>Most Recent</option>
                <option>Most Viewed</option>
                <option>Most Replies</option>
                <option>Oldest</option>
            </select>
        </div>
    </div>
</div>

<!-- Threads Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Thread
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Author
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Stats
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Created
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php foreach ($threads ?? [] as $thread): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-start space-x-3">
                            <?php if ($thread['is_pinned']): ?>
                            <i class="fas fa-thumbtack text-red-600 mt-1"></i>
                            <?php endif; ?>
                            <div>
                                <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                                   class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                    <?php echo e($thread['title']); ?>
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">
                                    <?php echo e(substr(strip_tags($thread['content']), 0, 100)); ?>...
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img src="<?php echo $thread['user_avatar'] ? upload('avatars/' . $thread['user_avatar']) : asset('images/default-avatar.svg'); ?>" 
                                 alt="Avatar" class="w-8 h-8 rounded-full mr-2">
                            <span class="text-sm text-gray-900 dark:text-white">
                                <?php echo e($thread['username']); ?>
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                            <?php echo e($thread['category_name']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        <div class="space-y-1">
                            <div><i class="fas fa-eye text-gray-400"></i> <?php echo number_format($thread['views']); ?> views</div>
                            <div><i class="fas fa-reply text-gray-400"></i> <?php echo number_format($thread['reply_count']); ?> replies</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                        <?php echo timeAgo($thread['created_at']); ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <button onclick="togglePin(<?php echo $thread['id']; ?>, <?php echo $thread['is_pinned'] ? 'true' : 'false'; ?>)" 
                                    class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" 
                                    title="<?php echo $thread['is_pinned'] ? 'Unpin' : 'Pin'; ?>">
                                <i class="fas fa-thumbtack"></i>
                            </button>
                            <a href="<?php echo url('/threads/' . $thread['id'] . '/edit'); ?>" 
                               class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteThread(<?php echo $thread['id']; ?>)" 
                                    class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" 
                                    title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing 1 to <?php echo count($threads ?? []); ?> of <?php echo $totalThreads ?? 0; ?> threads
            </div>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500">
                    Previous
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    1
                </button>
                <button class="px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500">
                    2
                </button>
                <button class="px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-500">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// CSRF Token
const csrfToken = '<?php echo $_SESSION[CSRF_TOKEN_NAME] ?? ''; ?>';

// Toggle Pin Thread
async function togglePin(threadId, isPinned) {
    const action = isPinned ? 'unpin' : 'pin';
    const confirmed = await showConfirm({
        icon: '📌',
        title: `${isPinned ? 'Unpin' : 'Pin'} Thread`,
        message: `Are you sure you want to ${action} this thread?`,
        confirmText: isPinned ? 'Unpin' : 'Pin'
    });
    
    if (!confirmed) return;
    
    try {
        const response = await fetch('<?php echo url('/admin/thread/pin'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `thread_id=${threadId}&csrf_token=${csrfToken}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message || 'Action failed');
        }
    } catch (error) {
        Toast.error('Failed to update thread');
    }
}

// Delete Thread
async function deleteThread(threadId) {
    const confirmed = await showConfirm({
        icon: '🗑️',
        title: 'Delete Thread',
        message: 'Are you sure you want to delete this thread? This action cannot be undone!',
        confirmText: 'Delete'
    });
    
    if (!confirmed) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `<?php echo url('/threads/'); ?>${threadId}/delete`;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = 'csrf_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Search functionality
document.getElementById('searchThreads').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const title = row.querySelector('a').textContent.toLowerCase();
        row.style.display = title.includes(searchTerm) ? '' : 'none';
    });
});
</script>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>
