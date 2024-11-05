<?php
require_once(__DIR__ . '/../controllers/session-controller.php');
require_once(__DIR__ . '/../models/notifications-model.php');
lazy_session_start();

$notificationsModel = new NotificationsModel($dbConnection);
$notifications = isset($_SESSION['id']) ? $notificationsModel->getNotifications($_SESSION['id']) : [];
$notificationCount = isset($_SESSION['id']) ? $notificationsModel->getUnreadNotificationCount($_SESSION['id']) : 0;
$role = $_SESSION['role'] ?? null;
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
        <div class="user-section">
            <?php if (isset($_SESSION['role'])): ?>
                <div class="notifications" onclick="toggleNotificationsDropdown()">
                    <img src="/images/notification.svg" alt="Notifications" class="notification-icon">
                    <?php if ($notificationCount > 0): ?>
                        <span id="notification-count" class="notification-count"><?= $notificationCount; ?></span>
                    <?php endif; ?>
                </div>

                <div id="notification-dropdown" class="notification-dropdown-content">
                    <?php if (count($notifications) > 0): ?>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification <?= $notification['is_read'] ? 'read' : 'unread'; ?>">
                                <div class="notification-body">
                                    <strong><?= htmlspecialchars($notification['sender_username']); ?>:</strong>
                                    <p><?= htmlspecialchars($notification['message']); ?></p>
                                </div>
                                <div class="notification-actions">
                                    <?php if (!$notification['is_read']): ?>
                                        <form method="POST" action="/controllers/notification-controller.php">
                                            <input type="hidden" name="notification_id" value="<?= $notification['id']; ?>">
                                            <input type="hidden" name="action" value="mark">
                                            <button type="submit">Marcar com a llegit</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" action="/controllers/notification-controller.php">
                                        <input type="hidden" name="notification_id" value="<?= $notification['id']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="delete-btn">Esborrar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No tens cap notificació.</p>
                    <?php endif; ?>
                </div>

                <div class="avatar" onclick="obreDropDownUsuari()">
                    <img src="<?= isset($_SESSION['avatar']) ? $_SESSION['avatar'] : '/images/avatar.svg'; ?>" alt="Avatar usuari">
                    <span class="username"><?= htmlspecialchars($_SESSION['username']); ?></span>
                </div>
                <div id="user-dropdown" class="user-dropdown-content">
                    <a href="/controllers/logout-controller.php">Tancar sessió</a>
                </div>
            <?php else: ?>
                <a href="/views/login-view.php" class="login-button">LOGIN</a>
            <?php endif; ?>
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
                if (linkPath === "/" && (currentPath === "/" || currentPath === "/index.php")) {
                    links[i].parentElement.classList.add('actual-page');
                } else if (currentPath === linkPath) {
                    links[i].parentElement.classList.add('actual-page');
                }
            }
        }

        mostraPaginaActiva();
    };

    function obreDropDownUsuari() {
        document.getElementById("user-dropdown").classList.toggle("show");
    }

    function toggleNotificationsDropdown() {
        document.getElementById("notification-dropdown").classList.toggle("show");
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

        if (!event.target.matches('.notification-icon')) {
            var dropdowns = document.getElementsByClassName("notification-dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
