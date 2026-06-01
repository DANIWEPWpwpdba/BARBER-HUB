<?php
/**
 * Barber Hub - Semilla de Datos Maestros (Ejecutable desde navegador)
 */
require_once __DIR__ . '/../app/models/Model.php';
require_once __DIR__ . '/../app/models/User.php';

echo "<h2>Inicializando creación de usuarios maestros...</h2><br>";

$userModel = new User();

$creado1 = $userModel->createMasterUser(
    'Daniel Morales Ramírez',
    'dev1@barberhub.local',
    'admin123',
    1
);

$creado2 = $userModel->createMasterUser(
    'David Santos Galicia',
    'dev2@barberhub.local',
    'admin123',
    1
);

if ($creado1) echo "Usuario <b>dev1@barberhub.local</b> creado exitosamente.<br>";
else echo "Usuario <b>dev1@barberhub.local</b> ya existía.<br>";

if ($creado2) echo "Usuario <b>dev2@barberhub.local</b> creado exitosamente.<br>";
else echo "Usuario <b>dev2@barberhub.local</b> ya existía.<br>";

echo "<br><a href='./'>Volver al inicio (Login)</a>";
