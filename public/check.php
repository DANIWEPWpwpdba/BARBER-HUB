<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$pdo = new PDO('mysql:host=localhost;dbname=barber_hub', 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// Generar el hash para Hub2026
$hash = password_hash('Hub2026', PASSWORD_BCRYPT);

// Actualizar las contraseñas de los administradores a Hub2026 para que el usuario pueda entrar fácilmente
$pdo->query("UPDATE usuarios SET password = '{$hash}' WHERE rol_id IN (1, 2)");

echo "Contraseñas de los administradores actualizadas a Hub2026<br>";
