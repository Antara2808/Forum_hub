<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 dark:text-white">
            <i class="fas fa-chart-line text-[#FF4500]"></i> Admin Dashboard
        </h1>
        <p class="text-gray-600 dark:text-gray-400">Manage your ForumHub Pro platform</p>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['total_users']; ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-circle text-green-500"></i> <?php echo $stats['users_online']; ?> online
                    </p>
                </div>
                <div class="text-4xl text-blue-600 dark:text-blue-400">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Threads -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Threads</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['total_threads']; ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Community discussions</p>
                </div>
                <div class="text-4xl text-green-600 dark:text-green-400">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Posts -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Posts</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['total_posts']; ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total replies</p>
                </div>
                <div class="text-4xl text-purple-600 dark:text-purple-400">
                    <i class="fas fa-reply"></i>
                </div>
            </div>
        </div>
        
        <!-- Categories -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Categories</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['total_categories']; ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Discussion topics</p>
                </div>
                <div class="text-4xl text-yellow-600 dark:text-yellow-400">
                    <i class="fas fa-folder"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Role Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Administrators</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['admins']; ?></p>
                </div>
                <div class="text-3xl text-red-600">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Moderators</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['moderators']; ?></p>
                </div>
                <div class="text-3xl text-yellow-600">
                    <i class="fas fa-shield"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Regular Users</p>
                    <p class="text-3xl font-bold mt-1 dark:text-white"><?php echo $stats['regular_users']; ?></p>
                </div>
                <div class="text-3xl text-blue-600">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="<?php echo url('/admin/users'); ?>" class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D] hover:shadow-lg transition-shadow">
            <div class="flex items-center space-x-4">
                <div class="text-4xl text-blue-600 dark:text-blue-400">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg dark:text-white">Manage Users</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View and manage user accounts</p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo url('/admin/categories'); ?>" class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D] hover:shadow-lg transition-shadow">
            <div class="flex items-center space-x-4">
                <div class="text-4xl text-green-600 dark:text-green-400">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg dark:text-white">Manage Categories</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Add and edit categories</p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo url('/analytics'); ?>" class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D] hover:shadow-lg transition-shadow">
            <div class="flex items-center space-x-4">
                <div class="text-4xl text-purple-600 dark:text-purple-400">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg dark:text-white">View Analytics</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Platform statistics</p>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- User Activity Chart -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <h2 class="text-xl font-bold mb-4 dark:text-white">
                <i class="fas fa-chart-bar text-blue-600"></i> User Activity (Last 7 Days)
            </h2>
            <canvas id="userActivityChart" height="300"></canvas>
        </div>
        
        <!-- Thread Activity Chart -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow p-6 border border-gray-200 dark:border-[#38444D]">
            <h2 class="text-xl font-bold mb-4 dark:text-white">
                <i class="fas fa-chart-line text-green-600"></i> Thread Activity (Last 7 Days)
            </h2>
            <canvas id="threadActivityChart" height="300"></canvas>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top Users by Reputation -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow border border-gray-200 dark:border-[#38444D]">
            <div class="p-6 border-b border-gray-200 dark:border-[#38444D]">
                <h2 class="text-xl font-bold dark:text-white">
                    <i class="fas fa-trophy text-yellow-600"></i> Top Users (By Reputation)
                </h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-[#38444D]">
                <?php foreach ($topUsers as $index => $user): ?>
                <div class="p-4 flex items-center space-x-4 hover:bg-gray-50 dark:hover:bg-[#192734]">
                    <div class="text-2xl font-bold text-gray-400 w-8">#<?php echo $index + 1; ?></div>
                    <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-12 h-12 rounded-full">
                    <div class="flex-1">
                        <a href="<?php echo url('/profile/' . $user['id']); ?>" class="font-bold hover:text-blue-600 dark:text-white dark:hover:text-blue-400">
                            <?php echo e($user['username']); ?>
                        </a>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo getReputationRank($user['reputation']); ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo $user['reputation']; ?></div>
                        <div class="text-xs text-gray-500">points</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="bg-white dark:bg-[#15202B] rounded-lg shadow border border-gray-200 dark:border-[#38444D]">
            <div class="p-6 border-b border-gray-200 dark:border-[#38444D]">
                <h2 class="text-xl font-bold dark:text-white">
                    <i class="fas fa-user-plus text-blue-600"></i> Recent Registrations
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-[#192734]">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-[#38444D]">
                        <?php foreach ($recentUsers as $user): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#192734]">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                                         alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                                    <div>
                                        <div class="font-medium dark:text-white"><?php echo e($user['username']); ?></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($user['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($user['role'] === 'admin'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        <i class="fas fa-crown"></i> Admin
                                    </span>
                                <?php elseif ($user['role'] === 'moderator'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                        <i class="fas fa-shield"></i> Moderator
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">User</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <?php echo timeAgo($user['created_at']); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Sample data - in production, this would come from PHP
const userActivityData = {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
        label: 'Active Users',
        data: [45, 52, 48, 65, 71, 68, 72],
        backgroundColor: 'rgba(59, 130, 246, 0.5)',
        borderColor: 'rgb(59, 130, 246)',
        borderWidth: 2
    }]
};

const threadActivityData = {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
        label: 'New Threads',
        data: [12, 19, 15, 25, 22, 30, 28],
        backgroundColor: 'rgba(16, 185, 129, 0.5)',
        borderColor: 'rgb(16, 185, 129)',
        borderWidth: 2,
        tension: 0.4
    }]
};

// User Activity Chart
new Chart(document.getElementById('userActivityChart'), {
    type: 'bar',
    data: userActivityData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                },
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#38444D' : '#e5e7eb'
                }
            },
            x: {
                ticks: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                },
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#38444D' : '#e5e7eb'
                }
            }
        }
    }
});

// Thread Activity Chart
new Chart(document.getElementById('threadActivityChart'), {
    type: 'line',
    data: threadActivityData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                },
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#38444D' : '#e5e7eb'
                }
            },
            x: {
                ticks: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#000'
                },
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#E7E9EA' : '#e5e7eb'
                }
            }
        }
    }
});
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
