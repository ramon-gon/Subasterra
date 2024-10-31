<?php
    require_once(__DIR__ . '/../controllers/session-controller.php');
    lazy_session_start();

    unset($_SESSION['product_error']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subasterra - Afegir Producte</title>
    <link rel="stylesheet" href="/../css/add-product.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="add-product-page">
        <div class="product-preview">
            <label for="photo" id="image-upload-label">
                <div id="image-preview-container">
                    <img id="image-preview" src="#" alt="Preview de la imatge del producte" style="display: none;">
                    <div id="upload-instructions">
                        <img src="/images/upload.svg" alt="Upload icon" class="upload-icon">
                        <span>Afegeix una imatge</span>
                    </div>
                </div>
            </label>
            <input type="file" name="photo" id="photo" accept="image/*" required onchange="previewImage(event)" style="display: none;">
            <button id="remove-image-btn" type="button" onclick="removeImage()" style="display: none;" class="btn btn-remove">Eliminar imatge</button>
        </div>

        <div class="add-product-panel">
            <form id="product-form" method="post" action="/../controllers/form-product-controller.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="name">Nom del producte:<span class="required-asterisk">*</span></label>
                    <input type="text" name="name" id="name" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="short_description">Descripció curta:</label>
                    <textarea name="short_description" id="short_description"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="long_description">Descripció llarga:</label>
                    <textarea name="long_description" id="long_description"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="observations">Observacions:</label>
                    <textarea name="observations" id="observations"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="starting_price">Preu de sortida (€):<span class="required-asterisk">*</span></label>
                    <input type="number" step="0.01" name="starting_price" id="starting_price" required>
                </div>

                <?php if (!empty($_SESSION['product_error'])): ?>
                    <div id="error-message" class="error-message">
                        <?= htmlspecialchars($_SESSION['product_error']); ?>
                    </div>
                    <?php unset($_SESSION['product_error']); ?>
                <?php endif; ?>

                <button type="submit" class="btn">Afegir Producte</button>
            </form>
        </div>
    </div>
    
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const fileInput = document.getElementById('photo');
            const preview = document.getElementById('image-preview');
            const instructions = document.getElementById('upload-instructions');
            const removeButton = document.getElementById('remove-image-btn');
            const imagePreviewContainer = document.getElementById('image-preview-container');

            reader.onload = function() {
                preview.src = reader.result;
                preview.style.display = 'block';
                instructions.style.display = 'none';
                imagePreviewContainer.style.width = 'auto';
                removeButton.style.display = 'inline-block';
            };
            reader.readAsDataURL(event.target.files[0]) 
        }

        function removeImage() {
            const preview = document.getElementById('image-preview');
            const instructions = document.getElementById('upload-instructions');
            const removeButton = document.getElementById('remove-image-btn');
            const fileInput = document.getElementById('photo');
            const imagePreviewContainer = document.getElementById('image-preview-container');

            preview.src = '#';
            preview.style.display = 'none';
            imagePreviewContainer.style.width = '400px';
            instructions.style.display = 'flex';
            removeButton.style.display = 'none';
            fileInput.value = ''; // Bàsicament buidem el valor del input file.
        }
    </script>
    </body>
</html>
