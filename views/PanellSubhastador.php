<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell de Subhastador</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<header>
    <p id="logo">Subasterra</p>
    <button id="login">Inicia sessió</button>
</header>

</head>

<body>
    <div class="container-auctions">

        <div class="current-auctions-header">
            <p class="title-category">Panell de Subhastador</p>
        </div>

        <div class="auction-gallery">

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?= htmlspecialchars($row['photo']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" class="photo">
                        <p id="product-name"><?= htmlspecialchars($row['name']); ?> (<?= htmlspecialchars($row['username']); ?>)</p>
                        <p id="product-description_short"><strong>Descripció Curta:</strong> <?= htmlspecialchars($row['short_description']); ?></p>
                        <p id="product-description_long"><strong>Descripció Llarga:</strong> <?= htmlspecialchars($row['long_description']); ?></p>
                        <p id="product-price"><strong>Preu de Sortida:</strong> <?= number_format($row['starting_price'], 2); ?> €</p>

                        <form method="POST" class="product-form">
                            <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                            <textarea name="message" placeholder="Escriu un missatge per al venedor..."></textarea>
                                <button type="submit" name="action" value="accept" class="btn accept">Acceptar</button>
                                <button type="submit" name="action" value="reject" class="btn reject">Rebutjar</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="product-name">No hi ha productes pendents de validació.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

<footer>
    <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
</footer>

</html>