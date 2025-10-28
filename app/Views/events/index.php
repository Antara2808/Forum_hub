<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                <i class="fas fa-calendar"></i> Events Calendar
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Upcoming community events</p>
        </div>
        <?php if (isLoggedIn()): ?>
        <a href="<?php echo url('/events/create'); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Event
        </a>
        <?php endif; ?>
    </div>
    
    <?php if (empty($events)): ?>
    <div class="card">
        <div class="card-body text-center py-12">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 dark:text-gray-400 text-lg">No upcoming events</p>
            <?php if (isLoggedIn()): ?>
            <a href="<?php echo url('/events/create'); ?>" class="btn btn-primary mt-4">
                Create First Event
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($events as $event): ?>
        <div class="card hover:shadow-xl transition-shadow">
            <div class="card-body">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-2">
                            <a href="<?php echo url('/events/' . $event['id']); ?>" class="hover:text-blue-600">
                                <?php echo e($event['title']); ?>
                            </a>
                        </h3>
                    </div>
                    <?php if ($event['is_online']): ?>
                    <span class="badge badge-success">
                        <i class="fas fa-wifi"></i> Online
                    </span>
                    <?php else: ?>
                    <span class="badge badge-primary">
                        <i class="fas fa-map-marker-alt"></i> In-Person
                    </span>
                    <?php endif; ?>
                </div>
                
                <?php if ($event['description']): ?>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    <?php echo truncate(e($event['description']), 150); ?>
                </p>
                <?php endif; ?>
                
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-calendar w-5"></i>
                        <span><?php echo formatDate($event['event_date'], 'F j, Y'); ?></span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock w-5"></i>
                        <span><?php echo formatDate($event['event_date'], 'g:i A'); ?></span>
                    </div>
                    <?php if ($event['location']): ?>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt w-5"></i>
                        <span><?php echo e($event['location']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center">
                        <i class="fas fa-user w-5"></i>
                        <span>By <?php echo e($event['username']); ?></span>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-users"></i> <?php echo $event['participant_count']; ?> going
                    </span>
                    <a href="<?php echo url('/events/' . $event['id']); ?>" class="btn btn-sm btn-primary">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
