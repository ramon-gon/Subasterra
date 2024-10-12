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
        <?php if ($products->num_rows > 0): ?>
            <h2 id="revision"></h2>
        <?php endif; ?>

        <div class="auction-gallery">

            <?php if ($products->num_rows > 0): ?>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?= htmlspecialchars($row['photo']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" class="photo">

                        <p id="product-name">
                            <strong>Nom del producte:</strong> <?= htmlspecialchars($row['name']); ?>
                        </p>
                        <p id="product-name">
                            <strong>Venedor:</strong> <?= htmlspecialchars($row['username']); ?>
                        </p>

                        <form method="POST" class="product-form">
                            <input type="hidden" name="product_id" value="<?= $row['id']; ?>">

                            <label for="short_description_<?= $row['id']; ?>">Descripció Curta:</label>
                            <textarea id="short_description_<?= $row['id']; ?>" name="short_description"><?= htmlspecialchars($row['short_description'] ?? ''); ?></textarea>

                            <label for="long_description_<?= $row['id']; ?>">Descripció Llarga:</label>
                            <textarea id="long_description_<?= $row['id']; ?>" name="long_description"><?= htmlspecialchars($row['long_description'] ?? ''); ?></textarea>

                            <p id="product-price"><strong>Preu de Sortida:</strong> <?= number_format($row['starting_price'], 2); ?> €</p>

                            <label for="message_<?= $row['id']; ?>">Missatge per al venedor:</label>
                            <textarea id="message_<?= $row['id']; ?>" name="message" placeholder="Escriu un missatge per al venedor..."><?= htmlspecialchars($row['auctioneer_message'] ?? ''); ?></textarea>

                            <button type="submit" name="action" value="accept" class="btn accept">Acceptar</button>
                            <button type="submit" name="action" value="reject" class="btn reject">Rebutjar</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hi ha productes pendents de validació.</p>
            <?php endif; ?>
        </div>

    </div>
</body>

<footer>
    <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
</footer>

</html>