<?php
class AuctionModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAuctionsWithFilters($status = null, $startDate = null, $endDate = null) {
        $query = "SELECT a.id, a.auction_date, a.description, GROUP_CONCAT(p.name) as product_names, a.status
                FROM auctions a
                LEFT JOIN auction_products ap ON a.id = ap.auction_id
                LEFT JOIN products p ON ap.product_id = p.id";

        $conditions = [];
        $params = [];

        if (!empty($status)) {
            $conditions[] = "a.status = ?";
            $params[] = $status;
        }

        if (!empty($startDate)) {
            $conditions[] = "a.auction_date >= ?";
            $params[] = $startDate;
        }

        if (!empty($endDate)) {
            $conditions[] = "a.auction_date <= ?";
            $params[] = $endDate;
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " GROUP BY a.id";

        $query .= " ORDER BY a.auction_date DESC";

        $stmt = $this->conn->prepare($query);

        if (count($params) > 0) {
            $types = str_repeat('s', count($params)); 
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function addAuction($description, $auctionDate, $productIds, $status = 'oberta') {
        $stmt = $this->conn->prepare("INSERT INTO auctions (description, auction_date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $description, $auctionDate, $status);
        
        if ($stmt->execute()) {
            $auctionId = $stmt->insert_id; 

            foreach ($productIds as $productId) {
                $stmt = $this->conn->prepare("INSERT INTO auction_products (auction_id, product_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $auctionId, $productId);
                $stmt->execute();
            }

            return true; 
        }

        return false; 
    }

    public function updateAuctionStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE auctions SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function getActiveAuctions() {
        $sql = "SELECT a.id, a.description
        FROM auctions a
        WHERE a.status = 'oberta'";

        return $this->conn->query($sql);
    }
}