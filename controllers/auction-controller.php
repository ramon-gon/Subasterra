<?php
require_once(__DIR__ . '/../models/auctions-model.php');
require_once(__DIR__ . '/../config/config.php');

$auctionModel = new AuctionModel($conn);

$status = $_GET['status'] ?? null;
$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;

$auctions = $auctionModel->getAuctionsWithFilters($status, $startDate, $endDate);

include(__DIR__ . '/../views/auction-view.php');
