<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';

$role = $_SESSION['role'] ?? null;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

$id = $_SESSION['id'] ?? null;

$productModel = new ProductModel($dbConnection);    

// Comprovar el rol de l'usuari per decidir quina funció cridar
if ($role === 'subhastador') {
    $result = $productModel->getProductsSubhastador($search, $order);
} else {
    $result = $productModel->getProducts($search, $order);
}

// Passar les dades a la vista
include_once __DIR__ . '/../views/products-list-view.php';