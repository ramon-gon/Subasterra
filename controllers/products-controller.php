<?php
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = null;
}

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';


$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

$productModel = new ProductModel($conn);

// Comprovar el rol de l'usuari per decidir quina funció cridar
if ($role === 'subhastador') {
    $result = $productModel->getProductsSubhastador($search, $order);
} else {
    $result = $productModel->getProducts($search, $order);
}

// Passar les dades a la vista
include_once __DIR__ . '/../views/products-list-view.php';

