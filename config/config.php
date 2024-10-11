<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "subasterra";

// Crear la connexió
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprovar la connexió
if ($conn->connect_error) {
    die("Connexió fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");