# Routes to Add

Add these routes to your routing configuration:

## Thread Like Routes
```php
// In your routes file, add:
POST /api/threads/like -> ThreadController@toggleLike
```

## Notification Routes
```php
// Notification API routes
GET  /api/notifications -> NotificationController@index
GET  /api/notifications/unread-count -> NotificationController@unreadCount
POST /api/notifications/{id}/read -> NotificationController@markAsRead
POST /api/notifications/mark-all-read -> NotificationController@markAllAsRead
DELETE /api/notifications/{id} -> NotificationController@delete
```

## Example Route Configuration

If using a routes array:
```php
$routes = [
    // ... existing routes ...
    
    // Thread interactions
    'POST /api/threads/like' => 'ThreadController@toggleLike',
    
    // Notifications
    'GET /api/notifications' => 'NotificationController@index',
    'GET /api/notifications/unread-count' => 'NotificationController@unreadCount',
    'POST /api/notifications/:id/read' => 'NotificationController@markAsRead',
    'POST /api/notifications/mark-all-read' => 'NotificationController@markAllAsRead',
    'DELETE /api/notifications/:id' => 'NotificationController@delete',
];
```

## Database Migration

Run this SQL to create the necessary tables:
```bash
mysql -u root -p forumhub_mvc < database/add_likes_notifications.sql
```

Or manually execute the SQL file in phpMyAdmin.
