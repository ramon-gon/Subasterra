<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/ProductModel.php';

// Obtenir el rol de l'usuari (aquest valor hauria de provenir de la sessió o autenticació)
$userRole = 'subhastador';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

$productModel = new ProductModel($conn);

// Comprovar el rol de l'usuari per decidir quina funció cridar
if ($userRole === 'subhastador') {
    $result = $productModel->getProductsSubhastador($search, $order);
} else {
    $result = $productModel->getProducts($search, $order);
}

// Passar les dades a la vista
include_once __DIR__ . '/../views/LlistaProductes.php';
