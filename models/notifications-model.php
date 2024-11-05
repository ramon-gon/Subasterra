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
                WHERE n.receiver = :receiver";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':receiver' => $receiver]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnreadNotificationCount($receiver) {
        $sql = "SELECT COUNT(*) as count
                FROM notifications
                WHERE receiver = :receiver AND is_read = FALSE";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':receiver' => $receiver]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function markAsRead($id) {
        $sql = "UPDATE notifications SET is_read = TRUE WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function sendNotification($message, $sender, $receiver) {
        $sql = "INSERT INTO notifications (message, sender, receiver) VALUES (:message, :sender, :receiver)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':message' => $message, ':sender' => $sender, ':receiver' => $receiver]);
    }

    public function deleteNotification($id) {
        $sql = "DELETE FROM notifications WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function deleteAllNotifications($receiver) {
        $sql = "DELETE FROM notifications WHERE receiver = :receiver";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':receiver' => $receiver]);
    }
}
?>
