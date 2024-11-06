<?php
require_once(__DIR__ . '/../controllers/auction-controller.php');
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subhastes</title>
    <link rel="stylesheet" href="/../css/auctioner-vendor-panel.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <?php include(__DIR__ . "/header-view.php"); ?>


    <div class="container-auctions">

        <div class="selector-menu-auctioneer">
            <button type="button" id="select-products">Productes</button>
            <button type="button" id="select-auctions">Subhastes</button>
        </div>

        <div id="auctions-menu">
            <form method="GET" action="" class="filter-form">
                <input type="hidden" name="form-type" value="filter-auctions">
                <input type="hidden" name="menu" value="auctions">
                    <div class="auction-gallery-header">
                        <div class="filter-div">
                        <label for="status">Filtrar per estat:</label>
                        <select name="status" id="status">
                            <option value="">Totes</option>
                            <option value="oberta">Oberta</option>
                            <option value="tancada">Tancada</option>
                        </select>

                        <label for="start_date">Data d'inici:</label>
                        <input type="date" name="start_date" id="start_date">

                        <label for="end_date">Data de finalització:</label>
                        <input type="date" name="end_date" id="end_date">

                        <div id="filter-btn-div">
                            <button class="filter-btn" type="submit">Aplicar filtres</button>
                        </div>
                    </div>

                    <button type="button" name="new-auction-button" value="create" id="new-auction-button" class="add-btn">
                        <img src="/images/add-icon.svg" alt="add-icon" class="add-icon">
                        <span class="button-text">Nova subhasta</span>
                    </button>

                </div>
            </form>

            <table id="auctions-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Descripció</th>
                        <th>Productes</th>
                        <th colspan="3">Estat</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($auctions)): ?>
                    <?php foreach ($auctions as $auction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($auction['id'] ?? ''); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($auction['auction_date'])); ?></td>
                                <td><?php echo htmlspecialchars($auction['description'] ?? ''); ?></td>
                                <td><?php echo !empty($auction['product_names']) ? htmlspecialchars($auction['product_names']) : 'No hi ha productes'; ?></td>
                                <td><?php echo htmlspecialchars($auction['status'] ?? ''); ?></td>
                                <td>
                                    <?php if ($auction['status'] === 'oberta'): ?>
                                        <form method="POST" action="/controllers/auctioner-panel-controller.php">
                                            <input type="hidden" name="form-type" value="update-auction">
                                            <input type="hidden" name="auction-id" value="<?= $auction['id']; ?>">
                                            <input type="hidden" name="status" value="iniciada">
                                            <button class="accept-btn">Inicia subhasta</button>
                                        </form>
                                    <?php elseif ($auction['status'] === 'iniciada'): ?>
                                        <form method="POST" action="/controllers/auctioner-panel-controller.php">
                                            <input type="hidden" name="form-type" value="update-auction">
                                            <input type="hidden" name="auction-id" value="<?= $auction['id']; ?>">
                                            <input type="hidden" name="status" value="tancada">
                                            <button class="deny-btn">Tanca subhasta</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No hi ha subhastes disponibles amb els filtres seleccionats.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div id="new-auction-menu">
            <form method="POST" action="/controllers/auctioner-panel-controller.php">
                <table id="new-auction">
                    <thead>
                        <tr>
                            <th colspan="7">Nova Subhasta</th>
                        </tr>
                    </thead>
                        <tbody>
                            <input type="hidden" name="form-type" value="create-auction">
                            <tr>
                                <th>Descripció</th>
                                <th colspan="6"><input type="text" name="auction-description" required></th>
                            </tr>
                            <tr>
                                <th>Data i hora</th>
                                <th colspan="6"><input type="datetime-local" name="auction-date" required></th>
                            </tr>
                            <tr>
                                <th>Percentatge</th>
                                <th colspan="6"><input type="number" min="1" max="100" name="auction-percentage" required value="10"></th>
                            </tr>
                            <tr>
                                <th>Selecciona productes</th>
                                <th colspan="6">
                                    <div class="product-selection">
                                        <select id="available_products" multiple size="5">
                                            <?php if (count($productsAuction) > 0): ?>
                                                <?php foreach ($productsAuction as $row): ?>
                                                    <option value="<?= htmlspecialchars($row['id']); ?>">
                                                        <?= htmlspecialchars($row['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <option disabled>No hi ha productes disponibles</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="selection-buttons">
                                            <button type="button" id="add_product">Agregar</button>
                                            <button type="button" id="remove_product">Quitar</button>
                                        </div>
                                        <select name="product_ids[]" id="selected_products" multiple size="5"></select>
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <button hidden type="submit" name="auction-create" value="create" id="auction-create" class="create-btn">Crea subasta</button>
                </form>
        </div>
    </div>

    <?php include(__DIR__ . "/footer-view.php"); ?>
</body>
</html>
