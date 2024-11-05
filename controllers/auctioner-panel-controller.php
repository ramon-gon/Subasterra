<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include_once __DIR__ . '/../config/config.php';
include_once __DIR__ . '/../models/productmodel.php';
include_once __DIR__ . '/../models/auctions-model.php';
include_once __DIR__ . '/../models/users-model.php';
include_once __DIR__ . '/../models/notifications-model.php';

$auctionModel = new AuctionModel($dbConnection);
$auctions = $auctionModel->getAuctions();
$activeAuctions = $auctionModel->getActiveAuctions();

$productModel = new ProductModel($dbConnection);
$products = $productModel->getPendingProducts();
$productsAuction = $productModel->getPendingProducts();

$usersModel = new UsersModel($dbConnection);
$subhastadorId = $usersModel->getIdByUsername('subhastador');

$notificationsModel = new NotificationsModel($dbConnection);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $form_type = $_GET['form-type'] ?? '';
    $menu = $_GET['menu'] ?? '';

    if ($form_type === 'filter-products') {
        $orderByPrice = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
        $status = $_GET['filter-status'] ?? null;
        $orderByPrice = $_GET['order-price'] ?? 'asc';

        $products = $productModel->getFilteredPendingProducts($status, strtoupper($orderByPrice));
    } elseif (empty($form_type) || $form_type === 'filter-auctions') {
        $status = $_GET['status'] ?? null;
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        $auctions = $auctionModel->getAuctionsWithFilters($status, $startDate, $endDate);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form-type'] ?? '';

    if ($form_type === 'update-auction') {
        $id = $_POST['auction-id'] ?? null;
        $status = $_POST['status'] ?? null;
    
        $auctionsStatus = $auctionModel->updateAuctionStatus($id, $status);
    } elseif ($form_type === 'create-auction') {
        $auction_description = $_POST['auction-description'];
        $auction_date = $_POST['auction-date'];
        $auction_percentage = $_POST['auction-percentage'];
        $product_ids = $_POST['product_ids'] ?? []; 

        if ($auction_description !== '' && $auction_date !== '') {
            $auctionModel->addAuction($auction_description, $auction_date, $auction_percentage, $product_ids);

            $message = 'Producte assignat a una subhasta.';
            foreach ($product_ids as $product_id) {
                $productModel->updateProductStatus($product_id, 'assignat a una subhasta', $message);
            }

            $venedors_ids = [];
            foreach ($product_ids as $product_id) {
                $venedor = $productModel->getUserIdbyProduct($product_id);
                if ($venedor && isset($venedor['user_id'])) {
                    $venedors_ids[] = $venedor['user_id'];
                }
            }

            foreach ($venedors_ids as $venedor_id) {
                $notificationsModel->sendNotification($message, $subhastador_id, $venedor_id);
            }
        }
    } elseif ($form_type === 'product-assignment') {
        $product_id = $_POST['product_id'];
        $user_id = $_POST['user_id'];
        $action = $_POST['action'];
        $message = $_POST['message'] ?? null;
        $short_description = $_POST['short_description'] ?? '';
        $long_description = $_POST['long_description'] ?? '';
        $auction_id = $_POST['auction-select'] ?? null;

        if ($action === 'accept') {
            $message = 'Producte acceptat. A espera de ser assignat a una subasta. ' . $message;
            $productModel->updateProductStatus($product_id, 'pendent d’assignació a una subhasta', $message);
        } elseif ($action === 'reject') {
            $message = 'Producte rebutjat. ' . $message;
            $productModel->updateProductStatus($product_id, 'rebutjat', $message);
        } elseif ($action === 'accept-and-assign') {
            $message = 'Producte assignat a una subhasta. ' . $message;
            $productModel->updateProductStatus($product_id, 'assignat a una subhasta', $message);
        } elseif ($action === 'unassign') {
            $message = 'Producte ha estat desassignat de la subhasta.';
            $productModel->updateProductStatus($product_id, 'pendent d’assignació a una subhasta', $message);
        }
        $notificacions = $notificationsModel->sendNotification($message, $subhastador_id, $user_id);         
        $productModel->updateProductDescriptions($product_id, $short_description, $long_description);
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

include_once __DIR__ . '/../views/auctioner-panel-view.php';
