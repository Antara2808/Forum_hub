<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white dark:bg-[#15202B] rounded-lg shadow border border-gray-200 dark:border-[#38444D]">
        <div class="p-6 border-b border-gray-200 dark:border-[#38444D]">
            <h1 class="text-2xl font-bold dark:text-white">
                <i class="fas fa-edit text-blue-600"></i> Edit Thread
            </h1>
        </div>
        
        <div class="p-6">
            <form method="POST" action="<?php echo url('/threads/' . $thread['id'] . '/edit'); ?>">
                <?php echo csrfField(); ?>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium mb-2 dark:text-gray-300">
                            Thread Title *
                        </label>
                        <input type="text" id="title" name="title" required
                               value="<?php echo e($thread['title']); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-[#38444D] rounded-lg 
                                      focus:ring-2 focus:ring-blue-500 dark:bg-[#192734] dark:text-white"
                               placeholder="Enter your thread title">
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium mb-2 dark:text-gray-300">
                            Category *
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-[#38444D] rounded-lg 
                                       focus:ring-2 focus:ring-blue-500 dark:bg-[#192734] dark:text-white">
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                    <?php echo $thread['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo e($category['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium mb-2 dark:text-gray-300">
                            Content *
                        </label>
                        <textarea id="content" name="content" rows="12" required
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-[#38444D] rounded-lg 
                                         focus:ring-2 focus:ring-blue-500 dark:bg-[#192734] dark:text-white"
                                  placeholder="Write your thread content here..."><?php echo e($thread['content']); ?></textarea>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle"></i> You can use Markdown formatting
                        </p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-[#38444D]">
                    <div class="flex gap-3">
                        <a href="<?php echo url('/threads/' . $thread['id']); ?>" 
                           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        
                        <button type="button" onclick="deleteThread()" 
                                class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-trash"></i> Delete Thread
                        </button>
                    </div>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
async function deleteThread() {
    const confirmed = await showConfirm({
        icon: '🗑️',
        title: 'Delete Thread',
        message: 'Are you sure you want to delete this thread? This action cannot be undone!',
        confirmText: 'Delete',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) {
        return;
    }
    
    // Create a form to submit the delete request
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?php echo url('/threads/' . $thread['id'] . '/delete'); ?>';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = 'csrf_token';
    csrfInput.value = document.querySelector('input[name="csrf_token"]').value;
    form.appendChild(csrfInput);
    
    // Add to body and submit
    document.body.appendChild(form);
    form.submit();
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
