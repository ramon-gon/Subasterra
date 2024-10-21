<?php
include(__DIR__ . "/../config/config.php");
include(__DIR__ . "/../controllers/login-controller.php");
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
    <?php include(__DIR__ . "/header-view.php"); ?>

    <div class="container-auctions">
        <div class="auction-gallery grid-layout">
            <?php if ($role === 'subhastador'): ?>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <article class="product-card">
                            <img src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="product-photo">
                            <h2 class="product-name"><?= htmlentities($row['name']); ?></h2>
                            <p class="product-status"><strong>Estat del producte:</strong> <?= htmlentities($row['status']); ?></p>
                            <p class="product-description-short"><strong>Descripció curta:</strong> <?= htmlentities($row['short_description']); ?></p>
                            <p class="product-description-long"><strong>Descripció llarga:</strong> <?= htmlentities($row['long_description']); ?></p>
                            <p class="product-price">Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No s'han trobat productes.</p>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <article class="product-card">
                            <img src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="product-photo">
                            <h2 class="product-name"><?= htmlentities($row['name']); ?></h2>
                            <p class="product-description-short"><strong>Descripció curta:</strong> <?= htmlentities($row['short_description']); ?></p>
                            <p class="product-description-long"><strong>Descripció llarga:</strong> <?= htmlentities($row['long_description']); ?></p>
                            <p class="product-price">Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No s'han trobat productes.</p>
                <?php endif; ?>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </div>

    <?php include(__DIR__ . "/footer-view.php"); ?>
</body>

</html>
