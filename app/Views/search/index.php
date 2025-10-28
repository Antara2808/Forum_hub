<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="card mb-6">
        <div class="card-body">
            <h1 class="text-2xl font-bold mb-4">
                <i class="fas fa-search"></i> Search Threads
            </h1>
            
            <form method="GET" action="<?php echo url('/search'); ?>" class="space-y-4">
                <div class="flex gap-4">
                    <input type="text" name="q" 
                           value="<?php echo e($query); ?>"
                           placeholder="Search for threads..."
                           class="form-input flex-1"
                           autofocus>
                    
                    <select name="category" class="form-input w-48">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" 
                                <?php echo $selectedCategory == $category['id'] ? 'selected' : ''; ?>>
                            <?php echo e($category['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <?php if (!empty($query)): ?>
    <div class="mb-4 text-gray-600 dark:text-gray-400">
        Found <?php echo count($threads); ?> result(s) for "<?php echo e($query); ?>"
    </div>
    
    <?php if (empty($threads)): ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400 text-lg">No threads found</p>
            <p class="text-gray-500 text-sm mt-2">Try different keywords or check spelling</p>
        </div>
    </div>
    <?php else: ?>
    <div class="space-y-4">
        <?php foreach ($threads as $thread): ?>
        <div class="card">
            <div class="card-body">
                <div class="flex items-start space-x-4">
                    <img src="<?php echo $thread['avatar'] ? upload('avatars/' . $thread['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-12 h-12 rounded-full">
                    
                    <div class="flex-1">
                        <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                           class="text-xl font-bold hover:text-blue-600 block mb-2">
                            <?php echo e($thread['title']); ?>
                        </a>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-3">
                            <?php echo truncate(e($thread['content']), 200); ?>
                        </p>
                        
                        <div class="flex gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-user"></i> <?php echo e($thread['username']); ?></span>
                            <span><i class="fas fa-folder"></i> <?php echo e($thread['category_name']); ?></span>
                            <span><i class="fas fa-eye"></i> <?php echo $thread['views']; ?> views</span>
                            <span><i class="fas fa-comments"></i> <?php echo $thread['reply_count']; ?> replies</span>
                            <span><i class="fas fa-clock"></i> <?php echo timeAgo($thread['created_at']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-12 text-gray-500">
            <i class="fas fa-search text-6xl mb-4"></i>
            <p class="text-lg">Enter keywords to search</p>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
