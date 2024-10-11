<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/ProductModel.php';

$productModel = new ProductModel($conn);
$result = $productModel->getPendingProducts();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];
    $message = $_POST['message'] ?? '';

    if ($action === 'accept') {
        $productModel->updateProductStatus($product_id, 'acceptat', 'Producte acceptat. ' . $message);
    } elseif ($action === 'reject') {
        $productModel->updateProductStatus($product_id, 'rebutjat', 'Producte rebutjat. ' . $message);
    }

    // Redireccionar a la misma página para evitar reenvíos de formularios
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
include_once __DIR__ . '/../views/PanellSubhastador.php';

