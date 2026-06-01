-- ─────────────────────────────────────────
-- ACTUALIZACIÓN: Registro de Clientes y Aprobaciones
-- ─────────────────────────────────────────

-- 1. Agregar el estado 'Pendiente' a los usuarios
ALTER TABLE `usuarios` 
MODIFY COLUMN `estado` ENUM('Pendiente', 'Activo', 'Inactivo', 'Suspendido') DEFAULT 'Activo';

-- 2. Permitir que clientes sean globales (barberia_id NULL)
ALTER TABLE `clientes`
MODIFY COLUMN `barberia_id` INT NULL;

-- Asegurar que el foreign key sigue funcionando pero permite nulos si es que estaba restringido
-- Si ya existía el FK, el ON DELETE CASCADE se mantiene si solo cambiamos la columna a NULL.
