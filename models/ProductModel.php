<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProducts($search, $order) {
        $search_param = '%' . $search . '%';

        // Validació de l'ordre per evitar SQL injection
        if ($order !== 'nom' && $order !== 'preu_sortida') {
            $order = 'nom';
        }

        $sql = "SELECT id, nom, descripcio, foto, preu_sortida 
                FROM productes 
                WHERE LOWER(REPLACE(nom, 'à', 'a')) LIKE LOWER(REPLACE(?, 'à', 'a')) 
                ORDER BY $order";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $search_param);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
