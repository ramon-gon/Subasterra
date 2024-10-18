<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

include(__DIR__ . "/../config/config.php");
include(__DIR__ . "/../models/products-model.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $short_description = $_POST['short_description'] ?? '';
    $long_description = $_POST['long_description'] ?? '';
    $observations = $_POST['observations'] ?? '';
    $starting_price = $_POST['starting_price'] ?? 0;
    $user_id = $_SESSION['id'];

    // Verificar si se ha subido una imagen
    if (!empty($_FILES['photo']['name'])) {
        $target_dir = __DIR__ . "/../images/";
        $photo_name = basename($_FILES['photo']['name']);
        $target_file = $target_dir . $photo_name;
        $uploadOk = true;

        // Comprobar si el archivo es una imagen
        $check = getimagesize($_FILES['photo']['tmp_name']);
        if ($check === false) {
            $message = "El archivo no es una imagen válida.";
            $uploadOk = false;
        }

        // Comprobar si la imagen ya existe
        if (file_exists($target_file)) {
            $message = "La imagen ya existe. Por favor, renombra el archivo.";
            $uploadOk = false;
        }

        // Verificar el tamaño del archivo (máximo 5MB)
        if ($_FILES['photo']['size'] > 5000000) {
            $message = "La imagen es demasiado grande (máximo 5MB).";
            $uploadOk = false;
        }

        // Tipos de archivo permitidos
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $message = "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
            $uploadOk = false;
        }

        // Si todo está bien, mover el archivo subido a la carpeta de destino
        if ($uploadOk && move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $photo_path = "/../images/" . $photo_name;

            // Crear instancia del modelo y añadir el producto
            $product = new ProductModel($conn);
            if ($product->addProduct($name, $short_description, $long_description, $observations, $starting_price, $photo_path, $user_id)) {
                $message = "Producte afegit correctament.";
            } else {
                $message = "Error en afegir el producte.";
            }
        } else {
            $message = $message ?: "Error en pujar la imatge.";
        }
    } else {
        $message = "Per favor, selecciona una imatge per al producte.";
    }
}

// Passar les dades a la vista
include_once __DIR__ . '/../views/add-product-view.php';

