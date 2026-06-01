<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=barber_hub;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $hash = password_hash('Hub2026', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('UPDATE usuarios SET password = ? WHERE rol_id <= 2');
    $stmt->execute([$hash]);
    echo "Contraseña restablecida correctamente.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
