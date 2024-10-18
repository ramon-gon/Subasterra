<?php

require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';

$productModel = new ProductModel($conn);
$id = $_SESSION["id"];
$products = $productModel->getMyProducts($id);

// Procesar la acción de retirar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'retire') {
    $product_id = $_POST['product_id'];

    // Verificar que el producto pertenezca al usuario y tenga un estado que permita su retirada
    $product = $productModel->getProductById($product_id);

    if ($product && $product['user_id'] == $id &&
        in_array($product['status'], ['pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta'])) {
        
        // Intentar actualizar el estado a 'retirat'
        $success = $productModel->updateProductStatusRetired($product_id, 'retirat');
        
        if ($success) {
            $_SESSION['message'] = "Producte retirat correctament.";
        } else {
            $_SESSION['message'] = "Error al retirar el producte.";
        }
    } else {
        $_SESSION['message'] = "No es pot retirar el producte.";
    }

    // Redirigir al panel del venedor después de procesar la acción
    header('Location: /controllers/vendor-panel-controller.php');
    exit();
}

// Incluir la vista
include_once __DIR__ . '/../views/vendor-panel-view.php';

