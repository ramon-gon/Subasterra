<?php
session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';

$role = isset($_SESSION['role']);

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

$id = isset($_SESSION['id']);

$productModel = new ProductModel($conn);

// Comprovar el rol de l'usuari per decidir quina funció cridar
if ($role === 'subhastador') {
    $result = $productModel->getProductsSubhastador($search, $order);
} else if ($role === 'venedor'){
    $result = $productModel->getMyProducts($id);
} else {
    $result = $productModel->getProducts($search, $order);
}

// Passar les dades a la vista
include_once __DIR__ . '/../views/products-list-view.php';