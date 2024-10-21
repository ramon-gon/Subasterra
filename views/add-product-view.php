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
        <button class="btn-panel" onclick="window.location.href='/controllers/vendor-panel-controller.php'">
            Panell Venedor
        </button>
    </header>

    <div class="container-auctions">

        <div class="current-auctions-header">
            <p class="title-category">Afegir Producte</p>
        </div>

        <form action="/../controllers/form-product-controller.php" method="post" enctype="multipart/form-data" id="product-form">
            <div class="form-group">
                <label for="name">Nom del producte:<span class="required-asterisk">*</span></label>
                <input type="text" name="name" id="name" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="short_description">Descripció curta:</label>
                <textarea name="short_description" id="short_description"></textarea>
            </div>
            <div class="form-group">
                <label for="long_description">Descripció llarga:</label>
                <textarea name="long_description" id="long_description"></textarea>
            </div>
            <div class="form-group">
                <label for="observations">Observacions:</label>
                <textarea name="observations" id="observations"></textarea>
            </div>
            <div class="form-group">
                <label for="starting_price">Preu de sortida (€):<span class="required-asterisk">*</span></label>
                <input type="number" step="0.01" name="starting_price" id="starting_price" required>
            </div>
            <div class="form-group">
                <label for="photo">Imatge del producte:<span class="required-asterisk">*</span></label>
                <input type="file" name="photo" id="photo" accept="image/*" required>
            </div>
            <input type="submit" value="Afegir Producte" class="btn" id="submit-btn">
        </form>
    </div>

    <?php include(__DIR__ . "/footer-view.php"); ?>
</body>

</html>
