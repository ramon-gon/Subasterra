<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/ProductModel.php';

$productModel = new ProductModel($conn);
$result = $productModel->getPendingProducts();
$products = $productModel->getPendingProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    $message = $_POST['message'] ?? '';
    $short_description = $_POST['short_description'] ?? '';
    $long_description = $_POST['long_description'] ?? '';

    if ($action === 'accept') {
        $productModel->updateProductStatus($product_id, 'pendent_adjudiacio', 'Producte acceptat. ' . $message);
    } elseif ($action === 'reject') {
        $productModel->updateProductStatus($product_id, 'rebutjat', 'Producte rebutjat. ' . $message);
    }
        $productModel->updateProductDescriptions($product_id, $short_description, $long_description);
        
    // Redireccionar a la misma página para evitar reenvíos de formularios
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
include_once __DIR__ . '/../views/PanellSubhastador.php';

