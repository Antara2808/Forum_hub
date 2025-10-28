<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        <i class="fas fa-chart-area text-blue-600"></i> Activity Overview
    </h2>
    <p class="text-gray-600 dark:text-gray-400">Comprehensive analytics and user engagement metrics</p>
</div>

<!-- Time Period Selector -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-4 mb-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center space-x-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Time Period:</label>
            <div class="flex space-x-2" role="group">
                <button onclick="updateCharts('7days')" class="period-btn active px-4 py-2 text-sm bg-blue-600 text-white rounded-lg">
                    Last 7 Days
                </button>
                <button onclick="updateCharts('30days')" class="period-btn px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    Last 30 Days
                </button>
                <button onclick="updateCharts('90days')" class="period-btn px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    Last 3 Months
                </button>
                <button onclick="updateCharts('year')" class="period-btn px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600">
                    This Year
                </button>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="exportData()" class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i> Export Data
            </button>
            <button onclick="refreshCharts()" class="px-4 py-2 text-sm bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-sync-alt mr-2"></i> Refresh
            </button>
        </div>
    </div>
</div>

<!-- Quick Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm mb-1">Total Engagement</p>
                <p class="text-3xl font-bold">12,458</p>
                <p class="text-xs text-blue-100 mt-2">
                    <i class="fas fa-arrow-up"></i> +12.5% from last week
                </p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-3xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm mb-1">Active Sessions</p>
                <p class="text-3xl font-bold">2,847</p>
                <p class="text-xs text-green-100 mt-2">
                    <i class="fas fa-arrow-up"></i> +8.3% from yesterday
                </p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm mb-1">Avg. Session Time</p>
                <p class="text-3xl font-bold">8m 42s</p>
                <p class="text-xs text-purple-100 mt-2">
                    <i class="fas fa-arrow-up"></i> +2.1 min increase
                </p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-3xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm mb-1">Bounce Rate</p>
                <p class="text-3xl font-bold">24.3%</p>
                <p class="text-xs text-amber-100 mt-2">
                    <i class="fas fa-arrow-down"></i> -5.2% improvement
                </p>
            </div>
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-pie text-3xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Main Charts Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- User Activity Timeline (Line Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-chart-line text-blue-600"></i> User Activity Timeline
            </h3>
            <select id="activityMetric" class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Active Users</option>
                <option>New Signups</option>
                <option>Page Views</option>
            </select>
        </div>
        <div class="h-80">
            <canvas id="activityTimelineChart"></canvas>
        </div>
    </div>
    
    <!-- Content Creation (Mixed Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-edit text-green-600"></i> Content Creation
            </h3>
            <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View Details</button>
        </div>
        <div class="h-80">
            <canvas id="contentCreationChart"></canvas>
        </div>
    </div>
    
</div>

<!-- Second Row Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- User Engagement (Doughnut Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-user-check text-purple-600"></i> User Engagement
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Activity distribution</p>
        </div>
        <div class="h-72">
            <canvas id="engagementChart"></canvas>
        </div>
    </div>
    
    <!-- Traffic Sources (Polar Area) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-globe text-blue-600"></i> Traffic Sources
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Where users come from</p>
        </div>
        <div class="h-72">
            <canvas id="trafficSourcesChart"></canvas>
        </div>
    </div>
    
    <!-- Device Usage (Bar Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-mobile-alt text-green-600"></i> Device Usage
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Platform breakdown</p>
        </div>
        <div class="h-72">
            <canvas id="deviceUsageChart"></canvas>
        </div>
    </div>
    
</div>

<!-- Heatmap & Radar Chart -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Peak Activity Hours (Bar Chart with Gradient) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-clock text-amber-600"></i> Peak Activity Hours
            </h3>
            <span class="text-sm text-gray-600 dark:text-gray-400">Last 7 days</span>
        </div>
        <div class="h-80">
            <canvas id="peakHoursChart"></canvas>
        </div>
    </div>
    
    <!-- Category Performance (Radar Chart) -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-tags text-red-600"></i> Category Performance
            </h3>
            <button class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Manage Categories</button>
        </div>
        <div class="h-80">
            <canvas id="categoryRadarChart"></canvas>
        </div>
    </div>
    
</div>

<!-- Real-time Activity Feed -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                <i class="fas fa-broadcast-tower text-blue-600"></i> Real-Time Activity Stream
            </h3>
            <div class="flex items-center space-x-2">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400">Live</span>
            </div>
        </div>
    </div>
    <div class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto" id="activityStream">
        <!-- Activity items will be dynamically inserted -->
        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors animate-fadeIn">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        <span class="font-bold">JohnDoe123</span> joined the platform
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-clock"></i> Just now
                    </p>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors animate-fadeIn">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-comments text-green-600 dark:text-green-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        <span class="font-bold">AliceSmith</span> created a new thread in <span class="text-blue-600 dark:text-blue-400">General Discussion</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-clock"></i> 2 minutes ago
                    </p>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors animate-fadeIn">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-comment text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        <span class="font-bold">BobMartin</span> replied to "Best PHP frameworks in 2025"
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-clock"></i> 5 minutes ago
                    </p>
                </div>
            </div>
        </div>
        
        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors animate-fadeIn">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-poll text-amber-600 dark:text-amber-400"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        <span class="font-bold">EmilyBrown</span> voted in poll "Favorite programming language"
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <i class="fas fa-clock"></i> 8 minutes ago
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}

.period-btn.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

<script>
// Theme-aware colors
const isDark = document.documentElement.classList.contains('dark');
const colors = {
    primary: isDark ? '#60a5fa' : '#3b82f6',
    success: isDark ? '#34d399' : '#10b981',
    warning: isDark ? '#fbbf24' : '#f59e0b',
    danger: isDark ? '#f87171' : '#ef4444',
    purple: isDark ? '#c084fc' : '#a855f7',
    indigo: isDark ? '#818cf8' : '#6366f1',
    pink: isDark ? '#f472b6' : '#ec4899',
    text: isDark ? '#e5e7eb' : '#374151',
    grid: isDark ? '#374151' : '#e5e7eb'
};

// 1. User Activity Timeline (Area Line Chart)
const activityCtx = document.getElementById('activityTimelineChart').getContext('2d');
const activityChart = new Chart(activityCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Active Users',
            data: [245, 312, 289, 378, 425, 398, 456],
            borderColor: colors.primary,
            backgroundColor: isDark ? 'rgba(96, 165, 250, 0.1)' : 'rgba(59, 130, 246, 0.1)',
            fill: true,
            tension: 0.4,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBackgroundColor: colors.primary
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: colors.text },
                grid: { color: colors.grid, drawBorder: false }
            },
            x: {
                ticks: { color: colors.text },
                grid: { display: false }
            }
        }
    }
});

