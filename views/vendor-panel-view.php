<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell de Venedor</title>
    <link rel="stylesheet" href="/../css/auctioner-vendor-panel.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <?php include(__DIR__ . "/header-view.php"); ?>

    <div class="container-auctions">
        <div class="auction-gallery">
        <button class="add-btn" onclick="window.location.href='/controllers/form-product-controller.php'">
            <img src="/images/add-icon.svg" alt="add-icon" class="add-icon">
            <span class="button-text">Afegir producte</span>
        </button>
            <table id="vendor-panel">
                <thead>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Nom producte</th>
                        <th>Descripció</th>
                        <th>Preu sortida</th>
                        <th>Estat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products->num_rows > 0): ?>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <tr class="short-info-dropdown">
                                <td id="icon-td">
                                    <div class="arrow-icon">
                                        <img src="/images/arrow-right.svg" alt="add-icon">
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['short_description'] ?? ''); ?></td>
                                <td><?= number_format($row['starting_price'], 2); ?></td>
                                <td><div class="status" value="<?= htmlspecialchars($row['status']); ?>"></td>
                            </tr>
                            <tr class="detailed-info-content">
                                <td colspan="7">
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
                                                <label class="panel-label">Observacions:</label>
                                                <div class="product-info" contenteditable="false">
                                                    <?= htmlspecialchars($row['observations']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <img src="<?= htmlspecialchars($row['photo']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
                                    </div>
                                    <div class="dropdown-buttons">
                                         <!-- Botón para retirar producto -->
                                        <?php if (in_array($row['status'], ['pendent', 'rebutjat', 'pendent d’assignació a una subhasta', 'assignat a una subhasta'])): ?>
                                            <form method="POST" action="/controllers/vendor-panel-controller.php">
                                                <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                                                <button type="submit" name="action" value="retire" class="retire-btn">Retirar producte</button>
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
</body>
</html>

<script src="../scripts/dropdown-tables.js"></script>
