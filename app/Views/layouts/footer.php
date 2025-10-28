</main>

<!-- Footer -->
<footer class="bg-white dark:bg-[#15202B] border-t border-gray-200 dark:border-[#38444D] mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-[#E7E9EA]">ForumHub Pro</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    The future of online communities. Connect, Discuss, Grow.
                </p>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-[#E7E9EA]">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo url('/threads'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]">Threads</a></li>
                    <li><a href="<?php echo url('/events'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]">Events</a></li>
                    <li><a href="<?php echo url('/search'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]">Search</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-[#E7E9EA]">Community</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo url('/community/guidelines'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0] transition-colors duration-300">Guidelines</a></li>
                    <li><a href="<?php echo url('/community/help'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0] transition-colors duration-300">Help Center</a></li>
                    <li><a href="<?php echo url('/community/contact'); ?>" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0] transition-colors duration-300">Contact</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="font-bold text-lg mb-4 text-gray-900 dark:text-[#E7E9EA]">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-2xl text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-2xl text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-2xl text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-[#1D9BF0]"><i class="fab fa-discord"></i></a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 text-center text-gray-600 dark:text-gray-400">
            <p>&copy; 2025 ForumHub Pro. All rights reserved. Version <?php echo APP_VERSION; ?></p>
        </div>
    </div>
</footer>

<!-- Alpine.js for dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Custom Scripts -->
<script src="<?php echo asset('js/app.js'); ?>"></script>

<script>
// Theme Toggle
function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    const theme = isDark ? 'dark' : 'light';
    localStorage.setItem('theme', theme);
    
    // Update user preference via AJAX
    <?php if (isset($_SESSION['user_id'])): ?>
    fetch('<?php echo url('/api/update-theme'); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ theme: theme })
    });
    <?php endif; ?>
}

// Check unread messages
<?php if (isset($_SESSION['user_id'])): ?>
function checkUnreadMessages() {
    fetch('<?php echo url('/messages/unread'); ?>')
        .then(res => res.json())
        .then(data => {
            const badge = document.querySelector('.unread-count');
            if (badge && data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'flex';
            } else if (badge) {
                badge.style.display = 'none';
            }
        });
}

// Search and add friend functionality
async function searchAndAddFriend(event) {
    event.preventDefault();
    const input = document.getElementById('friend-search-input');
    const resultsDiv = document.getElementById('friend-search-results');
    const username = input.value.trim();
    
    if (!username) {
        Toast.warning('Please enter a username');
        return;
    }
    
    try {
        // Search for user
        const response = await fetch(`<?php echo url('/api/search-users'); ?>?q=${encodeURIComponent(username)}`);
        const data = await response.json();
        
        if (data.users && data.users.length > 0) {
            resultsDiv.innerHTML = data.users.map(user => `
                <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <img src="${user.avatar ? '<?php echo BASE_URL; ?>/public/uploads/avatars/' + user.avatar : '<?php echo BASE_URL; ?>/public/assets/images/default-avatar.svg'}" 
                             class="w-8 h-8 rounded-full" alt="${user.username}">
                        <div>
                            <div class="font-semibold text-sm text-gray-900 dark:text-white">${user.username}</div>
                            <div class="text-xs text-gray-500">${user.reputation} points</div>
                        </div>
                    </div>
                    <button onclick="sendFriendRequestFromSearch(${user.id}, '${user.username}')" 
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded-lg transition-all">
                        <i class="fas fa-user-plus mr-1"></i>Add
                    </button>
                </div>
            `).join('');
        } else {
            resultsDiv.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">No users found</p>';
        }
    } catch (error) {
        Toast.error('Failed to search users');
    }
}

async function sendFriendRequestFromSearch(friendId, username) {
    try {
        const response = await fetch('<?php echo url('/friends/send'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `friend_id=${friendId}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            Toast.success(`Friend request sent to ${username}!`);
            document.getElementById('friend-search-input').value = '';
            document.getElementById('friend-search-results').innerHTML = '';
        } else {
            Toast.error(data.message);
        }
    } catch (error) {
        Toast.error('Failed to send friend request');
    }
}

// Check every 30 seconds
setInterval(checkUnreadMessages, 30000);
checkUnreadMessages();
<?php endif; ?>
</script>

</body>
</html>
