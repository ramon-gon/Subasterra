<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';
include_once __DIR__ . '/../models/auctions-model.php';

$productModel = new ProductModel($conn);
$AuctionModel = new AuctionModel($conn);

// Obtener productos pendientes
$products = $productModel->getPendingProducts();

$productsauction = $productModel->getPendingProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form-type'] ?? '';

    if ($form_type === 'create-auction') {
        $auction_description = $_POST['auction-description'];
        $auction_date = $_POST['auction-date'];
        $product_ids = $_POST['product_ids'] ?? []; // Capturamos los IDs de los productos

        if ($auction_description !== '' && $auction_date !== '' && !empty($product_ids)) {
            // Llamar al método addAuction con múltiples IDs de producto
            $AuctionModel->addAuction($auction_description, $auction_date, $product_ids);
        }
    } elseif ($form_type === 'product-assignment') {
        $product_id = $_POST['product_id'];
        $action = $_POST['action'];
        $message = $_POST['message'] ?? '';
        $short_description = $_POST['short_description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';

        if ($action === 'accept') {
            $productModel->updateProductStatus($product_id, 'pendent d’assignació a una subhasta', 'Producte acceptat. A espera de ser assignat a una subasta' . $message);
        } elseif ($action === 'reject') {
            $productModel->updateProductStatus($product_id, 'rebutjat', 'Producte rebutjat.' . $message);
        } elseif ($action === 'accept-and-assign') {
            $productModel->updateProductStatus($product_id, 'assignat a una subhasta', '' . $message);
        }
        
        $productModel->updateProductDescriptions($product_id, $short_description, $long_description);
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

include_once __DIR__ . '/../views/auctioner-panel-view.php';
