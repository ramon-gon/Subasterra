<?php
class NotificationsModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getNotifications($receiver) {
        $sql = "SELECT n.id, n.message, n.is_read, n.sender, u.username as sender_username
                FROM notifications n
                JOIN users u ON n.sender = u.id
                WHERE n.receiver = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $receiver);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function markAsRead($id) {
        $sql = "UPDATE notifications SET is_read = TRUE WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function sendNotification($message, $sender, $receiver) {
        $sql = "INSERT INTO notifications (message, sender, receiver) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sii', $message, $sender, $receiver);
        return $stmt->execute();
    }

    public function deleteNotification($id) {
        $sql = "DELETE FROM notifications WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function deleteAllNotifications($receiver) {
        $sql = "DELETE FROM notifications WHERE receiver = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $receiver);
        return $stmt->execute();
    }
}