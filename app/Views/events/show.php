<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Event Header -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold mb-2"><?php echo e($event['title']); ?></h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Organized by <a href="<?php echo url('/profile/' . $event['user_id']); ?>" class="text-blue-600 hover:underline">
                            <?php echo e($event['username']); ?>
                        </a>
                    </p>
                </div>
                <?php if ($event['is_online']): ?>
                <span class="badge badge-success badge-lg">
                    <i class="fas fa-wifi"></i> Online Event
                </span>
                <?php else: ?>
                <span class="badge badge-primary badge-lg">
                    <i class="fas fa-map-marker-alt"></i> In-Person
                </span>
                <?php endif; ?>
            </div>
            
            <?php if ($event['description']): ?>
            <div class="prose dark:prose-invert max-w-none mb-6">
                <?php echo nl2br(e($event['description'])); ?>
            </div>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar text-2xl text-blue-600"></i>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Date</div>
                        <div class="font-bold"><?php echo formatDate($event['event_date'], 'F j, Y'); ?></div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clock text-2xl text-green-600"></i>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Time</div>
                        <div class="font-bold"><?php echo formatDate($event['event_date'], 'g:i A'); ?></div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users text-2xl text-purple-600"></i>
                    <div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Participants</div>
                        <div class="font-bold"><?php echo $event['participant_count']; ?> going</div>
                    </div>
                </div>
            </div>
            
            <?php if ($event['location']): ?>
            <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                    <span class="font-medium">Location:</span>
                    <span><?php echo e($event['location']); ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Participants -->
    <div class="card">
        <div class="card-header">
            <h2 class="text-xl font-bold">
                <i class="fas fa-users"></i> Participants (<?php echo count($participants); ?>)
            </h2>
        </div>
        <div class="card-body">
            <?php if (empty($participants)): ?>
            <p class="text-center text-gray-500 py-8">No participants yet. Be the first to join!</p>
            <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach ($participants as $participant): ?>
                <a href="<?php echo url('/profile/' . $participant['user_id']); ?>" 
                   class="flex items-center space-x-2 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <img src="<?php echo $participant['avatar'] ? upload('avatars/' . $participant['avatar']) : asset('images/default-avatar.svg'); ?>" 
                         alt="Avatar" class="w-10 h-10 rounded-full">
                    <div class="flex-1 min-w-0">
                        <div class="font-medium truncate"><?php echo e($participant['username']); ?></div>
                        <div class="text-xs text-gray-500"><?php echo $participant['reputation']; ?> pts</div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
