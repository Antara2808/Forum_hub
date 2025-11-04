/**
 * Thread Interactions JavaScript
 * Handles likes, shares, and notifications
 */

// Toggle Thread Like
function toggleThreadLike(threadId) {
    console.log('toggleThreadLike called with threadId:', threadId);
    
    fetch('/api/threads/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `thread_id=${threadId}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('Like response:', data);
        if (data.success) {
            // Update like buttons in both locations
            const likeBtnMain = document.getElementById(`like-btn-${threadId}-main`);
            const likeCountMain = document.getElementById(`like-count-${threadId}-main`);
            
            console.log('Found like button main:', likeBtnMain);
            console.log('Found like count main:', likeCountMain);
            
            if (likeBtnMain && likeCountMain) {
                const iconMain = likeBtnMain.querySelector('i');
                
                if (data.liked) {
                    likeBtnMain.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    likeBtnMain.classList.add('bg-red-100', 'text-red-600', 'dark:bg-red-900', 'dark:text-red-400');
                    if (iconMain) {
                        iconMain.classList.remove('far');
                        iconMain.classList.add('fas');
                    }
                } else {
                    likeBtnMain.classList.add('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    likeBtnMain.classList.remove('bg-red-100', 'text-red-600', 'dark:bg-red-900', 'dark:text-red-400');
                    if (iconMain) {
                        iconMain.classList.add('far');
                        iconMain.classList.remove('fas');
                    }
                }
                
                likeCountMain.textContent = data.likes_count;
            }
            
            Toast.success(data.liked ? 'Thread liked!' : 'Like removed');
        } else {
            Toast.error(data.message || 'Failed to toggle like');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.error('An error occurred');
    });
}

// Share Thread
function shareThread(threadId, threadTitle) {
    console.log('shareThread called with threadId:', threadId, 'and title:', threadTitle);
    
    const url = window.location.href;
    
    // Check if Web Share API is available
    if (navigator.share) {
        navigator.share({
            title: threadTitle,
            text: `Check out this thread: ${threadTitle}`,
            url: url
        })
        .then(() => Toast.success('Thread shared!'))
        .catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Error sharing:', error);
            }
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(url)
        .then(() => {
            Toast.success('Link copied to clipboard!');
        })
        .catch(error => {
            console.error('Error copying:', error);
            Toast.error('Failed to copy link');
        });
    }
}

