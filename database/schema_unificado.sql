-- =====================================================
-- SCHEMA UNIFICADO - SISTEMA ELECTORAL Y VOTACIONES
-- Integración de ambos proyectos Laravel
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+00:00";
START TRANSACTION;

-- =====================================================
-- 1. TABLAS LARAVEL COMPARTIDAS
-- =====================================================

CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT UNSIGNED NOT NULL,
  `reserved_at` INT UNSIGNED NULL,
  `available_at` INT UNSIGNED NOT NULL,
  `created_at` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT NOT NULL,
  `pending_jobs` INT NOT NULL,
  `failed_jobs` INT NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL,
  `cancelled_at` INT NULL,
  `created_at` INT NOT NULL,
  `finished_at` INT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- 2. JERARQUÍA GEOGRÁFICA UNIFICADA
-- =====================================================

CREATE TABLE `departamentos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `provincias` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `departamento_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `provincias_departamento_id_foreign` (`departamento_id`),
  CONSTRAINT `provincias_departamento_id_foreign` 
    FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `municipios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `provincia_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `municipios_provincia_id_foreign` (`provincia_id`),
  CONSTRAINT `municipios_provincia_id_foreign` 
    FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nivel intermedio: CIRCUNSCRIPCIONES (Proyecto Votaciones)
CREATE TABLE `circunscripciones` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `municipio_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(10) UNIQUE,
  `numero_electores` INT NOT NULL DEFAULT 0,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `circunscripciones_municipio_id_foreign` (`municipio_id`),
  CONSTRAINT `circunscripciones_municipio_id_foreign` 
    FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nivel intermedio: ASIENTOS (Proyecto Electoral)
CREATE TABLE `asientos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `municipio_id` BIGINT UNSIGNED NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `asientos_municipio_id_foreign` (`municipio_id`),
  CONSTRAINT `asientos_municipio_id_foreign` 
    FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- RECINTOS (soporta ambos niveles)
CREATE TABLE `recintos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `circunscripcion_id` BIGINT UNSIGNED NULL COMMENT 'Para Proyecto Votaciones',
  `asiento_id` BIGINT UNSIGNED NULL COMMENT 'Para Proyecto Electoral',
  `nombre` VARCHAR(150) NOT NULL,
  `direccion` TEXT,
  `codigo` VARCHAR(10) UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `recintos_circunscripcion_id_foreign` (`circunscripcion_id`),
  KEY `recintos_asiento_id_foreign` (`asiento_id`),
  CONSTRAINT `recintos_circunscripcion_id_foreign` 
    FOREIGN KEY (`circunscripcion_id`) REFERENCES `circunscripciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recintos_asiento_id_foreign` 
    FOREIGN KEY (`asiento_id`) REFERENCES `asientos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `check_recinto_parent` CHECK (
    `circunscripcion_id` IS NOT NULL OR `asiento_id` IS NOT NULL
  )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- MESAS UNIFICADAS (combina mesas_sufragio + mesas)
CREATE TABLE `mesas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `recinto_id` BIGINT UNSIGNED NOT NULL,
  `numero_mesa` INT NOT NULL,
  `cantidad_electores` INT NOT NULL DEFAULT 0,
  `presidente_nombre` VARCHAR(100) NULL,
  `secretario_nombre` VARCHAR(100) NULL,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mesas_recinto_numero_unique` (`recinto_id`, `numero_mesa`),
  KEY `mesas_recinto_id_foreign` (`recinto_id`),
  CONSTRAINT `mesas_recinto_id_foreign` 
    FOREIGN KEY (`recinto_id`) REFERENCES `recintos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 3. PERSONAS (Proyecto Electoral)
-- =====================================================

CREATE TABLE `personas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ci` VARCHAR(20) NOT NULL UNIQUE,
  `nombre` VARCHAR(100) NOT NULL,
  `apellido` VARCHAR(100) NOT NULL,
  `fecha_nacimiento` DATE NULL,
  `correo` VARCHAR(100) NULL,
  `telefono` VARCHAR(20) NULL,
  `ciudad` VARCHAR(100) NULL,
  `estado` ENUM('VIVO', 'FALLECIDO') NOT NULL DEFAULT 'VIVO',
  `foto_carnet` VARCHAR(255) NULL,
  `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `personas_ci_index` (`ci`),
  KEY `personas_estado_index` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 4. USUARIOS UNIFICADOS
-- =====================================================

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  -- Laravel estándar
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  -- Proyecto Votaciones
  `username` VARCHAR(50) NULL UNIQUE,
  `mesa_number` INT NULL,
  `role` ENUM('admin', 'user') DEFAULT 'user',
  `is_active` TINYINT(1) DEFAULT 1,
  `mesa_id` BIGINT UNSIGNED NULL,
  `circunscripcion_id` BIGINT UNSIGNED NULL,
  -- Proyecto Electoral
  `rol_electoral` VARCHAR(50) NULL COMMENT 'ADMIN, VOLUNTARIO',
  `cargo` VARCHAR(100) NULL,
  `activo` TINYINT(1) DEFAULT 1,
  `persona_id` BIGINT UNSIGNED NULL COMMENT 'Relación con personas',
  -- Común
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `users_mesa_id_index` (`mesa_id`),
  KEY `users_circunscripcion_id_index` (`circunscripcion_id`),
  KEY `users_persona_id_index` (`persona_id`),
  CONSTRAINT `users_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla auxiliar admin_users (Proyecto Electoral)
CREATE TABLE `admin_users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 5. ELECCIONES Y VOTACIÓN (Proyecto Votaciones)
-- =====================================================

