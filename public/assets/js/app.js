// ForumHub Pro - Main JavaScript

// Toast Notification System
const Toast = {
    container: null,
    
    init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            document.body.appendChild(this.container);
        }
    },
    
    show(message, type = 'info', duration = 4000) {
        this.init();
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };
        
        toast.innerHTML = `
            <div class="toast-icon">${icons[type]}</div>
            <div class="toast-content">
                <p class="toast-message">${message}</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        `;
        
        this.container.appendChild(toast);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.add('hiding');
            setTimeout(() => toast.remove(), 400);
        }, duration);
        
        return toast;
    },
    
    success(message, duration) {
        return this.show(message, 'success', duration);
    },
    
    error(message, duration) {
        return this.show(message, 'error', duration);
    },
    
    warning(message, duration) {
        return this.show(message, 'warning', duration);
    },
    
    info(message, duration) {
        return this.show(message, 'info', duration);
    }
};

// Custom Confirm Dialog
function showConfirm(options) {
    return new Promise((resolve) => {
        const overlay = document.createElement('div');
        overlay.className = 'confirm-overlay';
        
        const modal = document.createElement('div');
        modal.className = 'confirm-modal';
        
        const icon = options.icon || '⚠️';
        const title = options.title || 'Confirm Action';
        const message = options.message || 'Are you sure?';
        const confirmText = options.confirmText || 'Confirm';
        const cancelText = options.cancelText || 'Cancel';
        
        modal.innerHTML = `
            <div class="confirm-icon">${icon}</div>
            <h3 class="confirm-title">${title}</h3>
            <p class="confirm-message">${message}</p>
            <div class="confirm-buttons">
                <button class="confirm-btn confirm-btn-cancel" data-action="cancel">${cancelText}</button>
                <button class="confirm-btn confirm-btn-confirm" data-action="confirm">${confirmText}</button>
            </div>
        `;
        
        overlay.appendChild(modal);
        document.body.appendChild(overlay);
        
        // Handle clicks
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                cleanup();
                resolve(false);
            }
        });
        
        modal.addEventListener('click', (e) => {
            const action = e.target.dataset.action;
            if (action === 'confirm') {
                cleanup();
                resolve(true);
            } else if (action === 'cancel') {
                cleanup();
                resolve(false);
            }
        });
        
        function cleanup() {
            overlay.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => overlay.remove(), 300);
        }
    });
}

// Override default alert and confirm
window.alert = function(message) {
    Toast.info(message);
};

const originalConfirm = window.confirm;
window.confirm = function(message) {
    // For backward compatibility, we'll use a synchronous-like approach
    // but this won't work perfectly for all cases
    console.warn('Using confirm() - consider using showConfirm() for better UX');
    return originalConfirm(message);
};

// Make Toast and showConfirm globally available
window.Toast = Toast;
window.showConfirm = showConfirm;

// Utility Functions
const ForumHub = {
    // API Call Wrapper
    async api(url, options = {}) {
        try {
            const response = await fetch(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...options.headers
                },
                ...options
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    },
    
    // Show notification (deprecated - use Toast instead)
    notify(message, type = 'info') {
        Toast.show(message, type);
    },
    
    // Confirm dialog (deprecated - use showConfirm instead)
    confirm(message, callback) {
        showConfirm({
            message: message,
            title: 'Confirm Action'
        }).then(confirmed => {
            if (confirmed && callback) {
                callback();
            }
        });
    },
    
    // Format date
    formatDate(date) {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    },
    
    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

// Make available globally
window.ForumHub = ForumHub;

// Auto-resize textareas
document.addEventListener('DOMContentLoaded', () => {
    const textareas = document.querySelectorAll('textarea[data-autoresize]');
    
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
});

// Image preview for file uploads
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        ForumHub.notify('Copied to clipboard!', 'success');
    }).catch(err => {
        console.error('Copy failed:', err);
    });
}

// Markdown preview toggle
function toggleMarkdownPreview(textareaId, previewId) {
    const textarea = document.getElementById(textareaId);
    const preview = document.getElementById(previewId);
    
    if (preview.classList.contains('hidden')) {
        // Show preview
        preview.innerHTML = marked.parse(textarea.value);
        preview.classList.remove('hidden');
        textarea.classList.add('hidden');
    } else {
        // Show editor
        preview.classList.add('hidden');
        textarea.classList.remove('hidden');
    }
}

// Live search
const setupLiveSearch = (inputId, resultsId, searchUrl) => {
    const input = document.getElementById(inputId);
    const results = document.getElementById(resultsId);
    
    if (!input || !results) return;
    
    const search = ForumHub.debounce(async (query) => {
        if (query.length < 2) {
            results.innerHTML = '';
            results.classList.add('hidden');
            return;
        }
        
        try {
            const data = await ForumHub.api(`${searchUrl}?q=${encodeURIComponent(query)}`);
            
            if (data.results && data.results.length > 0) {
                results.innerHTML = data.results.map(item => `
                    <a href="${item.url}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                        ${item.title}
                    </a>
                `).join('');
                results.classList.remove('hidden');
            } else {
                results.innerHTML = '<div class="px-4 py-2 text-gray-500">No results found</div>';
                results.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }, 300);
    
    input.addEventListener('input', (e) => search(e.target.value));
    
    // Hide results when clicking outside
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !results.contains(e.target)) {
            results.classList.add('hidden');
        }
    });
};

// Initialize tooltips
document.addEventListener('DOMContentLoaded', () => {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-900 text-white text-xs rounded py-1 px-2 z-50';
            tooltip.textContent = this.getAttribute('data-tooltip');
            tooltip.id = 'tooltip';
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
            tooltip.style.left = (rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2)) + 'px';
        });
        
        element.addEventListener('mouseleave', function() {
            const tooltip = document.getElementById('tooltip');
            if (tooltip) tooltip.remove();
        });
    });
});

console.log('ForumHub Pro - Frontend Loaded');
