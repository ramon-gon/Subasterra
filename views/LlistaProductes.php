<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista de Productes</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<header>
        <p id="logo">Subasterra</p>
        <button id="login">Inicia sessió</button>
</header>

<body>
    <div class="container-auctions">
    
        <div class="current-auctions-header">
            <p class="title-category">Subastes actives</p>
            
    <form id="search" method="GET" action="/index.php">
        <input type="text" name="search" placeholder="Cerca productes..." value="<?= htmlspecialchars($search); ?>">
        <select name="order">
            <option value="nom" <?= $order === 'name' ? 'selected' : ''; ?>>Ordena per nom</option>
            <option value="preu_sortida" <?= $order === 'starting_price' ? 'selected' : ''; ?>>Ordena per preu</option>
        </select>
        <button type="submit">Cerca</button>
    </form>

        </div>
        <div class="auction-gallery">
            

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                    <img id="photo" src="<?= htmlentities($row['photo']); ?>" alt="<?= htmlentities($row['name']); ?>" class="foto">
                        <p id="product-name"><?= htmlentities($row['name']); ?></p>
                        <p id="product-description_short"><?= htmlentities($row['short_description']); ?></p>
                        <p id="product-description_long"><?= htmlentities($row['long_description']); ?></p>
                        <p id="product-price"> Preu de sortida: <?= number_format($row['starting_price'], 2); ?> €</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No s'han trobat productes.</p>
            <?php endif; ?>

            <?php $conn->close(); ?>

        </div>
    </div>
    </div>
    </div>

</body>

<footer>
    <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
</footer>

</html>