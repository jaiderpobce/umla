-- =============================================================================
-- MÓDULO DE FINANZAS Y COBRANZA - ESTRUCTURA NORMALIZADA (3NF)
-- BD: MariaDB / MySQL
-- Archivo: finanzas_tablas.sql
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `finance_status_logs`;
DROP TABLE IF EXISTS `finance_receipts`;
DROP TABLE IF EXISTS `finance_payment_approvals`;
DROP TABLE IF EXISTS `finance_payments`;
DROP TABLE IF EXISTS `finance_charges`;
DROP TABLE IF EXISTS `finance_periods`;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
-- 1. TABLA: finance_periods
-- Propósito: Representa el ciclo o período fiscal/mensual de cobro (ej. Agosto 2026).
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_periods` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT 'Nombre del período, ej: Agosto 2026',
  `slug` varchar(40) NOT NULL COMMENT 'Identificador único, ej: 2026-08',
  `year` smallint(5) UNSIGNED NOT NULL,
  `month` tinyint(3) UNSIGNED NOT NULL,
  `starts_at` date NOT NULL COMMENT 'Fecha inicio del período',
  `ends_at` date NOT NULL COMMENT 'Fecha fin del período',
  `due_at` date NOT NULL COMMENT 'Fecha límite de pago sin recargos',
  `status` enum('draft', 'active', 'closed') NOT NULL DEFAULT 'draft',
  `notes` text DEFAULT NULL,
  `created_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finance_periods_year_month_unique` (`year`, `month`),
  UNIQUE KEY `finance_periods_slug_unique` (`slug`),
  KEY `finance_periods_status_idx` (`status`),
  CONSTRAINT `fk_finance_periods_created_by` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. TABLA: finance_charges
-- Propósito: Almacena el "Causado" o cobro mensual emitido por estudiante.
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_charges` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID del estudiante (users)',
  `finance_period_id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID del período',
  `charge_code` varchar(60) NOT NULL COMMENT 'Código único de cargo, ej: CHG-2026-08-511-MENS',
  `concept` varchar(160) NOT NULL COMMENT 'Concepto, ej: Mensualidad Agosto 2026',
  `description` text DEFAULT NULL,
  `currency` char(3) NOT NULL DEFAULT 'MXN',
  `amount_total` decimal(12,2) NOT NULL COMMENT 'Monto total a cobrar',
  `amount_paid` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Monto acumulado pagado',
  `balance_due` decimal(12,2) NOT NULL COMMENT 'Saldo pendiente por liquidar',
  `status` enum('pendiente', 'en_revision', 'pagado', 'cancelado') NOT NULL DEFAULT 'pendiente',
  `billed_at` date DEFAULT NULL COMMENT 'Fecha de emisión del cobro',
  `due_at` date DEFAULT NULL COMMENT 'Fecha de vencimiento',
  `created_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finance_charges_user_period_concept_unique` (`user_id`, `finance_period_id`, `concept`),
  UNIQUE KEY `finance_charges_charge_code_unique` (`charge_code`),
  KEY `finance_charges_user_idx` (`user_id`),
  KEY `finance_charges_period_idx` (`finance_period_id`),
  KEY `finance_charges_status_idx` (`status`),
  CONSTRAINT `fk_finance_charges_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_charges_period` FOREIGN KEY (`finance_period_id`) REFERENCES `finance_periods` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_finance_charges_created_by` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 3. TABLA: finance_payments
