<?php
class AuctionModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }
// Obtener subhastes con filtros opcionales de estado y fechas
public function getAuctions($status = null, $startDate = null, $endDate = null) {
    // Base query
    $query = "SELECT a.id, a.auction_date, a.description, GROUP_CONCAT(p.name) as product_names, a.status
              FROM auctions a
              LEFT JOIN auction_products ap ON a.id = ap.auction_id
              LEFT JOIN products p ON ap.product_id = p.id";

    // Condiciones dinámicas
    $conditions = [];
    $params = [];

    // Filtro por estado (oberta/tancada)
    if (!empty($status)) {
        $conditions[] = "a.status = ?";
        $params[] = $status;
    }

    // Filtro por fecha de inicio
    if (!empty($startDate)) {
        $conditions[] = "a.auction_date >= ?";
        $params[] = $startDate;
    }

    // Filtro por fecha de finalización
    if (!empty($endDate)) {
        $conditions[] = "a.auction_date <= ?";
        $params[] = $endDate;
    }

    // Añadir las condiciones a la query si existen
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    // Agrupar resultados por subasta
    $query .= " GROUP BY a.id";

    // Ordenar por fecha de subasta (las más recientes primero)
    $query .= " ORDER BY a.auction_date DESC";

    // Preparar la query
    $stmt = $this->conn->prepare($query);

    // Asociar parámetros
    if (count($params) > 0) {
        $types = str_repeat('s', count($params)); // Todos los parámetros serán cadenas (strings)
        $stmt->bind_param($types, ...$params);
    }

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}





    // Añadir nueva subhasta
 // Añadir nueva subhasta
public function addAuction($auctionDate, $description, $productIds, $status = 'oberta') {
    // Insertar la subasta
    $stmt = $this->conn->prepare("INSERT INTO auctions (auction_date, description, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $auctionDate, $description, $status);
    
    if ($stmt->execute()) {
        $auctionId = $stmt->insert_id; // Obtener el ID de la subasta recién creada

        // Insertar los productos en la tabla intermedia
        foreach ($productIds as $productId) {
            $stmt = $this->conn->prepare("INSERT INTO auction_products (auction_id, product_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $auctionId, $productId);
            $stmt->execute();
        }

        return true; // La subasta y sus productos se han añadido correctamente
    }

    return false; // Hubo un error al añadir la subasta
}


    // Actualizar subhasta (p.ej., cambiar estado)
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