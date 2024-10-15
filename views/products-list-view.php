<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista de Productes</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <header>
        <p id="logo">Subasterra</p>
        <button id="login" onclick="window.location.href='/views/login-view.php'">
            Inicia sessió 
        </button>

    </header>

    <div class="container-auctions">
        <div class="current-auctions-header">
            <p class="title-category">Subastes actives</p>

            <?php if ($userRole === 'subhastador'): ?>
                <button class="btn-panel" onclick="window.location.href='/controllers/auctioner-panel-controller.php'">
                    Panell Subhastador
                </button>
            <?php elseif ($userRole === 'venedor'): ?>
                <button class="btn-panel" onclick="window.location.href='/controllers/vendor-panel-controller.php'">
                    Panell Venedor
                </button>
            <?php endif; ?>


            <form id="search" method="GET" action="/index.php">
                <input type="text" name="search" placeholder="Cerca productes..." value="<?= htmlspecialchars($search); ?>">
                <select name="order">
                    <option value="name" <?= $order === 'name' ? 'selected' : ''; ?>>Ordena per nom</option>
                    <option value="starting_price" <?= $order === 'starting_price' ? 'selected' : ''; ?>>Ordena per preu</option>
                </select>
                <button type="submit">Cerca</button>
            </form>
        </div>

        <div class="auction-gallery">
            <?php if ($userRole === 'subhastador'): ?>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product">
                            <img id="photo" src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="foto">
                            <p id="product-name"><?= htmlentities($row['name']); ?></p>
                            <p id="product-status"><strong>Estat del producte:</strong> <?= htmlentities($row['status']); ?></p>
                            <p id="product-description_short"><strong>Descripció curta:</strong> <?= htmlentities($row['short_description']); ?></p>
                            <p id="product-description_long"><strong>Descripció llarga:</strong> <?= htmlentities($row['long_description']); ?></p>
                            <p id="product-price">Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No s'han trobat productes.</p>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product">
                            <img id="photo" src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="foto">
                            <p id="product-name"><?= htmlentities($row['name']); ?></p>
                            <p id="product-description_short"><strong>Descripció curta:</strong> <?= htmlentities($row['short_description']); ?></p>
                            <p id="product-description_long"><strong>Descripció llarga:</strong> <?= htmlentities($row['long_description']); ?></p>
                            <p id="product-price">Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No s'han trobat productes.</p>
                <?php endif; ?>
            <?php endif; ?>

            <?php $conn->close(); ?>
        </div>
    </div>

    <footer>
        <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
    </footer>
</body>

</html>