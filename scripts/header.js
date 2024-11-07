window.onload = function() {
    function mostraPaginaActiva() {
        var currentPath = window.location.pathname;
        var navbar = document.getElementById('navbar');
        var links = navbar.getElementsByTagName('a');

        for (var i = 0; i < links.length; i++) {
            var linkPath = links[i].getAttribute('href');
            if (linkPath === "/" && (currentPath === "/" || currentPath === "/index.php")
                || (linkPath === "/views/auctioner-panel-view.php" && currentPath === "/controllers/auctioner-panel-controller.php")
            ) {
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
