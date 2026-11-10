-- =====================================================================
-- RoyalWay Media: Resources overhaul (live database changes)
--
-- Run this whole file once in phpMyAdmin (SQL tab) on the live database.
-- It is safe to run more than once: every step checks first and skips
-- anything that already exists. No existing rows are changed or deleted.
--
-- Matches these Laravel migrations:
--   2026_11_10_000001_create_page_heroes_table
--   2026_11_10_000002_add_engagement_fields_to_resources_table
--   2026_11_10_000003_create_resource_views_table
--   2026_11_10_000004_create_resource_reactions_table
--   2026_11_10_000005_create_resource_comments_table
--   2026_11_10_000006_create_project_resource_table
-- =====================================================================

-- 1. Page heroes (CMS editable hero for News & Insights, Communication Assets, Policies)
CREATE TABLE IF NOT EXISTS `page_heroes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_heroes_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. New columns on resources (each added only if missing)
SET @sql := IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resources' AND COLUMN_NAME = 'topic') = 0,
  'ALTER TABLE `resources` ADD COLUMN `topic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER `type`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resources' AND COLUMN_NAME = 'is_featured') = 0,
  'ALTER TABLE `resources` ADD COLUMN `is_featured` tinyint(1) NOT NULL DEFAULT 0 AFTER `is_published`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resources' AND COLUMN_NAME = 'allow_comments') = 0,
  'ALTER TABLE `resources` ADD COLUMN `allow_comments` tinyint(1) NOT NULL DEFAULT 1 AFTER `is_featured`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @sql := IF((SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resources' AND COLUMN_NAME = 'views_count') = 0,
  'ALTER TABLE `resources` ADD COLUMN `views_count` int unsigned NOT NULL DEFAULT 0 AFTER `allow_comments`',
  'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- 3. Readership: one row per article, visitor hash and day
CREATE TABLE IF NOT EXISTS `resource_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` bigint unsigned NOT NULL,
  `visitor_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewed_on` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_views_unique` (`resource_id`,`visitor_hash`,`viewed_on`),
  KEY `resource_views_viewed_on_index` (`viewed_on`),
  CONSTRAINT `resource_views_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Reactions: one per visitor per article
CREATE TABLE IF NOT EXISTS `resource_reactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` bigint unsigned NOT NULL,
  `visitor_hash` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_hash` char(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resource_reactions_unique` (`resource_id`,`visitor_hash`),
  KEY `resource_reactions_resource_id_ip_hash_index` (`resource_id`,`ip_hash`),
  CONSTRAINT `resource_reactions_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Comments (every comment starts as pending)
CREATE TABLE IF NOT EXISTS `resource_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `resource_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `ip_hash` char(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_comments_resource_id_status_index` (`resource_id`,`status`),
  CONSTRAINT `resource_comments_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Communication assets linked to projects
CREATE TABLE IF NOT EXISTS `project_resource` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `resource_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_resource_project_id_resource_id_unique` (`project_id`,`resource_id`),
  KEY `project_resource_resource_id_foreign` (`resource_id`),
  CONSTRAINT `project_resource_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_resource_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Settings switches (only added if missing): reactions on, comments off
INSERT INTO `site_settings` (`key`, `value`, `type`, `group`, `created_at`, `updated_at`)
SELECT 'insights_reactions_enabled', '1', 'boolean', 'insights', NOW(), NOW() FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `site_settings` WHERE `key` = 'insights_reactions_enabled');

INSERT INTO `site_settings` (`key`, `value`, `type`, `group`, `created_at`, `updated_at`)
SELECT 'insights_comments_enabled', '0', 'boolean', 'insights', NOW(), NOW() FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `site_settings` WHERE `key` = 'insights_comments_enabled');

-- 8. Record the migrations so "php artisan migrate" knows they have run
SET @batch := (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT m.name, @batch FROM (
  SELECT '2026_11_10_000001_create_page_heroes_table' AS name UNION ALL
  SELECT '2026_11_10_000002_add_engagement_fields_to_resources_table' UNION ALL
  SELECT '2026_11_10_000003_create_resource_views_table' UNION ALL
  SELECT '2026_11_10_000004_create_resource_reactions_table' UNION ALL
  SELECT '2026_11_10_000005_create_resource_comments_table' UNION ALL
  SELECT '2026_11_10_000006_create_project_resource_table'
) AS m
WHERE NOT EXISTS (SELECT 1 FROM `migrations` WHERE `migration` = m.name);

-- 9. Read only check: old rows that are now hidden from the website
SELECT `id`, `title`, `type`, `is_published` FROM `resources` WHERE `type` IN ('publication', 'other') ORDER BY `id`;
