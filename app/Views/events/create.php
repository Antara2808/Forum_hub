<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">
                <i class="fas fa-calendar-plus"></i> Create New Event
            </h1>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo url('/events/store'); ?>">
                <?php echo csrfField(); ?>
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="form-label">Event Title *</label>
                        <input type="text" id="title" name="title" required
                               class="form-input"
                               placeholder="e.g., Community Meetup 2025">
                    </div>
                    
                    <div>
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="5"
                                  class="form-input"
                                  placeholder="Describe your event..."></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="event_date" class="form-label">Event Date & Time *</label>
                            <input type="datetime-local" id="event_date" name="event_date" required
                                   class="form-input">
                        </div>
                        
                        <div>
                            <label for="location" class="form-label">Location</label>
                            <input type="text" id="location" name="location"
                                   class="form-input"
                                   placeholder="e.g., Conference Room A">
                        </div>
                    </div>
                    
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_online" value="1" class="rounded">
                            <span><i class="fas fa-wifi"></i> This is an online event</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo url('/events'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-check"></i> Create Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
