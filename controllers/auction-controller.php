<?php
require_once(__DIR__ . '/../models/auctions-model.php');
require_once(__DIR__ . '/../config/config.php');

// Iniciar conexión a la base de datos
$auctionModel = new AuctionModel($conn);

// Obtener parámetros de filtros (estado y rango de fechas)
$status = $_GET['status'] ?? null;
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;

// Llamar al modelo para obtener las subhastes filtradas
$auctions = $auctionModel->getAuctions($status, $startDate, $endDate);

// Incluir la vista para mostrar los resultados
include(__DIR__ . '/../views/auction-view.php');
