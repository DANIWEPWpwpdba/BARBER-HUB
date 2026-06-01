<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=barber_hub;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->query("SELECT id, nombre_comercial FROM barberias");
    while($row = $stmt->fetch()) {
        echo $row['id'] . " - " . $row['nombre_comercial'] . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