CREATE TABLE `elections` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `election_date` DATE NOT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `candidates` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `party` VARCHAR(255) NULL,
  `color_hex` VARCHAR(7) NOT NULL DEFAULT '#3498db',
  `position` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `candidates_election_id_foreign` (`election_id`),
  CONSTRAINT `candidates_election_id_foreign` 
    FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `actas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `mesa_number` INT NOT NULL,
  `total_votes` INT NOT NULL,
  `null_votes` INT NOT NULL DEFAULT 0,
  `blank_votes` INT NOT NULL DEFAULT 0,
  `observations` TEXT NULL,
  `photo_path` VARCHAR(255) NULL,
  `is_validated` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `actas_election_id_foreign` (`election_id`),
  KEY `actas_user_id_foreign` (`user_id`),
  CONSTRAINT `actas_election_id_foreign` 
    FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `actas_user_id_foreign` 
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `acta_candidate_votes` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `acta_id` BIGINT UNSIGNED NOT NULL,
  `candidate_id` BIGINT UNSIGNED NOT NULL,
  `votes` INT NOT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acta_candidate_votes_acta_id_candidate_id_unique` (`acta_id`, `candidate_id`),
  KEY `acta_candidate_votes_candidate_id_foreign` (`candidate_id`),
  CONSTRAINT `acta_candidate_votes_acta_id_foreign` 
    FOREIGN KEY (`acta_id`) REFERENCES `actas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acta_candidate_votes_candidate_id_foreign` 
    FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 6. PARTIDOS E INSTITUCIONES (Proyecto Electoral)
-- =====================================================

