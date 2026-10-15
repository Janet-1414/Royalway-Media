-- MySQL dump 10.13  Distrib 9.0.1, for macos14 (arm64)
--
-- Host: localhost    Database: royalway
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('royalwaymedia-cache-site_settings','a:37:{s:9:\"site_name\";s:14:\"RoyalWay Media\";s:14:\"copyright_name\";s:18:\"RoyalWay Media Ltd\";s:12:\"footer_about\";s:209:\"At RoyalWay Media, we redefine excellence in integrated marketing and communications. Specializing in PR, Branding, Marketing, and Behavioral Change Communications, we transform ambitions into thriving brands.\";s:13:\"contact_email\";s:23:\"sales@royalwaymedia.com\";s:6:\"phones\";s:142:\"[{\"number\":\"+256 772 464 686\",\"label\":\"Mobile\"},{\"number\":\"+256 312 284 552\",\"label\":\"Office\"},{\"number\":\"+256 774 038 086\",\"label\":\"Mobile\"}]\";s:7:\"address\";s:55:\"Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda\";s:6:\"po_box\";s:22:\"P.O. Box 70348 Kampala\";s:12:\"office_hours\";s:30:\"Mon – Fri: 8:00am – 6:00pm\";s:17:\"google_maps_embed\";s:253:\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.748448252334!2d32.5882796!3d0.3390889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbba674754169%3A0x8a9ed4e73dc4c5b3!2sRoyalWay%20Media!5e0!3m2!1sen!2sug!4v1761603434898!5m2!1sen!2sug\";s:15:\"social_facebook\";s:42:\"https://www.facebook.com/RoyalWayMediaLtd/\";s:14:\"social_twitter\";s:33:\"https://twitter.com/RoyalWayMedia\";s:15:\"social_linkedin\";s:47:\"https://www.linkedin.com/company/royalway-media\";s:16:\"social_instagram\";s:39:\"https://www.instagram.com/royalwaymedia\";s:14:\"social_youtube\";s:63:\"https://www.youtube.com/channel/UC5292sL9n6DTH7p7Yh8HmOg/videos\";s:10:\"hero_title\";s:59:\"RoyalWay Media: Where Communications is catalyst for growth\";s:13:\"hero_subtitle\";s:116:\"We work with ambitious people and companies to help through creation, reinvention, or transformation of their brand.\";s:18:\"hero_button1_label\";s:15:\"Start a Project\";s:17:\"hero_button1_link\";s:8:\"/contact\";s:18:\"hero_button2_label\";s:8:\"Our Work\";s:17:\"hero_button2_link\";s:9:\"/projects\";s:14:\"homepage_stats\";s:134:\"[{\"number\":\"10+\",\"label\":\"Years of Experience\"},{\"number\":\"10+\",\"label\":\"Awards Won\"},{\"number\":\"150+\",\"label\":\"Satisfied Customers\"}]\";s:16:\"whatsapp_enabled\";s:1:\"1\";s:15:\"whatsapp_number\";s:12:\"256772464686\";s:21:\"whatsapp_display_name\";s:14:\"RoyalWay Media\";s:17:\"whatsapp_greeting\";s:109:\"Hi there! 👋 Planning a campaign, event or media project? Chat with us now we usually reply within minutes.\";s:16:\"whatsapp_prefill\";s:62:\"Hello RoyalWay Media, I\'d like to enquire about your services.\";s:17:\"whatsapp_position\";s:5:\"right\";s:9:\"seo_title\";s:53:\"RoyalWay Media | Marketing, PR & Events Agency Uganda\";s:15:\"seo_description\";s:148:\"Uganda\'s 360° integrated marketing and communications agency for PR, branding, events, experiential marketing and behavioral change communications.\";s:19:\"company_profile_pdf\";s:39:\"site/royalway-media-company-profile.pdf\";s:19:\"company_profile_url\";s:0:\"\";s:19:\"google_business_url\";s:0:\"\";s:10:\"hero_video\";s:40:\"site/hero/01M48VZDHEV0GK6NJPFQDGGTB4.mp4\";s:11:\"hero_poster\";s:40:\"site/hero/01M48VZDJ31ZB3R0BQNX6HVZA4.jpg\";s:12:\"seo_og_image\";s:35:\"site/01M48VZDJ4B056M6W8FD07QPCM.jpg\";s:21:\"google_search_console\";s:0:\"\";s:19:\"google_analytics_id\";s:12:\"G-ENGF6842SD\";}',2106677193);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_submissions_status_index` (`status`),
  KEY `contact_submissions_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_briefs`
--

DROP TABLE IF EXISTS `event_briefs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event_briefs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_nature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setup` enum('indoor','outdoor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_count` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venue_setup` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sound_visuals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `decoration` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `hospitality` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `branding` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `additional_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('new','reviewed','quoted','confirmed','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_briefs_status_index` (`status`),
  KEY `event_briefs_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_briefs`
--

LOCK TABLES `event_briefs` WRITE;
/*!40000 ALTER TABLE `event_briefs` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_briefs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_01_000001_create_projects_table',2),(5,'2024_01_01_000002_create_services_table',2),(6,'2024_01_01_000003_create_team_members_table',2),(7,'2024_01_01_000004_create_resources_table',2),(8,'2024_01_01_000005_create_policies_table',2),(9,'2024_01_01_000006_create_contact_submissions_table',2),(10,'2024_01_01_000007_create_event_briefs_table',2),(11,'2024_01_01_000008_create_partners_table',2),(12,'2024_01_01_000009_create_site_settings_table',2),(13,'2026_03_06_083001_remove_unused_columns_from_projects_table',3),(14,'2026_03_06_083856_update_projects_add_partner_and_results',3),(15,'2026_03_06_085150_create_project_service_table',3),(16,'2026_10_06_000001_add_enhanced_fields_to_services_table',4),(17,'2026_10_06_000002_add_enhanced_fields_to_projects_table',4),(18,'2026_10_06_100001_add_show_cover_to_resources_table',5),(19,'2026_10_06_142829_add_seo_fields_to_content_tables',6),(20,'2026_10_06_200000_normalize_project_side_card_items',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `partners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partners_is_active_index` (`is_active`),
  KEY `partners_order_index` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (2,'Airtel Uganda','partners/airtel-uganda.png','https://www.airtel.co.ug',NULL,6,1,'2026-01-06 18:23:51','2026-10-06 17:06:19'),(3,'ABSA','partners/absa.png','https://www.absa.co.ug',NULL,8,1,'2026-01-06 18:24:06','2026-10-06 17:06:19'),(4,'Agricultural Business Initiative (aBi)','partners/agricultural-business-initiative-abi.png','https://www.abi.co.ug/',NULL,4,1,'2026-01-06 18:24:22','2026-10-06 17:06:19'),(5,'Uganda Tourism Board','partners/uganda-tourism-board.png','https://utb.go.ug/',NULL,16,1,'2026-01-06 18:24:36','2026-10-06 17:06:19'),(6,'UN Women','partners/un-women.png','https://www.unwomen.org/en',NULL,7,1,'2026-01-06 18:24:55','2026-10-06 17:06:19'),(7,'European Union','partners/european-union.png','https://european-union.europa.eu/index_en',NULL,1,1,'2026-01-06 18:25:13','2026-10-06 17:06:19'),(8,'British Council','partners/british-council.png','https://www.britishcouncil.org/',NULL,10,1,'2026-01-06 18:25:54','2026-10-06 17:06:19'),(9,'DTB','partners/dtb.png','https://dtbu.dtbafrica.com',NULL,9,1,'2026-01-06 18:26:06','2026-10-06 17:06:19'),(10,'Private Sector Foundation Uganda','partners/private-sector-foundation-uganda.png','https://www.psfuganda.org/',NULL,14,1,'2026-01-06 18:26:19','2026-10-06 17:06:19'),(11,'Embassy of Ireland','partners/embassy-of-ireland.png','https://www.dfa.ie/irish-embassy/uganda/',NULL,12,1,'2026-01-06 18:27:05','2026-10-06 17:06:19'),(12,'Standard Chartered Bank','partners/standard-chartered-bank.png','https://www.sc.com',NULL,5,1,'2026-01-06 18:27:34','2026-10-06 17:06:19'),(13,'United Nations Development Programme','partners/united-nations-development-programme.png','https://www.undp.org/',NULL,3,1,'2026-01-06 18:28:02','2026-10-06 17:06:19'),(14,'SNV','partners/snv.png','https://www.snv.org/',NULL,15,1,'2026-01-06 18:28:13','2026-10-06 17:06:19'),(15,'Joh Hopkins','partners/01KE9QY8X3J0GP62E494KCMRTP.png',NULL,NULL,10,0,'2026-01-06 18:29:01','2026-10-06 17:06:19'),(16,'amre','partners/01KE9QYVSCXX4QBJDCK6MXH66M.png',NULL,NULL,11,0,'2026-01-06 18:29:20','2026-10-06 17:06:19'),(17,'Airtel','partners/01KE9R316Y6GAQ3H6ZHPSCTH7J.png',NULL,NULL,12,0,'2026-01-06 18:31:37','2026-10-06 17:06:19'),(18,'ABSA','partners/01KE9R3QX3YHV2006QP691S27C.png',NULL,NULL,13,0,'2026-01-06 18:32:00','2026-10-06 17:06:19'),(19,'ABI','partners/01KE9R5CTRVNFPZVBGTRSTWWW1.png',NULL,NULL,14,0,'2026-01-06 18:32:55','2026-10-06 17:06:19'),(20,'European Union','partners/european-union.png','https://european-union.europa.eu/index_en',NULL,1,0,'2026-10-06 16:56:54','2026-10-06 17:06:19'),(21,'UNICEF','partners/unicef.png','https://www.unicef.org/',NULL,2,1,'2026-10-06 16:56:55','2026-10-06 16:56:55'),(22,'Amref Health Africa','partners/amref-health-africa.png','https://amref.org/',NULL,11,1,'2026-10-06 17:06:19','2026-10-06 17:06:19'),(23,'Johns Hopkins University','partners/johns-hopkins-university.png','https://www.jhu.edu/',NULL,13,1,'2026-10-06 17:06:19','2026-10-06 17:06:19');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `policies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `badge_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `effective_date` date DEFAULT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policies_slug_unique` (`slug`),
  KEY `policies_slug_index` (`slug`),
  KEY `policies_is_published_index` (`is_published`),
  KEY `policies_order_index` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `policies`
--

LOCK TABLES `policies` WRITE;
/*!40000 ALTER TABLE `policies` DISABLE KEYS */;
INSERT INTO `policies` VALUES (1,'Zero Tolerance to Corruption','zero-tolerance-to-corruption','Ethical Today, Thriving Tomorrow','<p>RoyalWay Media Ltd, as a leading integrated marketing, events, and communications agency, is committed to upholding the highest standards of integrity and transparency in all its operations.</p><p>The company is committed to serve its clientele, including corporate entities, government bodies, and international Development organizations, through services such as PR, advertising, branding, experiential marketing, corporate events planning, and behavioral change communications.</p><p>This Anti-Corruption Policy, effective from February 17, 2025, underscores RoyalWay Media\'s dedication to ethical conduct and zero tolerance for corruption, ensuring that its operations across Uganda, Rwanda, and beyond reflect fairness, accountability, and trust.</p><p>The policy explicitly prohibits all forms of corruption, including bribery, extortion, fraud, nepotism, and misuse of influence for personal gain.</p><p>Royalway Media enforces a strict no-bribe policy, rejecting any offers, promises, or acceptance of improper advantages, whether through cash, gifts, or favors, to maintain objectivity and fairness in business dealings.</p><p>Transparency is central to the company\'s practices, with clear pricing, accurate record-keeping, and regular audits ensuring compliance with local laws, such as Uganda\'s Anti-Corruption Act (2009), and international anti-corruption standards.</p><p>RoyalWay Media fosters ethical partnerships by conducting due diligence on suppliers, subcontractors, and third parties to ensure alignment with its anti-corruption values.</p><p>Contracts include clauses mandating ethical adherence, and the company encourages partners to report concerns without fear of retaliation.</p><p>Hiring, promotions, and project assignments are merit- based, free from favoritism or undue influence, ensuring impartiality in talent selection and talent engagement for events and campaigns.</p><p>The company invests in regular employee training on anti-corruption policies and ethical decision-making, fostering a culture of accountability across its remote-first team.</p><p>Concerns and suspicions can be reported confidentially via email (compliance@royalwaymedia.com) or an anonymous hotline (+256772464686), with a promise of acknowledgment within 48 hours, thorough investigations within 10 business days, and protection against retaliation for whistleblowers.</p><p>We invite all our employees, clients, and partners to share in the responsibility of maintaining a corruption-free environment, ensuring that every project reflects its commitment to excellence and integrity.</p>','policies/sidebar/01K95H2CQWHSJJCWNKM688JE5C.jpg','[{\"type\": \"phone\", \"label\": \"Phone\", \"value\": \"+256-772-464-686\"}, {\"type\": \"email\", \"label\": \"Email\", \"value\": \"sales@royalwaymedia.com\"}]','2025-10-27','1.0',1,0,'2025-11-03 15:53:29','2025-11-03 15:53:29'),(2,'Our Customer Service Pledge','our-customer-service-pledge','You call we deliver a professional response','<p>RoyalWay Media Ltd a premier integrated marketing and communications agency, is dedicated to delivering exceptional customer service that aligns with its mission to elevate and delivering transformative experiences to all our customers.<br>We offer a wide range of services, including PR and Media Management, Advertising, Branding, Experiential Marketing, Corporate Events Planning, and Behavioral Change Communications, as outlined on www.<br>royalwaymedia.<br>com.<br>This Customer Service policy reflects RoyalWay Media’s commitment to fostering meaningful, seamless, and inspiring client interactions, ensuring every partnership drives impactful results with a client-centered approach.<br>The policy emphasizes responsive communication, promising to address all client inquiries—via email, phone, or website contact form—within 12 business hours, with immediate acknowledgment for urgent matters.<br>Clients can reach the team at sales@royalwaymedia.<br>com or +256- 772464686 during office hours (Monday to Friday- 8am-8.<br>00pm and Saturdays 8am-4.<br>00pm) Transparency and collaboration are core to the company’s approach.<br>RoyalWay Media provides clear timelines, detailed project updates, and transparent pricing, welcoming client feedback to refine deliverables and exceed expectations.<br>Quality assurance is integral, with every project undergoing rigorous checks to ensure creativity, precision, and strategic alignment.<br>For concerns or feedback, we encourage clients to contact our dedicated customer service team, promising acknowledgment within 24 business hours, a detailed response within 5 business days, and ongoing updates for complex issues.<br>We are committed to continuous improvement, reviewing its policy annually to adapt to evolving client needs and industry trends.<br>By building lasting partnerships, RoyalWay Media transforms client ambitions into reality through innovative, high-quality services.</p>','policies/sidebar/01K961NZ8VCTDA33XJEWX8EBHB.jpg','[{\"type\": \"email\", \"label\": \"Email\", \"value\": \"sales@royalwaymedia.com\"}, {\"type\": \"phone\", \"label\": \"Phone\", \"value\": \"+256-772-464-686\"}, {\"type\": \"office_hours\", \"label\": \"Office hours\", \"value\": \"Monday to Friday- 8am-8.00pm\\nSaturdays 8am-4.00pm\"}, {\"type\": \"address\", \"label\": \"Location\", \"value\": \"Plot 23, Cooper Road, Kisementi-Kololo\"}]','2025-10-27','1.0',1,0,'2025-11-03 20:43:48','2025-11-03 20:43:48');
/*!40000 ALTER TABLE `policies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_service`
--

DROP TABLE IF EXISTS `project_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_service` (
  `project_id` bigint unsigned NOT NULL,
  `service_id` bigint unsigned NOT NULL,
  KEY `project_service_project_id_foreign` (`project_id`),
  KEY `project_service_service_id_foreign` (`service_id`),
  CONSTRAINT `project_service_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_service`
--

LOCK TABLES `project_service` WRITE;
/*!40000 ALTER TABLE `project_service` DISABLE KEYS */;
INSERT INTO `project_service` VALUES (1,17),(1,20),(1,21),(1,19),(1,18),(2,21),(2,18),(3,19),(3,17),(3,20),(4,20),(4,17),(4,19),(4,18),(5,20),(5,19),(5,18),(5,22),(6,20),(6,18),(6,19);
/*!40000 ALTER TABLE `project_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead` text COLLATE utf8mb4_unicode_ci,
  `challenge` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `narrative_blocks` json DEFAULT NULL,
  `side_card_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `side_card_items` json DEFAULT NULL,
  `headline_stats` json DEFAULT NULL,
  `results` longtext COLLATE utf8mb4_unicode_ci,
  `result_channels` json DEFAULT NULL,
  `result_kpis` json DEFAULT NULL,
  `results_footnote` text COLLATE utf8mb4_unicode_ci,
  `outcome_text` text COLLATE utf8mb4_unicode_ci,
  `report_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary_pdf` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `project_date` date DEFAULT NULL,
  `download_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `partner_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_slug_unique` (`slug`),
  KEY `projects_slug_index` (`slug`),
  KEY `projects_category_index` (`category`),
  KEY `projects_is_published_index` (`is_published`),
  KEY `projects_is_featured_index` (`is_featured`),
  KEY `projects_partner_id_foreign` (`partner_id`),
  CONSTRAINT `projects_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'10 Years of Impact: Standard Chartered Bank','10-years-of-impact-standard-chartered-bank','Standard Chartered Bank Uganda',NULL,'As the top 360 marketing agency in Uganda, we have had an opportunity to work with Standard Chartered Bank for over 10 years across various Brand & marketing communications channels.','As the top 360 marketing agency in Uganda, we have had an opportunity to work with Standard Chartered Bank for over 10 years across various Brand & marketing communications channels.','<p><strong>As the top 360 marketing agency in Uganda we have worked with Standard Chartered Bank for over 10 years across brand and marketing communications channels including Branding, Media Management, and Experiential Marketing &amp; Events.</strong></p>\n<h3>Target Market</h3>\n<p>Standard Chartered primarily focuses on serving corporate and institutional clients, as well as high-net-worth individuals globally.</p>\n<h3>Objectives</h3>\n<ol>\n<li>Increase brand awareness and familiarity among the bank\'s target audience</li>\n<li>Customer onboarding across various client marketing segments</li>\n<li>Customer education and assistance on product penetration, driving the retail products promotions agenda</li>\n<li>Plan and manage bank events for internal and external stakeholders</li>\n<li>Public relations and media management</li>\n</ol>\n<h3>Services Offered</h3>\n<ul>\n<li><strong>Advertising, PR &amp; Media Management</strong> — Comprehensive media strategies and public relations management.</li>\n<li><strong>Events Planning &amp; Management</strong> — Full-service event coordination and execution.</li>\n<li><strong>Customer Onboarding &amp; Promotions</strong> — Strategic customer acquisition and engagement campaigns.</li>\n<li><strong>Printing &amp; Production</strong> — High-quality print materials and production services.</li>\n</ul>\n<h3>Strategy &amp; Tactics</h3>\n<p>We developed a multi-faceted strategy that included brand concepts, media relations and event management plans. Marketing executions covered corporate and CSR sponsorships — event planning, publicity, guest invitations and logistics such as catering, transport, décor and communication tools.</p>\n<p>We carried out promotions to create awareness of bank products, including brochures, customization of international documents for the local market, and media relations — developing and distributing press releases and writing supplements.</p>','[{\"body\": \"<p>Standard Chartered primarily focuses on serving corporate and institutional clients, as well as high-net-worth individuals globally.</p>\", \"heading\": \"Target Market\"}, {\"body\": \"<ol>\\n<li>Increase brand awareness and familiarity among the bank\'s target audience</li>\\n<li>Customer onboarding across various client marketing segments</li>\\n<li>Customer education and assistance on product penetration, driving the retail products promotions agenda</li>\\n<li>Plan and manage bank events for internal and external stakeholders</li>\\n<li>Public relations and media management</li>\\n</ol>\", \"heading\": \"Objectives\"}, {\"body\": \"<ul>\\n<li><strong>Advertising, PR &amp; Media Management</strong> — Comprehensive media strategies and public relations management.</li>\\n<li><strong>Events Planning &amp; Management</strong> — Full-service event coordination and execution.</li>\\n<li><strong>Customer Onboarding &amp; Promotions</strong> — Strategic customer acquisition and engagement campaigns.</li>\\n<li><strong>Printing &amp; Production</strong> — High-quality print materials and production services.</li>\\n</ul>\", \"heading\": \"Services Offered\"}, {\"body\": \"<p>We developed a multi-faceted strategy that included brand concepts, media relations and event management plans. Marketing executions covered corporate and CSR sponsorships — event planning, publicity, guest invitations and logistics such as catering, transport, décor and communication tools.</p>\\n<p>We carried out promotions to create awareness of bank products, including brochures, customization of international documents for the local market, and media relations — developing and distributing press releases and writing supplements.</p>\", \"heading\": \"Strategy & Tactics\"}]','Services delivered','[\"Advertising, PR & Media Management — Comprehensive media strategies and public relations management.\", \"Events Planning & Management — Full-service event coordination and execution.\", \"Customer Onboarding & Promotions — Strategic customer acquisition and engagement campaigns.\", \"Printing & Production — High-quality print materials and production services.\"]',NULL,'<ol>\n<li>Increased bank visibility, maintaining its position as one of the leading commercial banks in Uganda.</li>\n<li>Increased retail product penetration, onboarding over 50,000 new customers.</li>\n<li>Increased media value earned and content gained through PR and marketing activities.</li>\n</ol>\n<p>Marketing campaigns boosted engagement around the bank\'s brand, prolonging customer lifetime value.</p>',NULL,NULL,NULL,'Increased bank visibility, maintaining its position as one of the leading commercial banks in Uganda. Increased retail product penetration, onboarding over 50,000 new customers. Increased media value earned and content gained through PR and marketing activities. Marketing campaigns boosted engagement around the bank\'s brand, prolonging customer lifetime value.',NULL,NULL,NULL,NULL,'projects/featured/4d-min1702130143.png','[\"projects\\/gallery\\/a1701713283.jpg\",\"projects\\/gallery\\/b1701713283.jpg\"]','Strategic Communications','Uganda',NULL,1,1,'2023-12-04',NULL,'2026-10-06 05:36:30','2026-10-06 17:06:19',12),(2,'Airtel Nationwide Mobile Marketing Success','airtel-nationwide-mobile-marketing-success','Airtel Uganda',NULL,'Since 2021, Airtel Uganda partnered with RoyalWay Media for countrywide Mobile Marketing Activations, covering 70+ districts, promoting products and services.','Since 2021, Airtel Uganda partnered with RoyalWay Media for countrywide Mobile Marketing Activations, covering 70+ districts, promoting products and services.','<p><strong>Since 2021, Airtel Uganda has partnered with RoyalWay Media to design and implement countrywide mobile promotions and BTL marketing campaigns, reaching consumers in over 70 districts across Central, Western, Eastern and Northern Uganda.</strong></p>\n<h3>National Coverage</h3>\n<p>Our BTL campaigns span over 70 districts in all four regions of Uganda, ensuring maximum market penetration and customer engagement across diverse geographic and demographic segments.</p>\n<h3>Services Provided</h3>\n<ul>\n<li><strong>Contact Center Launches</strong> — Launch of 58 contact centers countrywide, including shop launches and logistics supplies.</li>\n<li><strong>Customer Product Education</strong> — Education programs on Airtel products and services.</li>\n<li><strong>Customer Acquisitions</strong> — SIM card sales, Mobile Money registrations and airtime activations.</li>\n<li><strong>Field Query Resolution</strong> — Resolving field queries including SIM blocks and barring issues.</li>\n<li><strong>Product Activations</strong> — Mobile Money activations and promotional campaigns such as Freaky Fridays.</li>\n<li><strong>Field Customer Service</strong> — Comprehensive field customer service support.</li>\n</ul>','[{\"body\": \"<p>Our BTL campaigns span over 70 districts in all four regions of Uganda, ensuring maximum market penetration and customer engagement across diverse geographic and demographic segments.</p>\", \"heading\": \"National Coverage\"}, {\"body\": \"<ul>\\n<li><strong>Contact Center Launches</strong> — Launch of 58 contact centers countrywide, including shop launches and logistics supplies.</li>\\n<li><strong>Customer Product Education</strong> — Education programs on Airtel products and services.</li>\\n<li><strong>Customer Acquisitions</strong> — SIM card sales, Mobile Money registrations and airtime activations.</li>\\n<li><strong>Field Query Resolution</strong> — Resolving field queries including SIM blocks and barring issues.</li>\\n<li><strong>Product Activations</strong> — Mobile Money activations and promotional campaigns such as Freaky Fridays.</li>\\n<li><strong>Field Customer Service</strong> — Comprehensive field customer service support.</li>\\n</ul>\", \"heading\": \"Services Provided\"}]','Services delivered','[\"Contact Center Launches — Launch of 58 contact centers countrywide, including shop launches and logistics supplies.\", \"Customer Product Education — Education programs on Airtel products and services.\", \"Customer Acquisitions — SIM card sales, Mobile Money registrations and airtime activations.\", \"Field Query Resolution — Resolving field queries including SIM blocks and barring issues.\", \"Product Activations — Mobile Money activations and promotional campaigns such as Freaky Fridays.\", \"Field Customer Service — Comprehensive field customer service support.\"]',NULL,'<p>Our partnership has delivered nationwide market penetration through strategic BTL campaigns: 58 contact centers launched, significantly increased customer acquisition, and improved customer satisfaction through field support — strengthening Airtel\'s brand visibility and customer loyalty across all four regions of Uganda.</p>',NULL,NULL,NULL,'Our partnership has delivered nationwide market penetration through strategic BTL campaigns: 58 contact centers launched, significantly increased customer acquisition, and improved customer satisfaction through field support — strengthening Airtel\'s brand visibility and customer loyalty across all four regions of Uganda.',NULL,NULL,NULL,NULL,'projects/featured/air-min1701170256.png','[\"projects\\/gallery\\/cc1701713844.jpg\",\"projects\\/gallery\\/aa1701713843.jpg\",\"projects\\/gallery\\/bb1701713843.jpg\",\"projects\\/gallery\\/air-min1701170256.png\",\"projects\\/gallery\\/4-min1701116628.png\"]','Experiential Marketing','Uganda',NULL,1,1,'2023-12-04',NULL,'2026-10-06 05:55:02','2026-10-06 17:06:19',2),(3,'UNICEF\'s Media Services for Child Rights in Uganda','unicefs-media-services-for-child-rights-in-uganda','UNICEF Uganda',NULL,'UNICEF Uganda amplifies child rights through strategic media services—advocacy, mass messaging—empowering voices, reaching hearts nationwide.','UNICEF Uganda amplifies child rights through strategic media services—advocacy, mass messaging—empowering voices, reaching hearts nationwide.','<p><strong>UNICEF Uganda is mandated by the United Nations to advocate for the protection of children\'s rights, help meet their basic needs, and expand their opportunities to reach their full potential.</strong></p>\n<h3>Communication Mission</h3>\n<p>Communication is integral to UNICEF Uganda\'s work, ranging from focused advocacy to mass media messages targeting large segments of the population. Mass media advertising allows messages to reach large populations across different geographic and demographic segments.</p>\n<h3>Partnership Overview</h3>\n<p>Over the past six years, UNICEF engaged RoyalWay Media to develop media strategies for multimedia campaigns and provide translation and production services for radio spots, TV spots, infomercials, online/social media content and documentaries.</p>\n<h3>Services Provided</h3>\n<ul>\n<li><strong>Media Strategy Development</strong> — Media strategy planning for child rights campaigns.</li>\n<li><strong>Communication Media Plans</strong> — Targeted communication media plans.</li>\n<li><strong>Radio &amp; TV Production</strong> — Production of radio and TV spots, plus translation services.</li>\n<li><strong>Media Rate Negotiation</strong> — Competitive media rates and bonuses for maximum reach.</li>\n<li><strong>Copywriting &amp; Translation</strong> — Professional copywriting and translation into local languages.</li>\n<li><strong>Online Content Development</strong> — Engaging content for digital platforms and social media.</li>\n</ul>','[{\"body\": \"<p>Communication is integral to UNICEF Uganda\'s work, ranging from focused advocacy to mass media messages targeting large segments of the population. Mass media advertising allows messages to reach large populations across different geographic and demographic segments.</p>\", \"heading\": \"Communication Mission\"}, {\"body\": \"<p>Over the past six years, UNICEF engaged RoyalWay Media to develop media strategies for multimedia campaigns and provide translation and production services for radio spots, TV spots, infomercials, online/social media content and documentaries.</p>\", \"heading\": \"Partnership Overview\"}, {\"body\": \"<ul>\\n<li><strong>Media Strategy Development</strong> — Media strategy planning for child rights campaigns.</li>\\n<li><strong>Communication Media Plans</strong> — Targeted communication media plans.</li>\\n<li><strong>Radio &amp; TV Production</strong> — Production of radio and TV spots, plus translation services.</li>\\n<li><strong>Media Rate Negotiation</strong> — Competitive media rates and bonuses for maximum reach.</li>\\n<li><strong>Copywriting &amp; Translation</strong> — Professional copywriting and translation into local languages.</li>\\n<li><strong>Online Content Development</strong> — Engaging content for digital platforms and social media.</li>\\n</ul>\", \"heading\": \"Services Provided\"}]','Services delivered','[\"Media Strategy Development — Media strategy planning for child rights campaigns.\", \"Communication Media Plans — Targeted communication media plans.\", \"Radio & TV Production — Production of radio and TV spots, plus translation services.\", \"Media Rate Negotiation — Competitive media rates and bonuses for maximum reach.\", \"Copywriting & Translation — Professional copywriting and translation into local languages.\", \"Online Content Development — Engaging content for digital platforms and social media.\"]',NULL,'<p>Through our six-year partnership we have delivered multimedia campaigns that significantly enhanced awareness of children\'s rights across Uganda. Strategic media planning, content production and multi-language translation enabled UNICEF to reach diverse audiences nationwide, contributing to improved child protection and advocacy outcomes.</p>',NULL,NULL,NULL,'Through our six-year partnership we have delivered multimedia campaigns that significantly enhanced awareness of children\'s rights across Uganda. Strategic media planning, content production and multi-language translation enabled UNICEF to reach diverse audiences nationwide, contributing to improved child protection and advocacy outcomes.',NULL,NULL,NULL,NULL,'projects/featured/4e-min1702131185.png','[\"projects\\/gallery\\/131701729298.jpg\",\"projects\\/gallery\\/121701729297.png\",\"projects\\/gallery\\/111701729297.jpg\"]','PR & Media','Uganda',NULL,1,1,'2023-12-05',NULL,'2026-10-06 05:55:02','2026-10-06 17:06:19',21),(4,'The European Union\'s Impact in Uganda','the-european-unions-impact-in-uganda','The European Union Delegation to Uganda',NULL,'The European Union, a key political and economic force in Uganda, leads in development support, emerging as the largest donor. Positioned as a strategic catalyst for growth.','The European Union, a key political and economic force in Uganda, leads in development support, emerging as the largest donor. Positioned as a strategic catalyst for growth.','<p><strong>The European Union and its member states are major political and economic actors in Uganda, and the EU\'s development support makes it the largest donor in the country.</strong></p>\n<h3>The Problem</h3>\n<p>Despite the major impact of EU activities in Uganda, awareness among Ugandans of the EU\'s role and contributions to the country\'s development was low. The EU sought to increase communication and visibility around its projects, and to provide accountability and transparency on the use of EU funds to taxpayers in member states and citizens of Uganda.</p>\n<h3>Solution</h3>\n<p>RoyalWay Media is implementing a nationwide communication and visibility intervention to enhance awareness of the EU\'s activities in Uganda, especially grant support — through traditional media (with emphasis on radio) and social media, telling concrete stories of beneficiaries.</p>\n<p><strong>Key focus areas:</strong></p>\n<ul>\n<li>Promoting Green Partnerships</li>\n<li>Promoting sustainable and inclusive growth and jobs</li>\n<li>Promoting democratic governance and social inclusion in private sector activities</li>\n<li>EU support targeting both Ugandans and refugees</li>\n</ul>\n<h3>Communication &amp; Visibility Services</h3>\n<ul>\n<li><strong>Media Buying and Coordination</strong></li>\n<li><strong>EU Events Planning and Management</strong></li>\n<li><strong>Supply of Branded Materials</strong></li>\n<li><strong>Social Media Management</strong></li>\n<li><strong>PR/Media Coordination &amp; Monitoring</strong></li>\n<li><strong>Perception Surveys</strong></li>\n<li><strong>Visual/Billboard Campaigns</strong></li>\n<li><strong>Photography/Video Production</strong></li>\n</ul>','[{\"body\": \"<p>Despite the major impact of EU activities in Uganda, awareness among Ugandans of the EU\'s role and contributions to the country\'s development was low. The EU sought to increase communication and visibility around its projects, and to provide accountability and transparency on the use of EU funds to taxpayers in member states and citizens of Uganda.</p>\", \"heading\": \"The Problem\"}, {\"body\": \"<p>RoyalWay Media is implementing a nationwide communication and visibility intervention to enhance awareness of the EU\'s activities in Uganda, especially grant support — through traditional media (with emphasis on radio) and social media, telling concrete stories of beneficiaries.</p>\\n<p><strong>Key focus areas:</strong></p>\\n<ul>\\n<li>Promoting Green Partnerships</li>\\n<li>Promoting sustainable and inclusive growth and jobs</li>\\n<li>Promoting democratic governance and social inclusion in private sector activities</li>\\n<li>EU support targeting both Ugandans and refugees</li>\\n</ul>\", \"heading\": \"Solution\"}, {\"body\": \"<ul>\\n<li><strong>Media Buying and Coordination</strong></li>\\n<li><strong>EU Events Planning and Management</strong></li>\\n<li><strong>Supply of Branded Materials</strong></li>\\n<li><strong>Social Media Management</strong></li>\\n<li><strong>PR/Media Coordination &amp; Monitoring</strong></li>\\n<li><strong>Perception Surveys</strong></li>\\n<li><strong>Visual/Billboard Campaigns</strong></li>\\n<li><strong>Photography/Video Production</strong></li>\\n</ul>\", \"heading\": \"Communication & Visibility Services\"}]','Services delivered',NULL,NULL,'<p>Over the past year we have implemented events, media management, editorial support and content development, social and digital management, and photography and video production — enhancing the visibility of the European Union and Team Europe in Uganda and improving awareness of the EU–Uganda partnership in all its dimensions.</p>',NULL,NULL,NULL,'Over the past year we have implemented events, media management, editorial support and content development, social and digital management, and photography and video production — enhancing the visibility of the European Union and Team Europe in Uganda and improving awareness of the EU–Uganda partnership in all its dimensions.',NULL,NULL,NULL,NULL,'projects/featured/5f-min1702130986.png','[\"projects\\/gallery\\/zz1701729476.png\",\"projects\\/gallery\\/xx1701729475.png\",\"projects\\/gallery\\/yy1701729475.png\"]','Strategic Communications','Uganda',NULL,1,1,'2023-12-05',NULL,'2026-10-06 05:55:02','2026-10-06 17:06:19',7),(5,'Cultivating Prosperity: aBi\'s Impact','cultivating-prosperity-abis-impact','Agricultural Business Initiative (aBi)',NULL,'aBi, a social enterprise, directs development funding to agribusinesses, fostering a competitive, profitable, and sustainable agriculture sector in Uganda.','aBi, a social enterprise, directs development funding to agribusinesses, fostering a competitive, profitable, and sustainable agriculture sector in Uganda.','<p><strong>The Agricultural Business Initiative (aBi) is a social enterprise that channels development cooperation funding to agribusinesses and agricultural service providers, building a competitive, profitable and sustainable agriculture sector in support of equitable wealth creation in Uganda.</strong></p>\n<h3>Project Overview</h3>\n<p>Following the launch of the green agribusiness taxonomy and the aBi Green Finance Fund in December 2022, aBi Finance contracted RoyalWay Media to develop IEC communication tools, conduct district-level activations and use mass media to create awareness of the green taxonomy and green finance.</p>\n<p><strong>Target districts:</strong> Kabale, Ntungamo, Bushenyi, Mbarara, Kasese, Fort Portal, Hoima, Masindi, Masaka, Kampala, Wakiso, Mukono, Jinja, Tororo, Mbale, Soroti, Lira, Moroto, Gulu and Arua.</p>\n<h3>Services Provided</h3>\n<ul>\n<li>Development and dissemination of green finance IEC materials — wallboards, stickers, animation clips, brochures and pull-up banners</li>\n<li>Constant visual reminders about green financing information</li>\n<li>Distribution of IEC materials to 1,500 financial institutions in Uganda</li>\n<li>Launch event sensitizing top-tier stakeholders on green finance</li>\n<li>District-level green finance activations</li>\n<li>Media coordination across TV, radio and digital channels</li>\n</ul>','[{\"body\": \"<p>Following the launch of the green agribusiness taxonomy and the aBi Green Finance Fund in December 2022, aBi Finance contracted RoyalWay Media to develop IEC communication tools, conduct district-level activations and use mass media to create awareness of the green taxonomy and green finance.</p>\\n<p><strong>Target districts:</strong> Kabale, Ntungamo, Bushenyi, Mbarara, Kasese, Fort Portal, Hoima, Masindi, Masaka, Kampala, Wakiso, Mukono, Jinja, Tororo, Mbale, Soroti, Lira, Moroto, Gulu and Arua.</p>\", \"heading\": \"Project Overview\"}, {\"body\": \"<ul>\\n<li>Development and dissemination of green finance IEC materials — wallboards, stickers, animation clips, brochures and pull-up banners</li>\\n<li>Constant visual reminders about green financing information</li>\\n<li>Distribution of IEC materials to 1,500 financial institutions in Uganda</li>\\n<li>Launch event sensitizing top-tier stakeholders on green finance</li>\\n<li>District-level green finance activations</li>\\n<li>Media coordination across TV, radio and digital channels</li>\\n</ul>\", \"heading\": \"Services Provided\"}]','Services delivered','[\"Development and dissemination of green finance IEC materials — wallboards, stickers, animation clips, brochures and pull-up banners\", \"Constant visual reminders about green financing information\", \"Distribution of IEC materials to 1,500 financial institutions in Uganda\", \"Launch event sensitizing top-tier stakeholders on green finance\", \"District-level green finance activations\", \"Media coordination across TV, radio and digital channels\"]',NULL,'<ul>\n<li>Successful stakeholder launch event</li>\n<li>Activations in 20 districts across Uganda</li>\n<li>IEC tools delivered — wallboards, stickers, animation clips, brochures and pull-up banners</li>\n<li>Messages disseminated in 1,500 financial institutions</li>\n<li>Media outputs across multiple channels</li>\n<li>Enhanced awareness of the green finance taxonomy among financial institutions</li>\n</ul>\n<p>The campaign laid a strong foundation for green finance adoption in Uganda\'s agricultural sector, positioning aBi Finance as a leader in sustainable agricultural development.</p>',NULL,NULL,NULL,'Successful stakeholder launch event Activations in 20 districts across Uganda IEC tools delivered — wallboards, stickers, animation clips, brochures and pull-up banners Messages disseminated in 1,500 financial institutions Media outputs across multiple channels Enhanced awareness of the green finance taxonomy among financial institutions The campaign laid a strong foundation for green finance adoption in Uganda\'s agricultural sector, positioning aBi Finance as a leader in sustainable agricultura...',NULL,NULL,NULL,NULL,'projects/featured/3c-min1702130141.png',NULL,'Events Planning','Uganda',NULL,1,1,'2023-12-05',NULL,'2026-10-06 05:55:02','2026-10-06 17:06:19',4),(6,'3rd Africa Climate Finance Conference','3rd-africa-climate-finance-conference','Climate Finance and Sustainability (CFS) Centre',NULL,'From Commitments to Capital: Operationalizing Africa\'s Climate Finance Architecture — a two-day high-level convening of about 300 stakeholders in Kampala, Uganda.','From Commitments to Capital: Operationalizing Africa\'s Climate Finance Architecture.','<h3>Overview</h3><p>This is the third annual conference organized by the Climate Finance and Sustainability (CFS) Centre in collaboration with the Africa Research and Impact Network (ARIN), Frankfurt School of Finance and Management (FS), and the Uganda Institute of Banking and Financial Services (UIBFS).</p>\n<p>The 2026 conference builds on the momentum of the 2025 conference and focuses on translating Africa\'s climate finance commitments into bankable investments, implementable policies, and scalable innovations. Grounded in evidence from ARIN\'s regional convenings and the forthcoming <em>Africa\'s Climate Finance Outlook, 2026</em>, this year\'s agenda is built on real-world experiences from across the continent.</p><h3>Details</h3><p>The 2025 conference drew over 200 participants from across the continent and catalyzed national dialogue on climate finance. Building on these outcomes, ARIN has been convening a series of regional climate finance convenings across Africa. Insights from these convenings, alongside fellow-led research, are being synthesized into <em>Africa\'s Climate Finance Outlook, 2026</em>, a flagship continental report.</p>\n<p>The Third Annual Climate Finance Conference (#3ACFC26) aligns with post-COP28 efforts to define country-led Article 6 pathways and ongoing continental efforts under the Africa Climate Change Strategy. The goal is to accelerate the translation of Africa\'s climate finance commitments into bankable investments, inclusive financial innovations, and actionable delivery systems through a high-level convening of multiple stakeholders.</p>\n<p>The two-day conference took place from 1st to 2nd September 2026 at the Marriott Hotel, Kampala, with proceedings delivered through keynote speeches, panel discussions, and research disseminations organized along thematic sessions, gathering a multi-disciplinary audience of about 300 stakeholders in climate finance and sustainability.</p>','[{\"body\": \"<p>This is the third annual conference organized by the Climate Finance and Sustainability (CFS) Centre in collaboration with the Africa Research and Impact Network (ARIN), Frankfurt School of Finance and Management (FS), and the Uganda Institute of Banking and Financial Services (UIBFS).</p>\\n<p>The 2026 conference builds on the momentum of the 2025 conference and focuses on translating Africa\'s climate finance commitments into bankable investments, implementable policies, and scalable innovations. Grounded in evidence from ARIN\'s regional convenings and the forthcoming <em>Africa\'s Climate Finance Outlook, 2026</em>, this year\'s agenda is built on real-world experiences from across the continent.</p>\", \"heading\": \"Overview\"}, {\"body\": \"<p>The 2025 conference drew over 200 participants from across the continent and catalyzed national dialogue on climate finance. Building on these outcomes, ARIN has been convening a series of regional climate finance convenings across Africa. Insights from these convenings, alongside fellow-led research, are being synthesized into <em>Africa\'s Climate Finance Outlook, 2026</em>, a flagship continental report.</p>\\n<p>The Third Annual Climate Finance Conference (#3ACFC26) aligns with post-COP28 efforts to define country-led Article 6 pathways and ongoing continental efforts under the Africa Climate Change Strategy. The goal is to accelerate the translation of Africa\'s climate finance commitments into bankable investments, inclusive financial innovations, and actionable delivery systems through a high-level convening of multiple stakeholders.</p>\\n<p>The two-day conference took place from 1st to 2nd September 2026 at the Marriott Hotel, Kampala, with proceedings delivered through keynote speeches, panel discussions, and research disseminations organized along thematic sessions, gathering a multi-disciplinary audience of about 300 stakeholders in climate finance and sustainability.</p>\", \"heading\": \"Details\"}]','Conference at a glance','[\"1–2 September 2026\", \"Marriott Hotel, Kampala\", \"About 300 stakeholders\", \"Keynotes, panels and research disseminations\", \"Partners: CFS Centre, ARIN, Frankfurt School, UIBFS\"]','[]',NULL,'[]','[]',NULL,NULL,NULL,NULL,NULL,NULL,'projects/featured/01M49CSS6M4SCP6T1Q5MYZTDGA.jpg','[\"projects\\/gallery\\/01M49CSS6M4SCP6T1Q5MYZTDGB.jpg\",\"projects\\/gallery\\/01M49CSS6NYVFTB8ZES8D1AX6Q.jpg\",\"projects\\/gallery\\/01M49CSS6NYVFTB8ZES8D1AX6R.jpg\",\"projects\\/gallery\\/01M49CSS6NYVFTB8ZES8D1AX6S.jpg\",\"projects\\/gallery\\/01M49CSS6NYVFTB8ZES8D1AX6T.jpg\"]','Events Planning','Marriott Hotel, Kampala, Uganda',NULL,1,1,'2026-09-01',NULL,'2026-10-06 11:13:02','2026-10-06 16:59:40',NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `resources` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('blog','publication','communication_asset','other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_cover` tinyint(1) NOT NULL DEFAULT '1',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` date DEFAULT NULL,
  `meta_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resources_slug_unique` (`slug`),
  KEY `resources_slug_index` (`slug`),
  KEY `resources_type_index` (`type`),
  KEY `resources_is_published_index` (`is_published`),
  KEY `resources_published_at_index` (`published_at`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resources`
--

LOCK TABLES `resources` WRITE;
/*!40000 ALTER TABLE `resources` DISABLE KEYS */;
INSERT INTO `resources` VALUES (3,'Zero Tolerance to Corruption','zero-tolerance-to-corruption','other','RoyalWay Media Ltd, as a leading integrated marketing, events, and communications agency, is committed to upholding the highest standards of integrity and transparency in all its operations.','<p>RoyalWay Media Ltd, as a leading integrated marketing, events, and communications agency, is committed to upholding the highest standards of integrity and transparency in all its operations. The company is committed to serve its diverse clientele, including corporate entities, government bodies, and international Development organizations, through services such as PR, advertising, branding, experiential marketing, corporate events planning, and behavioral change communications.&nbsp;</p><p>This Anti-Corruption Policy, effective from February 17, 2022, underscores Royalway Media’s dedication to ethical conduct and zero tolerance for corruption, ensuring that its operations across Uganda, Rwanda, and beyond reflect fairness, accountability, and trust. The policy explicitly prohibits all forms of corruption, including bribery, extortion, fraud, nepotism, and misuse of influence for personal gain. Royalway Media enforces a strict no-bribe policy, rejecting any offers, promises, or acceptance of improper advantages, whether through cash, gifts, or favors, to maintain objectivity and fairness in business dealings. Transparency is central to the company’s practices, with clear pricing, accurate record-keeping, and regular audits ensuring compliance with local laws, such as Uganda’s Anti-Corruption Act (2009), and international anti-corruption standards.&nbsp;</p><p>RoyalWay Media fosters ethical partnerships by conducting due diligence on suppliers, subcontractors, and third parties to ensure alignment with its anti-corruption values. Contracts include clauses mandating ethical adherence, and the company encourages partners to report concerns without fear of retaliation. Hiring, promotions, and project assignments are merit- based, free from favoritism or undue influence, ensuring impartiality in vendor selection and talent engagement for events and campaigns.&nbsp;</p><p>The company invests in regular employee training on anti-corruption policies and ethical decision-making, fostering a culture of accountability across its remote-first team. Concerns about corruption can be reported confidentially via email (compliance@royalwaymedia.com) or an anonymous hotline (+256772464686), with a promise of acknowledgment within 48 hours, thorough investigations within 10 business days, and protection against retaliation for whistleblowers.&nbsp;</p><p>We invite all our employees, clients, and partners to share in the responsibility of maintaining a corruption-free environment, ensuring that every project reflects its commitment to excellence and integrity.&nbsp;</p><p>For further inquiries, the Compliance Department can be reached at&nbsp;</p><p><a href=\"mailto:compliance@royalwaymedia.com\">compliance@royalwaymedia.com</a></p>','resources/files/01KE9K0RSN3CAEEB7FTB6QB1P5.pdf','resources/images/01KE9K0RSK62DFPGD5R27KVTQM.png',1,NULL,1,'2025-12-01',NULL,NULL,'2026-01-06 17:03:00','2026-10-06 10:43:28'),(4,'Our Customer Service Pledge','our-customer-service-pledge','other','RoyalWay Media Ltd, a premier integrated marketing and communications agency, is dedicated to delivering exceptional customer service that aligns with its mission to elevate and deliver transformative experiences to all our customers. We offer a wide range of services, including PR and Media Management, Advertising, Branding, Experiential Marketing, Corporate Events Planning, and Behavioral Change Communications, as outlined on www.royalwaymedia.com.','<p>RoyalWay Media Ltd, a premier integrated marketing and communications agency, is dedicated to delivering exceptional customer service that aligns with its mission to elevate and deliver transformative experiences to all our customers. We offer a wide range of services, including PR and Media Management, Advertising, Branding, Experiential Marketing, Corporate Events Planning, and Behavioral Change Communications, as outlined on www.royalwaymedia.com.&nbsp;</p><p>This Customer Service policy reflects RoyalWay Media’s commitment to fostering meaningful, seamless, and inspiring client interactions, ensuring every partnership drives impactful results with a client-centered approach. The policy emphasizes responsive communication, promising to address all client inquiries—via email, phone, or website contact form—within 12 business hours, with immediate acknowledgment for urgent matters. Clients can reach the team at sales@royalwaymedia.com or +256- 772464686 during office hours (Monday to Friday- 8 am-8.00 pm and Saturdays 8 am-4.00 pm).&nbsp;</p><p>Transparency and collaboration are core to the company’s approach. RoyalWay Media provides clear timelines, detailed project updates, and transparent pricing, welcoming client feedback to refine deliverables and exceed expectations. Quality assurance is integral, with every project undergoing rigorous checks to ensure creativity, precision, and strategic alignment.&nbsp;</p><p>For concerns or feedback, we encourage clients to contact our dedicated customer service team, promising acknowledgment within 24 business hours, a detailed response within 5 business days, and ongoing updates for complex issues. We are committed to continuous improvement, reviewing our policy annually to adapt to evolving client needs and industry trends. By building lasting partnerships, RoyalWay Media transforms client ambitions into reality through innovative, high-quality services.</p>','resources/files/01KE9KK218ZGHVXW8J6P30TH1T.docx','resources/images/01KE9KVSD0DXRTVE5VNWTMGWMQ.jpg',1,NULL,1,'2025-12-01',NULL,NULL,'2026-01-06 17:05:20','2026-01-06 17:17:45'),(5,'Our Commitment To Sustainability.','our-commitment-to-sustainability','other','Royalway Media Ltd recognizes its responsibility to conduct business in a way that improves the well-being of the people and protect state of the environment for future generations. As a leading firm, we understand that the long- term wellbeing of society, our colleagues, the strength of the global economy, and the continuing success of our own business depend on our commitment to sustainability and taking strategic efforts to promote and create a balance between People, Profit, and Planet.','<p>Royalway Media Ltd recognizes its responsibility to conduct business in a way that improves the wellbeing of the people and protect state of the environment for future generations. As a leading firm, we understand that the long-term wellbeing of society, our colleagues, the strength of the global economy, and the continuing success of our own business depend on our commitment to sustainability and taking strategic efforts to promote and create a balance between People, Profit, and Planet.</p><p>Sustainability is an integral part of being a successful business, and we always aim to act in an ethical, transparent, and responsible way. Naturally, we expect our business partners to do the same. Our Sustainability Commitment is a set of requirements that applies to ourselves and everybody we do business with, and is well embedded within our Brand DNA as illustrated below:</p><p>&nbsp;</p><ul><li><strong>TRANSPARENCY &amp; COLLABORATION: </strong>Transparency<strong> </strong>&amp; Collaboration are critical commodities for high-performing teams because they are a quick way to establish trust. We are keen to openly work with our customers, suppliers, and regulators like URA, PPDA, KCCA, URSB, the United Nations, and to play our role transparently and collaboratively.</li><li><strong>&nbsp;IMPACT ON PEOPLE: </strong>We respect human rights, promote inclusion, and champion diversity throughout our work and supply chain — and call on our Business Partners to do the same. Our company culture is an attitude and environment where we cultivate collaboration, productivity, and satisfaction among its employees. In our environment, managers trust their employees to produce quality work and make good decisions. Employees respect one another and work well as a team to complete projects</li><li><strong>REDUCING CARBON FOOTPRINT &amp; PROTECTING NATURAL ECOSYSTEMS: </strong>Reducing carbon footprint is a crucial step towards a sustainable future. We often identify ways to reduce our carbon footprint&nbsp; and protect natural ecosystems through:<strong> &nbsp;</strong></li></ul><ol><li>Reducing energy consumption.</li><li>Switching to renewable energy sources.</li><li>Encouraging sustainable transportation.</li><li>Work with sustainable suppliers.</li><li>Investing in green growth.</li></ol><p>&nbsp;</p><ul><li><strong>CLIMATE CHANGE EDUCATION &amp; LITERACY: </strong>We leverage our talents &amp;expertise in communication to promote climate action by designing awareness messages, communication tools, and working with partners like the&nbsp;<strong>Rotary Club of Acacia Sunset</strong> to help <a href=\"https://www.unesco.org/en/climate-change/education\"><span style=\"text-decoration: underline;\">people understand and address the impacts of the climate crisis, empowering them with the knowledge, skills, values, and attitudes needed to act as agents of change</span></a></li></ul><p>Join us to promote these values of excellence and the pursuit of responsibility</p>','resources/files/01KE9KF7NC0VAKYQ5QY8945RV9.docx','resources/images/01KE9KWE0XQ9SE7H8RW2D1TYKZ.jpg',1,NULL,1,'2025-12-01',NULL,NULL,'2026-01-06 17:10:54','2026-01-06 17:18:07'),(6,'Child Labor-Safeguarding, & Prevention of Sexual Exploitation & Abuse','child-labor-safeguarding-prevention-of-sexual-exploitation-abuse','other','RoyalWay Media Ltd enforces a stringent Policy on Child Labor as part of its broader commitment to ethical conduct and human rights, effective February 17, 2022. This policy, embedded within the company’s framework for Child Labor, Safeguarding, and Prevention of Sexual Exploitation and Abuse (PSEA), articulates a zero-tolerance stance on child labor across all operations, supply chains, and partnerships.','<p>RoyalWay Media Ltd enforces a stringent Policy on Child Labor as part of its broader commitment to ethical conduct and human rights, effective February 17, 2022. This policy, embedded within the company’s framework for Child Labor, Safeguarding, and Prevention of Sexual Exploitation and Abuse (PSEA), articulates a zero-tolerance stance on child labor across all operations, supply chains, and partnerships. Aligned with international standards such as the UN Convention on the Rights of the Child, ILO Conventions on Child Labor, and relevant national laws, it applies to all employees, contractors, suppliers, vendors, and business partners, ensuring compliance in all jurisdictions where the company operates.</p><p>The policy strictly prohibits the employment or engagement of children under the legal minimum working age, typically 18 years for hazardous work, in any of RoyalWay Media’s activities, including content production, marketing, and events. To prevent child labor in its supply chain, the company mandates that all suppliers and partners certify compliance with anti-child labor laws and submit to regular audits to verify adherence.&nbsp;</p><p>Any suspected instances of child labor are promptly investigated and reported to relevant authorities, ensuring swift action to address violations. In scenarios where children are involved in media productions or events, such as actors, models, or participants, RoyalWay Media requires parental or guardian consent and strict adherence to child performer regulations.</p><p>&nbsp;This includes limiting working hours to protect children’s education and well-being, ensuring their participation does not compromise their development or safety. The company fosters child-friendly environments, implementing risk assessments for projects involving children, conducting background checks on staff and contractors, and employing safe recruitment practices to mitigate risks.&nbsp;</p><p>RoyalWay Media reinforces its child labor policy through mandatory training for all employees and contractors within their first month, with annual refreshers covering child labor laws and best practices. Awareness campaigns, including workshops and informational materials, further promote compliance. Violations result in severe consequences, including termination of employment or contracts and potential legal action, with non-compliant suppliers facing contract termination. The policy is monitored through internal audits and supplier assessments, with annual reviews to align with legislative changes. For inquiries, contact the Compliance Department at <a href=\"mailto:sempala@royalwaymedia.com\">sempala@royalwaymedia.com</a>.</p>','resources/files/01KE9KJB2MV855A25QN3W7F147.docx','resources/images/01KE9KX2B1GT9KFRRBHG66QY1W.jpg',1,NULL,1,'2025-12-06',NULL,NULL,'2026-01-06 17:12:36','2026-01-06 17:18:27'),(7,'Baseline KAP Survey Report','baseline-kap-survey-report','communication_asset','Comprehensive baseline Knowledge, Attitudes, and Practices survey report providing essential insights and data analysis.','<p>Comprehensive baseline Knowledge, Attitudes, and Practices survey report providing essential insights and data analysis.</p>','resources/files/baseline-kap-survey-report.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02'),(8,'Communications & Marketing Strategy','communications-marketing-strategy','communication_asset','Strategic framework for communications and marketing initiatives, outlining key approaches and methodologies.','<p>Strategic framework for communications and marketing initiatives, outlining key approaches and methodologies.</p>','resources/files/communications-marketing-strategy.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02'),(9,'End of Activity Report - ABI Trust','end-of-activity-report-abi-trust','communication_asset','Comprehensive end-of-activity report detailing project outcomes, achievements, and key learnings from the ABI Trust initiative.','<p>Comprehensive end-of-activity report detailing project outcomes, achievements, and key learnings from the ABI Trust initiative.</p>','resources/files/end-of-activity-report-abi-trust.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02'),(10,'UEUBI 2025 Summary Report','ueubi-2025-summary-report','communication_asset','Final summary report for the Uganda-Europe Union Business Initiative 2025, highlighting key outcomes and strategic partnerships.','<p>Final summary report for the Uganda-Europe Union Business Initiative 2025, highlighting key outcomes and strategic partnerships.</p>','resources/files/ueubi-2025-summary-report.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02'),(11,'European Union and Uganda Partnership 2025','european-union-and-uganda-partnership-2025','communication_asset','Strategic partnership document outlining collaboration frameworks and initiatives between the European Union and Uganda for 2025.','<p>Strategic partnership document outlining collaboration frameworks and initiatives between the European Union and Uganda for 2025.</p>','resources/files/european-union-and-uganda-partnership-2025.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02'),(12,'Furaha OBUL Flyers','furaha-obul-flyers','communication_asset','Marketing and communication flyers for the Furaha OBUL initiative, designed to promote awareness and engagement.','<p>Marketing and communication flyers for the Furaha OBUL initiative, designed to promote awareness and engagement.</p>','resources/files/furaha-obul-flyers.pdf',NULL,1,'RoyalWay Media',1,'2025-08-04',NULL,NULL,'2026-10-06 05:55:02','2026-10-06 05:55:02');
/*!40000 ALTER TABLE `resources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro` text COLLATE utf8mb4_unicode_ci,
  `checklist` json DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery` json DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  KEY `services_slug_index` (`slug`),
  KEY `services_is_active_index` (`is_active`),
  KEY `services_order_index` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (17,'Media Services','media-services',NULL,NULL,NULL,NULL,'We use diverse media platforms strategically to enhance visibility and promote behaviors that benefit your goals.','<p>Media works best when it has a purpose. At Royal Way Media, we use a <strong>diverse mix of media platforms strategically</strong> to enhance visibility and promote behaviors that benefit your goals. From radio, television and print to digital and social media, every placement is chosen to put the right message in front of the right audience at the right time.</p>\n<h3>Our Media Services</h3>\n<ul>\n<li><strong>Media Strategy</strong>: Tailored media approaches built around your objectives, audience and budget.</li>\n<li><strong>Media Planning &amp; Buying</strong>: Placement across traditional and digital platforms to maximize reach, frequency and return on spend.</li>\n<li><strong>Radio &amp; TV Placements</strong>: Spots, talk show slots and sponsored segments on national and regional stations, including local language programming.</li>\n<li><strong>Digital &amp; Social Media Advertising</strong>: Targeted paid campaigns that reach and engage audiences online.</li>\n<li><strong>Media Monitoring &amp; Analysis</strong>: Tracking of coverage and campaign performance so you can see what works and adjust quickly.</li>\n<li><strong>Media Rate Negotiation</strong>: Competitive rates, bonuses and added value from our media partners.</li>\n</ul>\n<h3>How We Work</h3>\n<ol>\n<li><strong>Strategy</strong>: We design tailored media approaches to meet specific client objectives.</li>\n<li><strong>Visibility</strong>: Your message reaches the right audience at the right time.</li>\n<li><strong>Engagement</strong>: We spark meaningful interactions that drive audience connection.</li>\n<li><strong>Alignment</strong>: Media choices are guided by your mission, not just metrics.</li>\n</ol>\n<h3>Benefits to Our Clients</h3>\n<ul>\n<li><strong>Good Media Price Deals</strong>: Favorable rates and cost-effective packages that stretch your budget.</li>\n<li><strong>Optimized Media Space</strong>: Strategic placement for maximum visibility and engagement.</li>\n<li><strong>Protection from Ad Fraud</strong>: Careful monitoring and trusted platform partners that guard against fraudulent impressions and clicks.</li>\n</ul>',NULL,'services/images/media-services.png',NULL,NULL,3,1,1,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:53:42'),(18,'Events Planning & Management','events-planning-management',NULL,NULL,NULL,NULL,'We orchestrate unforgettable events with agility and expertise, ensuring seamless experiences that leave lasting impressions.','<p>We orchestrate unforgettable events with <strong>agility and expertise</strong> for corporate and institutional clients. Our team has handled everything from intimate stakeholder dinners to national forums, managing budgets, deadlines, venues, partners and talent so that every guest has a seamless experience and every speaker leaves with a lasting impression.</p>\n<h3>Events We Handle</h3>\n<ul>\n<li><strong>Conferences &amp; Forums</strong>: Business forums, panel discussions and large-scale gatherings with full stage and content coordination.</li>\n<li><strong>Product &amp; Program Launches</strong>: From concept to execution, a memorable first impression for what you are introducing.</li>\n<li><strong>Corporate &amp; Institutional Events</strong>: Dinners, annual partners\' meetings and stakeholder receptions tailored to your objectives.</li>\n<li><strong>International Day Celebrations</strong>: Creative, inclusive events for global milestones and awareness days.</li>\n<li><strong>Capacity Building Workshops</strong>: Training and learning events that support growth and engagement.</li>\n<li><strong>Exhibitions &amp; Trade Shows</strong>: Booth setup, logistics and branding for maximum visibility.</li>\n</ul>\n<h3>End-to-End Event Support</h3>\n<ul>\n<li><strong>Planning &amp; Logistics</strong>: Budgets, timelines, venues, catering, transport and guest management.</li>\n<li><strong>Stage, Branding &amp; Decor</strong>: Visuals, signage and set design aligned with your brand identity.</li>\n<li><strong>Audio-Visual &amp; Livestreaming</strong>: Sound, screens, lighting and real-time streaming to remote audiences.</li>\n<li><strong>Photography &amp; Videography</strong>: Impactful coverage you can reuse in future communication.</li>\n<li><strong>Invitations &amp; Promotion</strong>: Campaigns that boost attendance and awareness before the event.</li>\n<li><strong>Media Coordination</strong>: Liaison with journalists and outlets for the best possible coverage.</li>\n<li><strong>Post-Event Reporting</strong>: Summaries, insights and performance analytics.</li>\n</ul>\n<h3>Recent Work</h3>\n<p>Our events have included the UN Day Dinner 2024, a Capital Markets Authority event, World Press Freedom Day 2023, the Uganda-EU Business Forum under the Global Gateway, and the aBi Development Annual Partners\' Meeting.</p>',NULL,'services/images/events-planning-management.png',NULL,'[\"services/images/events-planning-management-8.png\"]',1,1,1,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:53:42'),(19,'Strategic Communication & Visibility','strategic-communication-visibility',NULL,NULL,NULL,NULL,'Communication and awareness creation across Uganda, building one message for every project.','<p>Good communication starts with one clear message. We help organizations create <strong>awareness and visibility across Uganda</strong> by building a single, consistent message for every project and carrying it through the right channels, from radio and print to social media, community events and branded materials.</p>\n<h3>Our Strategic Communication Services</h3>\n<ul>\n<li><strong>Communication Strategy &amp; Messaging</strong>: Clear objectives, audience insight and key messages that guide every activity.</li>\n<li><strong>Visibility Campaigns</strong>: Donor and partner visibility plans that follow brand and funder guidelines.</li>\n<li><strong>PR &amp; Media Coordination</strong>: Press releases, press conferences, media alerts, feature story pitches and talk show placements.</li>\n<li><strong>Content Development</strong>: Stories, fact sheets, infographics, photography and video that explain your work.</li>\n<li><strong>IEC Materials</strong>: Wallboards, stickers, brochures, pull-up banners and branded flags for field activities.</li>\n<li><strong>Social Behaviour Change Communication</strong>: Health and risk communication, civic and voter education, and community mobilization.</li>\n<li><strong>Perception Surveys &amp; Research</strong>: Evidence on what audiences know, think and do, so strategy stays grounded.</li>\n<li><strong>Crisis Communication</strong>: Proactive and reactive messaging that protects your reputation.</li>\n</ul>\n<h3>One Message, Many Channels</h3>\n<p>Whether it is a green agribusiness finance drive, a coffee sustainability program or a school fee solution for parents, we adapt one core message into radio spots, print, digital content and field materials so audiences hear the same story wherever they meet it.</p>\n<h3>Who We Serve</h3>\n<ul>\n<li>Development partners and multilateral agencies</li>\n<li>Government institutions and regulators</li>\n<li>Financial institutions and corporates</li>\n<li>NGOs and community organizations</li>\n</ul>',NULL,'services/images/strategic-communication-visibility.png',NULL,'[\"services/images/strategic-communication-visibility-7.png\", \"services/images/strategic-communication-visibility-4.png\"]',2,1,1,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:53:42'),(20,'Printing & Production','printing-production',NULL,NULL,NULL,NULL,'We amplify client messages through targeted communications to maximize reach and impact.','<p>We amplify client messages through <strong>targeted communications that maximize reach and impact</strong>. Our design, printing and production team turns ideas into finished materials, from strategic plans and flyers to videos and live broadcasts, using modern equipment and careful quality control.</p>\n<h3>Our Printing Services</h3>\n<ul>\n<li><strong>Corporate Stationery</strong>: Business cards, letterheads, envelopes and complete identity packages.</li>\n<li><strong>Reports &amp; Publications</strong>: Strategic plans, summary reports, manuals and brochures with professional layout, binding and finishing.</li>\n<li><strong>Marketing Collaterals</strong>: Flyers, posters, leaflets and point-of-sale materials designed to drive action.</li>\n<li><strong>Large Format &amp; Outdoor</strong>: Banners, billboards, vehicle branding and branded flags.</li>\n<li><strong>Promotional Items</strong>: Branded merchandise and giveaways that keep your name visible.</li>\n<li><strong>Packaging</strong>: Custom packaging and labels that reinforce your brand.</li>\n</ul>\n<h3>Our Production Services</h3>\n<ul>\n<li><strong>Design &amp; Layout</strong>: Creative design that blends identity, strategy and usability.</li>\n<li><strong>Radio &amp; TV Production</strong>: Scripting, translation and production of spots and infomercials.</li>\n<li><strong>Videography &amp; Photography</strong>: Professional coverage and editing for events and campaigns.</li>\n<li><strong>Documentary Production</strong>: Storyboarding, filming and editing from start to finish.</li>\n<li><strong>Live Streaming &amp; Video Walls</strong>: Real-time broadcasting and high-resolution display for events.</li>\n</ul>\n<h3>From Brief to Delivery</h3>\n<ol>\n<li><strong>Brief</strong>: We listen to your goals, audience and deadline.</li>\n<li><strong>Design</strong>: We develop concepts and refine them with your feedback.</li>\n<li><strong>Produce</strong>: We print or produce with strict quality checks.</li>\n<li><strong>Deliver</strong>: We hand over on time, ready to use in the field.</li>\n</ol>',NULL,'services/images/printing-production.png',NULL,NULL,5,1,0,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:53:42'),(21,'Experiential Marketing & Customer Engagement','experiential-marketing-customer-engagement',NULL,NULL,NULL,NULL,'Engagement goes beyond transactions. We connect with customers in ways that are relevant, respectful and impactful.','<p>We believe engagement goes beyond transactions. It is about <strong>listening, understanding and creating value at every touchpoint</strong>. Through data-driven insights, personalized communication and consistent brand experiences, we connect with customers in ways that are relevant, respectful and impactful.</p>\n<h3>Our Customer Engagement Services</h3>\n<ul>\n<li><strong>Road Shows</strong>: Mobile brand experiences that bring your message directly to people across Uganda.</li>\n<li><strong>Market Activations</strong>: Lively, face-to-face activations in markets, trading centers and transport hubs.</li>\n<li><strong>Customer Acquisition &amp; Onboarding</strong>: Registration, activation and sign-up drives that bring new customers on board.</li>\n<li><strong>Customer Education</strong>: Clear, practical sessions that help customers understand and trust your products.</li>\n<li><strong>Community Drives</strong>: Promotions that build goodwill through meaningful local engagement.</li>\n<li><strong>Field Customer Service</strong>: On-the-spot query resolution and support where your customers are.</li>\n<li><strong>Feedback &amp; Insight Collection</strong>: Simple tools to capture what customers say and need.</li>\n<li><strong>Loyalty &amp; Retention Campaigns</strong>: Programs that keep customers active and connected to your brand.</li>\n</ul>\n<h3>Our Approach</h3>\n<ol>\n<li><strong>Listen</strong>: We start with customer insight, not assumptions.</li>\n<li><strong>Understand</strong>: We segment audiences and adapt messages to local context.</li>\n<li><strong>Create Value</strong>: Every touchpoint should give the customer something useful.</li>\n<li><strong>Measure</strong>: We track results in the field and report back with clear numbers.</li>\n</ol>\n<h3>Proven at Scale</h3>\n<p>Our nationwide mobile marketing work for Airtel Uganda has reached customers in more than 70 districts across all four regions of the country.</p>',NULL,'services/images/customer-engagement.png',NULL,NULL,4,1,1,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:54:10'),(22,'Meaningful Dialogue','meaningful-dialogue',NULL,NULL,NULL,NULL,'Respectful, two-way conversations that uncover insights, build trust and co-create solutions that matter.','<p>Respectful dialogue is the foundation of strong relationships, both within our teams and with the people we serve. By <strong>actively listening and engaging in two-way conversations</strong>, we uncover insights, build trust and co-create solutions that matter.</p>\n<h3>Our Dialogue Services</h3>\n<ul>\n<li><strong>Stakeholder Engagement</strong>: Mapping, outreach and structured engagement with the groups who shape your work.</li>\n<li><strong>Forums, Panels &amp; Roundtables</strong>: Well-moderated conversations that bring decision makers and communities together.</li>\n<li><strong>Community Dialogues</strong>: Local meetings that give citizens a real voice and a chance to ask questions.</li>\n<li><strong>Policy &amp; Public Consultations</strong>: Inclusive processes that collect and report public input.</li>\n<li><strong>Listening Studies &amp; Perception Surveys</strong>: Evidence on attitudes, needs and expectations.</li>\n<li><strong>Moderation &amp; Facilitation</strong>: Skilled facilitators who keep discussions balanced and productive.</li>\n<li><strong>Internal Communication</strong>: Employee engagement programs that align teams with your mission.</li>\n<li><strong>Feedback Loops &amp; Reporting</strong>: Clear summaries showing what was heard and what will happen next.</li>\n</ul>\n<h3>Our Principles</h3>\n<ol>\n<li><strong>Listen First</strong>: Understanding comes before messaging.</li>\n<li><strong>Keep It Two-Way</strong>: Every channel should allow people to respond.</li>\n<li><strong>Build Trust</strong>: Honest, consistent communication over time.</li>\n<li><strong>Co-Create</strong>: Solutions work better when the people affected help shape them.</li>\n</ol>',NULL,'services/images/meaningful-dialogue.png',NULL,NULL,6,1,0,NULL,NULL,'2026-10-06 13:42:48','2026-10-06 16:53:42');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('vNrzlmX7mk0ax9nkEMMha3nHnyHVSfL50fvrinsn',1,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36','YTo3OntzOjY6Il90b2tlbiI7czo0MDoiYk9QUHJGSGJScVBZZEN1d1VLeXNBM0pYaWNxUFFhMG5jNnI4WFhyVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiQ3SVJOcEd0MC5CdUtqVlVzY0V6OHMuOFAxLmNkU0tZUWkudUJqejJQV0FMZUtNWFgudmdmVyI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',1791317410),('xneeehSLZhFwABloqiduHxEUdtAHkv9cFrgQmbCE',NULL,'127.0.0.1','curl/8.7.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid3pmajlXSnc3RGlSWlJTWnFOSHFwa0c1R0dFWlVSall1RjMzYjk2ciI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4NzY5L2FkbWluL3dlYnNpdGUtc2V0dGluZ3MiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cDovLzEyNy4wLjAuMTo4NzY5L2FkbWluL3dlYnNpdGUtc2V0dGluZ3MiO3M6NToicm91dGUiO3M6Mzc6ImZpbGFtZW50LmFkbWluLnBhZ2VzLndlYnNpdGUtc2V0dGluZ3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1791311820),('ZIeWH0kkX2dPntMQaN2f2sKxy7gWZAEKOYKooVyV',NULL,'127.0.0.1','curl/8.7.1','YTozOntzOjY6Il90b2tlbiI7czo0MDoibTZyT1dxQjN2UXAyc1FucVJFeTlOTW1KRlA4NDZuUDRtNzdoaFVNdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODc2OSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791311804);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`),
  KEY `site_settings_key_index` (`key`),
  KEY `site_settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES (2,'site_name','RoyalWay Media','text','general',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(3,'copyright_name','RoyalWay Media Ltd','text','general',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(4,'footer_about','At RoyalWay Media, we redefine excellence in integrated marketing and communications. Specializing in PR, Branding, Marketing, and Behavioral Change Communications, we transform ambitions into thriving brands.','textarea','general',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(5,'contact_email','sales@royalwaymedia.com','email','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(6,'phones','[{\"number\":\"+256 772 464 686\",\"label\":\"Mobile\"},{\"number\":\"+256 312 284 552\",\"label\":\"Office\"},{\"number\":\"+256 774 038 086\",\"label\":\"Mobile\"}]','json','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(7,'address','Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda','textarea','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(8,'po_box','P.O. Box 70348 Kampala','text','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(9,'office_hours','Mon – Fri: 8:00am – 6:00pm','text','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(10,'google_maps_embed','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.748448252334!2d32.5882796!3d0.3390889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbba674754169%3A0x8a9ed4e73dc4c5b3!2sRoyalWay%20Media!5e0!3m2!1sen!2sug!4v1761603434898!5m2!1sen!2sug','textarea','contact',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(11,'social_facebook','https://www.facebook.com/RoyalWayMediaLtd/','url','social',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(12,'social_twitter','https://twitter.com/RoyalWayMedia','url','social',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(13,'social_linkedin','https://www.linkedin.com/company/royalway-media','url','social',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(14,'social_instagram','https://www.instagram.com/royalwaymedia','url','social',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(15,'social_youtube','https://www.youtube.com/channel/UC5292sL9n6DTH7p7Yh8HmOg/videos','url','social',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(16,'hero_title','RoyalWay Media: Where Communications is catalyst for growth','text','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(17,'hero_subtitle','We work with ambitious people and companies to help through creation, reinvention, or transformation of their brand.','textarea','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(18,'hero_button1_label','Start a Project','text','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(19,'hero_button1_link','/contact','text','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(20,'hero_button2_label','Our Work','text','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(21,'hero_button2_link','/projects','text','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(22,'homepage_stats','[{\"number\":\"10+\",\"label\":\"Years of Experience\"},{\"number\":\"10+\",\"label\":\"Awards Won\"},{\"number\":\"150+\",\"label\":\"Satisfied Customers\"}]','json','homepage',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(23,'whatsapp_enabled','1','boolean','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(24,'whatsapp_number','256772464686','text','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(25,'whatsapp_display_name','RoyalWay Media','text','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(26,'whatsapp_greeting','Hi there! 👋 Planning a campaign, event or media project? Chat with us now we usually reply within minutes.','textarea','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 12:06:26'),(27,'whatsapp_prefill','Hello RoyalWay Media, I\'d like to enquire about your services.','textarea','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(28,'whatsapp_position','right','text','whatsapp',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(29,'seo_title','RoyalWay Media | Marketing, PR & Events Agency Uganda','text','seo',NULL,'2026-10-06 11:47:54','2026-10-06 15:36:14'),(30,'seo_description','Uganda\'s 360° integrated marketing and communications agency for PR, branding, events, experiential marketing and behavioral change communications.','textarea','seo',NULL,'2026-10-06 11:47:54','2026-10-06 15:36:15'),(31,'company_profile_pdf','site/royalway-media-company-profile.pdf','file','general',NULL,'2026-10-06 11:47:54','2026-10-06 11:47:54'),(32,'company_profile_url','','url','general',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(33,'google_business_url','','url','contact',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(34,'hero_video','site/hero/01M48VZDHEV0GK6NJPFQDGGTB4.mp4','file','homepage',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(35,'hero_poster','site/hero/01M48VZDJ31ZB3R0BQNX6HVZA4.jpg','image','homepage',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(36,'seo_og_image','site/01M48VZDJ4B056M6W8FD07QPCM.jpg','image','seo',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(37,'google_search_console','','text','seo',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39'),(38,'google_analytics_id','G-ENGF6842SD','text','seo',NULL,'2026-10-06 12:05:39','2026-10-06 12:05:39');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_is_active_index` (`is_active`),
  KEY `team_members_order_index` (`order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@royalwaymedia.com',NULL,'$2y$12$7IRNpGt0.BuKjVUscEz8s.8P1.cdSKYQi.uBjz2PWALeKMXX.vgfW',NULL,'2025-11-02 12:18:50','2025-11-02 12:18:50');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-06 23:11:29
