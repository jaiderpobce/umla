-- =============================================================================
-- SCRIPT DE REGISTRO DEL MÓDULO DE ALUMNOS ACTIVOS EN RBAC
-- =============================================================================

-- 1. Insertar el Módulo de Alumnos Activos si no existe
INSERT INTO `modules` (`name`, `slug`, `icon`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT 'Alumnos Activos', 'alumnos-activos', 'ST', 'Gestión de alumnos activos, catálogos e importación masiva por CURP', 9, 1, NOW(), NOW()
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `modules` WHERE `slug` = 'alumnos-activos');

-- 2. Insertar la Vista del Módulo de Alumnos Activos
INSERT INTO `module_views` (`module_id`, `name`, `slug`, `route`, `component`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`)
SELECT m.id, 'Gestión de Alumnos', 'gestion', '/alumnos-activos/gestion', 'ActiveStudentAdmin', 'Gestión de expediente, programas, períodos e importación CSV por CURP', 1, 1, NOW(), NOW()
FROM `modules` m
WHERE m.slug = 'alumnos-activos'
  AND NOT EXISTS (SELECT 1 FROM `module_views` mv WHERE mv.module_id = m.id AND mv.slug = 'gestion');

-- 3. Asignar el módulo a los Roles (Super Admin, Coordinador)
INSERT IGNORE INTO `role_module` (`role_id`, `module_id`)
SELECT r.id, m.id
FROM `roles` r, `modules` m
WHERE r.slug IN ('super-admin', 'coordinador')
  AND m.slug = 'alumnos-activos';

-- 4. Asignar Permisos a la Vista por Rol
-- Super Admin y Coordinador -> alumnos-activos.gestion
INSERT IGNORE INTO `role_view_permission` (`role_id`, `module_view_id`, `permission_id`, `created_at`, `updated_at`)
SELECT r.id, mv.id, p.id, NOW(), NOW()
FROM `roles` r
JOIN `modules` m ON m.slug = 'alumnos-activos'
JOIN `module_views` mv ON mv.module_id = m.id AND mv.slug = 'gestion'
JOIN `permissions` p ON p.slug IN ('view', 'create', 'edit', 'delete')
WHERE r.slug IN ('super-admin', 'coordinador');
