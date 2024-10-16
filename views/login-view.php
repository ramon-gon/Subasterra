<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subasterra - Iniciar sessió</title>
    <link rel="stylesheet" href="/../css/styles.css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="login-page">
        <div class="login-panel">

            <form id="login-form" method="post" action="">
                <?php
                include(__DIR__ . "/../config/config.php");
                include(__DIR__ . "/../controllers/login-controller.php");
                ?>  
                <div>    
                    <label class="login-label" for="username">Usuari:</label>
                    <input type="text" id="username" name="username">
                </div>
                <div>
                    <label class="login-label" for="password">Contrasenya:</label>
                    <input type="password" id="password" name="password">
                </div>
                <input name="login-button" class="btn" type="submit" value="INICIAR SESIÓN">
            </form>
        </div>
    </div>
</body>
</html>