<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell de Subhastador</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <header>
        <p id="logo">Subasterra</p>
        <button class="btn-panel" onclick="window.location.href='/controllers/products-controller.php'">
            Llista de productes
        </button>
    </header>

    <div class="container-auctions">

        <div class="current-auctions-header">
            <p class="title-category">Panell de Subhastador</p>
        </div>
        
            <?php if ($products->num_rows > 0): ?>
                <h2 id="revision"></h2>
            <?php endif; ?>

            <div class="auction-gallery">
            <table id="auctioneer-panel">
                <thead>
                    <tr>
                        <th>Id venedor</th>
                        <th>Usuari</th>
                        <th>Id product</th>
                        <th>Nom producte</th>
                        <th>Descripció</th>
                        <th>Preu sortida</th>
                        <th>Estat</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($products->num_rows > 0): ?>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <form method="POST" action="/controllers/auctioner-panel-controller.php">
                            <tr class="short-info-dropdown">
                                <td><?= htmlspecialchars($row['user_id']); ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['short_description']); ?></td>
                                <td><?= number_format($row['starting_price'], 2); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['id']); ?>">
                            </tr>
                            <tr class="detailed-info-content">
                                <td colspan="7">
                                    <div class="dropdown-content">
                                        <div class="dropdown-info">
                                            <div class="dropdown-info-field">
                                                <label class="panel-label">Venedor:</label>
                                                <div class="product-info">
                                                    <?= htmlspecialchars($row['username']); ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label">Nom producte:</label>
                                                <div class="product-info">
                                                    <?= htmlspecialchars($row['name']); ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label" for="short_description">Descripció breu:</label>
                                                <div class="product-info">
                                                    <input type="text" name="short_description" value="<?= htmlspecialchars($row['short_description']); ?>"></input>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label" for="long_description">Descripció extendida:</label>
                                                <div class="product-info">
                                                    <input type="text" name="long_description" value="<?= htmlspecialchars($row['long_description']); ?>"></input>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label">Preu inicial:</label>
                                                <div class="product-info">
                                                    <?= number_format($row['starting_price'], 2); ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label">Observacions:</label>
                                                <div class="product-info">
                                                    <?= htmlspecialchars($row['observations']); ?>
                                                </div>
                                            </div>
                                            <div class="dropdown-info-field">
                                                <label class="panel-label" for="message">Missatge al venedor:</label>
                                                <div class="product-info">
                                                    <textarea name="message" id="auctioner-message" placeholder="Escriu un missatge per al venedor">
                                                        <?= htmlspecialchars($row['auctioneer_message'] ?? ''); ?>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="<?= htmlspecialchars($row['photo']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
                                    </div>
                                    <input name="action" class="btn accept" type="submit" value="accept">
                                    <input name="action" class="btn reject" type="submit" value="reject">
                                </td>
                            </tr>
                        </form>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hi ha cap producte en venda</td>
                    </tr>
                <?php endif; ?>
                </tbody>
                </table>
        </div>
    </div>

    <footer>
        <p id="footer-content">Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
    </footer>

    <script>
    document.querySelectorAll('.short-info-dropdown').forEach(function(row) {
        row.addEventListener('click', function() {
            let nextRow = this.nextElementSibling;
            if (nextRow && nextRow.classList.contains('detailed-info-content')) {
                nextRow.classList.toggle('detailed-info-expanded');
            }
        });
    });
    </script>
</body>
</html>