<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            <i class="fas fa-flag"></i> Content Reports
        </h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            Manage user-submitted content reports
        </p>
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="card">
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
                <div class="text-2xl font-bold text-yellow-600"><?php echo $counts['pending'] ?? 0; ?></div>
            </div>
        </div>
        <div class="card">
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">Resolved</div>
                <div class="text-2xl font-bold text-green-600"><?php echo $counts['resolved'] ?? 0; ?></div>
            </div>
        </div>
        <div class="card">
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">Dismissed</div>
                <div class="text-2xl font-bold text-gray-600"><?php echo $counts['dismissed'] ?? 0; ?></div>
            </div>
        </div>
        <div class="card">
            <div class="p-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
                <div class="text-2xl font-bold"><?php echo $counts['total'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="text-xl font-bold">Filters</h2>
        </div>
        <div class="p-4">
            <div class="flex flex-wrap gap-4">
                <a href="<?php echo url('/admin/reports?status=all'); ?>" 
                   class="btn <?php echo $status === 'all' ? 'btn-primary' : 'btn-secondary'; ?>">
                    All Reports
                </a>
                <a href="<?php echo url('/admin/reports?status=pending'); ?>" 
                   class="btn <?php echo $status === 'pending' ? 'btn-primary' : 'btn-secondary'; ?>">
                    Pending
                </a>
                <a href="<?php echo url('/admin/reports?status=resolved'); ?>" 
                   class="btn <?php echo $status === 'resolved' ? 'btn-primary' : 'btn-secondary'; ?>">
                    Resolved
                </a>
                <a href="<?php echo url('/admin/reports?status=dismissed'); ?>" 
                   class="btn <?php echo $status === 'dismissed' ? 'btn-primary' : 'btn-secondary'; ?>">
                    Dismissed
                </a>
            </div>
        </div>
    </div>
    
    <!-- Reports Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-bold">Reports</h2>
        </div>
        <div class="overflow-x-auto">
            <?php if (empty($reports)): ?>
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-flag text-4xl mb-3"></i>
                <p>No reports found</p>
            </div>
            <?php else: ?>
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Report</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($reports as $report): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium"><?php echo e($report['reporter_username']); ?></div>
                            <div class="text-xs text-gray-500"><?php echo timeAgo($report['created_at']); ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium">
                                <?php echo ucfirst($report['reported_type']); ?> #<?php echo $report['reported_id']; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm"><?php echo e($report['reason']); ?></div>
                            <?php if ($report['description']): ?>
                            <div class="text-xs text-gray-500 mt-1"><?php echo e(truncate($report['description'], 50)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if ($report['status'] === 'pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                            <?php elseif ($report['status'] === 'resolved'): ?>
                            <span class="badge badge-success">Resolved</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Dismissed</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="<?php echo url('/admin/reports/' . $report['id']); ?>" 
                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <?php if ($report['status'] === 'pending'): ?>
                            <form method="POST" action="<?php echo url('/admin/reports/' . $report['id'] . '/resolve'); ?>" 
                                  class="inline" onsubmit="return confirm('Are you sure you want to resolve this report?')">
                                <?php echo csrfField(); ?>
                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                    <i class="fas fa-check"></i> Resolve
                                </button>
                            </form>
                            <form method="POST" action="<?php echo url('/admin/reports/' . $report['id'] . '/dismiss'); ?>" 
                                  class="inline" onsubmit="return confirm('Are you sure you want to dismiss this report?')">
                                <?php echo csrfField(); ?>
                                <button type="submit" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300">
                                    <i class="fas fa-times"></i> Dismiss
                                </button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>