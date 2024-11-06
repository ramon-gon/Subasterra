<?php
require_once(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/../controllers/products-controller.php");

$productModel = new ProductModel($dbConnection);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 12;

$offset = ($page - 1) * $items_per_page;

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'name';

if ($role === 'subhastador') {
    $products = $productModel->getProductsSubhastador($search, $order, $items_per_page, $offset);
} else {
    $products = $productModel->getProducts($search, $order, $items_per_page, $offset);
}

$total_products = $productModel->getTotalProducts($search, $role);
$total_pages = ceil($total_products / $items_per_page);
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista de Productes</title>
    <link rel="stylesheet" href="/../css/product-list.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <div class="wrapper">
    <?php include(__DIR__ . "/header-view.php"); ?>

    <div class="container-auctions">
        <div class="auction-gallery grid-layout">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $row): ?>
                    <article class="product-card">
                        <img src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="product-photo">
                        <h2 class="product-name"><?= htmlentities($row['name']); ?></h2>
                        <?php if ($role === 'subhastador'): ?>
                            <p class="product-status"><strong>Estat del producte:</strong> <?= htmlentities($row['status']); ?></p>
                        <?php endif; ?>
                        <p class="product-description-short"><strong>Descripció curta:</strong> <?= htmlentities($row['short_description']); ?></p>
                        <p class="product-description-long"><strong>Descripció llarga:</strong> <?= htmlentities($row['long_description']); ?></p>
                        <p class="product-price">Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No s'han trobat productes.</p>
            <?php endif; ?>
        </div>

        <!-- Controles de Paginació -->
        <div class="pagination-controls">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&search=<?= htmlentities($search) ?>&order=<?= htmlentities($order) ?>" class="pagination-button">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= htmlentities($search) ?>&order=<?= htmlentities($order) ?>" class="pagination-button <?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>&search=<?= htmlentities($search) ?>&order=<?= htmlentities($order) ?>" class="pagination-button">Següent</a>
            <?php endif; ?>
        </div>
    </div>

    <?php include(__DIR__ . "/footer-view.php"); ?>
</body>

</html>
