<?php
// Helpers are in global namespace for easy access

/**
 * Escape HTML output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate URL
 */
function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

/**
 * Asset URL
 */
function asset($path = '') {
    return ASSET_URL . '/' . ltrim($path, '/');
}

/**
 * Upload URL
 */
function upload($path = '') {
    return UPLOAD_URL . '/' . ltrim($path, '/');
}

/**
 * Redirect
 */
function redirect($url) {
    \Core\Router::redirect($url);
}

/**
 * Old input value (for forms)
 */
function old($key, $default = '') {
    return $_SESSION['old'][$key] ?? $default;
}

/**
 * Flash message
 */
function flash($key) {
    $message = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $message;
}

/**
 * Set flash message
 */
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Get current user
 */
function currentUser() {
    return $_SESSION['user'] ?? null;
}

/**
 * Get current user ID
 */
function userId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get user reputation safely
 */
function userReputation() {
    return $_SESSION['user']['reputation'] ?? 0;
}

/**
 * Get user avatar safely
 */
function userAvatar() {
    if (isset($_SESSION['user']['avatar']) && $_SESSION['user']['avatar']) {
        return upload('avatars/' . $_SESSION['user']['avatar']);
    }
    return asset('images/default-avatar.svg');
}

/**
 * Check if user has role
 */
function hasRole($role) {
    if (!isLoggedIn()) {
        return false;
    }
    return $_SESSION['user']['role'] === $role;
}

/**
 * Is admin
 */
function isAdmin() {
    return hasRole(ROLE_ADMIN);
}

/**
 * Is moderator
 */
function isModerator() {
    return hasRole(ROLE_MODERATOR) || isAdmin();
}

/**
 * Format date
 */
function formatDate($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Time ago
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' year' . ($years > 1 ? 's' : '') . ' ago';
    }
}

/**
 * Truncate text
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . $suffix;
    }
    return $text;
}

/**
 * Generate slug
 */
function slug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    
    if (empty($text)) {
        return 'n-a';
    }
    
    return $text;
}

/**
 * Get reputation rank
 */
function getReputationRank($reputation) {
    $ranks = array_reverse(REPUTATION_RANKS, true);
    
    foreach ($ranks as $rank => $minPoints) {
        if ($reputation >= $minPoints) {
            return $rank;
        }
    }
    
    return 'Newbie';
}

/**
 * Format file size
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

/**
 * Validate file type
 */
function isAllowedFileType($filename, $allowedTypes) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowedTypes);
}

/**
 * Generate random string
 */
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * CSRF token field
 */
function csrfField() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="' . CSRF_TOKEN_NAME . '" value="' . $_SESSION[CSRF_TOKEN_NAME] . '">';
}

/**
 * CSRF token
 */
function csrfToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Dump and die
 */
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

/**
 * Sanitize HTML
 */
function sanitizeHtml($html) {
    $allowed = '<p><br><strong><em><u><a><ul><ol><li><blockquote><code><pre><h1><h2><h3><h4><h5><h6>';
    return strip_tags($html, $allowed);
}

/**
 * Process content and embed media
 */
function processContentWithMedia($content) {
    // Convert URLs to clickable links first
    $content = makeLinksClickable($content);
    
    // Process YouTube embeds
    $content = embedYouTube($content);
    
    // Process Vimeo embeds
    $content = embedVimeo($content);
    
    // Process image URLs
    $content = embedImages($content);
    
    // Process Twitter embeds
    $content = embedTwitter($content);
    
    return $content;
}

/**
 * Convert URLs to clickable links
 */
function makeLinksClickable($text) {
    // URL pattern that matches http, https, and www
    $pattern = '/(https?:\/\/[^\s<>"{}|\\^`\[\]]+|www\.[^\s<>"{}|\\^`\[\]]+)/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $url = $matches[1];
        
        // Add http:// prefix if missing
        if (strpos($url, 'http') !== 0) {
            $url = 'http://' . $url;
        }
        
        // Truncate long URLs for display
        $displayUrl = strlen($matches[1]) > 50 ? substr($matches[1], 0, 50) . '...' : $matches[1];
        
        return '<a href="' . e($url) . '" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">' . e($displayUrl) . '</a>';
    }, $text);
}

/**
 * Embed YouTube videos
 */
function embedYouTube($content) {
    // YouTube URL patterns
    $patterns = [
        '/https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/i',
        '/https?:\/\/(?:www\.)?youtu\.be\/([a-zA-Z0-9_-]+)/i',
        '/https?:\/\/(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)/i'
    ];
    
    foreach ($patterns as $pattern) {
        $content = preg_replace_callback($pattern, function($matches) {
            $videoId = $matches[1];
            return '<div class="my-4 aspect-video w-full max-w-3xl mx-auto"><iframe class="w-full h-full rounded-lg" src="https://www.youtube.com/embed/' . e($videoId) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
        }, $content);
    }
    
    return $content;
}

