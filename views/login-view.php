<?php
    require_once(__DIR__ . "/../controllers/session-controller.php");
    require_once(__DIR__ . "/../controllers/login-controller.php");
    lazy_session_start();

    $login_error = $_SESSION['login_error'] ?? '';
    unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subasterra - Iniciar sessió</title>
    <link rel="stylesheet" href="/../css/login.css" type="text/css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
    <div class="login-page">
        <div class="login-logo">
            <span class="logo">Subasterra</span>
        </div>
        <div class="login-panel">
            <form id="login-form" method="post" action="/controllers/login-controller.php">
                <div>    
                    <label class="login-label" for="username">Usuari</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label class="login-label" for="password">Contrasenya</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-login">INICIAR SESSIÓ</button>
                    <a href="/register" class="btn btn-register">REGISTRAR-SE</a>
                </div>

                <div id="error-message" class="error-message" style="<?= $login_error ? 'display: block;' : 'display: none;' ?>">
                    <?= htmlspecialchars($login_error); ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
