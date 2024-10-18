<?php session_start(); ?>

<link rel="stylesheet" href="<?= '/css/header.css'; ?>">

<header>
    <p id="logo"><a href="/">Subasterra</a></p>
    <div class="navbar">
        <ul id="navbar">
            <li><a href="/">Llista de productes</a></li>
            <li><a href="/controllers/auctioner-panel-controller.php">Panell de subhastador</a></li>
        </ul>
        <div class="user-menu">
            <div class="avatar" onclick="obreDropDownUsuari()">
                <img src="<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '/images/avatar.svg'; ?>" alt="Avatar usuari">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="username"><?= htmlspecialchars($_SESSION['username']); ?></span>
                <?php endif; ?>
            </div>
            <div id="user-dropdown" class="dropdown-content">
                <?php if (!isset($_SESSION['role'])): ?>
                    <a href="/views/login-view.php">Iniciar sessió</a>
                <?php else: ?>
                    <a href="/profile.php">Perfil</a>
                    <a href="/controllers/logout-controller.php">Tancar sessió</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    window.onload = function() {
        function mostraPaginaActiva() {
            var currentPath = window.location.pathname;
            var navbar = document.getElementById('navbar');
            var links = navbar.getElementsByTagName('a');

            for (var i = 0; i < links.length; i++) {
                var linkPath = links[i].getAttribute('href');

                if (currentPath === linkPath) {
                    links[i].parentElement.classList.add('actual-page');
                }
            }
        }

        mostraPaginaActiva();
    };

    function obreDropDownUsuari() {
        document.getElementById("user-dropdown").classList.toggle("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('.avatar img')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
