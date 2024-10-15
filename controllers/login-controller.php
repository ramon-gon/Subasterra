<?php
if (!empty($_POST["login-button"])) {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) { // Asegúrate de que ambos campos estén llenos
        $user = $_POST["username"];
        $pass = $_POST["password"];
        
        // Preparar la consulta
        $check_credentials = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $check_credentials->bind_param("ss", $user, $pass);
        $check_credentials->execute();

        // Obtener el resultado como objeto
        $result = $check_credentials->get_result();
        $user_data = $result->fetch_object(); // Aquí se obtiene el objeto

        if ($user_data) {
            $_SESSION["id"]=$user_data->id;
            $_SESSION["username"]=$user_data->username;
            $_SESSION["role"]=$user_data->role;
            header("location: /../index.php");
            exit();
        } else {
            echo "ACCESO DENEGADO";
        }

        $check_credentials->close(); 
    } else {
        echo "Los campos están vacíos";
    }
}
?>
