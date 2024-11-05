<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/productmodel.php';
include_once __DIR__ . '/../models/users-model.php';
include_once __DIR__ . '/../models/notifications-model.php';

$productModel = new ProductModel($dbConnection);
$id = $_SESSION["id"];
$products = $productModel->getMyProducts($id);

$usersModel = new UsersModel($dbConnection);
$subhastador_id = $usersModel->getIdByUsername('subhastador');

$notificationsModel = new NotificationsModel($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product = $productModel->getProductById($product_id);

    if ($product && $product['user_id'] == $id && $product['status'] !== 'venut') {
        $productModel->updateProductStatusRetired($product_id, 'retirat');

        $messageToAuctioner = 'Un producte ha estat retirat.';
        $notificationsModel->sendNotification($messageToAuctioner, $id, $subhastador_id);

        $messageToVendor = 'Producte retirat satisfactoriament.';
        $notificationsModel->sendNotification($messageToVendor, $subhastador_id, $id);
    } else {
        $messageToVendor = "Hi ha hagut un error i no s'ha pogut retirar el producte.";
        $notificationsModel->sendNotification($messageToVendor, $subhastador_id, $id);     
    }

    header('Location: /controllers/vendor-panel-controller.php');
    exit();
}

include_once __DIR__ . '/../views/vendor-panel-view.php';