/**
 * Embed Vimeo videos
 */
function embedVimeo($content) {
    // Vimeo URL pattern
    $pattern = '/https?:\/\/(?:www\.)?vimeo\.com\/(?:channels\/[a-zA-Z0-9]+\/)?([0-9]+)/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $videoId = $matches[1];
        return '<div class="my-4 aspect-video w-full max-w-3xl mx-auto"><iframe class="w-full h-full rounded-lg" src="https://player.vimeo.com/video/' . e($videoId) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe></div>';
    }, $content);
}

/**
 * Embed images from URLs
 */
function embedImages($content) {
    // Image URL pattern
    $pattern = '/https?:\/\/[^\s<>"{}|\\^`\[\]]+\.(?:jpg|jpeg|png|gif|webp|bmp)/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $imageUrl = $matches[0];
        return '<div class="my-4 text-center"><a href="' . e($imageUrl) . '" target="_blank" rel="noopener noreferrer"><img src="' . e($imageUrl) . '" alt="Embedded image" class="max-w-full h-auto rounded-lg shadow-md mx-auto"></a></div>';
    }, $content);
}

/**
 * Embed Twitter posts
 */
function embedTwitter($content) {
    // Twitter URL pattern
    $pattern = '/https?:\/\/(?:www\.)?twitter\.com\/[a-zA-Z0-9_]+\/status\/([0-9]+)/i';
    
    return preg_replace_callback($pattern, function($matches) {
        $tweetId = $matches[1];
        return '<div class="my-4 w-full max-w-lg mx-auto"><blockquote class="twitter-tweet" data-lang="en"><a href="https://twitter.com/x/status/' . e($tweetId) . '"></a></blockquote><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>';
    }, $content);
}

/**
 * Get profile theme CSS class
 */
function getProfileThemeClass($theme) {
    $themes = [
        'default' => '',
        'blue' => 'border-blue-500',
        'green' => 'border-green-500',
        'purple' => 'border-purple-500'
    ];
    
    return $themes[$theme] ?? '';
}

/**
 * Get banner style CSS class
 */
function getBannerStyleClass($style, $user) {
    if ($style === 'image' && !empty($user['banner'])) {
        return '';
    }
    
    $styles = [
        'gradient' => 'bg-gradient-to-r from-blue-600 to-purple-600',
        'solid' => 'bg-blue-600',
        'image' => 'bg-gradient-to-r from-blue-600 to-purple-600'
    ];
    
    return $styles[$style] ?? 'bg-gradient-to-r from-blue-600 to-purple-600';
}

/**
 * Get banner style inline CSS
 */
function getBannerStyle($user) {
    if (!empty($user['banner']) && ($user['banner_style'] ?? 'gradient') === 'image') {
        return 'background-image: url(' . upload('banners/' . $user['banner']) . '); background-size: cover; background-position: center;';
    }
    return '';
}

/**
 * Check if profile is visible to current user
 */
function isProfileVisible($user) {
    // Public profiles are always visible
    if (($user['profile_visibility'] ?? 'public') === 'public') {
        return true;
    }
    
    // Private profiles only visible to owner and admins
    if (($user['profile_visibility'] ?? 'public') === 'private') {
        return (isLoggedIn() && (userId() == $user['id'] || isAdmin()));
    }
    
    // Friends only profiles
    if (($user['profile_visibility'] ?? 'public') === 'friends') {
        if (!isLoggedIn()) return false;
        if (userId() == $user['id'] || isAdmin()) return true;
        
        // Check if current user is friend
        $friendModel = new \Models\Friend();
        $friendStatus = $friendModel->getFriendStatus(userId(), $user['id']);
        return !empty($friendStatus) && $friendStatus['status'] === 'accepted';
    }
    
    return true;
}

/**
 * Get user display email based on privacy settings
 */
function getUserDisplayEmail($user) {
    if (($user['show_email'] ?? 1) && isLoggedIn()) {
        // Show to owner, admins, and friends if profile is friends-only
        if (userId() == $user['id'] || isAdmin()) {
            return $user['email'];
        }
        
        if (($user['profile_visibility'] ?? 'public') === 'friends') {
            $friendModel = new \Models\Friend();
            $friendStatus = $friendModel->getFriendStatus(userId(), $user['id']);
            if (!empty($friendStatus) && $friendStatus['status'] === 'accepted') {
                return $user['email'];
            }
        } elseif (($user['profile_visibility'] ?? 'public') === 'public') {
            return $user['email'];
        }
    }
    
    return null;
}
