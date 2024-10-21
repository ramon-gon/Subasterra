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
    <?php include(__DIR__ . "/header-view.php"); ?>

    <div class="container-auctions">

        <div class="current-auctions-header">
            <p class="title-category">Panell de Venedor</p>
        </div>
        <div class="auction-gallery">
        <button class="btn-panel" onclick="window.location.href='/controllers/form-product-controller.php'">
            Afegir producte
        </button>
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

                                        <!-- Botón para retirar producto -->
                                        <?php if (in_array($row['status'], ['pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta'])): ?>
                                            <form method="POST" action="/controllers/vendor-panel-controller.php">
                                                <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                                <button type="submit" name="action" value="retire" class="btn retire">Retirar producte</button>
                                            </form>

                                        <?php endif; ?>
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

    <?php include(__DIR__ . "/footer-view.php"); ?>

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