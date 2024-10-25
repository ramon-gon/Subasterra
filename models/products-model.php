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
                WHERE LOWER(name) LIKE LOWER(?) AND status = 'acceptat'
                ORDER BY $order";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getProductsSubhastador($search = '', $order = 'name') {
        $search_param = '%' . $search . '%';
        if ($order !== 'name' && $order !== 'starting_price') {
            $order = 'name';
        }
        
        $sql = "SELECT id, name, short_description, long_description, photo, starting_price, status
                FROM products 
                WHERE LOWER(name) LIKE LOWER(?) 
                ORDER BY $order";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getAcceptProducts() {
        $sql = "SELECT p.id, p.name, p.short_description, p.long_description, p.observations, p.starting_price, p.photo, 
                p.status, p.auctioneer_message, u.username 
                FROM products p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'pendent'";
    
        return $this->conn->query($sql);
    }
    
    public function getPendingProducts() {
        $sql = "SELECT p.user_id, p.id, p.name, p.short_description, p.long_description, p.observations, p.starting_price, p.photo, 
                p.status, p.auctioneer_message, u.username 
                FROM products p 
                JOIN users u ON p.user_id = u.id";
    
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

    public function getMyProducts($id) {
        $sql ="SELECT p.id, p.name, p.short_description, p.starting_price, p.status, p.photo, 
                p.long_description, p.observations
                FROM products p 
                JOIN users u ON p.user_id = u.id 
                WHERE u.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    public function addProduct($name, $short_description, $long_description, $observations, $starting_price, $photo_path, $user_id) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, short_description, long_description, observations, starting_price, photo, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdsd", $name, $short_description, $long_description, $observations, $starting_price, $photo_path, $user_id);
        return $stmt->execute();
    }
    public function getProductById($product_id) {
        // Preparar la consulta SQL para obtener el producto por su ID
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $product_id);
        
        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Verificar si se obtuvo un resultado
        if ($result->num_rows > 0) {
            // Retornar el producto como un array asociativo
            return $result->fetch_assoc();
        } else {
            // Si no se encuentra, retornar null
            return null;
        }
    }
    
    public function updateProductStatusRetired($product_id, $status) {
        $stmt = $this->conn->prepare("UPDATE products SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $product_id);
        return $stmt->execute();
    }  
    
    public function getUserIdbyProduct($product) {
        $sql = "SELECT user_id FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $product);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getFilteredPendingProducts($status = null, $orderByPrice = 'ASC') {
        $query = "
            SELECT products.*, users.username 
            FROM products 
            JOIN users ON products.user_id = users.id 
            WHERE status IN ('pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta', 'pendent_adjudicacio', 'venut', 'retirat')
        ";
        
        if (!empty($status)) {
            $query .= " AND products.status = ?";
        }
    
        // Ordenar por precio
        $query .= " ORDER BY products.starting_price $orderByPrice";
    
        $stmt = $this->conn->prepare($query);
        
        if (!empty($status)) {
            $stmt->bind_param('s', $status);
        }
    
        $stmt->execute();
        return $stmt->get_result();
    }
    
    
}
