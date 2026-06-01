-- ─────────────────────────────────────────
-- TABLA: desarrolladores
-- Solo Daniel Morales y David Santos pueden gestionar esto
-- ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `desarrolladores` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `cargo` VARCHAR(80) NOT NULL COMMENT 'Full Stack, Backend, Frontend, DBA, UI/UX',
  `descripcion` TEXT,
  `foto_url` VARCHAR(255) DEFAULT NULL,
  `tecnologias` TEXT COMMENT 'JSON: ["PHP","MySQL","JS"]',
  `contribuciones` TEXT,
  `instagram` VARCHAR(150) DEFAULT NULL,
  `facebook` VARCHAR(150) DEFAULT NULL,
  `linkedin` VARCHAR(150) DEFAULT NULL,
  `github` VARCHAR(150) DEFAULT NULL,
  `sitio_web` VARCHAR(150) DEFAULT NULL,
  `estado` ENUM('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `orden` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Orden de aparición en la página',
  `creado_por` INT UNSIGNED DEFAULT NULL COMMENT 'Solo dev1 o dev2',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─────────────────────────────────────────
-- TABLA: configuracion_footer
-- Permite al admin modificar el pie de página
-- ─────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `configuracion_footer` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `clave` VARCHAR(80) NOT NULL UNIQUE,
  `valor` TEXT,
  `descripcion` VARCHAR(200),
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ─────────────────────────────────────────
-- DATOS INICIALES del FOOTER
-- ─────────────────────────────────────────
INSERT INTO `configuracion_footer` (`clave`, `valor`, `descripcion`) VALUES
('empresa_nombre',     'Barber Hub',                          'Nombre de la empresa en el footer'),
('empresa_slogan',     'El estilo es nuestra identidad.',      'Slogan debajo del nombre'),
('empresa_descripcion','Barbería premium con estilo, precisión y pasión en cada corte.', 'Descripción del negocio'),
('derechos',           'Todos los derechos reservados.',       'Texto de derechos'),
('instagram',          'https://instagram.com/barberhub',      'URL Instagram'),
('facebook',           'https://facebook.com/barberhub',       'URL Facebook'),
('twitter',            'https://twitter.com/barberhub',        'URL Twitter (X)'),
('youtube',            '',                                      'URL YouTube (vacío = ocultar)'),
('tiktok',             'https://tiktok.com/@barberhub',        'URL TikTok'),
('telefono',           '+52 222 000 0000',                     'Teléfono de contacto'),
('correo',             'contacto@barberhub.mx',                'Correo de contacto'),
('direccion',          'Puebla, México',                       'Dirección o ciudad principal'),
('mostrar_devs',       '1',                                    '1 = mostrar link a desarrolladores, 0 = ocultar')
ON DUPLICATE KEY UPDATE `clave`=`clave`;

-- ─────────────────────────────────────────
-- DATOS INICIALES: Desarrolladores Maestros
-- ─────────────────────────────────────────
INSERT INTO `desarrolladores` (`nombre`, `cargo`, `descripcion`, `github`, `estado`, `orden`, `creado_por`) VALUES
('Daniel Morales Ramírez', 'Full Stack Developer & Arquitecto',
 'Co-fundador y arquitecto principal de Barber Hub. Responsable del diseño del sistema, la base de datos y el backend.',
 'https://github.com/daniel-morales', 'Activo', 1, NULL),
('David Santos Galicia', 'Full Stack Developer & UI/UX',
 'Co-fundador de Barber Hub. Responsable del frontend, diseño visual y experiencia de usuario.',
 'https://github.com/david-santos', 'Activo', 2, NULL)
ON DUPLICATE KEY UPDATE `nombre`=`nombre`;
