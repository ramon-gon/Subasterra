<?php
include(__DIR__ . "/../config/config.php");
require_once(__DIR__ . "/session-controller.php");

lazy_session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    if ($username && $password) {
        $check_credentials = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $check_credentials->bind_param("ss", $username, $password);
        $check_credentials->execute();
        
        $result = $check_credentials->get_result();
        $user_data = $result->fetch_object();
        $check_credentials->close();

        if ($user_data) {
            $_SESSION["id"] = $user_data->id;
            $_SESSION["username"] = $user_data->username;
            $_SESSION["role"] = $user_data->role;

            header("Location: /index.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'L\'usuari i/o la contrasenya són incorrectes';
        }
    } else {
        $_SESSION['login_error'] = 'Introdueix un usuari i una contrasenya';
    }

    header("Location: /views/login-view.php");
    exit();
}
?>
