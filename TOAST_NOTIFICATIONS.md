# 🎨 Toast Notification System

Modern, visually appealing notification system that replaces default JavaScript alerts with beautiful toast notifications and custom confirm dialogs.

## ✨ Features

- **Modern Design**: Gradient backgrounds, smooth animations, rounded corners
- **Auto-dismiss**: Notifications disappear after 3-4 seconds
- **Multiple Types**: Success, Error, Warning, Info
- **Custom Confirm Dialogs**: Beautiful modal confirmations instead of browser alerts
- **Dark Mode Support**: Fully themed for both light and dark modes
- **Responsive**: Works perfectly on mobile and desktop
- **Non-blocking**: Doesn't interrupt user workflow

---

## 📦 Toast Notifications

### Usage

```javascript
// Success notification (green)
Toast.success('✅ Post deleted successfully!');

// Error notification (red)
Toast.error('❌ Failed to delete post');

// Warning notification (yellow)
Toast.warning('⚠️ Please fill all required fields');

// Info notification (blue)
Toast.info('ℹ️ This is an informational message');

// Custom duration (default is 4000ms)
Toast.success('Message here', 5000);
```

### PHP Flash Messages

Flash messages from PHP are automatically converted to toast notifications:

```php
// In your controller
setFlash('success', 'Thread created successfully!');
setFlash('error', 'Failed to create thread');
setFlash('warning', 'Please verify your email');
setFlash('info', 'Check out our new features');
```

These will automatically display as toast notifications when the page loads.

---

## 🔔 Confirm Dialogs

Replace `confirm()` with modern modal dialogs:

### Basic Usage

```javascript
const confirmed = await showConfirm({
    title: 'Delete Thread',
    message: 'Are you sure you want to delete this thread?',
    confirmText: 'Delete',
    cancelText: 'Cancel'
});

if (confirmed) {
    // User clicked "Delete"
    deleteThread();
}
```

### Advanced Usage with Custom Icon

```javascript
const confirmed = await showConfirm({
    icon: '🗑️',
    title: 'Delete Thread',
    message: 'This action cannot be undone!',
    confirmText: 'Delete',
    cancelText: 'Cancel'
});
```

### Common Examples

```javascript
// Delete confirmation
const confirmed = await showConfirm({
    icon: '🗑️',
    title: 'Delete Item',
    message: 'Are you sure? This action cannot be undone!',
    confirmText: 'Delete',
    cancelText: 'Cancel'
});

// Logout confirmation
const confirmed = await showConfirm({
    icon: '👋',
    title: 'Logout',
    message: 'Are you sure you want to logout?',
    confirmText: 'Logout',
    cancelText: 'Stay'
});

// Ban user confirmation
const confirmed = await showConfirm({
    icon: '🚫',
    title: 'Ban User',
    message: 'This will prevent the user from accessing the platform.',
    confirmText: 'Ban User',
    cancelText: 'Cancel'
});
```

---

## 🎯 Migration Guide

### Replace `alert()`

**Before:**
```javascript
alert('Profile updated successfully!');
```

**After:**
```javascript
Toast.success('Profile updated successfully!');
```

### Replace `confirm()`

**Before:**
```javascript
if (confirm('Are you sure?')) {
    deleteItem();
}
```

**After:**
```javascript
const confirmed = await showConfirm({
    message: 'Are you sure?'
});

if (confirmed) {
    deleteItem();
}
```

---

## 🎨 Customization

### Toast Colors

- **Success**: Green gradient (#10b981 → #059669)
- **Error**: Red gradient (#ef4444 → #dc2626)
- **Warning**: Yellow gradient (#f59e0b → #d97706)
- **Info**: Blue gradient (#3b82f6 → #2563eb)

### Duration

Default duration is 4000ms (4 seconds). Customize per notification:

```javascript
Toast.success('Quick message', 2000);  // 2 seconds
Toast.error('Important error', 6000);   // 6 seconds
```

### Position

Toasts appear at **top-right** by default. Edit CSS in `style.css` to change:

```css
#toast-container {
    top: 20px;
    right: 20px;  /* Change to left: 20px for top-left */
}
```

---

## 📱 Examples in Action

### Thread Deletion

```javascript
async function deleteThread() {
    const confirmed = await showConfirm({
        icon: '🗑️',
        title: 'Delete Thread',
        message: 'This action cannot be undone!',
        confirmText: 'Delete',
        cancelText: 'Cancel'
    });
    
    if (!confirmed) return;
    
    // Submit delete form
    form.submit();
}
```

### Profile Update

```javascript
// On form submission success
if (response.success) {
    Toast.success('✅ Profile updated successfully!');
    setTimeout(() => location.reload(), 1500);
}
```

### File Upload

```javascript
// Success
Toast.success('📁 Avatar uploaded successfully!');

// Error
Toast.error('❌ File size too large (max 2MB)');
```

---

## 🔧 Technical Details

### Files Modified

1. **`public/assets/css/style.css`** - Toast and modal styles
2. **`public/assets/js/app.js`** - Toast and confirm functions
3. **`app/Views/layouts/header.php`** - Flash message integration
4. **`app/Views/threads/edit.php`** - Delete thread confirmation
5. **`app/Views/profile/edit.php`** - Avatar/banner removal
6. **`app/Views/admin/users.php`** - Admin actions

### Dependencies

- **No external libraries required**
- Pure CSS animations
- Vanilla JavaScript
- Works with existing Alpine.js and TailwindCSS

---

## 🎉 Best Practices

1. **Use appropriate types**: Success for positive actions, error for failures
2. **Add emojis**: Visual icons make notifications more engaging (✅ ❌ ⚠️ ℹ️)
3. **Keep messages short**: Aim for 5-8 words maximum
4. **Use confirm for destructive actions**: Always confirm deletes, bans, etc.
5. **Set appropriate durations**: Quick messages = 2-3s, Important = 5-6s

---

## 🐛 Troubleshooting

**Toast not showing?**
- Check browser console for errors
- Ensure `app.js` is loaded before your script
- Verify `Toast` object exists: `console.log(Toast)`

**Confirm dialog not working?**
- Make sure function is `async`
- Use `await` before `showConfirm()`
- Check for JavaScript errors in console

**Flash messages not converting?**
- Verify PHP session has flash messages
- Check header.php script tag loads correctly
- Inspect browser console for errors

---

## 📝 Notes

- Toast notifications stack vertically when multiple appear
- Clicking the × button dismisses immediately
- Confirm dialogs block interaction until answered
- All animations are GPU-accelerated for smooth performance
- Fully keyboard accessible (ESC to close)

Enjoy your modern notification system! 🎊
