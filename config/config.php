<?php
$servername = "localhost:1234"; // Vagrant fa port forwarding (MariaDB) al port 1234
$username = "subasterra";
$password = "subasterra1234!";
$dbname = "subasterra";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connexió fallida: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    error_log($e->getMessage());
    echo "Hi ha hagut un error amb la connexió. Si us plau, torna-ho a intentar més tard.";
}
