<?php
require_once __DIR__ . '/config/config.php';

$productModel = new ProductModel($dbConnection);
$products = $productModel->getProducts();

require_once __DIR__ . '/views/products-list-view.php';
?>