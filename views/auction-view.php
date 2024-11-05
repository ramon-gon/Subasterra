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

        <form method="GET" action="/controllers/auction-controller.php" class="filter-form">
            <label for="status">Filtrar per estat:</label>
            <select name="status" id="status">
                <option value="">Totes</option>
                <option value="oberta" <?= $status === 'oberta' ? 'selected' : '' ?>>Oberta</option>
                <option value="tancada" <?= $status === 'tancada' ? 'selected' : '' ?>>Tancada</option>
            </select>

            <label for="start_date">Data d'inici:</label>
            <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($startDate ?? '') ?>">

            <label for="end_date">Data de finalització:</label>
            <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($endDate ?? '') ?>">

            <button type="submit" class="apply-filters-btn">Aplicar filtres</button>
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
                                    <form method="POST" action="/controllers/auction-controller.php">
                                        <input type="hidden" name="auction-id" value="<?= $auction['id']; ?>">
                                        <input type="hidden" name="status" value="iniciada">
                                        <button class="accept-btn">Inicia subhasta</button>
                                    </form>
                                <?php elseif ($auction['status'] === 'iniciada'): ?>
                                    <form method="POST" action="/controllers/auction-controller.php">
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

    <?php include(__DIR__ . "/footer-view.php"); ?>
</body>
</html>