// 2. Content Creation (Mixed Bar + Line Chart)
const contentCtx = document.getElementById('contentCreationChart').getContext('2d');
const contentChart = new Chart(contentCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            type: 'bar',
            label: 'Threads',
            data: [12, 19, 15, 25, 22, 30, 28],
            backgroundColor: colors.success,
            borderRadius: 8
        }, {
            type: 'bar',
            label: 'Posts',
            data: [45, 52, 48, 65, 71, 68, 72],
            backgroundColor: colors.purple,
            borderRadius: 8
        }, {
            type: 'line',
            label: 'Engagement Rate',
            data: [65, 70, 68, 75, 80, 78, 82],
            borderColor: colors.warning,
            backgroundColor: 'transparent',
            tension: 0.4,
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: colors.text, padding: 15 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: colors.text },
                grid: { color: colors.grid, drawBorder: false }
            },
            y1: {
                position: 'right',
                beginAtZero: true,
                ticks: { color: colors.text },
                grid: { display: false }
            },
            x: {
                ticks: { color: colors.text },
                grid: { display: false }
            }
        }
    }
});

// 3. User Engagement (Doughnut Chart)
const engagementCtx = document.getElementById('engagementChart').getContext('2d');
const engagementChart = new Chart(engagementCtx, {
    type: 'doughnut',
    data: {
        labels: ['Very Active', 'Active', 'Moderate', 'Passive'],
        datasets: [{
            data: [28, 35, 22, 15],
            backgroundColor: [colors.success, colors.primary, colors.warning, colors.danger],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { color: colors.text, padding: 15 }
            }
        }
    }
});