// Toggle Bookmark
function toggleBookmark(threadId) {
    console.log('toggleBookmark called with threadId:', threadId);
    
    fetch('/api/threads/bookmark', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `thread_id=${threadId}`
    })
    .then(response => response.json())
    .then(data => {
        console.log('Bookmark response:', data);
        if (data.success) {
            // Update bookmark buttons in both locations
            const bookmarkBtnMain = document.getElementById(`bookmark-btn-${threadId}-main`);
            const bookmarkBtnSidebar = document.getElementById(`bookmark-btn-${threadId}-sidebar`);
            
            console.log('Found bookmark button main:', bookmarkBtnMain);
            console.log('Found bookmark button sidebar:', bookmarkBtnSidebar);
            
            // Update main button
            if (bookmarkBtnMain) {
                const iconMain = bookmarkBtnMain.querySelector('i');
                const textMain = bookmarkBtnMain.querySelector('span');
                
                if (data.bookmarked) {
                    bookmarkBtnMain.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    bookmarkBtnMain.classList.add('bg-yellow-100', 'text-yellow-600', 'dark:bg-yellow-900', 'dark:text-yellow-400');
                    if (iconMain) {
                        iconMain.classList.remove('far');
                        iconMain.classList.add('fas');
                    }
                    if (textMain) {
                        textMain.textContent = 'Bookmarked';
                    }
                } else {
                    bookmarkBtnMain.classList.add('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    bookmarkBtnMain.classList.remove('bg-yellow-100', 'text-yellow-600', 'dark:bg-yellow-900', 'dark:text-yellow-400');
                    if (iconMain) {
                        iconMain.classList.add('far');
                        iconMain.classList.remove('fas');
                    }
                    if (textMain) {
                        textMain.textContent = 'Bookmark';
                    }
                }
            }
            
            // Update sidebar button
            if (bookmarkBtnSidebar) {
                // For sidebar, we need to update the icon and text elements directly
                const iconSidebar = document.getElementById(`bookmark-icon-${threadId}-sidebar`);
                const textSidebar = document.getElementById(`bookmark-text-${threadId}-sidebar`);
                
                if (data.bookmarked) {
                    bookmarkBtnSidebar.classList.remove('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    bookmarkBtnSidebar.classList.add('bg-yellow-100', 'text-yellow-600', 'dark:bg-yellow-900', 'dark:text-yellow-400');
                    if (iconSidebar) {
                        iconSidebar.classList.remove('far');
                        iconSidebar.classList.add('fas');
                    }
                    if (textSidebar) {
                        textSidebar.textContent = 'Bookmarked';
                    }
                } else {
                    bookmarkBtnSidebar.classList.add('bg-gray-100', 'hover:bg-gray-200', 'dark:bg-gray-800', 'dark:hover:bg-gray-700', 'text-gray-600', 'dark:text-gray-400');
                    bookmarkBtnSidebar.classList.remove('bg-yellow-100', 'text-yellow-600', 'dark:bg-yellow-900', 'dark:text-yellow-400');
                    if (iconSidebar) {
                        iconSidebar.classList.add('far');
                        iconSidebar.classList.remove('fas');
                    }
                    if (textSidebar) {
                        textSidebar.textContent = 'Bookmark';
                    }
                }
            }
            
            Toast.success(data.bookmarked ? 'Thread bookmarked!' : 'Bookmark removed');
        } else {
            Toast.error(data.message || 'Failed to toggle bookmark');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.error('An error occurred');
    });
}

// Notifications
function loadNotifications() {
    fetch('/api/notifications')
    .then(response => response.json())
    .then(data => {
        if (data.notifications) {
            displayNotifications(data.notifications);
        }
    })
    .catch(error => console.error('Error loading notifications:', error));
}

function displayNotifications(notifications) {
    const list = document.getElementById('notifications-list');
    
    if (notifications.length === 0) {
        list.innerHTML = `
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-bell-slash text-3xl mb-2"></i>
                <p>No notifications yet</p>
            </div>
        `;
        return;
    }
    
    list.innerHTML = notifications.map(notif => {
        const isUnread = !notif.is_read;
        const iconMap = {
            'thread_like': 'fa-heart text-red-500',
            'thread_reply': 'fa-comment text-blue-500',
            'thread_comment': 'fa-comment text-blue-500',
            'thread_share': 'fa-share-alt text-green-500',
            'mention': 'fa-at text-purple-500',
            'friend_request': 'fa-user-plus text-indigo-500'
        };
        const icon = iconMap[notif.type] || 'fa-bell text-gray-500';
        
        return `
            <a href="/threads/${notif.thread_id}" 
               onclick="markNotificationRead(${notif.id})"
               class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-700 ${isUnread ? 'bg-blue-50 dark:bg-blue-900/20' : ''}">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <img src="${notif.actor_avatar ? `/uploads/avatars/${notif.actor_avatar}` : '/assets/images/default-avatar.svg'}" 
                             alt="${notif.actor_username}" 
                             class="w-10 h-10 rounded-full">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-900 dark:text-white">
                            <i class="fas ${icon} mr-1"></i>
                            ${notif.message}
                        </p>
                        ${notif.thread_title ? `<p class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">${notif.thread_title}</p>` : ''}
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${timeAgo(notif.created_at)}</p>
                    </div>
                    ${isUnread ? '<div class="flex-shrink-0"><span class="inline-block w-2 h-2 bg-blue-600 rounded-full"></span></div>' : ''}
                </div>
            </a>
        `;
    }).join('');
}

function updateNotificationCount() {
    fetch('/api/notifications/unread-count')
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('.notif-count');
        if (data.count > 0) {
            badge.textContent = data.count > 99 ? '99+' : data.count;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    })
    .catch(error => console.error('Error updating notification count:', error));
}

function markNotificationRead(notificationId) {
    fetch(`/api/notifications/${notificationId}/read`, {
        method: 'POST'
    })
    .then(() => {
        updateNotificationCount();
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

function markAllNotificationsRead() {
    fetch('/api/notifications/mark-all-read', {
        method: 'POST'
    })
    .then(() => {
        loadNotifications();
        updateNotificationCount();
        Toast.success('All notifications marked as read');
    })
    .catch(error => {
        console.error('Error marking all as read:', error);
        Toast.error('Failed to mark notifications as read');
    });
}

// Helper function for time ago
function timeAgo(dateString) {
    const date = new Date(dateString);
    const seconds = Math.floor((new Date() - date) / 1000);
    
    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1
    };
    
    for (const [name, value] of Object.entries(intervals)) {
        const interval = Math.floor(seconds / value);
        if (interval >= 1) {
            return interval === 1 ? `1 ${name} ago` : `${interval} ${name}s ago`;
        }
    }
    
    return 'just now';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Load notifications and update count every 30 seconds
    if (document.querySelector('.notif-count')) {
        updateNotificationCount();
        loadNotifications();
        setInterval(() => {
            updateNotificationCount();
            loadNotifications();
        }, 30000);
    }
});
