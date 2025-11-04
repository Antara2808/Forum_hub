<?php

namespace Controllers;

use Models\Notification;
use Core\Controller;

class NotificationController extends Controller
{
    private $notificationModel;

    public function __construct()
    {
        parent::__construct();
        $this->notificationModel = new Notification();
    }

    /**
     * Get notifications for the logged-in user
     */
    public function index()
    {
        if (!isLoggedIn()) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $notifications = $this->notificationModel->getByUser(userId(), 20);
        return $this->jsonResponse(['notifications' => $notifications]);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        if (!isLoggedIn()) {
            return $this->jsonResponse(['count' => 0]);
        }

        $count = $this->notificationModel->getUnreadCount(userId());
        return $this->jsonResponse(['count' => $count]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        if (!isLoggedIn()) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $this->notificationModel->markAsRead($id);
        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        if (!isLoggedIn()) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $this->notificationModel->markAllAsRead(userId());
        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Delete notification
     */
    public function delete($id)
    {
        if (!isLoggedIn()) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 401);
        }

        $this->notificationModel->delete($id);
        return $this->jsonResponse(['success' => true]);
    }

    /**
     * Helper method to send JSON response
     */
    private function jsonResponse($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
