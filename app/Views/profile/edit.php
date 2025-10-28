<?php require_once APP_PATH . '/Views/layouts/header.php'; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="card">
        <div class="card-header">
            <h1 class="text-2xl font-bold">
                <i class="fas fa-user-edit"></i> Edit Profile
            </h1>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo url('/profile/' . $user['id'] . '/edit'); ?>" 
                  enctype="multipart/form-data" class="space-y-6">
                <?php echo csrfField(); ?>
                
                <!-- Avatar Upload -->
                <div>
                    <label class="form-label">Profile Picture</label>
                    <div class="flex items-center gap-4">
                        <img id="avatar-preview" 
                             src="<?php echo $user['avatar'] ? upload('avatars/' . $user['avatar']) : asset('images/default-avatar.svg'); ?>" 
                             alt="Avatar" class="w-24 h-24 rounded-full border-2 border-gray-300 dark:border-[#38444D]">
                        <div class="flex-1">
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                   onchange="previewImage(this, 'avatar-preview')"
                                   class="form-input">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Max 5MB. JPG, PNG, GIF, WebP</p>
                            <?php if ($user['avatar']): ?>
                            <button type="button" onclick="removeAvatar()" 
                                    class="mt-2 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                <i class="fas fa-trash"></i> Remove Profile Picture
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Banner Upload -->
                <div>
                    <label class="form-label">Profile Banner</label>
                    <div class="mb-2">
                        <div id="banner-preview" class="h-32 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600"
                             style="<?php echo $user['banner'] ? 'background-image: url(' . upload('banners/' . $user['banner']) . '); background-size: cover; background-position: center;' : ''; ?>">
                        </div>
                    </div>
                    <input type="file" id="banner" name="banner" accept="image/*"
                           onchange="previewBanner(this)"
                           class="form-input">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Max 5MB. Recommended: 1500x500px</p>
                    <?php if ($user['banner']): ?>
                    <button type="button" onclick="removeBanner()" 
                            class="mt-2 text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <i class="fas fa-trash"></i> Remove Banner
                    </button>
                    <?php endif; ?>
                </div>
                
                <!-- Bio -->
                <div>
                    <label for="bio" class="form-label">Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                              class="form-input"
                              placeholder="Tell us about yourself..."><?php echo e($user['bio'] ?? ''); ?></textarea>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Max 500 characters</p>
                </div>
                
                <!-- Customization Options -->
                <div class="card bg-gray-50 dark:bg-gray-800 border-0">
                    <div class="card-header bg-transparent">
                        <h3 class="font-bold text-lg">
                            <i class="fas fa-palette"></i> Profile Customization
                        </h3>
                    </div>
                    <div class="card-body space-y-6">
                        <!-- Profile Color Theme -->
                        <div>
                            <label class="form-label">Profile Color Theme</label>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="profile_theme" value="default" 
                                           <?php echo ($user['profile_theme'] ?? 'default') === 'default' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span>Default</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="profile_theme" value="blue" 
                                           <?php echo ($user['profile_theme'] ?? 'default') === 'blue' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span class="text-blue-500">Blue</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="profile_theme" value="green" 
                                           <?php echo ($user['profile_theme'] ?? 'default') === 'green' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span class="text-green-500">Green</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="profile_theme" value="purple" 
                                           <?php echo ($user['profile_theme'] ?? 'default') === 'purple' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span class="text-purple-500">Purple</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Banner Style -->
                        <div>
                            <label class="form-label">Banner Style</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="banner_style" value="gradient" 
                                           <?php echo ($user['banner_style'] ?? 'gradient') === 'gradient' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span>Gradient</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="banner_style" value="solid" 
                                           <?php echo ($user['banner_style'] ?? 'gradient') === 'solid' ? 'checked' : ''; ?>
                                           class="w-4 h-4">
                                    <span>Solid Color</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-3 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <input type="radio" name="banner_style" value="image" 
                                           <?php echo ($user['banner_style'] ?? 'gradient') === 'image' ? 'checked' : ''; ?>
                                           class="w-4 h-4" <?php echo !$user['banner'] ? 'disabled' : ''; ?>>
                                    <span>Uploaded Image</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Location -->
                <div>
                    <label for="location" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Location
                    </label>
                    <input type="text" id="location" name="location"
                           value="<?php echo e($user['location'] ?? ''); ?>"
                           class="form-input"
                           placeholder="e.g. San Francisco, CA">
                </div>
                
                <!-- Website -->
                <div>
                    <label for="website" class="form-label">
                        <i class="fas fa-globe"></i> Website
                    </label>
                    <input type="url" id="website" name="website"
                           value="<?php echo e($user['website'] ?? ''); ?>"
                           class="form-input"
                           placeholder="https://yourwebsite.com">
                </div>
                
                <!-- Social Links -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="twitter" class="form-label">
                            <i class="fab fa-twitter"></i> Twitter Username
                        </label>
                        <input type="text" id="twitter" name="twitter"
                               value="<?php echo e($user['twitter'] ?? ''); ?>"
                               class="form-input"
                               placeholder="username (without @)">
                    </div>
                    
                    <div>
                        <label for="github" class="form-label">
                            <i class="fab fa-github"></i> GitHub Username
                        </label>
                        <input type="text" id="github" name="github"
                               value="<?php echo e($user['github'] ?? ''); ?>"
                               class="form-input"
                               placeholder="username">
                    </div>
                    
                    <div>
                        <label for="linkedin" class="form-label">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </label>
                        <input type="text" id="linkedin" name="linkedin"
                               value="<?php echo e($user['linkedin'] ?? ''); ?>"
                               class="form-input"
                               placeholder="username">
                    </div>
                    
                    <div>
                        <label for="instagram" class="form-label">
                            <i class="fab fa-instagram"></i> Instagram
                        </label>
                        <input type="text" id="instagram" name="instagram"
                               value="<?php echo e($user['instagram'] ?? ''); ?>"
                               class="form-input"
                               placeholder="username">
                    </div>
                </div>
                
                <!-- Privacy Settings -->
                <div class="card bg-gray-50 dark:bg-gray-800 border-0">
                    <div class="card-header bg-transparent">
                        <h3 class="font-bold text-lg">
                            <i class="fas fa-lock"></i> Privacy Settings
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium">Show Email</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Allow others to see your email address</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_email" <?php echo ($user['show_email'] ?? 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium">Show Online Status</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Display when you're online</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_online" <?php echo ($user['show_online'] ?? 1) ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium">Profile Visibility</label>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Who can view your profile</p>
                            </div>
                            <select name="profile_visibility" class="form-input w-auto">
                                <option value="public" <?php echo ($user['profile_visibility'] ?? 'public') === 'public' ? 'selected' : ''; ?>>Public</option>
                                <option value="friends" <?php echo ($user['profile_visibility'] ?? 'public') === 'friends' ? 'selected' : ''; ?>>Friends Only</option>
                                <option value="private" <?php echo ($user['profile_visibility'] ?? 'public') === 'private' ? 'selected' : ''; ?>>Private</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo url('/profile/' . $user['id']); ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Switch Toggle */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
</style>

<script>
// Preview avatar image
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Preview banner image
function previewBanner(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('banner-preview').style.backgroundImage = `url(${e.target.result})`;
            document.getElementById('banner-preview').style.backgroundSize = 'cover';
            document.getElementById('banner-preview').style.backgroundPosition = 'center';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove avatar
async function removeAvatar() {
    const confirmed = await showConfirm({
        icon: '🖼️',
        title: 'Remove Profile Picture',
        message: 'Are you sure you want to remove your profile picture?',
        confirmText: 'Remove',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) return;
    
    fetch('<?php echo url('/profile/' . $user['id'] . '/remove-avatar'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'csrf_token=' + encodeURIComponent(document.querySelector('input[name="csrf_token"]').value)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('avatar-preview').src = '<?php echo asset('images/default-avatar.svg'); ?>';
            Toast.success('Profile picture removed successfully!');
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error('Error: ' + data.message);
        }
    })
    .catch(error => {
        Toast.error('Error removing profile picture');
        console.error(error);
    });
}

// Remove banner
async function removeBanner() {
    const confirmed = await showConfirm({
        icon: '🖼️',
        title: 'Remove Banner',
        message: 'Are you sure you want to remove your banner?',
        confirmText: 'Remove',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) return;
    
    fetch('<?php echo url('/profile/' . $user['id'] . '/remove-banner'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'csrf_token=' + encodeURIComponent(document.querySelector('input[name="csrf_token"]').value)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const banner = document.getElementById('banner-preview');
            banner.style.backgroundImage = '';
            banner.className = 'h-32 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600';
            Toast.success('Banner removed successfully!');
            setTimeout(() => location.reload(), 1500);
        } else {
            Toast.error('Error: ' + data.message);
        }
    })
    .catch(error => {
        Toast.error('Error removing banner');
        console.error(error);
    });
}
</script>

<?php require_once APP_PATH . '/Views/layouts/footer.php'; ?>
