-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: seafood
-- ------------------------------------------------------
-- Server version	5.7.23-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `web_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片名稱',
  `web_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片路徑',
  `mobile_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片名稱',
  `mobile_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片路徑',
  `href` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '超連結',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '開啟方式(0 => 直接開啟, 1 => 開新視窗)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'pic1.jpg','banners/4aaysJQN3bPpX7RXP15CEuDaaOOP5Iv0eGoTMyhT.jpg','pic2.jpeg','banners/u9n4QsxFIDUBfilMqlISBCLlhjqE4m9lD9xhFZ31.jpg',NULL,0,0,'2021-10-14 16:17:32','2021-10-14 16:17:32',NULL),(2,'pic1.jpg','banners/17Td3WAn4Tdx6CHm1Io9jTn2w1SegRPvPDvratDf.jpg','S__111558660.jpg','banners/3a5nV0TuXwpunRh2NEzpz20nN71cGBLabur4jsIh.jpg',NULL,0,0,'2021-10-14 16:20:13','2021-10-14 16:49:41',NULL),(3,'S__111558660.jpg','banners/zDAEHFyqPAFWTXBZef1e7COiwvS8RFrlP2un7ZnI.jpg','生鮮配-0456.jpg','banners/7vZlKNKuAQliQsHBcA25R8NqKcoqJVFGTkihI8F1.jpg',NULL,0,0,'2021-10-14 16:20:58','2021-10-14 16:49:37',NULL),(4,'pic2.jpeg','banners/u99OncyOC9gHVfjp08mHDx1sDo8uIS9bfwLi1EqO.jpg','cartoon.png','banners/v7vJyo8IcJhfgYIj1eQRhtufgINHcNeMbmszvzv8.png',NULL,0,0,'2021-10-14 16:30:11','2021-10-14 16:49:31',NULL),(5,'pic1.jpg','banners/7dGCJFIzwPtpADCgwtZvmLgUc4hrMNMPWTj1LOEy.jpg','pic2.jpeg','banners/XaXHCvg7zFckSQWfitY9Ch5Oe1vFt5V4hzhY0ivh.jpg',NULL,0,1,'2021-10-14 16:42:29','2021-10-15 14:49:59',NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `specifications_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_cart_id_index` (`cart_id`),
  KEY `carts_user_id_index` (`user_id`),
  KEY `carts_specifications_id_index` (`specifications_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `config_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES ('basic_title','abcde測試','2021-09-10 09:22:23','2021-09-10 14:47:46'),('basic_phone','123111','2021-09-10 09:22:23','2021-09-10 09:37:45'),('basic_address','123','2021-09-10 09:22:23','2021-09-10 09:33:11'),('basic_email','123','2021-09-10 09:22:24','2021-09-10 09:33:11'),('basic_facebook','123123','2021-09-10 09:22:24','2021-09-10 09:33:11'),('basic_line','12312332','2021-09-10 09:22:24','2021-09-10 09:33:11'),('seo_keyword','11123','2021-09-10 09:22:53','2021-09-10 09:22:58'),('seo_description','12345','2021-09-10 09:22:53','2021-09-10 14:41:26'),('sms_account','aaa@aaa.com','2021-09-10 14:40:25','2021-09-10 14:40:48'),('sms_password','1234qwer123','2021-09-10 14:40:25','2021-09-10 14:46:37');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cooking`
--

DROP TABLE IF EXISTS `cooking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cooking` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cooking_types_id` int(11) NOT NULL COMMENT '分類ID',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '標題',
  `start_date` datetime NOT NULL COMMENT '發表時間',
  `end_date` datetime NOT NULL COMMENT '截止時間',
  `href` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '超連結',
  `description` longtext COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `keywords` text COLLATE utf8mb4_unicode_ci COMMENT '關鍵字',
  `youtube_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'youtube_id',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '開啟方式(0 => 直接開啟, 1 => 開新視窗)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '設為跑馬燈顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cooking_cooking_types_id_index` (`cooking_types_id`),
  KEY `cooking_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooking`
--

LOCK TABLES `cooking` WRITE;
/*!40000 ALTER TABLE `cooking` DISABLE KEYS */;
/*!40000 ALTER TABLE `cooking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cooking_types`
--

DROP TABLE IF EXISTS `cooking_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cooking_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分類名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooking_types`
--

LOCK TABLES `cooking_types` WRITE;
/*!40000 ALTER TABLE `cooking_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `cooking_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directories`
--

DROP TABLE IF EXISTS `directories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '目錄名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directories`
--

LOCK TABLES `directories` WRITE;
/*!40000 ALTER TABLE `directories` DISABLE KEYS */;
/*!40000 ALTER TABLE `directories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cellphone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機號碼(帳號)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'email',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '市內電話',
  `zipcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '郵遞區號',
  `country` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '城市',
  `city` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地區',
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '地址',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '帳號啟用狀態(0 => 停用, 1 => 啟用)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_cellphone_unique` (`cellphone`),
  KEY `members_cellphone_index` (`cellphone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (59,'2014_10_12_000000_create_users_table',1),(60,'2014_10_12_100000_create_password_resets_table',1),(61,'2016_06_01_000001_create_oauth_auth_codes_table',1),(62,'2016_06_01_000002_create_oauth_access_tokens_table',1),(63,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(64,'2016_06_01_000004_create_oauth_clients_table',1),(65,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(66,'2019_08_19_000000_create_failed_jobs_table',1),(67,'2019_12_14_000001_create_personal_access_tokens_table',1),(68,'2021_09_07_130852_create_permission_tables',1),(70,'2021_09_10_161057_create_config_table',2),(97,'2021_09_11_225050_create_news_types_table',3),(98,'2021_09_11_225633_create_news_table',3),(99,'2021_09_16_225751_create_cooking_types_table',3),(100,'2021_09_16_225841_create_cooking_table',3),(101,'2021_09_21_231939_create_product_types_table',3),(102,'2021_09_21_232050_create_products_table',3),(103,'2021_09_22_221925_create_product_specifications_table',4),(104,'2021_09_26_004328_create_directories_table',5),(107,'2021_09_26_154842_create_put_ons_table',6),(112,'2021_10_05_155315_create_carts_table',7),(113,'2021_10_06_213105_create_banners_table',7),(115,'2021_10_17_131739_create_sms_codes_table',8),(117,'2021_10_17_204344_create_members_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(4,'App\\Models\\User',2),(2,'App\\Models\\User',5),(2,'App\\Models\\User',6),(1,'App\\Models\\User',7),(4,'App\\Models\\User',8);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `news_types_id` int(11) NOT NULL COMMENT '分類ID',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '標題',
  `start_date` datetime NOT NULL COMMENT '發表時間',
  `end_date` datetime NOT NULL COMMENT '截止時間',
  `href` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '超連結',
  `description` longtext COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `keywords` text COLLATE utf8mb4_unicode_ci COMMENT '關鍵字',
  `web_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片名稱',
  `web_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片路徑',
  `mobile_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片名稱',
  `mobile_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片路徑',
  `target` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '開啟方式(0 => 直接開啟, 1 => 開新視窗)',
  `carousel` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '設為跑馬燈顯示(0 => 不顯示, 1 => 顯示)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_news_types_id_index` (`news_types_id`),
  KEY `news_status_index` (`status`),
  KEY `news_carousel_index` (`carousel`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_types`
--

DROP TABLE IF EXISTS `news_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分類名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_types`
--

LOCK TABLES `news_types` WRITE;
/*!40000 ALTER TABLE `news_types` DISABLE KEYS */;
INSERT INTO `news_types` VALUES (4,'news_type1','2021-10-15 14:56:25','2021-10-15 14:56:25',NULL),(5,'news_type2','2021-10-15 14:56:29','2021-10-15 14:56:29',NULL);
/*!40000 ALTER TABLE `news_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('008feb84ee179a01db2bfcb40cf2f37b998afb51e52746c15ee1f2f93981b626becc6192cdc27b54',1,1,'web','[]',1,'2021-10-10 15:41:12','2021-10-13 15:20:19','2021-10-11 01:41:12'),('01af7e627d2484d3beed145cf5f5d265c4572efeb5569a87088f8e6325e228d25f5bd749278c9e13',1,1,'web','[]',0,'2021-09-12 15:56:21','2021-09-12 15:56:21','2021-09-13 01:56:21'),('0305e1fd08b58a779f4a19c98532de6d75b3b60698ec01260166125de16186986489994e5add0758',1,1,'web','[]',1,'2021-09-11 15:01:11','2021-09-11 15:01:14','2021-09-12 01:01:11'),('031518941de2e6fb5adb52c1392802326c7c1e5970853036c752da8794b41937fda8e5684f625002',1,1,'web','[]',0,'2021-10-13 20:48:21','2021-10-13 20:48:21','2021-10-13 22:48:21'),('0321e36ab6c54fb5ba96a2f02cae4e0ab991734a5abd58e566067a248e37cd3b4e2acd0cfa0c8a0c',1,1,'web','[]',0,'2021-09-11 15:00:42','2021-09-11 15:00:42','2021-09-12 01:00:42'),('032ca3bc0a5cd947427258b9566399d2d7de734160568f67c70a21c2b10b98ef2900a2cc2866239c',1,1,'web','[]',1,'2021-09-10 14:53:21','2021-09-23 14:37:36','2021-09-11 00:53:22'),('070088d3bacbfe2a22a20f87ec11adb95aa9949a9897eeb2a95cd168728883c85f7642ebc4a33c51',1,1,'web','[]',1,'2021-09-24 09:11:46','2021-09-24 09:19:08','2021-09-24 19:11:46'),('09ca5667078cfbc6a5ecefb62c24cf603f35506180aadd2b451124c97e80832aa0057d3be59ce463',1,1,'web','[]',1,'2021-09-29 13:46:34','2021-10-06 13:36:07','2021-09-29 23:46:34'),('0bb2766900fbcc983f284cb5c56af0ba8da57a29c9d29164eebe499a2aa24f5a9c4b6298803b579c',6,1,'web','[]',1,'2021-09-09 09:34:19','2021-09-09 09:34:48','2021-09-09 19:34:20'),('0e1fe67c16c982de984ea04e6fb3fb5db71b62da2570d47cb87e1dd4cf837f854364aebd9736373f',1,1,'web','[]',1,'2021-09-08 14:39:23','2021-09-08 14:39:51','2021-09-09 00:39:23'),('0f6635182d9263240c7ef522812e9c73b3e5f4c20434a5695ca990212178fde468935b43828bb474',1,1,'web','[]',0,'2021-09-28 12:35:10','2021-09-28 12:35:10','2021-09-28 22:35:10'),('12fb5a49530d2e71466a82620ea72d72eca47766fb230ba92afac760441785eee90e5c7441f8b27f',1,1,'web','[]',1,'2021-10-13 15:23:37','2021-10-13 15:38:46','2021-10-14 01:23:38'),('1300647d0e25c8f1f2423f01eba2741563a4d3d40d531faac0a92a45abcc389562be62bce1356445',1,1,'web','[]',0,'2021-10-12 13:23:06','2021-10-12 13:23:06','2021-10-12 15:23:06'),('16687fc35570fed23327014b4caef403528d5a67baecffda05ce3682f90b6498a509275ca7c857f6',1,1,'web','[]',0,'2021-09-17 09:37:28','2021-09-17 09:37:28','2021-09-17 19:37:28'),('16f2e339085b5967dc9acc43bdabe0e395e0a580044195884c8ec3b837551de4b0d88cee2dd7877f',1,1,'web','[]',0,'2021-09-16 15:12:38','2021-09-16 15:12:39','2021-09-17 01:12:39'),('1ef3a529c346441b368520d7c8a56d3eb0af99c22ec4a1aab45306d3e274ab7bd2a990cf7a295e57',1,1,'web','[]',1,'2021-09-09 09:30:52','2021-09-09 09:34:14','2021-09-09 19:30:53'),('1f1dbda287cac52bc4bcf090942405198e011764c513e15c07db00083938998934753ed34878c9f7',6,1,'web','[]',1,'2021-09-08 14:43:40','2021-09-08 14:44:27','2021-09-09 00:43:40'),('212aa580e74247356500629e2583c51d2761f24b7c2621e0c06f40232b6e4b2c4c9e631cb2f10d30',1,1,'web','[]',1,'2021-09-16 15:08:24','2021-09-16 15:08:42','2021-09-17 01:08:25'),('26e7619fd88048364e403e1d5c64d3e30dd9d979d97e23b239b8227ef0a37cc1d6df14cd0d4b068e',1,1,'web','[]',0,'2021-10-06 13:36:11','2021-10-06 13:36:11','2021-10-06 23:36:11'),('2996d2c18a7f1f0b679163c40cc18b4266b3572c4b5a87a5e80ac3e94678729bdf21cc4ba3034d51',1,1,'web','[]',1,'2021-09-29 13:32:12','2021-09-29 13:39:14','2021-09-29 23:32:13'),('2c9dd06edeb6d47d94724f91f90a6b0157b5d758b5ba86da2443634f951fb5b6b8c5790ca7dc206d',1,1,'web','[]',0,'2021-09-21 15:08:57','2021-09-21 15:08:57','2021-09-22 01:08:57'),('2d0df6d3e9db1c6dcc8546b4886b7d7f7be01460a4e3882c8c050fb2d8db312cb05d3d3714609ea5',1,1,'web','[]',1,'2021-09-11 14:58:24','2021-09-11 15:00:27','2021-09-12 00:58:24'),('2da5f751e49fe494ddfa11ffe684bb2d3fb06d7a69d73fea50334cafb377724542368e5747db8261',1,1,'web','[]',0,'2021-09-12 09:19:16','2021-09-12 09:19:16','2021-09-12 19:19:16'),('32d076cdc7797ea66a0478a655f2f3a9e1fab2612e1c874f1bd4d15240e09685ce28f4821b49ed0a',1,1,'web','[]',0,'2021-09-23 12:32:40','2021-09-23 12:32:40','2021-09-23 22:32:40'),('3368c729f85a58098c1fcd30454108e003c1b381a7adad03b2a2fc274440e734fac860835b744018',1,1,'web','[]',1,'2021-10-13 13:14:16','2021-10-13 15:15:07','2021-10-13 15:14:16'),('353cc442bee7a88e491a7d4296c0e17f8bc52e7ae169be75bf38d88e82843b1c7a5f9549dbb96876',1,1,'web','[]',0,'2021-10-10 11:00:21','2021-10-10 11:00:21','2021-10-10 21:00:21'),('37b30a35fbf9812434ac18b1457387c97bd84ec4876cc2edcffb3389f460132e425b7fad08c66d20',6,1,'web','[]',1,'2021-09-08 14:39:57','2021-09-08 14:40:31','2021-09-09 00:39:57'),('37e33c6873259c8f704bdb1b344baba423e89bde22d496fb4e37f7a48079e20ea00cbc052de3329f',1,1,'web','[]',0,'2021-10-13 15:03:38','2021-10-13 15:03:38','2021-10-14 01:03:38'),('38101ea2a8e547a83e0b035fdd3ed45a91072f89c55a13cb536ee9615a1406fd9d0e8b01eae21637',1,1,'web','[]',0,'2021-10-09 08:22:50','2021-10-09 08:22:50','2021-10-09 18:22:50'),('39dee9e810ae4535c0018dfe484f0a62f834c279bd120cfa0ea3fbbb06cb7b854ac9cd2173f49aba',1,1,'web','[]',0,'2021-10-13 13:06:17','2021-10-13 13:06:18','2021-10-13 15:06:18'),('3a8b78f1ded48dec925a756a44f3e0b993c518aec5a8736414674848203a4028d79fdc0ba4b20f74',1,1,'web','[]',1,'2021-10-06 13:39:02','2021-10-06 13:40:09','2021-10-06 23:39:02'),('3b92b464f479300d53874e3107fd3a6055a336690c23409f394196e6a2065b451038f2e5f1bee457',1,1,'web','[]',0,'2021-09-12 09:19:24','2021-09-12 09:19:24','2021-09-12 19:19:24'),('3cb6d20d59762fc0a0f63a60957203b731c78969ff899a6fe692de09b2594e10e9ef69d6b9738dd8',1,1,'web','[]',0,'2021-09-16 16:02:46','2021-09-16 16:02:47','2021-09-17 02:02:47'),('407f12f62b13e3cc947410b07bdbfec8f701db8c191d0f77ec0847162a623027a038936dfeb30cea',1,1,'web','[]',1,'2021-09-22 13:15:09','2021-09-22 15:56:01','2021-09-22 23:15:09'),('4398267a9c616dbac8ef6ed03005b6039cf691c8a622f40bc06ac3eeb96159b86790692827f3f4c6',1,1,'web','[]',1,'2021-09-25 06:40:27','2021-09-25 07:34:18','2021-09-25 16:40:28'),('452d31205ade29ea952ada73a42c4cf62e8d6ba01b37cf02a60854df7bd5f4664eec3ae1649debc1',1,1,'web','[]',1,'2021-10-13 15:23:15','2021-10-13 15:23:24','2021-10-14 01:23:15'),('4ac60479342dd9e1645245b8ee5b2bde235efae0966ace18da06de47939bbf13cf4994201304bcb0',1,1,'web','[]',1,'2021-09-09 08:30:14','2021-10-13 16:19:41','2021-09-09 18:30:14'),('4c2aeca3a8a5da6bf1376c1b10cdb4548bd007d427bcb8a4689507fde5b18f07e3dca0036d62b9ec',1,1,'web','[]',0,'2021-09-09 09:34:54','2021-09-09 09:34:54','2021-09-09 19:34:54'),('4e65fb192ecc1cfa1d29c8271b2e287768f4bdcdd08382104a9543fad51c7b40ade6aafac60ac1fd',1,1,'web','[]',0,'2021-09-16 15:11:45','2021-09-16 15:11:45','2021-09-17 01:11:45'),('4f533410b054f4dc444c10fef264fef2c060186e70c98b606051b128338a83040c4d7bc21d32afd8',1,1,'web','[]',0,'2021-10-13 16:19:34','2021-10-13 16:19:34','2021-10-14 02:19:34'),('547d7bf67bd0ea6a3bd9c5a174e5b7857196accc469c15fa9e224ec048378916b409cf7c7db2df62',1,1,'web','[]',1,'2021-09-15 06:05:37','2021-09-15 08:07:08','2021-09-15 16:05:37'),('55d2011cdee2ee53a54fa1a11e1996803e75dab21929b681196e60f455cf443a2ed04c0176c3608f',1,1,'web','[]',1,'2021-09-25 16:38:27','2021-09-25 16:38:54','2021-09-26 02:38:27'),('5ae1a1f5644a643a6c041be928873770e0a7732cfb0d02f0854c10a53bdaa79ab925e7778536ae06',1,1,'web','[]',1,'2021-10-13 08:38:14','2021-10-13 08:57:45','2021-10-13 10:38:14'),('5b30e05aa6de32d7668254ce2cd86e4dd0979d93e54f8cb1fe1d64cf694443025c90ad2458f07d53',1,1,'web','[]',0,'2021-10-07 13:28:16','2021-10-07 13:28:16','2021-10-07 23:28:16'),('5ba2c5825d048e217b67c69ec34e123d620ab78978e30e4a504b950b407ecbaa565775ed34b2f8ef',1,1,'web','[]',1,'2021-09-22 15:56:06','2021-09-22 15:56:31','2021-09-23 01:56:06'),('5c3e04653e8c3df8ed0ade81094106cd1ca7e7bc195140a117b912053d797dcba7a0d99964d0cd87',1,1,'web','[]',0,'2021-10-01 13:43:33','2021-10-01 13:43:33','2021-10-01 23:43:33'),('5da3bc287b4002d266a6b9bcacba1bb0061f616ba983dad03ae2defa34592a8e9ab124c48f5c892f',1,1,'web','[]',0,'2021-10-13 16:20:16','2021-10-13 16:20:16','2021-10-14 02:20:16'),('5ddc8795c34056297894ab14b18aa58d190e69a55c2c29271b7ad4e3066ab110768d37bcd2834e3e',1,1,'web','[]',1,'2021-09-08 14:44:37','2021-09-08 14:44:52','2021-09-09 00:44:37'),('5e2af4d9a776ad2056e4220121aeb97f3c53f0dc4b0affa8587bf58c15f528e764019ac715ab078c',1,1,'web','[]',0,'2021-09-25 16:38:57','2021-09-25 16:38:57','2021-09-26 02:38:57'),('607600f7052a64eda6e320e732f5146a349f34678be82815170a2a8554fa45bccfe2396909489619',1,1,'web','[]',0,'2021-10-09 14:37:09','2021-10-09 14:37:09','2021-10-10 00:37:09'),('61b3ef66b246d75f674e80c06954fc32351622fb169b20cdb2995725584a239d78c8c32366423d4a',1,1,'web','[]',1,'2021-10-13 16:19:03','2021-10-13 16:19:10','2021-10-14 02:19:03'),('62db6bda72a0ed6d8d2e01ae55bea6580456221909bcca5fe74453ef8cd137d9a1480d9b4b9382ac',1,1,'web','[]',0,'2021-09-25 07:34:41','2021-09-25 07:34:41','2021-09-25 17:34:41'),('668778df68372443987c34b747d8b96b23d5c5db1ba8b5d50db7738a7cc7db173844d4ff3b7de7b4',1,1,'web','[]',0,'2021-10-04 13:46:02','2021-10-04 13:46:03','2021-10-04 23:46:03'),('69be433b8524f1b518032206ff07e60ea58daca5ed453b7508de6ce3a55c89a1880fc49ed59d2698',6,1,'web','[]',1,'2021-09-08 14:44:56','2021-09-08 14:45:19','2021-09-09 00:44:56'),('714c25712ac6e0d14e66eb1bf1f2225e832bc165e46aa3033d7e0509abb06e217b458621f7fff118',1,1,'web','[]',0,'2021-09-24 09:22:07','2021-09-24 09:22:08','2021-09-24 19:22:08'),('75c73282110b2ed4b9b767669745a5b6e6b07fd22cbcab255a93124a6ff3d08ec4c4a23d52befa86',1,1,'web','[]',0,'2021-10-13 08:58:17','2021-10-13 08:58:17','2021-10-13 10:58:17'),('75d52bfaf6ae93429a6d80f4d4f10132eafb7721693af9f031315fe80f9ead3fbc4b88445fa3b903',1,1,'web','[]',0,'2021-10-13 18:17:47','2021-10-13 18:17:48','2021-10-13 20:17:48'),('77d3689535db4482aca4c6a1c3f1ec93f394b7bceac6c947e52bb76e847f159c0d2a750223e06b56',1,1,'web','[]',1,'2021-09-27 12:39:35','2021-09-27 14:40:26','2021-09-27 22:39:35'),('7da288a93a01754c3ffe9ab1371224ea07cba47e214bdf89aaa6136fa9ecb3b501902e6b9a4f2446',1,1,'web','[]',1,'2021-10-10 08:57:55','2021-10-10 11:00:17','2021-10-10 18:57:56'),('7da98536470fc357a0e43f1d546c33ba814cc2eb5a2587afaba956feb61fab177685251e4c0749c1',6,1,'web','[]',1,'2021-09-11 14:48:47','2021-09-11 14:48:53','2021-09-12 00:48:48'),('7ddc0ed7d2b5c707640125d94dbc6c88b4255c98f49719b6952e41c72c4d1dd2060e406f2f24590d',1,1,'web','[]',0,'2021-09-14 14:26:02','2021-09-14 14:26:03','2021-09-15 00:26:03'),('7e23673c0ded50f79ca18e5a598d2fae5441d1c1e28ec39251af15b2b36ba2fbcb3f7a95e1c24559',1,1,'web','[]',0,'2021-09-17 08:07:30','2021-09-17 08:07:30','2021-09-17 18:07:30'),('85af61d60686cebcab45d66d1784635cd06d1f48de0e74c4696dc241d6ad6196411f4ea511c5c3e9',1,1,'web','[]',1,'2021-09-16 15:11:30','2021-09-16 15:11:42','2021-09-17 01:11:31'),('88a8e2d68b3655220cb48fdd97af95d9de3cdcd728c9581e64bcb597e3c4f405a404fccf54b9b9db',1,1,'web','[]',1,'2021-09-15 03:57:48','2021-09-15 06:05:32','2021-09-15 13:57:48'),('8a9d54a9a1ed08a28e50c8f1714b6d5fa7a6ef07f079d14ae67bd78f23dc498fa6365e51673b5f25',1,1,'web','[]',0,'2021-10-13 17:59:34','2021-10-13 17:59:34','2021-10-13 19:59:34'),('8d33286516a932788bd8b5fdead8e20c9d9fe7129062b32349d3dddca533f3a4f40600eae4e273a0',1,1,'web','[]',0,'2021-10-13 15:20:12','2021-10-13 15:20:13','2021-10-14 01:20:13'),('8ebcd7b8da69e5c6c2f416799a8710467ccd7c698f0104020bbad846902e83be2374f644d7c35f57',6,1,'web','[]',1,'2021-09-08 14:42:41','2021-09-08 14:43:34','2021-09-09 00:42:41'),('9510f673be539f50f41b4cb161ea6416c1959e2881d999a1c1810091efff3b0faa06d5c2c0f87110',1,1,'web','[]',0,'2021-10-07 16:57:35','2021-10-07 16:57:35','2021-10-08 02:57:35'),('95fd05e768e982b6cedd8e85fc22329676df8ad8ab444ca0e08fa2968de5e5e6b8fa7c65f816201b',1,1,'web','[]',0,'2021-10-03 05:26:18','2021-10-03 05:26:18','2021-10-03 15:26:18'),('97d813b904afc01b3c1e590836ce2ed510ecd656eb0e0eec3d6d8628fed4c4c30f7942b848cd79b4',1,1,'web','[]',1,'2021-09-10 08:59:20','2021-09-10 09:37:55','2021-09-10 18:59:20'),('996e00448c7882df24ca0a551af0e974fb81cf5319c7d8c59d147834bd637242e62dd48d397623d9',1,1,'web','[]',0,'2021-09-17 01:06:00','2021-09-17 01:06:01','2021-09-17 11:06:01'),('9a1d8a0baf7c75df28abf9cffb3800dc4f63cb2295cb3dda85739a19a022b48fa8420045b20471ad',1,1,'web','[]',1,'2021-09-12 13:55:35','2021-09-12 15:56:15','2021-09-12 23:55:35'),('9c67e33caf57f3a49a3ab5a06c7131767f3b33163418975c488555e6f7cbd0f0e7efaaca074cbbfa',1,1,'web','[]',0,'2021-10-09 06:14:04','2021-10-09 06:14:04','2021-10-09 16:14:04'),('9d087ced33af286be366d8844511b5fda25aa0b843e10cea6c88b322fb658272592c667fee828fbc',1,1,'web','[]',0,'2021-10-06 13:22:49','2021-10-06 13:22:49','2021-10-06 23:22:49'),('9d0debc21fd715730edefcedf878bbedbcf6b9949cdae0ebf0afb338cebd7092729c5fe88a2fc34a',1,1,'web','[]',0,'2021-09-28 13:11:57','2021-09-28 13:11:57','2021-09-28 23:11:57'),('9dbb52b88736446aa83df527a6712e05d017453f1e88943dbf4d1af6a4b205af9d4434deef6c2fd2',1,1,'web','[]',0,'2021-10-13 16:21:46','2021-10-13 16:21:46','2021-10-14 02:21:46'),('9e4819025d7a7af3f5b131854c34ce0fc416c45481b8832cb780aac871982a81cd95e9d728983df6',1,1,'web','[]',0,'2021-09-12 04:00:02','2021-09-12 04:00:02','2021-09-12 14:00:02'),('a0bc5174b443dc9868219f28b5e46a2a92366c83abb652bf0b4e917c3597d005d416adeca82fa383',1,1,'web','[]',0,'2021-09-26 13:03:17','2021-09-26 13:03:17','2021-09-26 23:03:17'),('a3ff3ddf840bbc85022b2211e27bbc5f8868d874c051105a660107ec4d22c87e47dc420d131b2b01',1,1,'web','[]',0,'2021-09-29 13:39:23','2021-09-29 13:39:23','2021-09-29 23:39:23'),('a61811f9af07317602d380fb2e5110ded8ef8f71e298a809066fad98bc29975557dd1534edcc878b',1,1,'web','[]',0,'2021-10-14 13:29:06','2021-10-14 13:29:06','2021-10-14 23:29:06'),('a890a3071785ebce02a07ba458fed16366fc0877ab0a4be3c78da5a70025bef74777b722076547a6',1,1,'web','[]',0,'2021-09-29 13:26:32','2021-09-29 13:26:32','2021-09-29 23:26:32'),('a91c9e07b7d9a9c75dbc54d3f0bd46a4193a0918285f86f5414e1cf627ba4b6d13fd5172877d1f9a',1,1,'web','[]',0,'2021-10-12 18:50:03','2021-10-12 18:50:03','2021-10-12 20:50:03'),('b08dee864330dbbf4867864cbe7381e9698b7b4ea9a013ae3abf5bb8a63c1c73bb9e5818af5158be',1,1,'web','[]',0,'2021-09-10 08:09:42','2021-09-10 08:09:43','2021-09-10 18:09:43'),('b2b592842e45efad7ba5888d54065d0161847062424727aa22727f7dacd53a8024fe2e6b730ee09b',1,1,'web','[]',0,'2021-09-11 15:02:24','2021-09-11 15:02:24','2021-09-12 01:02:24'),('b4d85f0438812069d4aef85ea7b59badac4df5cc452100ba0c43e785f290f2f9799b88c177f2f261',1,1,'web','[]',0,'2021-10-02 03:50:22','2021-10-02 03:50:22','2021-10-02 13:50:22'),('b4fe45aa2a549b5aa157e19913010404457ff1ae8d155060e114edb59f88b593f615b17e3f607f01',1,1,'web','[]',1,'2021-09-08 14:38:46','2021-09-08 14:39:09','2021-09-09 00:38:46'),('b55cf50297945e6ee362f3b665610a000dd259a9ad8294eafbeb3f69503adb92f6022e7dee4adf51',1,1,'web','[]',0,'2021-10-14 15:38:06','2021-10-14 15:38:06','2021-10-15 01:38:06'),('b58fc2f69b749a694af01991a5986de3c5bb2ab98c0e2f7592bc5be1add26a789c3d8b5f4aba5f01',1,1,'web','[]',0,'2021-09-11 14:48:59','2021-09-11 14:48:59','2021-09-12 00:48:59'),('b677c901b2d1746e990fa8e13c83378a94347618a9f427a0abc2889dcb3ac91048ddd383275ed12d',1,1,'web','[]',0,'2021-09-25 14:23:12','2021-09-25 14:23:12','2021-09-26 00:23:12'),('b9c7a4661d13cc77a8f3abdbb8c29f4deebb88dd5aff061af7e05e66655f2b3fa5aebc8c56fe1bad',6,1,'web','[]',0,'2021-09-16 15:08:57','2021-09-16 15:08:57','2021-09-17 01:08:57'),('babfcfc8e56d5778778080cf3573737071b9f83a1674db3f63a97ee32bb2c4904b64a48402b3c022',1,1,'web','[]',0,'2021-09-25 07:34:22','2021-09-25 07:34:22','2021-09-25 17:34:22'),('bad4aaa7f38731e42a2efd6b79406844e528c82b66c38199960393f9938c7b8e3e8b7774b9198dc2',1,1,'web','[]',0,'2021-10-08 15:01:31','2021-10-08 15:01:31','2021-10-09 01:01:31'),('bbf9436c6ef92d1e537a9fc7682e6b1ab88e955c72b134163332edfd8e049cd0b3b19ffa6061754b',1,1,'web','[]',0,'2021-09-08 15:19:26','2021-09-08 15:19:26','2021-09-09 01:19:26'),('be72e8534d5e0a002fafdde254f6fe2e7e217233c97c66882ecba625374e00caa875369451be4df9',1,1,'web','[]',0,'2021-09-16 15:13:17','2021-09-16 15:13:17','2021-09-17 01:13:17'),('bf414e4ceca5ec33126e84be55e2d8ca8085d00d4a556b048e0ee5a7e76002a27bf21234c4d3f629',1,1,'web','[]',0,'2021-09-27 14:40:30','2021-09-27 14:40:30','2021-09-28 00:40:30'),('c1310184a60eeea0a75d5cbb400eea00aab84d1c8d400f236cb7916efb4aaf198ad9805db9a32c14',1,1,'web','[]',0,'2021-09-23 14:37:55','2021-09-23 14:37:55','2021-09-24 00:37:55'),('c1e4c887596752204033c031bad5406faac8e2191b6efca2cc1d0fcf99881c6e93d6b14bd0f2b106',1,1,'web','[]',0,'2021-09-26 07:43:18','2021-09-26 07:43:18','2021-09-26 17:43:18'),('c41537f315c1667b7552046eaa5f91c7f6b4d59cb9b8ead15013cc0d5f61ff85f6bed21160547d52',1,1,'web','[]',0,'2021-10-15 14:49:38','2021-10-15 14:49:39','2021-10-16 00:49:39'),('c50d89a9b45c7e4ad602d21f4a45b31d1a9cb449599f0203e2649135ba5b6e4df129c6d884f21505',1,1,'web','[]',0,'2021-09-21 14:59:18','2021-09-21 14:59:19','2021-09-22 00:59:19'),('c76f5ed991c37c04b60e6e83d9edce07a128fb6a71d98e080a9a4e0cc5f0cad46eb9beebf42d8687',1,1,'web','[]',0,'2021-09-16 15:15:13','2021-09-16 15:15:13','2021-09-17 01:15:13'),('c7d31ad83cf9b4c52c7075885fa00905b17832c96db7480d7b16fd89f60b2a2f571e286b9632a2a8',1,1,'web','[]',0,'2021-10-13 15:52:20','2021-10-13 15:52:20','2021-10-13 17:52:20'),('c927a298a74f10862e7469f53bc16a106887fa13705cb68ab27b62abe806072ec8b4010af07120a9',1,1,'web','[]',0,'2021-09-29 08:21:22','2021-09-29 08:21:22','2021-09-29 18:21:22'),('c953f5a5f63cfef4fd1f27249f24c34c21bdc17c662dcaa3e14a854c8a3e95fc759e491cfc63b995',1,1,'web','[]',0,'2021-09-15 08:07:12','2021-09-15 08:07:12','2021-09-15 18:07:12'),('ca011d14c86c0989868dc0e1b07e5d9cc2fa280cbc1001942c6799f144c7e5eb059356b65c4a07e3',1,1,'web','[]',0,'2021-09-16 15:10:11','2021-09-16 15:10:11','2021-09-17 01:10:11'),('ca63052595fa9cccfe273d865ed91675d5161fb3c1cb882dbff6f4e1fafc5f4fa696eb9bbb210230',1,1,'web','[]',0,'2021-10-13 15:38:52','2021-10-13 15:38:52','2021-10-14 01:38:52'),('cca0ceaf7489a52ed8e0b4945e4c1d3455b37e0e7ccde20d49950b118d07708bbb0f24d22424a4a6',1,1,'web','[]',0,'2021-09-12 09:00:10','2021-09-12 09:00:11','2021-09-12 19:00:11'),('cdb9e79b812b6c21bb3a205a8de7ead7845da9bcc3f069cceb96d9e7666c0cea8a7e99be6c3703e0',1,1,'web','[]',0,'2021-10-06 13:38:51','2021-10-06 13:38:51','2021-10-06 23:38:51'),('d012858e6c523f8459644670a315b5a4e3c7e06eb005d35a39d3f5780a7cf3defb95f21d9205c23c',1,1,'web','[]',0,'2021-09-17 00:49:00','2021-09-17 00:49:00','2021-09-17 10:49:00'),('d17259f1393c0b59db6bdcac52629471d6634184962f94fe6fb29976983fa315f6d4d30d6484d90d',1,1,'web','[]',0,'2021-09-15 13:44:23','2021-09-15 13:44:23','2021-09-15 23:44:23'),('d25790a1299b58dd441a6a3cc169d140be9938806d48a3697238e6cb959d20feff8e78dadf38d7bf',1,1,'web','[]',0,'2021-09-29 12:30:57','2021-09-29 12:30:57','2021-09-29 22:30:57'),('d6292c0a61eb317f49d8809da41fe82231f4e2501b2fe37f3d298e3c15e37c01e374ccce650283e8',1,1,'web','[]',0,'2021-10-13 16:22:24','2021-10-13 16:22:24','2021-10-14 02:22:24'),('d6843b00df890f41ab24da9df6690893c638c4d4700fe5da95165698d0bd7f2f8e6781270f6a4ae4',1,1,'web','[]',0,'2021-10-06 14:37:01','2021-10-06 14:37:01','2021-10-07 00:37:01'),('d9f9679050a33e218570bd729d0de5ab0d8e8fd45b3fe9e1cccbd1f76d7fb09076e625efd213991c',1,1,'web','[]',0,'2021-09-16 15:09:44','2021-09-16 15:09:45','2021-09-17 01:09:45'),('e1a0fd20d30d3e113c91ee50870dfd898a105ab26709e196e7aa74831ca831ead7598d80a10dee0f',1,1,'web','[]',0,'2021-10-13 15:13:40','2021-10-13 15:13:41','2021-10-14 01:13:41'),('e4923f347b850d2a305b2d6e0bafa5e37f4f73caa38a671e1de328b785acc8f4bfa2c8904a3c56af',1,1,'web','[]',0,'2021-09-10 13:04:11','2021-09-10 13:04:12','2021-09-10 23:04:12'),('e61e61d26a359d042a663c3b63c043932887e909f09d4079623a304debb331c62e27f8f4151310d9',1,1,'web','[]',0,'2021-09-16 14:23:51','2021-09-16 14:23:52','2021-09-17 00:23:52'),('e6a4fbde8e2d6bd3e2c5635f57a1a950d651e9616eae7dad1fe3bec7cd5a88b2779613b92dd8c3ed',6,1,'web','[]',0,'2021-09-09 09:36:55','2021-09-09 09:36:55','2021-09-09 19:36:55'),('e756a2b679af71c7fcc3f7caa7c56cede7755153d0cbec4758dee65ccacea53c77c072afc9ac4927',2,1,'web','[]',0,'2021-09-08 14:45:25','2021-09-08 14:45:25','2021-09-09 00:45:25'),('eac9f25553b669f48f6bc9e5fc0014e57ec8de7007fbb12648549cfc85c473fab38af97a707117f6',1,1,'web','[]',0,'2021-10-12 13:19:49','2021-10-12 13:19:49','2021-10-12 15:19:49'),('edde2c7887b0ff4e141587a9ea00b46506871284264cdd82a1c0ea03165e29291dc3c421d7fbb81a',1,1,'web','[]',0,'2021-10-05 12:30:04','2021-10-05 12:30:05','2021-10-05 22:30:05'),('f046bbbba02338c740f397c110c3c7d8d7bf15ce453f0829876a84163dc987953c164a37b3e770de',1,1,'web','[]',0,'2021-10-06 13:40:45','2021-10-06 13:40:45','2021-10-06 23:40:45'),('f06752a9a7057564db8b1efd828420039b8ed7ca8128b5f73cfe8b4d3e14a038abef90a8d7cab92f',1,1,'web','[]',0,'2021-10-06 13:36:18','2021-10-06 13:36:18','2021-10-06 23:36:18'),('f10eedb4511ed106e879ee209ea62ee3e2c89bb0535f8d7309f3dcb932b597c761bf7084a09d1a34',1,1,'web','[]',0,'2021-09-28 15:12:20','2021-09-28 15:12:20','2021-09-29 01:12:20'),('f5a784c2f3c57e404e23d30d2c9880246c3f3b1dcdd2284614cce91b53fbeadc91d923faad08033d',1,1,'web','[]',0,'2021-09-17 00:49:33','2021-09-17 00:49:33','2021-09-17 10:49:33'),('f70d1c9f190d3aa0c13985af639d9083179f9745944eb71e742c6ca72932f777ffeaa16a84169a3d',1,1,'web','[]',0,'2021-09-16 12:22:22','2021-09-16 12:22:23','2021-09-16 22:22:23'),('f7813d5a4b76ef46dc8deef6b46463a1d66e9f613b4d328513d749c60d8a29c9fe02e65299970def',1,1,'web','[]',0,'2021-09-16 15:16:04','2021-09-16 15:16:04','2021-09-17 01:16:04'),('faad062e503ade076f64b08786cd6a950ea99ae9539c739358d588b2c0dd60935b0586c2a00050b5',1,1,'web','[]',0,'2021-09-08 14:41:07','2021-09-08 14:41:07','2021-09-09 00:41:07'),('fb00fe7c87893b6bcbaa24b99152706f6856f8614852c2d306278d3e209014f6af16fec5e6f39dc3',1,1,'web','[]',0,'2021-10-03 13:35:03','2021-10-03 13:35:03','2021-10-03 23:35:03');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `client_id` bigint(20) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','4bOtJNl9pESdDqr2ju0yQL9VbyoLAGXenS4Jn9d6',NULL,'http://localhost',1,0,0,'2021-09-08 14:38:28','2021-09-08 14:38:28'),(2,NULL,'Laravel Password Grant Client','Jef45zd5DyU9BqmaNFK5ZPnBysBfYxxFYyGen5se','users','http://localhost',0,1,0,'2021-09-08 14:38:28','2021-09-08 14:38:28');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2021-09-08 14:38:28','2021-09-08 14:38:28');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'set_basic','web','基本設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(2,'set_manager','web','人員管理','2021-09-08 13:59:43','2021-09-08 13:59:43'),(3,'set_message','web','簡訊設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(4,'news-type','web','最新消息分類','2021-09-10 14:52:43','2021-09-10 14:52:43'),(5,'news','web','最新消息管理','2021-09-10 14:52:43','2021-09-10 14:52:43'),(6,'cooking-type','web','烹飪教學分類','2021-09-16 02:50:00','2021-09-16 02:50:00'),(7,'cooking','web','烹飪教學管理','2021-09-16 02:50:00','2021-09-16 02:50:00'),(9,'product-type','web','產品分類','2021-09-21 15:00:00','2021-09-21 15:00:00'),(10,'product','web','產品管理','2021-09-21 15:00:00','2021-09-21 15:00:00'),(11,'directory','web','目錄管理','2021-09-25 16:00:00','2021-09-25 16:00:00'),(12,'put-on','web','上架管理','2021-09-25 16:00:00','2021-09-25 16:00:00'),(13,'banners','web','大圖輪播','2021-10-04 16:00:00','2021-10-04 16:00:00');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_specifications`
--

DROP TABLE IF EXISTS `product_specifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_specifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL COMMENT '分類ID',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '規格名稱',
  `original_price` int(11) NOT NULL COMMENT '原價',
  `selling_price` int(11) NOT NULL COMMENT '售價',
  `inventory` int(11) NOT NULL COMMENT '庫存',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_specifications_product_id_index` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specifications`
--

LOCK TABLES `product_specifications` WRITE;
/*!40000 ALTER TABLE `product_specifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_specifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分類名稱',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_types_id` int(11) NOT NULL COMMENT '分類ID',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '標題',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '內文',
  `web_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片名稱',
  `web_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片路徑',
  `mobile_img_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片名稱',
  `mobile_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片路徑',
  `keywords` text COLLATE utf8mb4_unicode_ci COMMENT '關鍵字',
  `description` longtext COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `sales_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否暫停銷售(0 => 暫停, 1 => 開放)',
  `show_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否於上架管理顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_product_types_id_index` (`product_types_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `put_ons`
--

DROP TABLE IF EXISTS `put_ons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `put_ons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `directories_id` int(11) NOT NULL COMMENT '目錄ID',
  `product_id` int(11) NOT NULL COMMENT '產品ID',
  `start_date` datetime DEFAULT NULL COMMENT '開始上架時間',
  `end_date` datetime DEFAULT NULL COMMENT '下架時間',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上架狀態(0 => 下架, 1 => 上架-不依據時間上下架, 2 => 上架-依據時間上下架)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `put_ons_directories_id_index` (`directories_id`),
  KEY `put_ons_product_id_index` (`product_id`),
  KEY `put_ons_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `put_ons`
--

LOCK TABLES `put_ons` WRITE;
/*!40000 ALTER TABLE `put_ons` DISABLE KEYS */;
/*!40000 ALTER TABLE `put_ons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(9,1),(10,1),(11,1),(12,1),(13,1),(1,2),(1,3),(2,3),(3,3),(2,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'系統管理者','web','2021-09-08 13:59:43','2021-09-08 13:59:43',NULL),(2,'一般使用者','web','2021-09-08 14:05:27','2021-09-08 14:05:27',NULL),(3,'一般使用者11','web','2021-09-09 08:41:24','2021-09-09 08:41:29','2021-09-09 08:41:29'),(4,'店長','web','2021-09-10 14:50:33','2021-09-10 14:50:33',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_codes`
--

DROP TABLE IF EXISTS `sms_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cellphone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機名稱',
  `verification_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '驗證碼(共5碼)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sms_codes_cellphone_index` (`cellphone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_codes`
--

LOCK TABLES `sms_codes` WRITE;
/*!40000 ALTER TABLE `sms_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '帳號啟用狀態(0 => 停用, 1 => 啟用)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','系統管理者','josh.chiang@aibitechcology.com',NULL,'$2y$10$/pIg1LYjJCTolGwgHza2.O/J2MACa2Yd8AqueLtG9DzTYaWcz6vRO',NULL,1,'2021-09-08 13:59:52','2021-09-17 00:58:16',NULL),(2,'test1','test1','aaa@aaa.com',NULL,'$2y$10$83Rel.ea3MyahV4OuoFGJuunwTvH1YyQuNimZspWFkorvE1K/4BVq',NULL,0,'2021-09-08 14:04:59','2021-09-17 01:10:56',NULL),(3,'test2','test2','bbb@bbb.com',NULL,'$2y$10$VH7h9Bvu52BcAj3z5quk1.sImM2Zy9mC7Qg1ukzhUCDtCmKNNwhWG',NULL,1,'2021-09-08 14:34:04','2021-09-08 14:34:17','2021-09-08 14:34:17'),(4,'test2','test2','bbb@bbb.com',NULL,'$2y$10$Dn2SWNjnaTbPt9jRRncXp.3alz/FknLaTk.I7eK44Yj999kCbjQB6',NULL,1,'2021-09-08 14:34:32','2021-09-08 14:35:06','2021-09-08 14:35:06'),(5,'test2','test2','bbb@bbb.com',NULL,'$2y$10$l4Kbkj9TevlRJVP2ZEvl5emS9DWHgfd4Tolwnvwz/91jgL2oCuo1i',NULL,1,'2021-09-08 14:36:03','2021-09-08 14:36:03',NULL),(6,'josh','josh','ccc@ccc.com',NULL,'$2y$10$lEx2lCxPisasqN1HdhQ0MemdbBAEw0DISa5T6pZ9NLQmzE2mpwRAG',NULL,1,'2021-09-08 14:39:46','2021-09-08 14:44:49',NULL),(7,'test3','test3','aaa@aaa.com',NULL,'$2y$10$PtT9KfjHJCCD0TBzM0zUD.6ii3GOuPiMqxJYuJaOoDGZHTcUmuVou',NULL,1,'2021-09-14 15:05:52','2021-09-17 01:06:12','2021-09-17 01:06:12'),(8,'test3','test3','aaa@aaa.com',NULL,'$2y$10$31JX9c8EMFtD5fL4iCXObukhJIPTX.e5hSKPYXu.TR4RziR0p/2NK',NULL,1,'2021-09-17 01:06:55','2021-09-17 01:08:36','2021-09-17 01:08:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'seafood'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-17 22:39:30
