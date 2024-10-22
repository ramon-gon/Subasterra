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
    
        <!-- Formulario de filtros -->
        <form method="GET" action="auction-controller.php" class="filter-form">
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

            <button type="submit" class="apply-filters-btn">Aplicar filtres</button>
        </form>

        <!-- Resultados de subastas -->
        <table id="auctions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Descripció</th>
                    <th>Producte</th>
                    <th>Estat</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($auctions->num_rows > 0): ?>
                    <?php while ($auction = $auctions->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($auction['id']); ?></td>
                            <td><?php echo htmlspecialchars($auction['auction_date']); ?></td>
                            <td><?php echo htmlspecialchars($auction['description']); ?></td>
                            <td><?php echo htmlspecialchars($auction['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($auction['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
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
