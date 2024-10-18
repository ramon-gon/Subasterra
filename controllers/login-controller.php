<?php
require_once(__DIR__ . "/session-controller.php");
lazy_session_start();

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

        $check_credentials->close();

        if ($user_data) {
            // Almacenar la información del usuario en la sesión
            $_SESSION["id"] = $user_data->id;
            $_SESSION["username"] = $user_data->username;
            $_SESSION["role"] = $user_data->role;

            // Redirigir al usuario a la página principal
            header("Location: /index.php");
            exit(); 
        } else {
            
            $_SESSION['login_error'] = 'Acceso denegado';
            header("Location: /views/login-view.php");
            exit(); 
        }
    } else {
        
        $_SESSION['login_error'] = 'Los campos están vacíos';
        header("Location: /views/login-view.php");
        exit();
    }
}