-- Propósito: Transacciones/comprobantes de pago reportados por los alumnos.
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `finance_charge_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Cargo al que aplica el pago',
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Estudiante que realiza el pago',
  `reported_by_user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Usuario que reportó el pago',
  `approved_by_user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Admin que validó el pago',
  `amount` decimal(12,2) NOT NULL COMMENT 'Monto reportado',
  `payment_date` date DEFAULT NULL COMMENT 'Fecha en que se realizó el depósito/transferencia',
  `reported_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `status` enum('reportado', 'aprobado', 'rechazado') NOT NULL DEFAULT 'reportado',
  `payment_method` varchar(60) DEFAULT NULL COMMENT 'transferencia, deposito, tarjeta, etc.',
  `reference` varchar(120) DEFAULT NULL COMMENT 'Número de referencia bancaria',
  `bank_name` varchar(120) DEFAULT NULL COMMENT 'Banco emisor/receptor',
  `voucher_path` varchar(255) DEFAULT NULL COMMENT 'Ruta del archivo PDF/Imagen subido',
  `voucher_original_name` varchar(255) DEFAULT NULL COMMENT 'Nombre original del archivo',
  `review_notes` text DEFAULT NULL COMMENT 'Notas del admin al aprobar o rechazar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finance_payments_charge_idx` (`finance_charge_id`),
  KEY `finance_payments_user_idx` (`user_id`),
  KEY `finance_payments_status_idx` (`status`),
  CONSTRAINT `fk_finance_payments_charge` FOREIGN KEY (`finance_charge_id`) REFERENCES `finance_charges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_payments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_payments_approved_by` FOREIGN KEY (`approved_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. TABLA: finance_payment_approvals
-- Propósito: Auditoría detallada del flujo de decisiones (Aprobado/Rechazado).
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_payment_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `finance_payment_id` bigint(20) UNSIGNED NOT NULL,
  `acted_by_user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Admin que ejecutó la acción',
  `action` enum('approve', 'reject') NOT NULL,
  `status_from` varchar(30) DEFAULT NULL,
  `status_to` varchar(30) NOT NULL,
  `notes` text DEFAULT NULL,
  `acted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finance_payment_approvals_payment_idx` (`finance_payment_id`),
  KEY `finance_payment_approvals_user_idx` (`acted_by_user_id`),
  CONSTRAINT `fk_finance_payment_approvals_payment` FOREIGN KEY (`finance_payment_id`) REFERENCES `finance_payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_payment_approvals_user` FOREIGN KEY (`acted_by_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 5. TABLA: finance_receipts
-- Propósito: Recibo digital oficial emitido al aprobar el pago.
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `finance_payment_id` bigint(20) UNSIGNED NOT NULL,
  `finance_charge_id` bigint(20) UNSIGNED NOT NULL,
  `student_user_id` bigint(20) UNSIGNED NOT NULL,
  `approved_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `folio` varchar(60) NOT NULL COMMENT 'Folio único de recibo, ej: REC-20260804-000001',
  `period_label` varchar(120) NOT NULL,
  `concept` varchar(160) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(60) DEFAULT NULL,
  `reference` varchar(120) DEFAULT NULL,
  `receipt_path` varchar(255) DEFAULT NULL COMMENT 'PDF generado del recibo',
  `sent_to_email` varchar(200) DEFAULT NULL COMMENT 'Correo al que se envió la notificación',
  `generated_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `finance_receipts_payment_unique` (`finance_payment_id`),
  UNIQUE KEY `finance_receipts_folio_unique` (`folio`),
  KEY `finance_receipts_charge_idx` (`finance_charge_id`),
  KEY `finance_receipts_student_idx` (`student_user_id`),
  CONSTRAINT `fk_finance_receipts_payment` FOREIGN KEY (`finance_payment_id`) REFERENCES `finance_payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_receipts_charge` FOREIGN KEY (`finance_charge_id`) REFERENCES `finance_charges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_finance_receipts_student` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 6. TABLA: finance_status_logs
-- Propósito: Bitácora universal de cambios de estado para auditoría financiera.
-- -----------------------------------------------------------------------------
CREATE TABLE `finance_status_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity_type` varchar(40) NOT NULL COMMENT 'finance_charge, finance_payment, etc.',
  `entity_id` bigint(20) UNSIGNED NOT NULL,
  `status_from` varchar(30) DEFAULT NULL,
  `status_to` varchar(30) NOT NULL,
  `acted_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `acted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `finance_status_logs_entity_idx` (`entity_type`, `entity_id`),
  KEY `finance_status_logs_user_idx` (`acted_by_user_id`),
  CONSTRAINT `fk_finance_status_logs_user` FOREIGN KEY (`acted_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
