<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            <i class="fas fa-poll text-amber-600"></i> Manage Polls
        </h2>
        <p class="text-gray-600 dark:text-gray-400">Create and manage community polls</p>
    </div>
    <button onclick="showCreatePollModal()" 
            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg">
        <i class="fas fa-plus mr-2"></i> Create Poll
    </button>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Polls</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_polls'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-poll-h text-4xl text-blue-600 dark:text-blue-400"></i>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Active Polls</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['active_polls'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-check-circle text-4xl text-green-600 dark:text-green-400"></i>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Votes</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['total_votes'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-users-vote text-4xl text-purple-600 dark:text-purple-400"></i>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Avg. Participation</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">
                    <?php echo number_format($stats['avg_votes'] ?? 0); ?>
                </p>
            </div>
            <i class="fas fa-chart-line text-4xl text-amber-600 dark:text-amber-400"></i>
        </div>
    </div>
</div>

<!-- Polls List -->
<div class="space-y-6">
    <?php foreach ($polls ?? [] as $poll): ?>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <!-- Poll Header -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                        <?php echo e($poll['question']); ?>
                    </h3>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span><i class="fas fa-user"></i> <?php echo e($poll['creator_name']); ?></span>
                        <span><i class="fas fa-clock"></i> <?php echo timeAgo($poll['created_at']); ?></span>
                        <span><i class="fas fa-vote-yea"></i> <?php echo number_format($poll['total_votes']); ?> votes</span>
                        <?php if ($poll['is_active']): ?>
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 rounded-full text-xs font-semibold">
                            <i class="fas fa-circle text-xs"></i> Active
                        </span>
                        <?php else: ?>
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 rounded-full text-xs font-semibold">
                            <i class="fas fa-circle text-xs"></i> Closed
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="togglePollStatus(<?php echo $poll['id']; ?>, <?php echo $poll['is_active'] ? 'true' : 'false'; ?>)" 
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400" 
                            title="<?php echo $poll['is_active'] ? 'Close Poll' : 'Activate Poll'; ?>">
                        <i class="fas fa-<?php echo $poll['is_active'] ? 'pause' : 'play'; ?>"></i>
                    </button>
                    <button onclick="deletePoll(<?php echo $poll['id']; ?>)" 
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400" 
                            title="Delete Poll">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <!-- Poll Options -->
            <div class="space-y-3">
                <?php 
                $totalVotes = $poll['total_votes'] > 0 ? $poll['total_votes'] : 1;
                foreach ($poll['options'] as $option): 
                    $percentage = ($option['votes'] / $totalVotes) * 100;
                ?>
                <div class="relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            <?php echo e($option['option_text']); ?>
                        </span>
                        <div class="flex items-center space-x-2 text-sm">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                <?php echo number_format($option['votes']); ?> votes
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">
                                (<?php echo number_format($percentage, 1); ?>%)
                            </span>
                        </div>
                    </div>
                    <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-500" 
                             style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Create Poll Modal -->
<div id="createPollModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="hideCreatePollModal()"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full p-8 z-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-poll text-blue-600"></i> Create New Poll
                </h3>
                <button onclick="hideCreatePollModal()" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <form action="<?php echo url('/admin/polls/create'); ?>" method="POST" id="createPollForm">
                <div class="space-y-4">
                    <!-- Question -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Poll Question <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="question" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                               placeholder="What's your favorite programming language?">
                    </div>
                    
                    <!-- Options -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Poll Options <span class="text-red-600">*</span>
                        </label>
                        <div id="pollOptions" class="space-y-2">
                            <input type="text" name="options[]" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   placeholder="Option 1">
                            <input type="text" name="options[]" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                   placeholder="Option 2">
                        </div>
                        <button type="button" onclick="addPollOption()" 
                                class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                            <i class="fas fa-plus"></i> Add Another Option
                        </button>
                    </div>
                    
                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Poll Duration (days)
                        </label>
                        <select name="duration" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="7">7 days</option>
                            <option value="14">14 days</option>
                            <option value="30" selected>30 days</option>
                            <option value="0">No expiration</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-check mr-2"></i> Create Poll
                    </button>
                    <button type="button" onclick="hideCreatePollModal()" 
                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show/Hide Modal
function showCreatePollModal() {
    document.getElementById('createPollModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideCreatePollModal() {
    document.getElementById('createPollModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Add Poll Option
function addPollOption() {
    const container = document.getElementById('pollOptions');
    const optionCount = container.children.length + 1;
    
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'options[]';
    input.required = true;
    input.placeholder = `Option ${optionCount}`;
    input.className = 'w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500';
    
    container.appendChild(input);
}

// Toggle Poll Status
async function togglePollStatus(pollId, isActive) {
    const action = isActive ? 'close' : 'activate';
    const confirmed = await showConfirm({
        icon: isActive ? '⏸️' : '▶️',
        title: `${isActive ? 'Close' : 'Activate'} Poll`,
        message: `Are you sure you want to ${action} this poll?`,
        confirmText: action.charAt(0).toUpperCase() + action.slice(1)
    });
    
    if (!confirmed) return;
    
    fetch(`<?php echo url('/admin/polls/'); ?>${pollId}/toggle`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Toast.success(`Poll ${action}d successfully!`);
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message || 'Action failed');
        }
    });
}

// Delete Poll
async function deletePoll(pollId) {
    const confirmed = await showConfirm({
        icon: '🗑️',
        title: 'Delete Poll',
        message: 'Are you sure you want to delete this poll? All votes will be lost!',
        confirmText: 'Delete'
    });
    
    if (!confirmed) return;
    
    fetch(`<?php echo url('/admin/polls/'); ?>${pollId}/delete`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Toast.success('Poll deleted successfully!');
            setTimeout(() => location.reload(), 1000);
        } else {
            Toast.error(data.message || 'Delete failed');
        }
    });
}
</script>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>
