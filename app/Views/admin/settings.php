<?php require_once APP_PATH . '/Views/layouts/admin_header.php'; ?>

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        <i class="fas fa-cog text-blue-600"></i> Site Settings
    </h2>
    <p class="text-gray-600 dark:text-gray-400">Configure your ForumHub Pro platform</p>
</div>

<form action="<?php echo url('/admin/settings/update'); ?>" method="POST" enctype="multipart/form-data">
    
    <div class="space-y-6">
        
        <!-- General Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-globe text-blue-600"></i> General Settings
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Site Title
                        </label>
                        <input type="text" name="site_title" value="<?php echo e($settings['site_title'] ?? 'ForumHub Pro'); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Site Tagline
                        </label>
                        <input type="text" name="site_tagline" value="<?php echo e($settings['site_tagline'] ?? 'Connect, Discuss, Grow'); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Site Description
                    </label>
                    <textarea name="site_description" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"><?php echo e($settings['site_description'] ?? 'The future of online communities'); ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contact Email
                        </label>
                        <input type="email" name="contact_email" value="<?php echo e($settings['contact_email'] ?? 'admin@forumhub.com'); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Default Theme
                        </label>
                        <select name="default_theme"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <option value="light" <?php echo ($settings['default_theme'] ?? 'dark') === 'light' ? 'selected' : ''; ?>>Light</option>
                            <option value="dark" <?php echo ($settings['default_theme'] ?? 'dark') === 'dark' ? 'selected' : ''; ?>>Dark</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Email Settings (SMTP) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-envelope text-purple-600"></i> Email Settings (SMTP)
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SMTP Host
                        </label>
                        <input type="text" name="smtp_host" value="<?php echo e($settings['smtp_host'] ?? 'smtp.gmail.com'); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SMTP Port
                        </label>
                        <input type="number" name="smtp_port" value="<?php echo e($settings['smtp_port'] ?? '587'); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SMTP Username
                        </label>
                        <input type="text" name="smtp_username" value="<?php echo e($settings['smtp_username'] ?? ''); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SMTP Password
                        </label>
                        <input type="password" name="smtp_password" value="<?php echo e($settings['smtp_password'] ?? ''); ?>"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        SMTP Encryption
                    </label>
                    <select name="smtp_encryption"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="tls" <?php echo ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : ''; ?>>TLS</option>
                        <option value="ssl" <?php echo ($settings['smtp_encryption'] ?? 'tls') === 'ssl' ? 'selected' : ''; ?>>SSL</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Forum Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-comments text-green-600"></i> Forum Settings
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Posts Per Page
                        </label>
                        <input type="number" name="posts_per_page" value="<?php echo e($settings['posts_per_page'] ?? '20'); ?>" min="10" max="100"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Threads Per Page
                        </label>
                        <input type="number" name="threads_per_page" value="<?php echo e($settings['threads_per_page'] ?? '15'); ?>" min="10" max="50"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Max Upload Size (MB)
                        </label>
                        <input type="number" name="max_upload_size" value="<?php echo e($settings['max_upload_size'] ?? '5'); ?>" min="1" max="20"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="space-y-3">
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="allow_registration" value="1" <?php echo ($settings['allow_registration'] ?? true) ? 'checked' : ''; ?>
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Allow User Registration</span>
                    </label>
                    
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="require_email_verification" value="1" <?php echo ($settings['require_email_verification'] ?? false) ? 'checked' : ''; ?>
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Require Email Verification</span>
                    </label>
                    
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="enable_reputation" value="1" <?php echo ($settings['enable_reputation'] ?? true) ? 'checked' : ''; ?>
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Enable Reputation System</span>
                    </label>
                    
                    <label class="flex items-center space-x-3">
                        <input type="checkbox" name="enable_polls" value="1" <?php echo ($settings['enable_polls'] ?? true) ? 'checked' : ''; ?>
                               class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Enable Polls</span>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Logo & Branding -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-image text-amber-600"></i> Logo & Branding
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Site Logo
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <?php if (!empty($settings['logo'])): ?>
                            <img src="<?php echo upload($settings['logo']); ?>" alt="Logo" class="h-16 w-16 object-contain border border-gray-300 dark:border-gray-600 rounded-lg p-2">
                            <?php else: ?>
                            <div class="h-16 w-16 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-2xl text-gray-400"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="logo" accept="image/*"
                               class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended: PNG or SVG, max 2MB</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Favicon
                    </label>
                    <input type="file" name="favicon" accept="image/x-icon,image/png"
                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Recommended: 32x32 or 64x64 pixels</p>
                </div>
            </div>
        </div>
        
        <!-- Save Button -->
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="resetSettings()" 
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold transition-all duration-300">
                <i class="fas fa-undo mr-2"></i> Reset
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg">
                <i class="fas fa-save mr-2"></i> Save Settings
            </button>
        </div>
    </div>
</form>

<script>
function resetSettings() {
    if (confirm('Are you sure you want to reset to default settings?')) {
        location.reload();
    }
}
</script>

<?php require_once APP_PATH . '/Views/layouts/admin_footer.php'; ?>
