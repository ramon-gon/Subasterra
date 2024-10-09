<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista de Productes</title>
    <style>
        .producte { margin-bottom: 20px; }
        .foto { width: 150px; height: auto; }
    </style>
</head>
<body>
    <h1>Llista de Productes</h1>
    <form method="GET" action="/index.php">
        <input type="text" name="search" placeholder="Cerca productes..." value="<?= htmlspecialchars($search); ?>">
        <select name="order">
            <option value="nom" <?= $order === 'nom' ? 'selected' : ''; ?>>Ordena per nom</option>
            <option value="preu_sortida" <?= $order === 'preu_sortida' ? 'selected' : ''; ?>>Ordena per preu</option>
        </select>
        <button type="submit">Cerca</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="producte">
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
</body>
</html>
