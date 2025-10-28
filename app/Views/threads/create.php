<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">Create New Thread</h1>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo url('/threads/create'); ?>" class="space-y-6">
                <?php echo csrfField(); ?>
                
                <div>
                    <label for="title" class="form-label">Thread Title</label>
                    <input type="text" id="title" name="title" required
                           class="form-input"
                           placeholder="Enter an engaging title for your thread"
                           maxlength="255">
                </div>
                
                <div>
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" required class="form-input">
                        <option value="">Select a category...</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo e($category['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="content" class="form-label">Content</label>
                    <textarea id="content" name="content" required rows="12"
                              class="form-input"
                              placeholder="Write your thread content here..."></textarea>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-info-circle"></i> You can use basic HTML and markdown
                    </p>
                </div>
                
                <div>
                    <label for="tags" class="form-label">Tags (Optional)</label>
                    <input type="text" id="tags" name="tags"
                           class="form-input"
                           placeholder="php, javascript, tutorial (comma separated)">
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-tags"></i> Add tags to help categorize your thread
                    </p>
                </div>
                
                <!-- Future: File upload -->
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <i class="fas fa-lightbulb"></i> <strong>Tip:</strong> Make your thread title clear and descriptive to attract more readers!
                    </p>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo url('/threads'); ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Create Thread
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
