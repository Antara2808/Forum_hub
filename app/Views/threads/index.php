<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white transition-colors duration-300">Discussion Threads</h1>
            <p class="text-gray-600 dark:text-gray-200 transition-colors duration-300">Explore topics and join conversations</p>
        </div>
        <?php if (isLoggedIn()): ?>
        <a href="<?php echo url('/threads/create'); ?>" 
           class="px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
            <i class="fas fa-plus mr-2"></i> New Thread
        </a>
        <?php endif; ?>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300 sticky top-4">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="font-bold text-gray-900 dark:text-gray-50 transition-colors duration-300">
                        <i class="fas fa-filter text-blue-600 dark:text-blue-400"></i> Filter by Category
                    </h3>
                </div>
                <div class="px-3 py-4 space-y-1">
                    <a href="<?php echo url('/threads'); ?>" 
                       class="flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium transition-all duration-300
                              <?php echo empty($_GET['category']) 
                                  ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-200 font-bold shadow-sm' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="fas fa-th w-5"></i>
                        <span>All Threads</span>
                    </a>
                    <?php foreach ($categories as $category): ?>
                    <a href="<?php echo url('/threads?category=' . $category['slug']); ?>" 
                       class="flex items-center gap-2 px-4 py-2.5 rounded-lg font-medium transition-all duration-300
                              <?php echo ($_GET['category'] ?? '') === $category['slug'] 
                                  ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-200 font-bold shadow-sm' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700/50'; ?>
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="<?php echo $category['icon']; ?> w-5"></i>
                        <span><?php echo e($category['name']); ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Sort Options -->
            <div class="flex items-center justify-between mb-6 bg-white dark:bg-gray-800 rounded-lg px-4 py-3 border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <div class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    <i class="fas fa-list-ul mr-1.5"></i>
                    <?php echo count($threads); ?> threads found
                </div>
                <select class="px-4 py-2 text-sm font-medium border border-gray-300 dark:border-gray-600 rounded-lg 
                              bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                              focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                              transition-all duration-300 cursor-pointer hover:border-gray-400 dark:hover:border-gray-500">
                    <option>Most Recent</option>
                    <option>Most Viewed</option>
                    <option>Most Replies</option>
                    <option>Most Popular</option>
                </select>
            </div>
            
            <!-- Threads List -->
            <?php if (empty($threads)): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <div class="p-12 text-center">
                    <i class="fas fa-inbox text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-4 font-medium">No threads found</p>
                    <?php if (isLoggedIn()): ?>
                    <a href="<?php echo url('/threads/create'); ?>" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <i class="fas fa-plus mr-2"></i> Create First Thread
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($threads as $thread): ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 
                            hover:shadow-lg dark:hover:shadow-2xl dark:hover:shadow-blue-500/10 
                            hover:border-gray-300 dark:hover:border-gray-600
                            transition-all duration-300 transform hover:-translate-y-0.5">
                    <div class="flex items-start space-x-4">
                        <a href="<?php echo url('/profile/' . $thread['user_id']); ?>" 
                           class="flex-shrink-0 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 rounded-full">
                            <img src="<?php echo $thread['avatar'] ? upload('avatars/' . $thread['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                 alt="Avatar" class="w-14 h-14 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 transition-all duration-300 hover:ring-blue-500 dark:hover:ring-blue-400">
                        </a>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <!-- Badges -->
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <?php if ($thread['is_pinned']): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full 
                                                     bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 
                                                     border border-amber-200 dark:border-amber-700">
                                            <i class="fas fa-thumbtack"></i> Pinned
                                        </span>
                                        <?php endif; ?>
                                        <?php if ($thread['is_locked']): ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full 
                                                     bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 
                                                     border border-red-200 dark:border-red-700">
                                            <i class="fas fa-lock"></i> Locked
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Title -->
                                    <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                                       class="text-xl font-bold text-gray-900 dark:text-gray-50 
                                              hover:text-blue-600 dark:hover:text-blue-400 
                                              transition-colors duration-300 block mt-1 
                                              focus:outline-none focus:underline">
                                        <?php echo e($thread['title']); ?>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                <span class="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300">
                                    <i class="fas fa-user"></i>
                                    <a href="<?php echo url('/profile/' . $thread['user_id']); ?>" 
                                       class="font-medium focus:outline-none focus:underline">
                                        <?php echo e($thread['username']); ?>
                                    </a>
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fas fa-folder text-gray-500 dark:text-gray-400"></i>
                                    <?php if (!empty($thread['category_slug'])): ?>
                                    <a href="<?php echo url('/threads?category=' . $thread['category_slug']); ?>" 
                                       class="font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 focus:outline-none focus:underline">
                                        <?php echo e($thread['category_name'] ?? 'Uncategorized'); ?>
                                    </a>
                                    <?php else: ?>
                                    <span class="text-gray-500 dark:text-gray-400">Uncategorized</span>
                                    <?php endif; ?>
                                </span>
                                <span class="inline-flex items-center gap-1.5 text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-clock"></i>
                                    <?php echo timeAgo($thread['created_at']); ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="hidden sm:flex items-center gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 transition-colors duration-300">
                                    <?php echo $thread['reply_count'] ?? 0; ?>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">replies</div>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 transition-colors duration-300">
                                    <?php echo $thread['views']; ?>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium mt-0.5">views</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="mt-8 flex justify-center" id="pagination">
                <div class="inline-flex rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden" role="group">
                    <!-- Previous Button -->
                    <?php if ($currentPage > 1): ?>
                    <a href="<?php echo url('/threads?page=' . ($currentPage - 1) . ($category ? '&category=' . $category : '')); ?>" 
                       class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                              border-r border-gray-200 dark:border-gray-700 
                              hover:bg-gray-50 dark:hover:bg-gray-700 
                              transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <?php else: ?>
                    <span class="px-4 py-2.5 text-sm font-medium bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 
                                 border-r border-gray-200 dark:border-gray-700 cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    <?php endif; ?>
                    
                    <!-- Page Numbers -->
                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                    
                    // Show first page if not in range
                    if ($startPage > 1):
                    ?>
                    <a href="<?php echo url('/threads?page=1' . ($category ? '&category=' . $category : '')); ?>" 
                       class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                              border-r border-gray-200 dark:border-gray-700 
                              hover:bg-gray-50 dark:hover:bg-gray-700 
                              transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        1
                    </a>
                    <?php if ($startPage > 2): ?>
                    <span class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-400 dark:text-gray-500 
                                 border-r border-gray-200 dark:border-gray-700">
                        ...
                    </span>
                    <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Page Number Buttons -->
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <?php if ($i == $currentPage): ?>
                        <span class="px-4 py-2.5 text-sm font-bold bg-blue-600 dark:bg-blue-500 text-white 
                                     border-r border-blue-500 dark:border-blue-400 shadow-inner">
                            <?php echo $i; ?>
                        </span>
                        <?php else: ?>
                        <a href="<?php echo url('/threads?page=' . $i . ($category ? '&category=' . $category : '')); ?>" 
                           class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                                  border-r border-gray-200 dark:border-gray-700 
                                  hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 
                                  transition-all duration-300 
                                  focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <?php echo $i; ?>
                        </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <!-- Show last page if not in range -->
                    <?php if ($endPage < $totalPages): ?>
                    <?php if ($endPage < $totalPages - 1): ?>
                    <span class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-400 dark:text-gray-500 
                                 border-r border-gray-200 dark:border-gray-700">
                        ...
                    </span>
                    <?php endif; ?>
                    <a href="<?php echo url('/threads?page=' . $totalPages . ($category ? '&category=' . $category : '')); ?>" 
                       class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                              border-r border-gray-200 dark:border-gray-700 
                              hover:bg-gray-50 dark:hover:bg-gray-700 
                              transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <?php echo $totalPages; ?>
                    </a>
                    <?php endif; ?>
                    
                    <!-- Next Button -->
                    <?php if ($currentPage < $totalPages): ?>
                    <a href="<?php echo url('/threads?page=' . ($currentPage + 1) . ($category ? '&category=' . $category : '')); ?>" 
                       class="px-4 py-2.5 text-sm font-medium bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 
                              hover:bg-gray-50 dark:hover:bg-gray-700 
                              transition-all duration-300 
                              focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php else: ?>
                    <span class="px-4 py-2.5 text-sm font-medium bg-gray-100 dark:bg-gray-900 text-gray-400 dark:text-gray-600 cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Pagination Info -->
            <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-300 font-medium">
                Showing page <?php echo $currentPage; ?> of <?php echo $totalPages; ?> (<?php echo $totalThreads; ?> total threads)
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Smooth scroll to top on pagination click
document.addEventListener('DOMContentLoaded', function() {
    const paginationLinks = document.querySelectorAll('#pagination a');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Let the link navigate normally, but add smooth scroll
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
    
    // Check URL for page parameter and scroll to top if navigating via pagination
    const urlParams = new URLSearchParams(window.location.search);
    const pageParam = urlParams.get('page');
    
    if (pageParam && pageParam !== '1') {
        // User navigated via pagination, scroll smoothly to thread list
        setTimeout(() => {
            const threadsSection = document.querySelector('.max-w-7xl');
            if (threadsSection) {
                threadsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    }
});
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
