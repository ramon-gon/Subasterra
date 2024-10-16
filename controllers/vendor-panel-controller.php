<?php

session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/products-model.php';

$productModel = new ProductModel($conn);
$id = $_SESSION["id"];
$products = $productModel->getMyProducts($id);
    
include_once __DIR__ . '/../views/vendor-panel-view.php';
