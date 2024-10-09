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
        <button id="login">Inicia sessió</button>
        <input id="search" type="text" placeholder="Cerca">
    </header>


    <div class="container-auctions">
        
    <form method="GET" action="/index.php">
        <input type="text" name="search" placeholder="Cerca productes..." value="<?= htmlspecialchars($search); ?>">
        <select name="order">
            <option value="nom" <?= $order === 'nom' ? 'selected' : ''; ?>>Ordena per nom</option>
            <option value="preu_sortida" <?= $order === 'preu_sortida' ? 'selected' : ''; ?>>Ordena per preu</option>
        </select>
        <button type="submit">Cerca</button>
    </form>

        <div class="current-auctions-header">
            <p class="title-category">Subastes actives</p>
        </div>
        <div class="auction-gallery">

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <h2><?= htmlspecialchars($row['nom']); ?></h2>
                        <p><?= htmlspecialchars($row['descripcio']); ?></p>
                        <img src="<?= htmlspecialchars($row['foto']); ?>" alt="<?= htmlspecialchars($row['nom']); ?>" class="foto">
                        <p>Preu de sortida: <?= number_format($row['preu_sortida'], 2); ?> €</p>
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

    <footer>
        <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved
        </p>
    </footer>
</body>

</html>