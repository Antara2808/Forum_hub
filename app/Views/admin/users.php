<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-users"></i> User Management
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Manage all user accounts</p>
    </div>
    
    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="text-xl font-bold">Filters</h2>
        </div>
        <div class="p-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Search</label>
                    <input type="text" name="search" value="<?php echo e($searchQuery ?? ''); ?>" 
                           placeholder="Username or email..." 
                           class="form-input w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Role</label>
                    <select name="role" class="form-input w-full">
                        <option value="all" <?php echo ($roleFilter ?? 'all') === 'all' ? 'selected' : ''; ?>>All Roles</option>
                        <option value="user" <?php echo ($roleFilter ?? 'all') === 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="moderator" <?php echo ($roleFilter ?? 'all') === 'moderator' ? 'selected' : ''; ?>>Moderator</option>
                        <option value="admin" <?php echo ($roleFilter ?? 'all') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1 dark:text-gray-300">Status</label>
                    <select name="status" class="form-input w-full">
                        <option value="all" <?php echo ($statusFilter ?? 'all') === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                        <option value="online" <?php echo ($statusFilter ?? 'all') === 'online' ? 'selected' : ''; ?>>Online</option>
                        <option value="offline" <?php echo ($statusFilter ?? 'all') === 'offline' ? 'selected' : ''; ?>>Offline</option>
                        <option value="banned" <?php echo ($statusFilter ?? 'all') === 'banned' ? 'selected' : ''; ?>>Banned</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="text-xl font-bold">All Users (<?php echo $totalUsers ?? count($users); ?>)</h2>
            <div>
                <input type="text" id="searchUsers" placeholder="Search users..." 
                       class="form-input w-64">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Reputation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="usersTable">
                    <?php foreach ($users as $user): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                     alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                                <div>
                                    <div class="font-medium"><?php echo e($user['username']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($user['email']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge badge-danger"><i class="fas fa-crown"></i> Admin</span>
                            <?php elseif ($user['role'] === 'moderator'): ?>
                                <span class="badge badge-warning"><i class="fas fa-shield"></i> Moderator</span>
                            <?php else: ?>
                                <span class="badge badge-primary">User</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-yellow-600 font-bold"><?php echo $user['reputation']; ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($user['is_banned']): ?>
                                <span class="badge badge-danger"><i class="fas fa-ban"></i> Banned</span>
                            <?php elseif ($user['is_online']): ?>
                                <span class="badge badge-success"><i class="fas fa-circle"></i> Online</span>
                            <?php else: ?>
                                <span class="text-gray-500 text-sm">Offline</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo timeAgo($user['created_at']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="<?php echo url('/profile/' . $user['id']); ?>" 
                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button onclick="openRoleModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                                    class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300">
                                <i class="fas fa-user-tag"></i> Role
                            </button>
                            <button onclick="openReputationModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                                    class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300">
                                <i class="fas fa-star"></i> Points
                            </button>
                            <?php if (!$user['is_banned']): ?>
                            <button onclick="openBanModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <i class="fas fa-ban"></i> Ban
                            </button>
                            <?php else: ?>
                            <button onclick="unbanUser(<?php echo $user['id']; ?>)" 
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-check"></i> Unban
                            </button>
                            <?php endif; ?>
                            <button onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo e($user['username']); ?>')" 
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Showing page <?php echo $currentPage ?? 1; ?> of <?php echo $totalPages; ?>
        </div>
        <div class="flex space-x-2">
            <?php if (($currentPage ?? 1) > 1): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => ($currentPage ?? 1) - 1])); ?>" 
               class="px-3 py-1 rounded border dark:border-gray-600 dark:hover:bg-gray-700">
                Previous
            </a>
            <?php endif; ?>
            
            <?php for ($i = max(1, ($currentPage ?? 1) - 2); $i <= min($totalPages, ($currentPage ?? 1) + 2); $i++): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" 
               class="px-3 py-1 rounded <?php echo $i == ($currentPage ?? 1) ? 'bg-blue-600 text-white' : 'border dark:border-gray-600 dark:hover:bg-gray-700'; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>
            
            <?php if (($currentPage ?? 1) < $totalPages): ?>
            <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => ($currentPage ?? 1) + 1])); ?>" 
               class="px-3 py-1 rounded border dark:border-gray-600 dark:hover:bg-gray-700">
                Next
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Simple client-side search
document.getElementById('searchUsers').addEventListener('keyup', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>

<!-- Role Modal -->
<div id="roleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-[#15202B] rounded-lg p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-[#38444D]">
        <h3 class="text-2xl font-bold mb-4 dark:text-white">Change User Role</h3>
        <form id="roleForm">
            <?php echo csrfField(); ?>
            <input type="hidden" id="roleUserId" name="user_id">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="roleUsername" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Select Role</label>
                <select name="role" id="roleSelect" class="w-full px-4 py-2 border rounded dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
                    <option value="user">User</option>
                    <option value="moderator">Moderator</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeRoleModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Role</button>
            </div>
        </form>
    </div>
</div>

<!-- Reputation Modal -->
<div id="reputationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-[#15202B] rounded-lg p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-[#38444D]">
        <h3 class="text-2xl font-bold mb-4 dark:text-white">Add/Remove Reputation Points</h3>
        <form id="reputationForm">
            <?php echo csrfField(); ?>
            <input type="hidden" id="repUserId" name="user_id">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="repUsername" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Current Reputation: <span id="repCurrent" class="text-yellow-600 font-bold"></span></label>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Points (use negative to remove)</label>
                <input type="number" name="points" id="repPoints" class="w-full px-4 py-2 border rounded dark:bg-[#192734] dark:border-[#38444D] dark:text-white" placeholder="e.g., 100 or -50">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeReputationModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update Points</button>
            </div>
        </form>
    </div>
</div>

<!-- Ban Modal -->
<div id="banModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-[#15202B] rounded-lg p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-[#38444D]">
        <h3 class="text-2xl font-bold mb-4 text-red-600">Ban User</h3>
        <form id="banForm">
            <?php echo csrfField(); ?>
            <input type="hidden" id="banUserId" name="user_id">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="banUsername" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Reason</label>
                <textarea name="reason" rows="3" class="w-full px-4 py-2 border rounded dark:bg-[#192734] dark:border-[#38444D] dark:text-white" placeholder="Why is this user being banned?"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeBanModal()" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Ban User</button>
            </div>
        </form>
    </div>
</div>

<script>
// Role Modal Functions
function openRoleModal(user) {
    document.getElementById('roleUserId').value = user.id;
    document.getElementById('roleUsername').value = user.username;
    document.getElementById('roleSelect').value = user.role;
    document.getElementById('roleModal').classList.remove('hidden');
}

function closeRoleModal() {
    document.getElementById('roleModal').classList.add('hidden');
}

document.getElementById('roleForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('<?php echo url('/admin/user/role'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            closeRoleModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error updating role');
    }
});

