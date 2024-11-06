<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../models/products-model.php';
include(__DIR__ . "/../config/config.php");

$_SESSION['product_error'] = '';
$message = '';

$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$short_description = htmlspecialchars(trim($_POST['short_description'] ?? ''));
$long_description = htmlspecialchars(trim($_POST['long_description'] ?? ''));
$observations = htmlspecialchars(trim($_POST['observations'] ?? ''));
$starting_price = floatval($_POST['starting_price'] ?? 0);
$user_id = $_SESSION['id'];

if (empty($name)) {
    $message = "El nom del producte és obligatori.";
} elseif (strlen($name) > 50) {
    $message = "El nom del producte no pot tenir més de 50 caràcters.";
} elseif ($starting_price <= 0) {
    $message = "El preu de sortida ha de ser major que 0.";
} elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] != UPLOAD_ERR_OK) {
    $message = "Si us plau, puja una imatge.";
} else {
    $target_dir = __DIR__ . "/../images/";
    $photo_name = basename($_FILES['photo']['name']);
    $target_file = $target_dir . $photo_name;
    $uploadOk = true;

    if (getimagesize($_FILES['photo']['tmp_name']) === false) {
        $message = "El fitxer no és una imatge.";
        $uploadOk = false;
    }

    if (file_exists($target_file)) {
        $message = "La imatge ja existeix, si us plau, canvia el nom de la imatge.";
        $uploadOk = false;
    }

    if ($_FILES['photo']['size'] > 5000000) {
        $message = "La imatge és massa gran (màxim 5MB).";
        $uploadOk = false;
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $message = "Només s'accepten fitxers JPG, JPEG, PNG i GIF.";
        $uploadOk = false;
    }

    if ($uploadOk && move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        $photo_path = "/images/" . $photo_name;
        $product = new ProductModel($dbConnection);
        if ($product->addProduct($name, $short_description, $long_description, $observations, $starting_price, $photo_path, $user_id)) {
            $message = "El producte s'ha afegit correctament.";
        } else {
            $message = "Error en afegir el producte.";
        }
    } else {
        $message = $message ?: "Error en pujar la imatge.";
    }
}

if ($message) {
    error_log($message);
    $_SESSION['product_error'] = $message;
    header('Location: /../views/add-product-view.php');
    exit();
}

header('Location: /../views/add-product-view.php');
exit();
?>
