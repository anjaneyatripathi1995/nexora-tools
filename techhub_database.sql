-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: techhub
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB
-- TechHub / Nexora Tools — database schema + seed reference.
-- Use for manual import or as reference; Laravel migrations in database/migrations/ are the source of truth.

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `techhub`
--

/*!40000 DROP DATABASE IF EXISTS `techhub`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `techhub` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `techhub`;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_02_21_140803_create_tools_table',1),(5,'2026_02_21_141402_create_projects_table',1),(6,'2026_02_21_141501_create_templates_table',1),(7,'2026_02_21_141629_create_saved_items_table',1),(8,'2026_02_21_141812_create_tool_histories_table',1),(9,'2026_02_21_160000_add_role_and_access_rules_to_users_table',1),(10,'2026_02_21_160001_add_columns_to_tool_histories_table',1),(11,'2026_02_21_160002_add_columns_to_saved_items_table',1),(12,'2026_02_21_170000_create_cache_tables_for_laravel',1),(13,'2026_02_21_170001_add_is_master_to_users_table',1),(14,'2026_02_27_000000_create_tool_jobs_table',1);

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `saved_items`
--

DROP TABLE IF EXISTS `saved_items`;
CREATE TABLE `saved_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `item_type` varchar(32) NOT NULL,
  `item_slug` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `saved_items_user_id_foreign` (`user_id`),
  CONSTRAINT `saved_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
CREATE TABLE `templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `tool_histories`
--

DROP TABLE IF EXISTS `tool_histories`;
CREATE TABLE `tool_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `tool_slug` varchar(128) DEFAULT NULL,
  `tool_id` bigint(20) unsigned DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tool_histories_user_id_foreign` (`user_id`),
  KEY `tool_histories_tool_id_foreign` (`tool_id`),
  CONSTRAINT `tool_histories_tool_id_foreign` FOREIGN KEY (`tool_id`) REFERENCES `tools` (`id`) ON DELETE SET NULL,
  CONSTRAINT `tool_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `tool_jobs`
--

DROP TABLE IF EXISTS `tool_jobs`;
CREATE TABLE `tool_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `progress` int(10) unsigned NOT NULL DEFAULT 0,
  `input_paths` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`input_paths`)),
  `result_path` varchar(255) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `tools`
--

DROP TABLE IF EXISTS `tools`;
CREATE TABLE `tools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tools_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` VALUES (1,'EMI Calculator','emi-calculator','Finance & Date','Calculate loan EMI instantly','fa-calculator',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(2,'SIP Calculator','sip-calculator','Finance & Date','Systematic Investment Plan returns','fa-chart-line',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(3,'FD/RD Calculator','fd-rd-calculator','Finance & Date','Fixed & Recurring Deposit maturity','fa-piggy-bank',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(4,'GST Calculator','gst-calculator','Finance & Date','Calculate GST and reverse GST','fa-percent',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(5,'Age Calculator','age-calculator','Finance & Date','Calculate exact age from DOB','fa-birthday-cake',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(6,'Month-to-Date Converter','month-to-date-converter','Finance & Date','Convert month/date formats','fa-calendar-days',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(7,'PDF to Word','pdf-to-word','PDF & File','Convert PDF to editable Word','fa-file-word',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(8,'PDF to Excel','pdf-to-excel','PDF & File','Extract tables to Excel','fa-file-excel',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(9,'PDF to Image','pdf-to-image','PDF & File','Convert PDF pages to images','fa-file-image',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(10,'Merge PDF','pdf-merger','PDF & File','Merge multiple PDFs into one','fa-object-group',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(11,'Split PDF','split-pdf','PDF & File','Split PDF by pages','fa-scissors',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(12,'Compress PDF','compress-pdf','PDF & File','Reduce PDF file size','fa-file-zipper',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(13,'Lock / Unlock PDF','lock-unlock-pdf','PDF & File','Password protect or remove protection','fa-lock',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(14,'OCR (Image to Text)','ocr','PDF & File','Extract text from images','fa-font',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(15,'ZIP Compressor','zip-compressor','PDF & File','Compress files to ZIP','fa-file-zipper',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(16,'Image Compressor','image-compressor','PDF & File','Compress images without losing quality','fa-image',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(17,'Word & Character Counter','word-counter','Text & Content','Count words, characters, sentences in text','fa-calculator',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(18,'Case Converter','case-converter','Text & Content','Convert text to UPPER, lower, Title Case','fa-font',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(19,'Paraphraser / Rewriter','paraphraser','Text & Content','Rewrite text in different words','fa-pen-fancy',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(20,'Grammar Checker','grammar-checker','Text & Content','Check and fix grammar','fa-spell-check',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(21,'Plagiarism Checker','plagiarism-checker','Text & Content','Check content originality','fa-copy',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(22,'Resume Builder','resume-builder','Text & Content','Create professional resumes','fa-id-card',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(23,'Essay / Letter Generator','essay-letter-generator','Text & Content','Generate essays and letters','fa-envelope-open-text',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(24,'JSON Formatter','json-formatter','Developer','Format & validate JSON','fa-braces',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(25,'QR Code Generator','qr-code-generator','Developer','Generate QR codes','fa-qrcode',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(26,'Regex Tester','regex-tester','Developer','Test regular expressions','fa-code',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(27,'Base64 Encoder','base64-encoder','Developer','Encode/decode Base64','fa-terminal',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(28,'URL Encoder','url-encoder','Developer','Encode/decode URL strings','fa-link',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(29,'HTML/CSS/JS Minifier','minifier','Developer','Minify front-end code','fa-compress',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(30,'Image Resizer','image-resizer','Image','Resize images to dimensions','fa-expand',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(31,'Background Remover','background-remover','Image','Remove image background','fa-eraser',1,'2026-02-27 07:31:46','2026-02-27 07:31:46'),(32,'OCR Tool','image-ocr','Image','Extract text from images','fa-font',1,'2026-02-27 07:31:46','2026-02-27 07:31:46');

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(32) NOT NULL DEFAULT 'user',
  `access_rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`access_rules`)),
  `is_master` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1,'Master Admin','admin@gmail.com',NULL,'$2y$12$jl5eLxugsZrQ3da0bCFWQ.xUg3kgpCT490rRRUQd69hi5YUFFXakm','admin',NULL,1,NULL,'2026-02-27 07:31:46','2026-02-27 07:31:46');

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-27 18:31:53