// Reputation Modal Functions
function openReputationModal(user) {
    document.getElementById('repUserId').value = user.id;
    document.getElementById('repUsername').value = user.username;
    document.getElementById('repCurrent').textContent = user.reputation;
    document.getElementById('repPoints').value = '';
    document.getElementById('reputationModal').classList.remove('hidden');
}

function closeReputationModal() {
    document.getElementById('reputationModal').classList.add('hidden');
}

document.getElementById('reputationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('<?php echo url('/admin/user/reputation'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            closeReputationModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error updating reputation');
    }
});

// Ban Modal Functions
function openBanModal(user) {
    document.getElementById('banUserId').value = user.id;
    document.getElementById('banUsername').value = user.username;
    document.getElementById('banModal').classList.remove('hidden');
}

function closeBanModal() {
    document.getElementById('banModal').classList.add('hidden');
}

document.getElementById('banForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch('<?php echo url('/admin/user/ban'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            closeBanModal();
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error banning user');
    }
});

async function unbanUser(userId) {
    const confirmed = await showConfirm({
        icon: '✅',
        title: 'Unban User',
        message: 'Are you sure you want to unban this user?',
        confirmText: 'Unban',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) return;
    
    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
    
    try {
        const response = await fetch('<?php echo url('/admin/user/ban'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error unbanning user');
    }
}

async function deleteUser(userId, username) {
    const confirmed = await showConfirm({
        icon: '🗑️',
        title: 'Delete User',
        message: `Are you sure you want to delete user <strong>${username}</strong>? This action cannot be undone.`,
        confirmText: 'Delete',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) return;
    
    const formData = new FormData();
    formData.append('user_id', userId);
    formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
    
    try {
        const response = await fetch('<?php echo url('/admin/user/delete'); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams(formData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            Toast.success(result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error deleting user');
    }
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
