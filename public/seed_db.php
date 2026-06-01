<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('max_execution_time', 1200); 
ini_set('memory_limit', '2048M');

try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=barber_hub;charset=utf8mb4", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $tablas = ['resenas', 'pagos', 'citas', 'productos', 'proveedores', 'servicios', 'barberos', 'clientes', 'sucursales', 'barberias', 'auditoria'];
    foreach ($tablas as $t) $pdo->exec("TRUNCATE TABLE {$t};");
    $pdo->exec("DELETE FROM usuarios WHERE rol_id > 2;");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

    $imagenes = [
        'http://localhost/barber_hub/public/assets/img/hero_barber_1780262216201.png',
        'http://localhost/barber_hub/public/assets/img/shop_modern_1780262229137.png',
        'http://localhost/barber_hub/public/assets/img/shop_vintage_1780262306705.png'
    ];

    $sucursales_nombres = ['Polanco', 'Condesa', 'Roma Norte', 'Santa Fe', 'Coyoacán', 'Del Valle', 'Napoles', 'Angelópolis', 'Cholula', 'La Paz', 'Zavaleta', 'Sonata', 'San Pedro', 'Valle Oriente', 'San Jerónimo', 'Cumbres', 'Mitras', 'Providencia', 'Puerta de Hierro', 'Chapultepec', 'Andares', 'Zona Hotelera', 'Puerto Cancun', 'Juriquilla', 'Centro Histórico', 'Altabrisa', 'Montebello', 'Zona Río', 'Playas', 'Campestre'];
    $ciudades = ['CDMX','CDMX','CDMX','CDMX','CDMX','CDMX','CDMX', 'Puebla','Puebla','Puebla','Puebla','Puebla', 'Monterrey','Monterrey','Monterrey','Monterrey','Monterrey', 'Guadalajara','Guadalajara','Guadalajara','Guadalajara', 'Cancún','Cancún', 'Querétaro','Querétaro', 'Mérida','Mérida', 'Tijuana','Tijuana', 'León'];
    
    $barberias_ids = [];
    $stmtBarb = $pdo->prepare("INSERT INTO barberias (nombre_comercial, portada, descripcion, telefono, estado_ubicacion, ciudad, calle, codigo_postal, estado) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmtSucursal = $pdo->prepare("INSERT INTO sucursales (barberia_id, nombre, direccion, telefono) VALUES (?,?,?,?)");
    
    $num_sucursales = 30;

    for ($i = 0; $i < $num_sucursales; $i++) {
        $nombre = "Barber Hub " . $sucursales_nombres[$i];
        $ciudad = $ciudades[$i];
        $desc = "Exclusiva sucursal en $ciudad ofreciendo cortes profesionales.";
        $img = $imagenes[array_rand($imagenes)];
        
        $stmtBarb->execute([$nombre, $img, $desc, '22212345' . sprintf('%02d', $i), $ciudad, $ciudad, "Av. Principal #".mt_rand(100,9999), '72000', 'Activa']);
        $b_id = $pdo->lastInsertId();
        $barberias_ids[] = $b_id;
        
        $stmtSucursal->execute([$b_id, 'Sucursal ' . $nombre, 'Misma Direccion', '22212345' . sprintf('%02d', $i)]);
    }

    $hash = password_hash('Hub2026', PASSWORD_BCRYPT);
    $stmtUser = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password, telefono, rol_id, estado, barberia_id) VALUES (?,?,?,?,?,?,?)");
    
    $nombres_barberos = ['Carlos', 'Miguel', 'José', 'Luis', 'David', 'Jorge', 'Fernando', 'Roberto', 'Diego', 'Andrés', 'Hugo', 'Marco', 'Pablo', 'Omar', 'Ivan', 'Arturo', 'Kevin', 'Bryan', 'Javier', 'Raúl'];
    $apellidos = ['García', 'López', 'Pérez', 'González', 'Sánchez', 'Martínez', 'Ramírez', 'Gómez', 'Díaz', 'Cruz'];
    
    $barberos_data = []; 
    $servicios_data = [];
    $stmtBarbero = $pdo->prepare("INSERT INTO barberos (usuario_id, barberia_id, anios_experiencia) VALUES (?,?,?)");
    $stmtServicio = $pdo->prepare("INSERT INTO servicios (barberia_id, nombre, duracion_minutos, precio) VALUES (?,?,?,?)");

    $c = 1;
    $srv_demo = [
        ['Corte Clásico', 150.00, 30], ['Fade', 180.00, 45], ['Barba VIP', 280.00, 60]
    ];

    for ($i=0; $i<$num_sucursales; $i++) {
        $b_id = $barberias_ids[$i];
        $num = $i + 1;
        
        $stmtUser->execute(["Propietario " . $sucursales_nombres[$i], "prop{$num}@demo.com", $hash, "555000".sprintf('%02d', $num), 3, 'Activo', $b_id]);
        $stmtUser->execute(["Recep A " . $sucursales_nombres[$i], "recA{$num}@demo.com", $hash, "555100".sprintf('%02d', $num), 4, 'Activo', $b_id]);

        foreach($srv_demo as $s) {
            $stmtServicio->execute([$b_id, $s[0], $s[2], $s[1]]);
            $servicios_data[] = ['id' => $pdo->lastInsertId(), 'b_id' => $b_id, 'precio' => $s[1], 'duracion' => $s[2]];
        }
        
        for ($j = 0; $j < 8; $j++) { 
            $nom = $nombres_barberos[array_rand($nombres_barberos)] . ' ' . $apellidos[array_rand($apellidos)];
            $stmtUser->execute([$nom, "barbero{$c}@demo.com", $hash, "555300".sprintf('%03d', $c), 5, 'Activo', $b_id]);
            $u_id = $pdo->lastInsertId();
            $stmtBarbero->execute([$u_id, $b_id, mt_rand(1, 15)]);
            $barberos_data[] = ['id' => $pdo->lastInsertId(), 'b_id' => $b_id];
            $c++;
        }
    }

    $nombres_clientes = ['Alejandro', 'Daniel', 'Mateo', 'Leonardo', 'Emiliano', 'Santiago', 'Sebastián', 'Matías', 'Juan', 'Nicolás'];
    $clientes_data = [];
    $stmtUserCliente = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password, telefono, rol_id, estado) VALUES (?,?,?,?,?,?)");
    $stmtCliente = $pdo->prepare("INSERT INTO clientes (usuario_id, puntos_acumulados, nivel) VALUES (?,?,?)");
    
    for ($i = 1; $i <= 300; $i++) {
        $nom = $nombres_clientes[array_rand($nombres_clientes)] . ' ' . $apellidos[array_rand($apellidos)];
        $stmtUserCliente->execute([$nom, "cliente{$i}@demo.com", $hash, "555400".sprintf('%03d', $i), 6, 'Activo']);
        $u_id = $pdo->lastInsertId();
        
        $pts = mt_rand(0, 3000);
        $nivel = 'Bronce';
        if($pts>=1000) $nivel='Leyenda'; elseif($pts>=500) $nivel='Diamante'; elseif($pts>=200) $nivel='Oro'; elseif($pts>=50) $nivel='Plata';
        $stmtCliente->execute([$u_id, $pts, $nivel]);
        $clientes_data[] = $pdo->lastInsertId();
    }

    $stmtCita = $pdo->prepare("INSERT INTO citas (codigo_unico, barberia_id, cliente_id, barbero_id, servicio_id, fecha, hora, duracion_minutos, estado) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmtPago = $pdo->prepare("INSERT INTO pagos (cita_id, monto, metodo, estado, validado_por) VALUES (?,?,?,?,?)");
    $stmtResena = $pdo->prepare("INSERT INTO resenas (cita_id, cliente_id, barbero_id, barberia_id, calificacion, comentario) VALUES (?,?,?,?,?,?)");
    
    for ($i = 0; $i < 1000; $i++) {
        $c_id = $clientes_data[array_rand($clientes_data)];
        $barb = $barberos_data[array_rand($barberos_data)];
        
        $b_id = $barb['b_id'];
        $srvs = array_filter($servicios_data, function($s) use ($b_id) { return $s['b_id'] == $b_id; });
        if (empty($srvs)) continue;
        $srv = $srvs[array_rand($srvs)];
        
        $fecha = date('Y-m-d', strtotime(($i < 800 ? "-" . mt_rand(1, 365) : "+" . mt_rand(0, 30)) . " days"));
        $estado = $i < 800 ? ((mt_rand(1,10) > 1) ? 'Finalizada' : 'Cancelada') : ((mt_rand(1,10) > 2) ? 'Confirmada' : 'Pendiente');
        $hora = sprintf("%02d:%02d:00", mt_rand(9, 20), (mt_rand(0,1)==0 ? 0 : 30));
        $codigo = "DMO-" . strtoupper(substr(md5(mt_rand()), 0, 6));
        
        $stmtCita->execute([$codigo, $b_id, $c_id, $barb['id'], $srv['id'], $fecha, $hora, $srv['duracion'], $estado]);
        $cita_id = $pdo->lastInsertId();
        
        if ($estado == 'Finalizada') {
            $metodos = ['Efectivo', 'Tarjeta Debito', 'Tarjeta Credito'];
            $stmtPago->execute([$cita_id, $srv['precio'], $metodos[array_rand($metodos)], 'Confirmado', 1]);
            if (mt_rand(1,10) <= 6) {
                $comentarios = ['Excelente servicio.', 'Me encantó.', 'Buen ambiente.', 'Rápido y eficiente.'];
                $stmtResena->execute([$cita_id, $c_id, $barb['id'], $b_id, mt_rand(4,5), $comentarios[array_rand($comentarios)]]);
            }
        }
    }
    
    echo "¡Seed Masivo Finalizado Correctamente!";

} catch (Exception $e) {
    $error_msg = "Error: " . $e->getMessage() . "\n";
    if (isset($u_id, $b_id)) $error_msg .= "Variables: u_id=$u_id, b_id=$b_id\n";
    file_put_contents('seed_error.txt', $error_msg);
    echo "Error: " . $e->getMessage();
}
