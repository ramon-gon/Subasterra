<?php
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afegir producte</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <header id="header">
        <p id="logo">Subasterra</p>
    </header>

    <div class="container-auctions">

        <div class="current-auctions-header">
            <p class="title-category">Afegir Producte</p>
        </div>

        <form action="/../controllers/form-product-controller.php" method="post" enctype="multipart/form-data" id="product-form">
            <div class="form-group">
                <label for="name">Nom del producte:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="short_description">Descripció curta:</label>
                <textarea name="short_description" id="short_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="long_description">Descripció llarga:</label>
                <textarea name="long_description" id="long_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="observations">Observacions:</label>
                <textarea name="observations" id="observations"></textarea>
            </div>
            <div class="form-group">
                <label for="starting_price">Preu de sortida (€):</label>
                <input type="number" step="0.01" name="starting_price" id="starting_price" required>
            </div>
            <div class="form-group">
                <label for="photo">Imatge del producte:</label>
                <input type="file" name="photo" id="photo" accept="image/*" required>
            </div>
            <input type="submit" value="Afegir Producte" class="btn" id="submit-btn">
        </form>
    </div>

    <footer id="footer-content">
        <p>Roger Ortiz Leal | Ramón González Guix | Ismael Benítez Martínez © All Rights Reserved</p>
    </footer>
</body>
</html>