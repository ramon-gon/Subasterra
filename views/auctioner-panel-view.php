<?php
require_once(__DIR__ . '/../controllers/auctioner-panel-controller.php');
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panell de Subhastador</title>
    <link rel="stylesheet" href="/../css/auctioner-vendor-panel.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>

<body>
    <?php include(__DIR__ . "/header-view.php"); ?>
    
    <div class="container-auctions">
        <form id="filter-form" method="GET" action="">
            <div class="auction-gallery-header">
                    <div class="filter-div">
                        <label for="filter-status">Filtrar per estat:</label>
                        <select name="filter-status" id="filter-status">
                            <option value="">Tots els estats</option>
                            <option value="pendent">Pendent</option>
                            <option value="rebutjat">Rebutjat</option>
                            <option value="pendent d’assignació a una subhasta">Pendent d’assignació a una subhasta</option>
                            <option value="assignat a una subhasta">Assignat a una subhasta</option>
                            <option value="pendent_adjudicacio">Pendent d'adjudicació</option>
                            <option value="venut">Venut</option>
                            <option value="retirat">Retirat</option>
                        </select>

                        <label for="order-price">Ordenar per preu:</label>
                        <select name="order-price" id="order-price">
                            <option value=""></option>
                            <option value="asc">Ascendent</option>
                            <option value="desc">Descendent</option>
                        </select>
                    </div>

                    <div id="filter-btn-div">
                        <button id="filter-btn" type="submit">Aplicar filtres</button>
                    </div>

                <button type="button" name="new-auction-button" value="create" id="new-auction-button" class="add-btn">
                    <img src="/images/add-icon.svg" alt="add-icon" class="add-icon">
                    <span class="button-text">Nova subasta</span>
                </button>
            </div>
        </form>

        <div class="auction-gallery">

            <table hidden id="new-auction">
                <thead>
                    <tr>
                        <th colspan="7">Nova Subhasta</th>
                    </tr>
                </thead>
                <form method="POST" action="/controllers/auctioner-panel-controller.php">
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
                                    <?php if (count($productsauction) > 0): ?>
                                        <?php foreach ($productsauction as $row): ?>
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

            <table id="auctioneer-panel">
                <thead>
                    <tr>
                        <th></th>
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
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $row): ?>
                        <form method="POST" action="/controllers/auctioner-panel-controller.php">
                            <tr class="short-info-dropdown">
                                <td id="icon-td">
                                    <div class="arrow-icon">
                                        <img src="/images/arrow-right.svg" alt="add-icon">
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['user_id']); ?></td>
                                <td><?= htmlspecialchars($row['username']); ?></td>
                                <td><?= htmlspecialchars($row['id']); ?></td>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['short_description']); ?></td>
                                <td><?= number_format($row['starting_price'], 2); ?></td>
                                <td><div class="status" value="<?= htmlspecialchars($row['status']); ?>"></td>
                                <input type="hidden" name="form-type" value="product-assignment">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['id']); ?>">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']); ?>">
                            </tr>
                            <tr class="detailed-info-content">
                                <td colspan="8">
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
                                    <?php if (in_array($row['status'], ['pendent'])): ?>
                                    <div class="dropdown-buttons">
                                        <button name="action" class="accept-btn" id="accept-btn" type="submit" value="accept">Acceptar</button>
                                        <button name="action" class="deny-btn" type="submit" value="reject">Rebutjar</button>
                                        <button name="action" class="assign-btn" type="button">Acceptar i assignar</button>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (in_array($row['status'], ['pendent d’assignació a una subhasta'])): ?>
                                    <div class="dropdown-buttons">
                                        <button name="action" class="assign-btn" type="button">Assignar subhasta</button>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (in_array($row['status'], ['assignat a una subhasta'])): ?>
                                    <div class="dropdown-buttons">
                                        <button name="action" value="unassign" class="retire-btn" type="submit">Desassignar subhasta</button>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <div class="modal" id="auction-modal-confirm">
                                <div class="modal-content">
                                    <span class="close" id="close-modal">&times;</span>
                                    <h1>Assigna a una subhasta activa</h1>
                                    <?php if ($auctions->num_rows > 0): ?>
                                        <select name="auction-select">
                                            <?php foreach ($auctions as $auction): ?>
                                                <option value="<?= htmlspecialchars($auction['id']); ?>">
                                                    <?= htmlspecialchars($auction['description']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>          
                                        <button name="action" class="accept-btn" type="submit" value="accept-and-assign">Acceptar</button>
                                        <button name="action" class="deny-btn" id="not-assign" type="button">Rebutjar</button>
                                    <?php else: ?>
                                        <p>No hi ha subhastes disponibles amb els filtres seleccionats.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
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
<script src="../scripts/product-selection.js"></script>
<script src="../scripts/modal.js"></script>
