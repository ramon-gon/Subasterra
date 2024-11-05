<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'subasterra');
define('DB_USER', 'subasterra');
define('DB_PASS', 'subasterra1234!');

try {
    $dbConnection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error de connexió a la base de dades: ' . $e->getMessage();
    exit;
}

require_once __DIR__ . '/autoload.php';
?>