CREATE TABLE `partidos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sigla` VARCHAR(20) NOT NULL UNIQUE,
  `nombre` VARCHAR(100) NOT NULL,
  `estado` ENUM('ACTIVO', 'INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  `logo_url` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  KEY `partidos_estado_index` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `instituciones` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `sigla` VARCHAR(20) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 7. ROLES ELECTORALES (Proyecto Electoral)
-- =====================================================

CREATE TABLE `jurados` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `mesa_id` BIGINT UNSIGNED NOT NULL,
  `cargo` ENUM('PRESIDENTE', 'SECRETARIO', 'VOCAL', 'SUPLENTE') NOT NULL,
  `verificado` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `jurados_persona_id_index` (`persona_id`),
  KEY `jurados_mesa_id_index` (`mesa_id`),
  CONSTRAINT `jurados_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jurados_mesa_id_foreign` 
    FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `veedores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `institucion_id` BIGINT UNSIGNED NOT NULL,
  `carta_respaldo` VARCHAR(255) NULL,
  `estado` ENUM('PENDIENTE', 'APROBADO', 'RECHAZADO') NOT NULL DEFAULT 'PENDIENTE',
  `motivo_rechazo` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  KEY `veedores_persona_id_index` (`persona_id`),
  KEY `veedores_institucion_id_index` (`institucion_id`),
  KEY `veedores_estado_index` (`estado`),
  CONSTRAINT `veedores_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `veedores_institucion_id_foreign` 
    FOREIGN KEY (`institucion_id`) REFERENCES `instituciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `delegados` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `partido_id` BIGINT UNSIGNED NOT NULL,
  `mesa_id` BIGINT UNSIGNED NULL,
  `habilitado` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `delegados_persona_partido_mesa_unique` (`persona_id`, `partido_id`, `mesa_id`),
  KEY `delegados_persona_id_index` (`persona_id`),
  KEY `delegados_partido_id_index` (`partido_id`),
  KEY `delegados_mesa_id_index` (`mesa_id`),
  CONSTRAINT `delegados_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `delegados_partido_id_foreign` 
    FOREIGN KEY (`partido_id`) REFERENCES `partidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `delegados_mesa_id_foreign` 
    FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `asistencia` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `jurado_id` BIGINT UNSIGNED NOT NULL,
  `mesa_id` BIGINT UNSIGNED NOT NULL,
  `estado` ENUM('PRESENTE', 'AUSENTE') NOT NULL DEFAULT 'AUSENTE',
  `registrado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `asistencia_jurado_id_index` (`jurado_id`),
  KEY `asistencia_mesa_id_index` (`mesa_id`),
  CONSTRAINT `asistencia_jurado_id_foreign` 
    FOREIGN KEY (`jurado_id`) REFERENCES `jurados` (`id`) ON DELETE CASCADE,
  CONSTRAINT `asistencia_mesa_id_foreign` 
    FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `historial_personas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `tipo_rol` VARCHAR(50) NOT NULL,
  `partido_id` BIGINT UNSIGNED NULL,
  `fecha_inicio` DATE NULL,
  `fecha_fin` DATE NULL,
  PRIMARY KEY (`id`),
  KEY `historial_personas_persona_id_index` (`persona_id`),
  CONSTRAINT `historial_personas_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `historial_personas_partido_id_foreign` 
    FOREIGN KEY (`partido_id`) REFERENCES `partidos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 8. CREDENCIALES (Proyecto Electoral)
-- =====================================================

CREATE TABLE `credenciales` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `rol` VARCHAR(50) NOT NULL COMMENT 'JURADO, VEEDOR, DELEGADO',
  `tipo` VARCHAR(50) NOT NULL DEFAULT 'CREDENCIAL',
  `nombre_archivo` VARCHAR(255) NOT NULL,
  `ruta_archivo` VARCHAR(500) NOT NULL,
  `estado` VARCHAR(50) NOT NULL DEFAULT 'GENERADO',
  `contenido_qr` TEXT NULL,
  `generado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descargado_en` TIMESTAMP NULL,
  `expira_en` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `credenciales_persona_id_rol_index` (`persona_id`, `rol`),
  KEY `credenciales_estado_index` (`estado`),
  CONSTRAINT `credenciales_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- 9. ACADEMIA ELECTORAL (Proyecto Electoral)
-- =====================================================

CREATE TABLE `capacitaciones` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NULL,
  `rol_destino` VARCHAR(50) NOT NULL,
  `estado` VARCHAR(20) NOT NULL DEFAULT 'ACTIVO',
  `total_niveles` INT NOT NULL DEFAULT 3,
  `puntaje_minimo` INT NOT NULL DEFAULT 90,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `capacitaciones_rol_destino_index` (`rol_destino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `capacitacion_niveles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `capacitacion_id` BIGINT UNSIGNED NOT NULL,
  `numero_nivel` INT NOT NULL,
  `titulo` VARCHAR(255) NOT NULL,
  `contenido` TEXT NOT NULL,
  `tipo_contenido` VARCHAR(50) NOT NULL DEFAULT 'TEXTO',
  `archivo_url` VARCHAR(500) NULL,
  `duracion_minutos` INT NULL,
  `requiere_completar` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `capacitacion_niveles_capacitacion_id_index` (`capacitacion_id`),
  CONSTRAINT `capacitacion_niveles_capacitacion_id_foreign` 
    FOREIGN KEY (`capacitacion_id`) REFERENCES `capacitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `progreso_capacitaciones` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `persona_id` BIGINT UNSIGNED NOT NULL,
  `capacitacion_id` BIGINT UNSIGNED NOT NULL,
  `nivel_actual` INT NOT NULL DEFAULT 1,
  `completado` TINYINT(1) NOT NULL DEFAULT 0,
  `puntaje_quiz` INT NULL,
  `aprobado` TINYINT(1) NOT NULL DEFAULT 0,
  `fecha_inicio` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_completado` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `progreso_capacitaciones_persona_capacitacion_unique` (`persona_id`, `capacitacion_id`),
  CONSTRAINT `progreso_capacitaciones_persona_id_foreign` 
    FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `progreso_capacitaciones_capacitacion_id_foreign` 
    FOREIGN KEY (`capacitacion_id`) REFERENCES `capacitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quiz_preguntas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `capacitacion_id` BIGINT UNSIGNED NOT NULL,
  `pregunta` TEXT NOT NULL,
  `tipo` VARCHAR(20) NOT NULL DEFAULT 'MULTIPLE',
  `puntos` INT NOT NULL DEFAULT 1,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_preguntas_capacitacion_id_index` (`capacitacion_id`),
  CONSTRAINT `quiz_preguntas_capacitacion_id_foreign` 
    FOREIGN KEY (`capacitacion_id`) REFERENCES `capacitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `quiz_respuestas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta_id` BIGINT UNSIGNED NOT NULL,
  `opcion` TEXT NOT NULL,
  `es_correcta` TINYINT(1) NOT NULL DEFAULT 0,
  `orden` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_respuestas_pregunta_id_index` (`pregunta_id`),
  CONSTRAINT `quiz_respuestas_pregunta_id_foreign` 
    FOREIGN KEY (`pregunta_id`) REFERENCES `quiz_preguntas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- FINALIZACIÓN
-- =====================================================

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- =====================================================
-- RESUMEN DE UNIFICACIÓN
-- =====================================================
-- ✅ Tablas compartidas: cache, sessions, jobs, password_reset_tokens
-- ✅ Geografía unificada: departamentos → provincias → municipios
-- ✅ Dos niveles intermedios: circunscripciones + asientos
-- ✅ Recintos soportan ambos niveles (FK nullable)
-- ✅ Mesas unificadas con campos de ambos proyectos
-- ✅ Users unificado con campos de ambos proyectos
-- ✅ Personas relacionadas con users (FK opcional)
-- ✅ Todas las tablas específicas de cada proyecto incluidas
-- =====================================================
