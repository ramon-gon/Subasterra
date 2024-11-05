<?php
require_once(__DIR__ . '/../models/auctions-model.php');
require_once(__DIR__ . '/../config/config.php');

$auctionModel = new AuctionModel($dbConnection); 
$auctions = $auctionModel->getAuctions();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $status = $_GET['status'] ?? null;
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;
    
    $auctions = $auctionModel->getAuctionsWithFilters($status, $startDate, $endDate);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['auction-id'] ?? null;
    $status = $_POST['status'] ?? null;

    $auctionModel->updateAuctionStatus($id, $status);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

include(__DIR__ . '/../views/auction-view.php');
