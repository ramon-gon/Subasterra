<?php
class AuctionModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAuctions() {
        $query = "SELECT a.id, a.auction_date, a.description, GROUP_CONCAT(p.name) as product_names, a.status
                  FROM auctions a
                  LEFT JOIN auction_products ap ON a.id = ap.auction_id
                  LEFT JOIN products p ON ap.product_id = p.id
                  GROUP BY a.id
                  ORDER BY a.auction_date DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAuctionsWithFilters($status = null, $startDate = null, $endDate = null) {
        $query = "SELECT a.id, a.auction_date, a.description, GROUP_CONCAT(p.name) as product_names, a.status
                  FROM auctions a
                  LEFT JOIN auction_products ap ON a.id = ap.auction_id
                  LEFT JOIN products p ON ap.product_id = p.id";
        
        $conditions = [];
        $params = [];
    
        if (!empty($status)) {
            $conditions[] = "a.status = :status";
            $params[':status'] = $status;
        }
        if (!empty($startDate)) {
            $conditions[] = "a.auction_date >= :startDate";
            $params[':startDate'] = $startDate;
        }
        if (!empty($endDate)) {
            $conditions[] = "a.auction_date <= :endDate";
            $params[':endDate'] = $endDate;
        }
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $query .= " GROUP BY a.id ORDER BY a.auction_date DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function addAuction($description, $auctionDate, $auctionPercentage, $productIds, $status = 'oberta') {
        $this->conn->beginTransaction();
        try {
            $stmt = $this->conn->prepare("INSERT INTO auctions (description, auction_date, percentage, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$description, $auctionDate, $auctionPercentage, $status]);
            $auctionId = $this->conn->lastInsertId();
    
            $stmt = $this->conn->prepare("INSERT INTO auction_products (auction_id, product_id) VALUES (?, ?)");
            foreach ($productIds as $productId) {
                $stmt->execute([$auctionId, $productId]);
            }
    
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }    

    public function updateAuctionStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE auctions SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }    

    public function getActiveAuctions() {
        $sql = "SELECT a.id, a.description FROM auctions a WHERE a.status = 'oberta'";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsInActiveAuction() {
        $sql = "SELECT p.id
                FROM auction_products ap
                INNER JOIN auctions a ON a.id = ap.auction_id
                INNER JOIN products p ON p.id = ap.product_id
                WHERE a.status = 'iniciada'";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}