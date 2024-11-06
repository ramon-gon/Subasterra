<?php
class AuctionProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function assignProductToAuction($auction_id, $product_id) {
        $sql = "INSERT INTO auction_products (auction_id, product_id) VALUES (:auction_id, :product_id)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':auction_id' => $auction_id, ':product_id' => $product_id]);
    }

    public function unassignProductFromAuction($auction_id, $product_id) {
        $sql = "DELETE FROM auction_products WHERE auction_id = :auction_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':auction_id' => $auction_id, ':product_id' => $product_id]);
    }
}