// 4. Traffic Sources (Polar Area Chart)
const trafficCtx = document.getElementById('trafficSourcesChart').getContext('2d');
const trafficChart = new Chart(trafficCtx, {
    type: 'polarArea',
    data: {
        labels: ['Direct', 'Search', 'Social', 'Referral', 'Email'],
        datasets: [{
            data: [35, 28, 22, 10, 5],
            backgroundColor: [
                colors.primary,
                colors.success,
                colors.purple,
                colors.warning,
                colors.pink
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
                labels: { color: colors.text, padding: 10 }
            }
        },
        scales: {
            r: {
                ticks: { color: colors.text, backdropColor: 'transparent' },
                grid: { color: colors.grid }
            }
        }
    }
});

// 5. Device Usage (Horizontal Bar Chart)
const deviceCtx = document.getElementById('deviceUsageChart').getContext('2d');
const deviceChart = new Chart(deviceCtx, {
    type: 'bar',
    data: {
        labels: ['Desktop', 'Mobile', 'Tablet'],
        datasets: [{
            label: 'Users',
            data: [4250, 5830, 1420],
            backgroundColor: [colors.primary, colors.success, colors.purple],
            borderRadius: 8,
            barThickness: 40
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { color: colors.text },
                grid: { color: colors.grid, drawBorder: false }
            },
            y: {
                ticks: { color: colors.text },
                grid: { display: false }
            }
        }
    }
});

// 6. Peak Activity Hours (Gradient Bar Chart)
const peakCtx = document.getElementById('peakHoursChart').getContext('2d');
const gradient = peakCtx.createLinearGradient(0, 0, 0, 400);
gradient.addColorStop(0, colors.primary);
gradient.addColorStop(1, colors.purple);

const peakChart = new Chart(peakCtx, {
    type: 'bar',
    data: {
        labels: ['12AM', '4AM', '8AM', '12PM', '4PM', '8PM'],
        datasets: [{
            label: 'Active Users',
            data: [120, 85, 245, 380, 520, 445],
            backgroundColor: gradient,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: colors.text },
                grid: { color: colors.grid, drawBorder: false }
            },
            x: {
                ticks: { color: colors.text },
                grid: { display: false }
            }
        }
    }
});

// 7. Category Performance (Radar Chart)
const radarCtx = document.getElementById('categoryRadarChart').getContext('2d');
const radarChart = new Chart(radarCtx, {
    type: 'radar',
    data: {
        labels: ['General', 'Tech', 'Gaming', 'News', 'Entertainment', 'Education'],
        datasets: [{
            label: 'Activity Score',
            data: [85, 92, 78, 65, 88, 75],
            borderColor: colors.primary,
            backgroundColor: isDark ? 'rgba(96, 165, 250, 0.2)' : 'rgba(59, 130, 246, 0.2)',
            pointBackgroundColor: colors.primary,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            r: {
                angleLines: { color: colors.grid },
                grid: { color: colors.grid },
                pointLabels: { color: colors.text },
                ticks: { color: colors.text, backdropColor: 'transparent' }
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
    [activityChart, contentChart, engagementChart, trafficChart, deviceChart, peakChart, radarChart].forEach(chart => {
        if (chart.options.scales?.y) {
            chart.options.scales.y.ticks.color = newColors.text;
            chart.options.scales.y.grid.color = newColors.grid;
        }
        if (chart.options.scales?.x) {
            chart.options.scales.x.ticks.color = newColors.text;
        }
        if (chart.options.plugins?.legend?.labels) {
            chart.options.plugins.legend.labels.color = newColors.text;
        }
        chart.update();
    });
}

// Period button toggle
function updateCharts(period) {
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    });
    event.target.classList.add('active', 'bg-blue-600', 'text-white');
    event.target.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    
    Toast.info(`Showing data for: ${period.replace(/(\d+)/, '$1 ')}`);
}

// Refresh charts
function refreshCharts() {
    Toast.success('Charts refreshed successfully!');
    // In production, fetch new data from API
}

// Export data
function exportData() {
    Toast.success('Exporting data as CSV...');
    // In production, generate and download CSV file
}

// Simulate real-time activity updates
setInterval(() => {
    const activities = [
        { icon: 'fa-user-plus', color: 'blue', text: 'New user registered' },
        { icon: 'fa-comments', color: 'green', text: 'New thread created' },
        { icon: 'fa-comment', color: 'purple', text: 'New reply posted' },
        { icon: 'fa-poll', color: 'amber', text: 'Poll vote submitted' }
    ];
    
    const activity = activities[Math.floor(Math.random() * activities.length)];
    const stream = document.getElementById('activityStream');
    
    const item = document.createElement('div');
    item.className = 'px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors animate-fadeIn';
    item.innerHTML = `
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0 w-10 h-10 bg-${activity.color}-100 dark:bg-${activity.color}-900/30 rounded-full flex items-center justify-center">
                <i class="fas ${activity.icon} text-${activity.color}-600 dark:text-${activity.color}-400"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white">${activity.text}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    <i class="fas fa-clock"></i> Just now
                </p>
            </div>
        </div>
    `;
    
    stream.insertBefore(item, stream.firstChild);
    
    // Keep only last 10 items
    if (stream.children.length > 10) {
        stream.removeChild(stream.lastChild);
    }
}, 5000); // New activity every 5 seconds
</script>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>
