<?php
class AuctionModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

 // Obtener subhastes con filtros opcionales de estado y fechas
public function getAuctions($status = null, $startDate = null, $endDate = null) {
    // Base query
    $query = "SELECT a.id, a.auction_date, a.description, p.name as product_name, a.status
              FROM auctions a
              JOIN products p ON a.product_id = p.id";
    
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


    // Obtener subhasta por ID
    public function getAuctionById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM auctions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Añadir nueva subhasta
    public function addAuction($auctionDate, $description, $productId, $status = 'oberta') {
        $stmt = $this->conn->prepare("INSERT INTO auctions (auction_date, description, product_id, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $auctionDate, $description, $productId, $status);
        return $stmt->execute();
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