-- BARBER HUB - Base de Datos (MySQL 8+)
-- Arquitectura SaaS Multiempresa

CREATE DATABASE IF NOT EXISTS barber_hub;
USE barber_hub;

-- --------------------------------------------------------
-- CONFIGURACIÓN GLOBAL
-- --------------------------------------------------------
CREATE TABLE configuraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(50) NOT NULL UNIQUE,
    valor TEXT,
    descripcion VARCHAR(255)
);

-- --------------------------------------------------------
-- ROLES Y PERMISOS
-- --------------------------------------------------------
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE, -- Super Administrador, Desarrollador, Propietario, Moderador, Barbero, Cliente
    descripcion VARCHAR(255)
);

CREATE TABLE permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255)
);

CREATE TABLE rol_permiso (
    rol_id INT NOT NULL,
    permiso_id INT NOT NULL,
    PRIMARY KEY (rol_id, permiso_id),
    FOREIGN KEY (rol_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permiso_id) REFERENCES permisos(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- BARBERÍAS (SaaS Multiempresa)
-- --------------------------------------------------------
CREATE TABLE barberias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_comercial VARCHAR(150) NOT NULL,
    logo VARCHAR(255),
    portada VARCHAR(255),
    descripcion TEXT,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    sitio_web VARCHAR(100),
    estado_ubicacion VARCHAR(50),
    municipio VARCHAR(50),
    ciudad VARCHAR(50),
    colonia VARCHAR(100),
    calle VARCHAR(100),
    codigo_postal VARCHAR(10),
    latitud DECIMAL(10, 8),
    longitud DECIMAL(11, 8),
    estado ENUM('Pendiente', 'Activa', 'Suspendida', 'Eliminada') DEFAULT 'Pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sucursales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barberia_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    direccion TEXT,
    telefono VARCHAR(20),
    estado ENUM('Activa', 'Inactiva') DEFAULT 'Activa',
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- USUARIOS DEL SISTEMA
-- --------------------------------------------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol_id INT NOT NULL,
    barberia_id INT NULL, -- NULL = Super Admin / Desarrollador (Acceso Global)
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Argon2 o Bcrypt
    telefono VARCHAR(20),
    fotografia VARCHAR(255),
    estado ENUM('Pendiente', 'Activo', 'Inactivo', 'Suspendido') DEFAULT 'Activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_id) REFERENCES roles(id),
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- BARBEROS (Perfil Profesional)
-- --------------------------------------------------------
CREATE TABLE barberos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    barberia_id INT NOT NULL,
    sucursal_id INT NULL,
    biografia TEXT,
    anios_experiencia INT DEFAULT 0,
    estado ENUM('Activo', 'Inactivo', 'Vacaciones', 'Suspendido') DEFAULT 'Activo',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id) ON DELETE SET NULL
);

-- --------------------------------------------------------
-- CLIENTES (CRM)
-- --------------------------------------------------------
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    barberia_id INT NULL, -- NULL = Cliente global, no asignado a una barbería específica
    puntos_acumulados INT DEFAULT 0,
    nivel ENUM('Bronce', 'Plata', 'Oro', 'Diamante', 'Leyenda') DEFAULT 'Bronce',
    qr_unico VARCHAR(100) UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- SERVICIOS
-- --------------------------------------------------------
CREATE TABLE servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barberia_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    duracion_minutos INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- CITAS
-- --------------------------------------------------------
CREATE TABLE citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_unico VARCHAR(20) NOT NULL UNIQUE,
    barberia_id INT NOT NULL,
    sucursal_id INT NOT NULL,
    cliente_id INT NOT NULL,
    barbero_id INT NOT NULL,
    servicio_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    duracion_minutos INT NOT NULL,
    estado ENUM('Pendiente', 'Confirmada', 'Reagendada', 'Cancelada', 'Finalizada', 'No asistio') DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE,
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (barbero_id) REFERENCES barberos(id),
    FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);

-- --------------------------------------------------------
-- FINANZAS (Pagos y Comprobantes)
-- --------------------------------------------------------
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cita_id INT NOT NULL,
    monto DECIMAL(10, 2) NOT NULL,
    metodo ENUM('Efectivo', 'Tarjeta Debito', 'Tarjeta Credito', 'Transferencia Bancaria') NOT NULL,
    estado ENUM('Pendiente', 'Confirmado', 'Rechazado', 'Reembolsado') DEFAULT 'Pendiente',
    validado_por INT NULL, -- Moderador o Propietario que confirmó
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cita_id) REFERENCES citas(id),
    FOREIGN KEY (validado_por) REFERENCES usuarios(id)
);

-- --------------------------------------------------------
-- INVENTARIO Y PRODUCTOS
-- --------------------------------------------------------
CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    barberia_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    empresa VARCHAR(100),
    correo VARCHAR(100),
    telefono VARCHAR(20),
    estado ENUM('Activo', 'Suspendido') DEFAULT 'Activo',
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_interno VARCHAR(50),
    codigo_qr VARCHAR(100),
    barberia_id INT NOT NULL,
    proveedor_id INT NULL,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    precio_compra DECIMAL(10, 2),
    precio_venta DECIMAL(10, 2),
    stock_actual INT DEFAULT 0,
    stock_minimo INT DEFAULT 0,
    estado ENUM('Disponible', 'Bajo Inventario', 'Agotado', 'Suspendido') DEFAULT 'Disponible',
    FOREIGN KEY (barberia_id) REFERENCES barberias(id) ON DELETE CASCADE,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id) ON DELETE SET NULL
);

-- --------------------------------------------------------
-- AUDITORÍA (Bitácora de Eventos Críticos)
-- --------------------------------------------------------
CREATE TABLE auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    accion VARCHAR(255) NOT NULL,
    resultado VARCHAR(255),
    direccion_ip VARCHAR(45),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

-- --------------------------------------------------------
-- DATOS MAESTROS INICIALES (Semilla)
-- --------------------------------------------------------
INSERT INTO roles (nombre, descripcion) VALUES 
('Super Administrador', 'Acceso total absoluto al sistema SaaS.'),
('Desarrollador', 'Acceso técnico, respaldos y auditoría.'),
('Propietario', 'Administrador principal de una barbería.'),
('Moderador', 'Mini administrador de barbería.'),
('Barbero', 'Personal operativo.'),
('Cliente', 'Usuario final que reserva citas.');
