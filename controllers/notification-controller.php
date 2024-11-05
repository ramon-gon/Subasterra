<?php
require_once(__DIR__ . '/../controllers/session-controller.php');
require_once(__DIR__ . '/../models/notifications-model.php');
include_once __DIR__ . '/../config/config.php';

lazy_session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['notification_id']) && isset($_SESSION['id']) && isset($_POST['action'])) {
        $notificationId = $_POST['notification_id'];
        $notificationsModel = new NotificationsModel($dbConnection);
        
        switch ($_POST['action']) {
            case 'mark':
                $notificationsModel->markAsRead($notificationId);
                break;
            case 'delete':
                $notificationsModel->deleteNotification($notificationId);
                break;
            default:
                http_response_code(400);
                exit('Acció invàlida');
        }
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
