<?php
session_start();
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../controllers/products-controller.php");

if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (in_array($product_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$product_id]);
    } else {
        $_SESSION['favorites'][] = $product_id;
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$productModel = new ProductModel($dbConnection);
$products = $productModel->getProducts();
?>
