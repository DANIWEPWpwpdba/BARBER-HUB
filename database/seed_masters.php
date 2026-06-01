<?php
/**
 * Barber Hub - Semilla de Datos Maestros
 * Ejecutar este archivo directamente desde CLI o el navegador para crear los usuarios maestros.
 */
require_once __DIR__ . '/../app/models/Model.php';
require_once __DIR__ . '/../app/models/User.php';

echo "Inicializando creación de usuarios maestros...\n";

$userModel = new User();

// Asumiendo que el ID de rol 'Super Administrador' o 'Desarrollador' es 1 y 2 en la BD.
// Según schema.sql: 1=Super Admin, 2=Desarrollador. Les daremos a ambos Rol 1 (Acceso total absoluto).

$creado1 = $userModel->createMasterUser(
    'Daniel Morales Ramírez',
    'dev1@barberhub.local',
    'admin123', // Contraseña por defecto para pruebas
    1
);

$creado2 = $userModel->createMasterUser(
    'David Santos Galicia',
    'dev2@barberhub.local',
    'admin123', // Contraseña por defecto para pruebas
    1
);

if ($creado1) echo "Usuario dev1@barberhub.local creado exitosamente.\n";
else echo "Usuario dev1@barberhub.local ya existía.\n";

if ($creado2) echo "Usuario dev2@barberhub.local creado exitosamente.\n";
else echo "Usuario dev2@barberhub.local ya existía.\n";

echo "Proceso finalizado.\n";
