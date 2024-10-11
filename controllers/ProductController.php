<?php
include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/ProductModel.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

$productModel = new ProductModel($conn);
$result = $productModel->getProducts($search, $order);

// Passar les dades a la vista
include_once __DIR__ . '/../views/LlistaProductes.php';

