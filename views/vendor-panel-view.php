<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell de Venedor</title>
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
            <p class="title-category">Panell de Venedor</p>
        </div>
            <div class="auction-gallery">

            <table id="vendor-panel">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom producte</th>
                        <th>Descripció</th>
                        <th>Preu sortida</th>
                        <th>Última puja</th>
                        <th>Estat</th>
                    </tr>
                </thead>    
                <tbody>
                <?php if ($products->num_rows > 0): ?>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <tr class="short-info-dropdown">
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['short_description'] ?? ''); ?></td>
                            <td><?= number_format($row['starting_price'], 2); ?></td>
                            <td><?= htmlspecialchars($row['starting_price']); ?></td> <!-- Aquí luego pongo last_bid cuando actualice la bbdd -->
                            <td><?= htmlspecialchars($row['status']); ?></td>
                        </tr>
                        <tr class="detailed-info-content">
                            <td colspan="6">
                                <div class="dropdown-content">
                                    <div class="dropdown-info">
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Nom producte:</label>
                                            <div class="product-info" contenteditable="false">
                                                <?= htmlspecialchars($row['name']); ?>
                                            </div>
                                        </div>
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Descripció breu:</label>
                                            <div class="product-info" contenteditable="false">
                                                <?= htmlspecialchars($row['short_description']); ?>
                                            </div>
                                        </div>
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Descripció extendida:</label>
                                            <div class="product-info" contenteditable="false">
                                                <?= htmlspecialchars($row['long_description']); ?>
                                            </div>
                                        </div>
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Preu inicial:</label>
                                            <div class="product-info" contenteditable="false">
                                                <?= htmlspecialchars($row['starting_price']); ?>
                                            </div>
                                        </div>
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Última puja:</label>
                                            <div class="product-info">
                                                <?= htmlspecialchars($row['starting_price']); ?> <!-- Aquí luego pongo last_bid cuando actualice la bbdd -->
                                            </div>
                                        </div>
                                        <div class="dropdown-info-field">
                                            <label class="panel-label">Observacions:</label>
                                            <div class="product-info" contenteditable="false">
                                                <?= htmlspecialchars($row['observations']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <img src="<?= htmlspecialchars($row['photo']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
                                </div>
                            </td>
                        </tr>
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