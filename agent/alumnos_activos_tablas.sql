-- =============================================================================
-- MÓDULO DE GESTIÓN DE ALUMNOS ACTIVOS - ESTRUCTURA NORMALIZADA (3NF)
-- BD: MariaDB / MySQL
-- Archivo: alumnos_activos_tablas.sql
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `periodo_alumnos`;
DROP TABLE IF EXISTS `alumnos_activos`;
DROP TABLE IF EXISTS `periodos_academicos`;
DROP TABLE IF EXISTS `programas_academicos`;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
-- 1. TABLA: programas_academicos
-- Propósito: Almacenar la oferta educativa y carreras impartidas por la universidad.
-- -----------------------------------------------------------------------------
CREATE TABLE `programas_academicos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) NOT NULL COMMENT 'Clave o ID del programa ej. BG, LPO, ING, DE',
  `nombre` varchar(160) NOT NULL COMMENT 'Nombre del programa ej. LIC. PSICOLOGIA ORGANIZACIONAL',
  `nivel` varchar(80) DEFAULT NULL COMMENT 'Nivel académico ej. BACHILLERATO, LICENCIATURA, MAESTRIA, DOCTORADO',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programas_academicos_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. TABLA: periodos_academicos
-- Propósito: Representar los períodos tetramestrales/semestrales aperturados.
-- -----------------------------------------------------------------------------
CREATE TABLE `periodos_academicos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL COMMENT 'Nombre del período ej. ENERO - ABRIL 2021',
  `slug` varchar(60) NOT NULL COMMENT 'Slug único del período ej. enero-abril-2021',
  `fecha_ini` date DEFAULT NULL COMMENT 'Fecha de inicio del período',
  `fecha_fin` date DEFAULT NULL COMMENT 'Fecha de fin del período',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `periodos_academicos_nombre_unique` (`nombre`),
  UNIQUE KEY `periodos_academicos_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 3. TABLA: alumnos_activos
-- Propósito: Datos personales y académicos del alumno, utilizando CURP como campo único.
-- -----------------------------------------------------------------------------
CREATE TABLE `alumnos_activos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `curp` varchar(20) NOT NULL COMMENT 'Identificador único para búsqueda y UPSERT',
  `matricula` varchar(50) DEFAULT NULL COMMENT 'Matrícula del estudiante',
  `nombre_completo` varchar(200) NOT NULL COMMENT 'Nombre completo del alumno',
  `email` varchar(200) DEFAULT NULL COMMENT 'Correo institucional o personal',
  `programa_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'FK a programas_academicos',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'FK opcional a usuarios (users.id)',
  `status` enum('activo', 'inactivo', 'baja', 'egresado') NOT NULL DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alumnos_activos_curp_unique` (`curp`),
  KEY `alumnos_activos_matricula_idx` (`matricula`),
  KEY `alumnos_activos_programa_idx` (`programa_id`),
  KEY `alumnos_activos_user_idx` (`user_id`),
  CONSTRAINT `fk_alumnos_activos_programa` FOREIGN KEY (`programa_id`) REFERENCES `programas_academicos` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_alumnos_activos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. TABLA: periodo_alumnos
-- Propósito: Relación N:M de inscripción entre Alumnos Activos y Períodos Aperturados.
-- -----------------------------------------------------------------------------
CREATE TABLE `periodo_alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_alumno` bigint(20) UNSIGNED NOT NULL COMMENT 'FK a alumnos_activos.id',
  `id_periodo` bigint(20) UNSIGNED NOT NULL COMMENT 'FK a periodos_academicos.id',
  `status` enum('cursando', 'inscrito', 'concluido', 'baja') NOT NULL DEFAULT 'inscrito',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `periodo_alumnos_alumno_periodo_unique` (`id_alumno`, `id_periodo`),
  KEY `periodo_alumnos_alumno_idx` (`id_alumno`),
  KEY `periodo_alumnos_periodo_idx` (`id_periodo`),
  CONSTRAINT `fk_periodo_alumnos_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos_activos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_periodo_alumnos_periodo` FOREIGN KEY (`id_periodo`) REFERENCES `periodos_academicos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
