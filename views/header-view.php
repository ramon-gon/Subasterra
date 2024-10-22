<?php
    require_once(__DIR__ . '/../controllers/session-controller.php');
    lazy_session_start();    
?>

<link rel="stylesheet" href="<?= '/css/header.css'; ?>">

<header>
    <div class="logo-search">
        <p id="logo"><a href="/">Subasterra</a></p>
        <?php if (basename($_SERVER['PHP_SELF']) === 'index.php' || $_SERVER['REQUEST_URI'] === '/'): ?>
            <form id="search" method="GET" action="/index.php" class="header-search-form">
                <input type="text" name="search" placeholder="Cerca productes..." value="<?= htmlspecialchars($search ?? ''); ?>" class="search-input">
                <select name="order" class="search-select">
                    <option value="name" <?= (isset($order) && $order === 'name') ? 'selected' : ''; ?>>Ordena per nom</option>
                    <option value="starting_price" <?= (isset($order) && $order === 'starting_price') ? 'selected' : ''; ?>>Ordena per preu</option>
                </select>
                <button type="submit" class="btn search-btn">
                    <img src="/images/search.svg" alt="Search" class="search-icon">
                </button>
            </form>
        <?php endif; ?>
    </div>
    <div class="navbar">
        <ul id="navbar">
            <li><a href="/">Llista de productes</a></li>
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] === 'subhastador'): ?>
                    <li><a href="/controllers/auctioner-panel-controller.php">Panell de subhastador</a></li>
                <?php elseif ($_SESSION['role'] === 'venedor'): ?>
                    <li><a href="/controllers/vendor-panel-controller.php">Panell de venedor</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
        <div class="user-menu">
            <div class="avatar" onclick="obreDropDownUsuari()">
                <img src="<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '/images/avatar.svg'; ?>" alt="Avatar usuari">
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="username"><?= htmlspecialchars($_SESSION['username']); ?></span>
                <?php endif; ?>
            </div>
            <div id="user-dropdown" class="user-dropdown-content">
                <?php if (!isset($_SESSION['role'])): ?>
                    <a href="/views/login-view.php">Iniciar sessió</a>
                <?php else: ?>
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
