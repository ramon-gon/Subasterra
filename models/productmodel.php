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
        
        $sql = "SELECT id, name, short_description, long_description, photo, starting_price, status
                FROM products 
                WHERE LOWER(name) LIKE LOWER(:search) AND status = 'assignat a una subhasta'
                ORDER BY $order";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search' => $search_param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProductsSubhastador($search = '', $order = 'name') {
        $search_param = '%' . $search . '%';
        if ($order !== 'name' && $order !== 'starting_price') {
            $order = 'name';
        }
        
        $sql = "SELECT id, name, short_description, long_description, photo, starting_price, status
                FROM products 
                WHERE LOWER(name) LIKE LOWER(:search)
                ORDER BY $order";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':search' => $search_param]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAcceptProducts() {
        $sql = "SELECT p.id, p.name, p.short_description, p.long_description, p.observations, p.starting_price, p.photo, 
                p.status, p.auctioneer_message, u.username 
                FROM products p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'pendent'";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPendingProducts() {
        $sql = "SELECT p.user_id, p.id, p.name, p.short_description, p.long_description, p.observations, p.starting_price, p.photo, 
                p.status, p.auctioneer_message, u.username 
                FROM products p 
                JOIN users u ON p.user_id = u.id";
    
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProductStatus($product_id, $status, $message) {
        $sql = "UPDATE products SET status = :status, auctioneer_message = :message WHERE id = :product_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':message' => $message, ':product_id' => $product_id]);
    }

    public function updateProductDescriptions($product_id, $short_description, $long_description) {
        $sql = "UPDATE products SET short_description = :short_description, long_description = :long_description WHERE id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':short_description' => $short_description, ':long_description' => $long_description, ':product_id' => $product_id]);
    }

    public function getMyProducts($id) {
        $sql = "SELECT p.id, p.name, p.short_description, p.starting_price, p.status, p.photo, 
                p.long_description, p.observations
                FROM products p 
                JOIN users u ON p.user_id = u.id 
                WHERE u.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $short_description, $long_description, $observations, $starting_price, $photo_path, $user_id) {
        $sql = "INSERT INTO products (name, short_description, long_description, observations, starting_price, photo, user_id) VALUES (:name, :short_description, :long_description, :observations, :starting_price, :photo, :user_id)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name, 
            ':short_description' => $short_description, 
            ':long_description' => $long_description, 
            ':observations' => $observations, 
            ':starting_price' => $starting_price, 
            ':photo' => $photo_path, 
            ':user_id' => $user_id
        ]);
    }

    public function getProductById($product_id) {
        $sql = "SELECT * FROM products WHERE id = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product_id' => $product_id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    public function updateProductStatusRetired($product_id, $status) {
        $sql = "UPDATE products SET status = :status WHERE id = :product_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':product_id' => $product_id]);
    }  
    
    public function getUserIdbyProduct($product) {
        $sql = "SELECT user_id FROM products WHERE id = :product";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':product' => $product]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFilteredPendingProducts($status = null, $orderByPrice = 'ASC') {
        $query = "
            SELECT products.*, users.username 
            FROM products 
            JOIN users ON products.user_id = users.id 
            WHERE status IN ('pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta', 'pendent_adjudicacio', 'venut', 'retirat')
        ";
        
        $params = [];
        
        if (!empty($status)) {
            $query .= " AND products.status = :status";
            $params[':status'] = $status;
        }

        $query .= " ORDER BY products.starting_price $orderByPrice";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
