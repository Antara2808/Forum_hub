<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_users'] ?? 0); ?>
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['users_today'] ?? 0; ?> today
                </p>
            </div>
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-3xl text-blue-600 dark:text-blue-400"></i>
            </div>
        </div>
    </div>
    
    <!-- Active Threads -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Active Threads</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_threads'] ?? 0); ?>
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['threads_today'] ?? 0; ?> today
                </p>
            </div>
            <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                <i class="fas fa-comments text-3xl text-green-600 dark:text-green-400"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Posts</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_posts'] ?? 0); ?>
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                    <i class="fas fa-arrow-up"></i> <?php echo $stats['posts_today'] ?? 0; ?> today
                </p>
            </div>
            <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                <i class="fas fa-reply text-3xl text-purple-600 dark:text-purple-400"></i>
            </div>
        </div>
    </div>
    
    <!-- Polls Created -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 transition-all duration-300 hover:shadow-xl">
        <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Polls Created</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_polls'] ?? 0); ?>
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <i class="fas fa-check-circle"></i> <?php echo $stats['active_polls'] ?? 0; ?> active
                </p>
            </div>
            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                <i class="fas fa-poll text-3xl text-amber-600 dark:text-amber-400"></i>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- File Uploads -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">File Uploads</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_uploads'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-paperclip text-3xl text-indigo-600 dark:text-indigo-400"></i>
        </div>
    </div>
    
    <!-- Daily Views -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Daily Views</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['daily_views'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-eye text-3xl text-pink-600 dark:text-pink-400"></i>
        </div>
    </div>
    
    <!-- Online Users -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Online Now</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['users_online'] ?? 0); ?>
                </p>
            </div>
            <div class="relative">
                <i class="fas fa-circle text-3xl text-green-600 dark:text-green-400"></i>
                <span class="absolute top-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-gray-800 bg-green-400 animate-pulse"></span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Contributors (Bar Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-trophy text-amber-600"></i> Top Contributors
            </h3>
            <select class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>This Week</option>
                <option>This Month</option>
                <option>All Time</option>
            </select>
        </div>
        <div class="h-80">
            <canvas id="topContributorsChart"></canvas>
        </div>
    </div>
    
    <!-- Most Viewed Threads (Pie Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-fire text-red-600"></i> Hot Threads
            </h3>
            <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</button>
        </div>
        <div class="h-80">
            <canvas id="hotThreadsChart"></canvas>
        </div>
    </div>
</div>

<!-- Weekly Activity (Line Chart) -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
            <i class="fas fa-chart-line text-blue-600"></i> Weekly Post Activity
        </h3>
        <div class="flex space-x-2">
            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-lg">Posts</button>
            <button class="px-3 py-1 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Users</button>
            <button class="px-3 py-1 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">Threads</button>
        </div>
    </div>
    <div class="h-96">
        <canvas id="weeklyActivityChart"></canvas>
    </div>
</div>

<!-- Recent Activities & Top Users -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activities Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-clock text-blue-600"></i> Recent Activities
            </h3>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto">
            <?php foreach (($recentActivities ?? []) as $activity): ?>
            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <?php if ($activity['type'] === 'thread'): ?>
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-comments text-green-600 dark:text-green-400"></i>
                            </div>
                        <?php elseif ($activity['type'] === 'user'): ?>
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-plus text-blue-600 dark:text-blue-400"></i>
                            </div>
                        <?php else: ?>
                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-comment text-purple-600 dark:text-purple-400"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                            <?php echo e($activity['message']); ?>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <i class="fas fa-clock"></i> <?php echo timeAgo($activity['created_at']); ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Top Users by Reputation -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-star text-yellow-600"></i> Top Users
            </h3>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto">
            <?php foreach (($topUsers ?? []) as $index => $user): ?>
            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-gray-400 dark:text-gray-600 w-8">
                        #<?php echo $index + 1; ?>
                    </div>
                    <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-12 h-12 rounded-full border-2 border-blue-600">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white truncate">
                            <?php echo e($user['username']); ?>
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <?php echo getReputationRank($user['reputation']); ?>
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-amber-600 dark:text-amber-400">
                            <?php echo number_format($user['reputation']); ?>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">points</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
// Chart Configuration
const isDark = document.documentElement.classList.contains('dark');

// Theme-aware colors
const chartColors = {
    primary: isDark ? '#60a5fa' : '#3b82f6',
    success: isDark ? '#34d399' : '#10b981',
    warning: isDark ? '#fbbf24' : '#f59e0b',
    danger: isDark ? '#f87171' : '#ef4444',
    purple: isDark ? '#c084fc' : '#a855f7',
    text: isDark ? '#e5e7eb' : '#374151',
    grid: isDark ? '#374151' : '#e5e7eb'
};

// Top Contributors Bar Chart
const topContributorsCtx = document.getElementById('topContributorsChart').getContext('2d');
const topContributorsChart = new Chart(topContributorsCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($topContributors ?? [], 'username')); ?>,
        datasets: [{
            label: 'Posts',
            data: <?php echo json_encode(array_column($topContributors ?? [], 'post_count')); ?>,
            backgroundColor: chartColors.primary,
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: chartColors.text },
                grid: { color: chartColors.grid, drawBorder: false }
            },
            x: {
                ticks: { color: chartColors.text },
                grid: { display: false }
            }
        }
    }
});

// Hot Threads Pie Chart
const hotThreadsCtx = document.getElementById('hotThreadsChart').getContext('2d');
const hotThreadsChart = new Chart(hotThreadsCtx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_column($hotThreads ?? [], 'title')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_column($hotThreads ?? [], 'views')); ?>,
            backgroundColor: [
                chartColors.primary,
                chartColors.success,
                chartColors.warning,
                chartColors.danger,
                chartColors.purple
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { color: chartColors.text, padding: 15 }
            }
        }
    }
});

// Weekly Activity Line Chart
const weeklyActivityCtx = document.getElementById('weeklyActivityChart').getContext('2d');
const weeklyActivityChart = new Chart(weeklyActivityCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Posts',
            data: <?php echo json_encode($weeklyPosts ?? [12, 19, 15, 25, 22, 30, 28]); ?>,
            borderColor: chartColors.primary,
            backgroundColor: isDark ? 'rgba(96, 165, 250, 0.1)' : 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: chartColors.primary
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: chartColors.text },
                grid: { color: chartColors.grid, drawBorder: false }
            },
            x: {
                ticks: { color: chartColors.text },
                grid: { color: chartColors.grid, drawBorder: false }
            }
        }
    }
});

// Update charts when theme changes
function updateChartTheme(isDark) {
    const newColors = {
        primary: isDark ? '#60a5fa' : '#3b82f6',
        success: isDark ? '#34d399' : '#10b981',
        warning: isDark ? '#fbbf24' : '#f59e0b',
        danger: isDark ? '#f87171' : '#ef4444',
        purple: isDark ? '#c084fc' : '#a855f7',
        text: isDark ? '#e5e7eb' : '#374151',
        grid: isDark ? '#374151' : '#e5e7eb'
    };
    
    // Update all charts
    [topContributorsChart, hotThreadsChart, weeklyActivityChart].forEach(chart => {
        chart.options.scales.y.ticks.color = newColors.text;
        chart.options.scales.y.grid.color = newColors.grid;
        chart.options.scales.x.ticks.color = newColors.text;
        chart.options.plugins.legend.labels.color = newColors.text;
        chart.update();
    });
}
</script>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>
