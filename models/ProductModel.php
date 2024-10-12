<?php
class ProductModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getProducts($search = '', $order = 'name') {
        $search_param = '%' . $search . '%';
        if ($order !== 'name' && $order !== 'starting_price') {
            $order = 'name';
        }
        
        $sql = "SELECT id, name, short_description, long_description, photo, starting_price 
                FROM products 
                WHERE LOWER(name) LIKE LOWER(?) 
                ORDER BY $order";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getPendingProducts() {
        $sql = "SELECT p.id, p.name, p.short_description, p.long_description, p.observations, p.starting_price, p.photo, 
                p.status, p.auctioneer_message, u.username 
                FROM products p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'pendent'";
    
        return $this->conn->query($sql);
    }
    

    public function updateProductStatus($product_id, $status, $message) {
        $sql = "UPDATE products SET status = ?, auctioneer_message = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssi', $status, $message, $product_id);
        return $stmt->execute();
    }

    public function updateProductDescriptions($product_id, $short_description, $long_description) {
        $sql = "UPDATE products SET short_description = ?, long_description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssi', $short_description, $long_description, $product_id);
        $stmt->execute();
    }    
}
