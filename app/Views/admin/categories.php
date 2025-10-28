<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                <i class="fas fa-folder"></i> Category Management
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Manage forum categories</p>
        </div>
        <button onclick="openCreateModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-bold">All Categories (<?php echo count($categories); ?>)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($categories as $category): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3"
                                     style="background-color: <?php echo $category['color']; ?>20; color: <?php echo $category['color']; ?>">
                                    <i class="<?php echo e($category['icon']); ?> text-xl"></i>
                                </div>
                                <div>
                                    <div class="font-bold"><?php echo e($category['name']); ?></div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($category['description']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($category['slug']); ?></td>
                        <td class="px-6 py-4">
                            <span class="text-2xl" style="color: <?php echo $category['color']; ?>">
                                <i class="<?php echo e($category['icon']); ?>"></i>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($category['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm"><?php echo $category['display_order']; ?></td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button onclick="editCategory(<?php echo htmlspecialchars(json_encode($category)); ?>)" 
                                    class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-2xl w-full mx-4">
        <h3 class="text-2xl font-bold mb-4" id="modalTitle">Add Category</h3>
        <form id="categoryForm" method="POST">
            <?php echo csrfField(); ?>
            <input type="hidden" id="categoryId" name="id">
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" id="categoryName" class="form-input" required>
                </div>
                
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" id="categoryDescription" class="form-input" rows="3"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Icon (FontAwesome class)</label>
                        <input type="text" name="icon" id="categoryIcon" class="form-input" placeholder="fa-comments">
                    </div>
                    
                    <div>
                        <label class="form-label">Color (Hex)</label>
                        <input type="color" name="color" id="categoryColor" class="form-input">
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Category</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Add Category';
    document.getElementById('categoryForm').action = '<?php echo url('/admin/categories/create'); ?>';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    document.getElementById('categoryModal').classList.remove('hidden');
}

function editCategory(category) {
    document.getElementById('modalTitle').textContent = 'Edit Category';
    document.getElementById('categoryForm').action = '<?php echo url('/admin/categories/edit/'); ?>' + category.id;
    document.getElementById('categoryId').value = category.id;
    document.getElementById('categoryName').value = category.name;
    document.getElementById('categoryDescription').value = category.description;
    document.getElementById('categoryIcon').value = category.icon;
    document.getElementById('categoryColor').value = category.color;
    document.getElementById('categoryModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
