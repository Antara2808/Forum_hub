<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <a href="<?php echo url('/admin/users'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mb-4">
            <i class="fas fa-arrow-left mr-2"></i> Back to User Management
        </a>
        <h1 class="text-3xl font-bold mb-2">
            <i class="fas fa-user"></i> User Profile
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Detailed information for <?php echo e($user['username']); ?></p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">User Information</h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center mb-6">
                        <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                             alt="Avatar" class="w-24 h-24 rounded-full mb-4">
                        <h3 class="text-xl font-bold"><?php echo e($user['username']); ?></h3>
                        <p class="text-gray-600 dark:text-gray-400"><?php echo e($user['email']); ?></p>
                        <div class="mt-2">
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge badge-danger"><i class="fas fa-crown"></i> Admin</span>
                            <?php elseif ($user['role'] === 'moderator'): ?>
                                <span class="badge badge-warning"><i class="fas fa-shield"></i> Moderator</span>
                            <?php else: ?>
                                <span class="badge badge-primary">User</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Joined</label>
                            <p class="font-medium"><?php echo formatDate($user['created_at']); ?></p>
                            <p class="text-sm text-gray-500"><?php echo timeAgo($user['created_at']); ?></p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Seen</label>
                            <p class="font-medium"><?php echo $user['last_seen'] ? formatDate($user['last_seen']) : 'Never'; ?></p>
                            <p class="text-sm text-gray-500"><?php echo $user['last_seen'] ? timeAgo($user['last_seen']) : 'Never'; ?></p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                            <div class="mt-1">
                                <?php if ($user['is_banned']): ?>
                                    <span class="badge badge-danger"><i class="fas fa-ban"></i> Banned</span>
                                    <?php if ($user['ban_reason']): ?>
                                        <p class="text-sm text-gray-500 mt-1"><?php echo e($user['ban_reason']); ?></p>
                                    <?php endif; ?>
                                <?php elseif ($user['is_online']): ?>
                                    <span class="badge badge-success"><i class="fas fa-circle"></i> Online</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Offline</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats and Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">User Statistics</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?php echo $stats['thread_count'] ?? 0; ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Threads</div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo $stats['post_count'] ?? 0; ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Posts</div>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400"><?php echo $user['reputation']; ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Reputation</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400"><?php echo $stats['friend_count'] ?? 0; ?></div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Friends</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h2 class="text-xl font-bold">Recent Activity</h2>
                </div>
                <div class="p-6">
                    <?php if (!empty($recentActivity)): ?>
                        <div class="space-y-4">
                            <?php foreach ($recentActivity as $activity): ?>
                                <div class="flex items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="mr-3 mt-1">
                                        <?php if ($activity['type'] === 'thread'): ?>
                                            <i class="fas fa-comment-alt text-blue-500"></i>
                                        <?php else: ?>
                                            <i class="fas fa-reply text-green-500"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium">
                                            <?php if ($activity['type'] === 'thread'): ?>
                                                Created thread: <?php echo e($activity['content']); ?>
                                            <?php else: ?>
                                                Posted: <?php echo e($activity['content']); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-sm text-gray-500"><?php echo timeAgo($activity['created_at']); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No recent activity</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Admin Actions -->
    <div class="card mt-6">
        <div class="card-header">
            <h2 class="text-xl font-bold">Admin Actions</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <button onclick="openRoleModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                        class="btn btn-secondary">
                    <i class="fas fa-user-tag"></i> Change Role
                </button>
                <button onclick="openReputationModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                        class="btn btn-secondary">
                    <i class="fas fa-star"></i> Modify Reputation
                </button>
                <?php if (!$user['is_banned']): ?>
                <button onclick="openBanModal(<?php echo htmlspecialchars(json_encode($user)); ?>)" 
                        class="btn btn-danger">
                    <i class="fas fa-ban"></i> Ban User
                </button>
                <?php else: ?>
                <button onclick="unbanUser(<?php echo $user['id']; ?>)" 
                        class="btn btn-success">
                    <i class="fas fa-check"></i> Unban User
                </button>
                <?php endif; ?>
                <button onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo e($user['username']); ?>')" 
                        class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete User
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Role Modal -->
<div id="roleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-[#15202B] rounded-lg p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-[#38444D]">
        <h3 class="text-2xl font-bold mb-4 dark:text-white">Change User Role</h3>
        <form id="roleForm">
            <?php echo csrfField(); ?>
            <input type="hidden" id="roleUserId" name="user_id" value="<?php echo $user['id']; ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="roleUsername" value="<?php echo e($user['username']); ?>" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Select Role</label>
                <select name="role" id="roleSelect" class="w-full px-4 py-2 border rounded dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>Moderator</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
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
            <input type="hidden" id="repUserId" name="user_id" value="<?php echo $user['id']; ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="repUsername" value="<?php echo e($user['username']); ?>" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Current Reputation: <span id="repCurrent" class="text-yellow-600 font-bold"><?php echo $user['reputation']; ?></span></label>
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
            <input type="hidden" id="banUserId" name="user_id" value="<?php echo $user['id']; ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 dark:text-gray-300">Username</label>
                <input type="text" id="banUsername" value="<?php echo e($user['username']); ?>" readonly class="w-full px-4 py-2 border rounded bg-gray-100 dark:bg-[#192734] dark:border-[#38444D] dark:text-white">
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
            setTimeout(() => window.location.href = '<?php echo url('/admin/users'); ?>', 1500);
        } else {
            Toast.error(result.message);
        }
    } catch (error) {
        Toast.error('Error deleting user');
    }
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>