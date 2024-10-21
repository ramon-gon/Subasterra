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
    <?php include(__DIR__ . "/header-view.php"); ?>
    
    <div class="container-auctions">
        <div class="current-auctions-header">
            <p class="title-category">Panell de Subhastador</p>
        </div>
        <div class="auction-gallery">
            <table hidden id="new-auction">
            <button type="submit" name="new-auction-button" value="create" id="new-auction-button" class="btn accept">Nova subasta</button>
            <thead>
                <tr>
                    <th colspan="7">Nova subhasta</th>
                </tr>
            </thead>
            <tbody>
                <form method="POST" action="/controllers/auctioner-panel-controller.php">
                <input type="hidden" name="form-type" value="create-auction">
                <tr>
                    <th>Descripció</th>
                    <th colspan="6"><input type="text" name="auction-description"></th>
                </tr>
                <tr>
                    <th>Data i hora</th>
                    <th colspan="6"><input type="datetime-local" name="auction-date"></th>
                </tr>
                <button hidden type="submit" name="auction-create" value="create" id="auction-create" class="btn accept">Crea subasta</button>
                </form>
            </tbody>
            </table>        
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
                                <input type="hidden" name="form-type" value="product-assignment">
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
                                    <button name="action" class="btn accept" type="submit" value="accept">Acceptar</button>
                                    <button name="action" class="btn accept" type="submit" value="accept">Rebutjar</button>
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

    <?php include(__DIR__ . "/footer-view.php"); ?>

</body>
</html>

<script src="../scripts/dropdown-tables.js"></script>
<script src="../scripts/switch-tables.js"></script>