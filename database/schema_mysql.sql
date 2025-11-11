-- =====================================================
-- SISTEMA DE VOTACIONES - SCHEMA MYSQL
-- Generado desde las migraciones de Laravel
-- =====================================================

-- Configuración inicial
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- 1. TABLAS DE USUARIOS Y AUTENTICACIÓN
-- =====================================================

-- Tabla: users
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `mesa_number` INT DEFAULT NULL COMMENT 'Número de mesa asignada',
  `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `rol` VARCHAR(255) DEFAULT 'user',
  `cargo` VARCHAR(255) DEFAULT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `mesa_id` BIGINT UNSIGNED DEFAULT NULL,
  `circunscripcion_id` BIGINT UNSIGNED DEFAULT NULL,
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_mesa_id_index` (`mesa_id`),
  KEY `users_circunscripcion_id_index` (`circunscripcion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: password_reset_tokens
CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: sessions
CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `user_agent` TEXT,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 2. TABLAS DE CACHE Y JOBS (Laravel)
-- =====================================================

-- Tabla: cache
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: cache_locks
CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: jobs
CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED DEFAULT NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: job_batches
CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT DEFAULT NULL,
  `cancelled_at` INT DEFAULT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: failed_jobs
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL UNIQUE,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. ESTRUCTURA GEOGRÁFICA ELECTORAL
-- =====================================================

-- Tabla: departamentos
CREATE TABLE `departamentos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: provincias
CREATE TABLE `provincias` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `departamento_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `provincias_departamento_id_foreign` (`departamento_id`),
  CONSTRAINT `provincias_departamento_id_foreign` 
    FOREIGN KEY (`departamento_id`) 
    REFERENCES `departamentos` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: municipios
CREATE TABLE `municipios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `provincia_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `municipios_provincia_id_foreign` (`provincia_id`),
  CONSTRAINT `municipios_provincia_id_foreign` 
    FOREIGN KEY (`provincia_id`) 
    REFERENCES `provincias` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: circunscripcions
CREATE TABLE `circunscripcions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `municipio_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) NOT NULL UNIQUE,
  `numero_electores` INT NOT NULL DEFAULT 0,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `circunscripcions_municipio_id_foreign` (`municipio_id`),
  CONSTRAINT `circunscripcions_municipio_id_foreign` 
    FOREIGN KEY (`municipio_id`) 
    REFERENCES `municipios` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: recintos
CREATE TABLE `recintos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `circunscripcion_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `direccion` TEXT NOT NULL,
  `codigo` VARCHAR(10) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `recintos_circunscripcion_id_foreign` (`circunscripcion_id`),
  CONSTRAINT `recintos_circunscripcion_id_foreign` 
    FOREIGN KEY (`circunscripcion_id`) 
    REFERENCES `circunscripcions` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: mesas_sufragio
CREATE TABLE `mesas_sufragio` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `recinto_id` BIGINT UNSIGNED NOT NULL,
  `numero_mesa` INT NOT NULL UNIQUE,
  `cantidad_electores` INT NOT NULL DEFAULT 0,
  `presidente_nombre` VARCHAR(100) DEFAULT NULL,
  `secretario_nombre` VARCHAR(100) DEFAULT NULL,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `mesas_sufragio_recinto_id_foreign` (`recinto_id`),
  CONSTRAINT `mesas_sufragio_recinto_id_foreign` 
    FOREIGN KEY (`recinto_id`) 
    REFERENCES `recintos` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. TABLAS DE ELECCIONES Y VOTACIÓN
-- =====================================================

-- Tabla: elections
CREATE TABLE `elections` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `election_date` DATE NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: candidates
CREATE TABLE `candidates` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `party` VARCHAR(255) DEFAULT NULL,
  `color_hex` VARCHAR(7) NOT NULL DEFAULT '#3498db',
  `position` INT NOT NULL DEFAULT 0 COMMENT 'Orden de aparición',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidates_election_id_foreign` (`election_id`),
  CONSTRAINT `candidates_election_id_foreign` 
    FOREIGN KEY (`election_id`) 
    REFERENCES `elections` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: actas
CREATE TABLE `actas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `mesa_number` INT NOT NULL,
  `total_votes` INT NOT NULL COMMENT 'Total de votos (máximo 240)',
  `null_votes` INT NOT NULL DEFAULT 0 COMMENT 'Votos nulos',
  `blank_votes` INT NOT NULL DEFAULT 0 COMMENT 'Votos en blanco',
  `observations` TEXT DEFAULT NULL,
  `photo_path` VARCHAR(255) DEFAULT NULL,
  `is_validated` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `actas_election_id_foreign` (`election_id`),
  KEY `actas_user_id_foreign` (`user_id`),
  CONSTRAINT `actas_election_id_foreign` 
    FOREIGN KEY (`election_id`) 
    REFERENCES `elections` (`id`) 
    ON DELETE CASCADE,
  CONSTRAINT `actas_user_id_foreign` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: acta_candidate_votes
CREATE TABLE `acta_candidate_votes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `acta_id` BIGINT UNSIGNED NOT NULL,
  `candidate_id` BIGINT UNSIGNED NOT NULL,
  `votes` INT NOT NULL COMMENT 'Votos para este candidato',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acta_candidate_votes_acta_id_candidate_id_unique` (`acta_id`, `candidate_id`),
  KEY `acta_candidate_votes_candidate_id_foreign` (`candidate_id`),
  CONSTRAINT `acta_candidate_votes_acta_id_foreign` 
    FOREIGN KEY (`acta_id`) 
    REFERENCES `actas` (`id`) 
    ON DELETE CASCADE,
  CONSTRAINT `acta_candidate_votes_candidate_id_foreign` 
    FOREIGN KEY (`candidate_id`) 
    REFERENCES `candidates` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ÍNDICES ADICIONALES (si son necesarios)
-- =====================================================

-- Restaurar verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================
-- FIN DEL SCHEMA
-- =====================================================
