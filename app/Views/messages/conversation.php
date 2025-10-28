<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="card">
        <!-- Chat Header -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="<?php echo url('/messages'); ?>" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <img src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                     alt="Avatar" class="w-10 h-10 rounded-full">
                <div>
                    <h2 class="font-bold"><?php echo e($user['username']); ?></h2>
                    <p class="text-xs text-gray-500">
                        <?php echo $user['is_online'] ? '<i class="fas fa-circle text-green-500"></i> Online' : 'Offline'; ?>
                    </p>
                </div>
            </div>
            <a href="<?php echo url('/profile/' . $user['id']); ?>" class="btn btn-sm btn-secondary">
                View Profile
            </a>
        </div>
        
        <!-- Messages Area -->
        <div class="p-4 h-96 overflow-y-auto bg-gray-50 dark:bg-gray-900" id="messagesArea">
            <?php if (empty($messages)): ?>
            <p class="text-center text-gray-500 py-12">No messages yet. Start the conversation!</p>
            <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($messages as $message): ?>
                <?php if ($message['sender_id'] == userId()): ?>
                <!-- Sent Message -->
                <div class="flex justify-end">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-blue-600 text-white rounded-lg rounded-tr-none p-3">
                            <?php echo nl2br(e($message['message'])); ?>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-right">
                            <?php echo timeAgo($message['created_at']); ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <!-- Received Message -->
                <div class="flex justify-start">
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg rounded-tl-none p-3">
                            <?php echo nl2br(e($message['message'])); ?>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            <?php echo timeAgo($message['created_at']); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Message Input -->
        <form method="POST" action="<?php echo url('/messages/send'); ?>" class="p-4 border-t border-gray-200 dark:border-gray-700">
            <?php echo csrfField(); ?>
            <input type="hidden" name="receiver_id" value="<?php echo $user['id']; ?>">
            
            <div class="flex space-x-3">
                <textarea name="message" rows="2" required
                          class="form-input flex-1"
                          placeholder="Type your message..."></textarea>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-scroll to bottom of messages
const messagesArea = document.getElementById('messagesArea');
if (messagesArea) {
    messagesArea.scrollTop = messagesArea.scrollHeight;
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
