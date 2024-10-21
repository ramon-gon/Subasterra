<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';

$productModel = new ProductModel($conn);

$products = $productModel->getPendingProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form-type'] ?? '';

    if ($form_type === 'create-auction') {
        $auction_description = $_POST['auction-description'];
        $auction_date = $_POST['auction-date'];
        
        if ($auction_description !== '' && $auction_date !== '')
        $productModel->addNewAuction($auction_description, $auction_date);
    } elseif ($form_type === 'product-assignment') {
        $product_id = $_POST['product_id'];
        $action = $_POST['action'];
        $message = $_POST['message'] ?? '';
        $short_description = $_POST['short_description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';
    
        if ($action === 'accept') {
            $productModel->updateProductStatus($product_id, 'acceptat', 'Producte acceptat. ' . $message);
        } elseif ($action === 'reject') {
            $productModel->updateProductStatus($product_id, 'rebutjat', 'Producte rebutjat. ' . $message);
        }
        
        $productModel->updateProductDescriptions($product_id, $short_description, $long_description);
    }
        
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
include_once __DIR__ . '/../views/auctioner-panel-view.php';

