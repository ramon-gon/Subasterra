<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProducts($search, $order) {
        $search_param = '%' . $search . '%';

        // Validació de l'ordre per evitar SQL injection
        if ($order !== 'name' && $order !== 'starting_price') {
            $order = 'name';
        }

        $sql = "SELECT id, name, short_description, long_description, photo, starting_price
                FROM products 
                WHERE LOWER(REPLACE(name, 'à', 'a')) LIKE LOWER(REPLACE(?, 'à', 'a')) 
                ORDER BY $order";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
