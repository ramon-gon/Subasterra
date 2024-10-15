<?php
session_start(); // Asegúrate de que la sesión se inicie aquí

if (!empty($_POST["login-button"])) {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) { 
        $user = $_POST["username"];
        $pass = $_POST["password"];

        // Preparar la consulta para verificar las credenciales
        $check_credentials = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $check_credentials->bind_param("ss", $user, $pass);
        $check_credentials->execute();

        // Obtener el resultado
        $result = $check_credentials->get_result();
        $user_data = $result->fetch_object();

        if ($user_data) {
            // Almacenar la información del usuario en la sesión
            $_SESSION["id"] = $user_data->id;
            $_SESSION["username"] = $user_data->username;
            $_SESSION["userRole"] = $user_data->role; // Almacenar el rol en la sesión

            // Redirigir al usuario a la página principal
            header("Location: /index.php");
            exit();
        } else {
            echo "ACCESO DENEGADO";
        }

        $check_credentials->close(); 
    } else {
        echo "Los campos están vacíos";
    }
}
