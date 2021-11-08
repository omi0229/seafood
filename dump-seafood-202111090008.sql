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
  `web_img_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片名稱',
  `web_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片路徑',
  `mobile_img_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片名稱',
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,'b30bdb56-7e73-4a9c-a9db-1756edcd33be',NULL,7,10,'2021-11-02 12:49:52','2021-11-06 17:21:17','2021-11-06 17:21:17'),(2,'b30bdb56-7e73-4a9c-a9db-1756edcd33be',NULL,3,20,'2021-11-03 09:54:57','2021-11-06 17:22:56','2021-11-06 17:22:56'),(3,'b30bdb56-7e73-4a9c-a9db-1756edcd33be',NULL,3,1,'2021-11-06 17:28:49','2021-11-06 17:28:49',NULL),(4,'b30bdb56-7e73-4a9c-a9db-1756edcd33be',NULL,5,5,'2021-11-07 14:27:43','2021-11-07 14:27:43',NULL);
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
INSERT INTO `config` VALUES ('basic_title','abcde測試','2021-09-10 09:22:23','2021-09-10 14:47:46'),('basic_phone','123111','2021-09-10 09:22:23','2021-09-10 09:37:45'),('basic_address','123','2021-09-10 09:22:23','2021-09-10 09:33:11'),('basic_email','123','2021-09-10 09:22:24','2021-09-10 09:33:11'),('basic_facebook','123123','2021-09-10 09:22:24','2021-09-10 09:33:11'),('basic_line','12312332','2021-09-10 09:22:24','2021-09-10 09:33:11'),('seo_keyword','11123','2021-09-10 09:22:53','2021-09-10 09:22:58'),('seo_description','12345','2021-09-10 09:22:53','2021-09-10 14:41:26'),('sms_account','edison@ljnet.com.tw','2021-09-10 14:40:25','2021-10-26 14:11:53'),('sms_password','22639087','2021-09-10 14:40:25','2021-10-26 14:11:54');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooking`
--

LOCK TABLES `cooking` WRITE;
/*!40000 ALTER TABLE `cooking` DISABLE KEYS */;
INSERT INTO `cooking` VALUES (14,3,'cooking-practice','2021-10-24 12:48:00','2021-10-29 12:48:00',NULL,NULL,'','8b-DcbRUvjo',1,1,'2021-10-24 04:48:19','2021-10-24 04:49:00',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooking_types`
--

LOCK TABLES `cooking_types` WRITE;
/*!40000 ALTER TABLE `cooking_types` DISABLE KEYS */;
INSERT INTO `cooking_types` VALUES (3,'cooking1','2021-10-24 04:36:50','2021-10-24 04:36:50',NULL),(4,'cooking2','2021-10-24 04:36:53','2021-10-24 04:36:53',NULL),(5,'cooking3','2021-10-24 04:36:58','2021-10-24 04:36:58',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directories`
--

LOCK TABLES `directories` WRITE;
/*!40000 ALTER TABLE `directories` DISABLE KEYS */;
INSERT INTO `directories` VALUES (31,'directory1','2021-10-24 04:41:18','2021-10-24 04:41:18',NULL);
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
-- Table structure for table `forget_password_logs`
--

DROP TABLE IF EXISTS `forget_password_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forget_password_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cellphone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手機號碼(帳號)',
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'IP',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forget_password_logs_cellphone_index` (`cellphone`),
  KEY `forget_password_logs_ip_index` (`ip`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forget_password_logs`
--

LOCK TABLES `forget_password_logs` WRITE;
/*!40000 ALTER TABLE `forget_password_logs` DISABLE KEYS */;
INSERT INTO `forget_password_logs` VALUES (2,'0933288334','::1','2021-10-27 13:45:13','2021-10-27 13:52:31','2021-10-27 13:52:31'),(3,'0933288331','192.1.1.1','2021-10-27 13:52:32','2021-10-27 13:52:32',NULL),(4,'0933288334','::1','2021-10-27 13:53:05','2021-10-27 13:58:25','2021-10-27 13:58:25'),(5,'0933288334','::1','2021-10-27 13:58:25','2021-10-27 14:01:53','2021-10-27 14:01:53'),(6,'0933288334','::1','2021-10-27 14:01:53','2021-10-27 14:07:19','2021-10-27 14:07:19'),(7,'0933288334','::1','2021-10-27 14:07:19','2021-10-27 14:14:17','2021-10-27 14:14:17'),(8,'0933288334','::1','2021-10-27 14:14:17','2021-10-27 14:21:15','2021-10-27 14:21:15'),(9,'0933288334','::1','2021-10-27 14:21:15','2021-10-27 14:45:48','2021-10-27 14:45:48'),(10,'0933288334','::1','2021-10-27 14:45:48','2021-10-27 14:49:54','2021-10-27 14:49:54'),(11,'0933288334','::1','2021-10-27 14:49:55','2021-10-28 13:00:15','2021-10-28 13:00:15'),(12,'0933288334','::1','2021-10-28 13:00:15','2021-10-28 13:09:26','2021-10-28 13:09:26'),(13,'0933288334','::1','2021-10-28 13:09:26','2021-10-28 13:57:38','2021-10-28 13:57:38'),(14,'0933288334','::1','2021-10-28 13:57:38','2021-10-28 13:57:38',NULL);
/*!40000 ALTER TABLE `forget_password_logs` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'0987654321','$2y$10$ptmUnL9drpK8RreXsx7D7OPCtIzReRtQGcOBxUgJkcFp5ZwA/rLoy','test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2021-10-18 15:10:26','2021-10-27 15:03:09',NULL),(2,'0922222222','$2y$10$zxMocrfyrOFIAEOb9v0LruuCytL5DgP51lwzGJtN7hr5FCHO4gY6W','abcde','bbb@bbb.com',NULL,'04-12345678','900','屏東縣','屏東市','12345',NULL,1,'2021-10-18 15:11:18','2021-10-27 14:54:05',NULL),(3,'0933288334','$2y$10$aKhQMOlmTjd.sl36TcwenOZzjG6SpFu2dW8DdsXPZpavzRvl8zywS','煩',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'2021-10-26 15:31:30','2021-10-28 13:59:05',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (59,'2014_10_12_000000_create_users_table',1),(60,'2014_10_12_100000_create_password_resets_table',1),(61,'2016_06_01_000001_create_oauth_auth_codes_table',1),(62,'2016_06_01_000002_create_oauth_access_tokens_table',1),(63,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(64,'2016_06_01_000004_create_oauth_clients_table',1),(65,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(66,'2019_08_19_000000_create_failed_jobs_table',1),(67,'2019_12_14_000001_create_personal_access_tokens_table',1),(68,'2021_09_07_130852_create_permission_tables',1),(70,'2021_09_10_161057_create_config_table',2),(97,'2021_09_11_225050_create_news_types_table',3),(98,'2021_09_11_225633_create_news_table',3),(99,'2021_09_16_225751_create_cooking_types_table',3),(100,'2021_09_16_225841_create_cooking_table',3),(101,'2021_09_21_231939_create_product_types_table',3),(102,'2021_09_21_232050_create_products_table',3),(103,'2021_09_22_221925_create_product_specifications_table',4),(104,'2021_09_26_004328_create_directories_table',5),(107,'2021_09_26_154842_create_put_ons_table',6),(112,'2021_10_05_155315_create_carts_table',7),(113,'2021_10_06_213105_create_banners_table',7),(115,'2021_10_17_131739_create_sms_codes_table',8),(117,'2021_10_17_204344_create_members_table',9),(120,'2021_10_27_211842_create_forget_password_logs_table',10),(122,'2021_10_30_161032_create_product_images_table',11);
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
  `web_img_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片名稱',
  `web_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電腦版圖片路徑',
  `mobile_img_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手機板圖片名稱',
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (25,5,'news2','2021-10-24 12:46:00','2021-11-06 12:46:00','null',NULL,NULL,NULL,NULL,'生鮮配-0456.jpg','news/SVAZeJz0G9f3HsogTQqQkSqZMQ8DsT6jE24CFrqi.jpg',0,1,1,'2021-10-24 04:46:16','2021-11-01 13:56:15',NULL),(26,5,'news','2021-11-06 15:26:00','2021-11-13 15:26:00','https://www.google.com.tw','<p>test</p>',NULL,'生鮮配-0456.jpg','news/hl0bIcGE1tWlkN6ZfrZr2gidPLALSaXNzuPcAqju.jpg',NULL,NULL,0,1,1,'2021-11-06 07:26:31','2021-11-06 07:26:31',NULL);
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
INSERT INTO `oauth_access_tokens` VALUES ('008feb84ee179a01db2bfcb40cf2f37b998afb51e52746c15ee1f2f93981b626becc6192cdc27b54',1,1,'web','[]',1,'2021-10-10 15:41:12','2021-10-13 15:20:19','2021-10-11 01:41:12'),('01af7e627d2484d3beed145cf5f5d265c4572efeb5569a87088f8e6325e228d25f5bd749278c9e13',1,1,'web','[]',0,'2021-09-12 15:56:21','2021-09-12 15:56:21','2021-09-13 01:56:21'),('0269726b7bc66d6d09c5b4ca052559190bf5bff6104ce165578ae341d52ef14ff6724884aeebcb8a',2,1,'api','[]',0,'2021-10-19 13:47:14','2021-10-19 13:47:14','2022-10-19 21:47:14'),('02e8a4a8871c1b276bc5b45081d00d5049f3394ab6f43c99dc376eb7ee398f95a8b14bbdc96bc2b3',1,1,'web','[]',1,'2021-10-31 06:14:44','2021-10-31 06:52:09','2021-10-31 16:14:44'),('0305e1fd08b58a779f4a19c98532de6d75b3b60698ec01260166125de16186986489994e5add0758',1,1,'web','[]',1,'2021-09-11 15:01:11','2021-09-11 15:01:14','2021-09-12 01:01:11'),('031518941de2e6fb5adb52c1392802326c7c1e5970853036c752da8794b41937fda8e5684f625002',1,1,'web','[]',0,'2021-10-13 20:48:21','2021-10-13 20:48:21','2021-10-13 22:48:21'),('0321e36ab6c54fb5ba96a2f02cae4e0ab991734a5abd58e566067a248e37cd3b4e2acd0cfa0c8a0c',1,1,'web','[]',0,'2021-09-11 15:00:42','2021-09-11 15:00:42','2021-09-12 01:00:42'),('032ca3bc0a5cd947427258b9566399d2d7de734160568f67c70a21c2b10b98ef2900a2cc2866239c',1,1,'web','[]',1,'2021-09-10 14:53:21','2021-09-23 14:37:36','2021-09-11 00:53:22'),('0330e8f811492538a28fd86519777b0e240c18c2f8bef5b2fcd654a7ed188b7c0e35f759082b7c22',2,1,'api','[]',0,'2021-10-21 13:18:17','2021-10-21 13:18:17','2022-10-21 21:18:17'),('040e58205bd549be7fcd281e719e93a2bddd2f222ba56d805e66bd46b54bcaef08f6b3e6a572a896',2,1,'api','[]',0,'2021-10-22 15:25:07','2021-10-22 15:25:07','2022-10-22 23:25:07'),('050e2c251f2069e1997e0ff345cc782175b83bc69d0418ba6e52055a0851803454b02b870bc6bb7b',2,1,'api','[]',0,'2021-10-23 08:19:33','2021-10-23 08:19:33','2022-10-23 16:19:33'),('05d14484a7934593da73245c4fe2c6ed8e07260a09ac4d92eaacb2fa982d40bfd032a06b08a58f88',2,1,'api','[]',0,'2021-10-27 14:53:48','2021-10-27 14:53:48','2022-10-27 22:53:48'),('067f2f1682f9998d56d7609361c79fedbc30b18db6dd2f664060177ba037597a7412af3e605d4336',1,1,'web','[]',0,'2021-10-28 13:01:08','2021-10-28 13:01:08','2021-10-28 23:01:08'),('06d55e92577c35dc3afc82b4cacab3e7e2b14cb7ad09b076a8dcf3c1c218e28916831fad61c518b1',2,1,'api','[]',1,'2021-10-27 14:52:58','2021-10-30 16:21:11','2022-10-27 22:52:58'),('070088d3bacbfe2a22a20f87ec11adb95aa9949a9897eeb2a95cd168728883c85f7642ebc4a33c51',1,1,'web','[]',1,'2021-09-24 09:11:46','2021-09-24 09:19:08','2021-09-24 19:11:46'),('09ca5667078cfbc6a5ecefb62c24cf603f35506180aadd2b451124c97e80832aa0057d3be59ce463',1,1,'web','[]',1,'2021-09-29 13:46:34','2021-10-06 13:36:07','2021-09-29 23:46:34'),('0a772285b1fd793cf10f2058686a716606c89fed1a7005fbabe5590282b1dbb4a4edee260ea77312',2,1,'api','[]',1,'2021-11-06 17:20:06','2021-11-07 02:42:58','2022-11-07 01:20:06'),('0acf89e783f6355507480807c8cf9cc5fe277cb510a7e7ad8c3d3fc537689a1828701c425eb90d9f',1,1,'web','[]',1,'2021-10-31 13:05:34','2021-10-31 13:15:17','2021-10-31 23:05:35'),('0bb2766900fbcc983f284cb5c56af0ba8da57a29c9d29164eebe499a2aa24f5a9c4b6298803b579c',6,1,'web','[]',1,'2021-09-09 09:34:19','2021-09-09 09:34:48','2021-09-09 19:34:20'),('0bd901480f4a7edccb472a596069644553040cb6cb3b6684fa002af310f01103a7340a8cab612e4a',2,1,'api','[]',0,'2021-10-23 15:18:06','2021-10-23 15:18:06','2022-10-23 23:18:06'),('0c6a4627ad823a75a1d8e13f1d1c9cfe39f123d4c808673b2e175e7a98dc56d138716e80a108e4d4',2,1,'api','[]',0,'2021-10-22 15:53:57','2021-10-22 15:53:57','2022-10-22 23:53:57'),('0c6f840cc33059e4ac243e2d0c873297df66a41e782dd0a50336602a32e690b1d252a5a439676329',2,1,'api','[]',0,'2021-10-22 15:46:56','2021-10-22 15:46:56','2022-10-22 23:46:56'),('0c9cd7fd2efee298399eb98a26100dd6d1a2c431202bcbeb30af2c37ec6671853d7e4d6eb53a8cc2',1,1,'web','[]',0,'2021-10-31 07:16:53','2021-10-31 07:16:53','2021-10-31 17:16:53'),('0cccd797220d7e06bfceb79e106a1dd7ac927f4d153c78f5c7f140bc13f1f9fc90e818856ee5dc90',1,1,'web','[]',0,'2021-11-06 08:05:16','2021-11-06 08:05:16','2021-11-06 18:05:16'),('0e1fe67c16c982de984ea04e6fb3fb5db71b62da2570d47cb87e1dd4cf837f854364aebd9736373f',1,1,'web','[]',1,'2021-09-08 14:39:23','2021-09-08 14:39:51','2021-09-09 00:39:23'),('0ec3b55137520f1a2097fb8542c8c20ebe7aa2aba7a45b0eea7de035093c2f46e3416c18198455ca',2,1,'api','[]',0,'2021-11-02 13:29:32','2021-11-02 13:29:32','2022-11-02 21:29:32'),('0f6635182d9263240c7ef522812e9c73b3e5f4c20434a5695ca990212178fde468935b43828bb474',1,1,'web','[]',0,'2021-09-28 12:35:10','2021-09-28 12:35:10','2021-09-28 22:35:10'),('0fb53d21e7dc28c484a6bd41d13af3e82a2741d5e83125814f605ca7093fab7ed7007d4014587b23',1,1,'web','[]',0,'2021-10-24 12:55:55','2021-10-24 12:55:56','2021-10-24 22:55:56'),('122c20286db60730941b5b111b50a9f6f05340f50e7d394b625840485856bf1c1ca7a0b58f149e70',2,1,'api','[]',0,'2021-10-23 15:36:10','2021-10-23 15:36:10','2022-10-23 23:36:10'),('124b68261d620c6754032203b94ba4dc20873c88ded95fb8e44190f2aad2c674938c60ce8cd70785',1,1,'web','[]',1,'2021-11-01 13:20:15','2021-11-01 16:25:07','2021-11-01 23:20:15'),('12fb5a49530d2e71466a82620ea72d72eca47766fb230ba92afac760441785eee90e5c7441f8b27f',1,1,'web','[]',1,'2021-10-13 15:23:37','2021-10-13 15:38:46','2021-10-14 01:23:38'),('1300647d0e25c8f1f2423f01eba2741563a4d3d40d531faac0a92a45abcc389562be62bce1356445',1,1,'web','[]',0,'2021-10-12 13:23:06','2021-10-12 13:23:06','2021-10-12 15:23:06'),('14041b9698d69a9d563b9646aaaa746be0ebc3c7ee69e10934fd365c9712863e18f302661a7d98b6',2,1,'api','[]',0,'2021-10-22 15:19:38','2021-10-22 15:19:38','2022-10-22 23:19:38'),('157cd36afe6b62eef38ed75bbc34fc9bcf07e7737e71bc95da9a78ef63686ec41cc879a122f34a54',1,1,'web','[]',1,'2021-10-24 13:55:30','2021-10-24 13:55:33','2021-10-24 23:55:30'),('15d21597de54f50350661b4a4f0899f95e85c3955b2efeae780de454edd93ab2657ae99d7d122026',1,1,'web','[]',0,'2021-10-30 08:28:20','2021-10-30 08:28:20','2021-10-30 18:28:20'),('1630c008490ecc2aa08875ffe63b6e6773bddcbeb6d81ed5fad0d8113ad7c9cfa456cd74d82e183e',2,1,'api','[]',0,'2021-10-22 14:55:54','2021-10-22 14:55:54','2022-10-22 22:55:54'),('16687fc35570fed23327014b4caef403528d5a67baecffda05ce3682f90b6498a509275ca7c857f6',1,1,'web','[]',0,'2021-09-17 09:37:28','2021-09-17 09:37:28','2021-09-17 19:37:28'),('16c7ce0cc4ef5526fd56a8ae481a6dd56181dc15740912603b1f95fa9e97764c41abae79256cc29a',2,1,'api','[]',0,'2021-10-19 15:04:25','2021-10-19 15:04:25','2022-10-19 23:04:25'),('16f2e339085b5967dc9acc43bdabe0e395e0a580044195884c8ec3b837551de4b0d88cee2dd7877f',1,1,'web','[]',0,'2021-09-16 15:12:38','2021-09-16 15:12:39','2021-09-17 01:12:39'),('177730402001843fb45ccc2d6d25beb3fdfda29f97444e73598c0646c7bf8ef52de59ecf5ab0d31c',1,1,'web','[]',1,'2021-10-31 13:18:29','2021-10-31 13:19:13','2021-10-31 23:18:29'),('1854ec22c60b210c128fadf10d60455e91dc697ead97200ee6cafdac7830d4209d50812861ee8a72',2,1,'api','[]',0,'2021-10-22 15:28:47','2021-10-22 15:28:47','2022-10-22 23:28:47'),('18a916a667482938249647760ad1f944a594a79abd959124d2a741711d9969269d7ec18e30940b05',2,1,'api','[]',0,'2021-11-02 13:34:35','2021-11-02 13:34:35','2022-11-02 21:34:35'),('190d5fba717cbde1aac6646c72a556771b847672d61f4c71999b2f6ff99464501704c0c5f8957831',2,1,'api','[]',0,'2021-10-22 15:44:09','2021-10-22 15:44:09','2022-10-22 23:44:09'),('19419fc9ac6fb527b12b0496f239b9ac5653a2f6adb5c97000eae939fd357010dc6419924e610bd6',3,1,'api','[]',0,'2021-10-27 14:51:56','2021-10-27 14:51:56','2022-10-27 22:51:56'),('19ab7d20a5188c32da599cc6b4b08c3a9c10344a369e09fc5bfdb846fbb0c3592461df4f9e2b6e83',2,1,'api','[]',0,'2021-10-22 16:43:00','2021-10-22 16:43:00','2022-10-23 00:43:00'),('1b114d5170fe3d9abbc6cd8ebd620c722e2b2cc75c1502cc21b047528b98ddc54a4334424ab3d764',2,1,'api','[]',0,'2021-10-19 15:08:05','2021-10-19 15:08:05','2022-10-19 23:08:05'),('1c2aebf1f71f3560b70df1f8028fbe5b07fabaa4a07a66299b2dd53e7bea7a8fce4ee99137476f78',2,1,'api','[]',0,'2021-10-22 15:28:09','2021-10-22 15:28:09','2022-10-22 23:28:09'),('1d3a895e6d111eeeaf264f64529a44e55cc07aa78d8862578d2d6b1d0db99a7e3f09efaf923973e0',1,1,'api','[]',0,'2021-10-19 15:02:23','2021-10-19 15:02:23','2022-10-19 23:02:23'),('1ef3a529c346441b368520d7c8a56d3eb0af99c22ec4a1aab45306d3e274ab7bd2a990cf7a295e57',1,1,'web','[]',1,'2021-09-09 09:30:52','2021-09-09 09:34:14','2021-09-09 19:30:53'),('1f1dbda287cac52bc4bcf090942405198e011764c513e15c07db00083938998934753ed34878c9f7',6,1,'web','[]',1,'2021-09-08 14:43:40','2021-09-08 14:44:27','2021-09-09 00:43:40'),('204701a3514c7840b2576a62a15f00cf3d68e9ca111dd7c7987e612434fc7e72b7ca7135681ac320',3,1,'api','[]',0,'2021-10-27 14:54:47','2021-10-27 14:54:47','2022-10-27 22:54:47'),('212aa580e74247356500629e2583c51d2761f24b7c2621e0c06f40232b6e4b2c4c9e631cb2f10d30',1,1,'web','[]',1,'2021-09-16 15:08:24','2021-09-16 15:08:42','2021-09-17 01:08:25'),('2280a37fd08ab0b42f9e6e7f071c359932c4a149e06753b179d2a468a79bb8dca8d2d6c73ab841df',2,1,'api','[]',0,'2021-10-22 15:09:36','2021-10-22 15:09:36','2022-10-22 23:09:36'),('230497ddac557c24f18bf0bd32910076758e465e58689ce9259efb1a06a7c75fa009c272b5aa7e27',2,1,'api','[]',0,'2021-10-23 07:11:34','2021-10-23 07:11:34','2022-10-23 15:11:34'),('235e5b19dddc71c75c5f9b6356e8868bd9a6c83fe3a0a4b178c3ba79c984d1d4fbedb882f4082f60',2,1,'api','[]',0,'2021-10-22 15:25:41','2021-10-22 15:25:41','2022-10-22 23:25:41'),('24cbea1037588d657377ddd10cc3401673887b750bd33552bd25d2fa2a2a7a5b67302d5e6811f55e',2,1,'api','[]',0,'2021-10-22 15:53:22','2021-10-22 15:53:22','2022-10-22 23:53:22'),('26e7619fd88048364e403e1d5c64d3e30dd9d979d97e23b239b8227ef0a37cc1d6df14cd0d4b068e',1,1,'web','[]',0,'2021-10-06 13:36:11','2021-10-06 13:36:11','2021-10-06 23:36:11'),('27e0a3a7bcf71e355a4778765398dc9177c3e1c49f1208648eeb7f57bc228e7ee8623c88cd86d145',2,1,'api','[]',0,'2021-10-19 15:01:23','2021-10-19 15:01:23','2022-10-19 23:01:23'),('2996d2c18a7f1f0b679163c40cc18b4266b3572c4b5a87a5e80ac3e94678729bdf21cc4ba3034d51',1,1,'web','[]',1,'2021-09-29 13:32:12','2021-09-29 13:39:14','2021-09-29 23:32:13'),('2b7903c48f63efe49a09fd064c8d22da64a4357531119b988e6e52e00e2c886e8f593e9942e2f9b8',2,1,'api','[]',0,'2021-10-21 16:29:55','2021-10-21 16:29:55','2022-10-22 00:29:55'),('2bc585c0cd8c80b8bf988c1a586ec1412e989073290c15add301f4b7a8f997d7204fc93ed6f8edd6',2,1,'api','[]',0,'2021-10-21 13:20:45','2021-10-21 13:20:45','2022-10-21 21:20:45'),('2c9dd06edeb6d47d94724f91f90a6b0157b5d758b5ba86da2443634f951fb5b6b8c5790ca7dc206d',1,1,'web','[]',0,'2021-09-21 15:08:57','2021-09-21 15:08:57','2021-09-22 01:08:57'),('2d0df6d3e9db1c6dcc8546b4886b7d7f7be01460a4e3882c8c050fb2d8db312cb05d3d3714609ea5',1,1,'web','[]',1,'2021-09-11 14:58:24','2021-09-11 15:00:27','2021-09-12 00:58:24'),('2da5f751e49fe494ddfa11ffe684bb2d3fb06d7a69d73fea50334cafb377724542368e5747db8261',1,1,'web','[]',0,'2021-09-12 09:19:16','2021-09-12 09:19:16','2021-09-12 19:19:16'),('32d076cdc7797ea66a0478a655f2f3a9e1fab2612e1c874f1bd4d15240e09685ce28f4821b49ed0a',1,1,'web','[]',0,'2021-09-23 12:32:40','2021-09-23 12:32:40','2021-09-23 22:32:40'),('3368c729f85a58098c1fcd30454108e003c1b381a7adad03b2a2fc274440e734fac860835b744018',1,1,'web','[]',1,'2021-10-13 13:14:16','2021-10-13 15:15:07','2021-10-13 15:14:16'),('353cc442bee7a88e491a7d4296c0e17f8bc52e7ae169be75bf38d88e82843b1c7a5f9549dbb96876',1,1,'web','[]',0,'2021-10-10 11:00:21','2021-10-10 11:00:21','2021-10-10 21:00:21'),('355fdbb5da54460ee5b4a169cdf3f1e62860cdb78c963ab20c20ce4f3e3f872bafa18c26a6e08177',1,1,'web','[]',0,'2021-11-01 16:25:12','2021-11-01 16:25:12','2021-11-02 02:25:12'),('37b30a35fbf9812434ac18b1457387c97bd84ec4876cc2edcffb3389f460132e425b7fad08c66d20',6,1,'web','[]',1,'2021-09-08 14:39:57','2021-09-08 14:40:31','2021-09-09 00:39:57'),('37e33c6873259c8f704bdb1b344baba423e89bde22d496fb4e37f7a48079e20ea00cbc052de3329f',1,1,'web','[]',0,'2021-10-13 15:03:38','2021-10-13 15:03:38','2021-10-14 01:03:38'),('38101ea2a8e547a83e0b035fdd3ed45a91072f89c55a13cb536ee9615a1406fd9d0e8b01eae21637',1,1,'web','[]',0,'2021-10-09 08:22:50','2021-10-09 08:22:50','2021-10-09 18:22:50'),('3853238b959e1a42987ae6a4d7172f19ca0a3957165001af959d159b520504760e96c4b2e8c3ce95',2,1,'api','[]',0,'2021-10-19 14:59:33','2021-10-19 14:59:33','2022-10-19 22:59:33'),('389fd80f8ee0a51d743712b887a864e8077e320e4db9ae922667be9c325474b89a965e6f08417af1',2,1,'api','[]',0,'2021-10-22 14:05:09','2021-10-22 14:05:09','2022-10-22 22:05:09'),('39dee9e810ae4535c0018dfe484f0a62f834c279bd120cfa0ea3fbbb06cb7b854ac9cd2173f49aba',1,1,'web','[]',0,'2021-10-13 13:06:17','2021-10-13 13:06:18','2021-10-13 15:06:18'),('39f3f6216d2d02eec63980cce46bc2c454e84d8bc877b7ce733d5aefb500b3b932b66491279d2013',1,1,'web','[]',0,'2021-11-07 03:03:25','2021-11-07 03:03:25','2021-11-07 13:03:25'),('3a8b78f1ded48dec925a756a44f3e0b993c518aec5a8736414674848203a4028d79fdc0ba4b20f74',1,1,'web','[]',1,'2021-10-06 13:39:02','2021-10-06 13:40:09','2021-10-06 23:39:02'),('3b92b464f479300d53874e3107fd3a6055a336690c23409f394196e6a2065b451038f2e5f1bee457',1,1,'web','[]',0,'2021-09-12 09:19:24','2021-09-12 09:19:24','2021-09-12 19:19:24'),('3cb6d20d59762fc0a0f63a60957203b731c78969ff899a6fe692de09b2594e10e9ef69d6b9738dd8',1,1,'web','[]',0,'2021-09-16 16:02:46','2021-09-16 16:02:47','2021-09-17 02:02:47'),('3f7ca96f18e9aae539782611d8963c761447ef73df30a0c037407fb664e1ca0aeccee3840b3daf55',2,1,'api','[]',0,'2021-10-23 15:31:32','2021-10-23 15:31:32','2022-10-23 23:31:32'),('3fb3f86c63a250448ad84cdf92d2c3483c328b881b79fae93f33dff71d4aa5e6562e053785396369',1,1,'web','[]',0,'2021-10-31 13:15:20','2021-10-31 13:15:20','2021-10-31 23:15:20'),('407f12f62b13e3cc947410b07bdbfec8f701db8c191d0f77ec0847162a623027a038936dfeb30cea',1,1,'web','[]',1,'2021-09-22 13:15:09','2021-09-22 15:56:01','2021-09-22 23:15:09'),('408aa9da85b390382c8be46fdd53482288636d98083fe94aafd4defa5e97551bb4fd459bc80c2a27',2,1,'api','[]',0,'2021-11-04 14:34:04','2021-11-04 14:34:04','2022-11-04 22:34:04'),('4398267a9c616dbac8ef6ed03005b6039cf691c8a622f40bc06ac3eeb96159b86790692827f3f4c6',1,1,'web','[]',1,'2021-09-25 06:40:27','2021-09-25 07:34:18','2021-09-25 16:40:28'),('445df914f4000f8f8e19edab8a230ea681d0b96b627fc4e52965c67d678f2e995c0fcd973ca78e29',2,1,'api','[]',0,'2021-10-22 14:16:57','2021-10-22 14:16:57','2022-10-22 22:16:57'),('45215b7108fbb1a4f34ba69f78ad4146dd2b7da88c55d68992b5dd49afe745760151b3bdc0e02128',3,1,'api','[]',0,'2021-10-27 14:46:03','2021-10-27 14:46:03','2022-10-27 22:46:03'),('452d31205ade29ea952ada73a42c4cf62e8d6ba01b37cf02a60854df7bd5f4664eec3ae1649debc1',1,1,'web','[]',1,'2021-10-13 15:23:15','2021-10-13 15:23:24','2021-10-14 01:23:15'),('456d39885c7e517fc06ead6e9a285108b64f787fdd8b4f3d1adc3d982a27754e908228aba2a989ae',2,1,'api','[]',0,'2021-10-19 15:01:09','2021-10-19 15:01:09','2022-10-19 23:01:09'),('464d115d6cf1362e4008e703dedb17c254e3e36a7272a07d1e011a35867e519d6b02c9875d1e20e9',2,1,'api','[]',0,'2021-10-23 15:26:17','2021-10-23 15:26:17','2022-10-23 23:26:17'),('46c775fa16313396bc4bb1f0a6c1e48824f071a8e7abef1b549cdcb2257c63da6dcf8204321d76e1',2,1,'api','[]',0,'2021-10-22 15:06:28','2021-10-22 15:06:28','2022-10-22 23:06:28'),('48a54642c79591042550fa8c29d561294877ec27d4b9b5aeeb050f80cb0ceaaf6f0fbc63ddd9465c',2,1,'api','[]',0,'2021-10-22 16:36:05','2021-10-22 16:36:05','2022-10-23 00:36:05'),('492d714dbaba1dca5a674edac0a4ddf78bf851edc0052460c103b069cb6517a2239dc1631bb9a73f',2,1,'api','[]',0,'2021-10-21 16:32:08','2021-10-21 16:32:08','2022-10-22 00:32:08'),('4aad05e8fb7bcec0963d3c9a16e3b2f3d6502c67326b0eac4440ab1b99469b33400c70a7c9bb04af',1,1,'web','[]',1,'2021-10-31 06:52:13','2021-10-31 07:16:37','2021-10-31 16:52:13'),('4ac60479342dd9e1645245b8ee5b2bde235efae0966ace18da06de47939bbf13cf4994201304bcb0',1,1,'web','[]',1,'2021-09-09 08:30:14','2021-10-13 16:19:41','2021-09-09 18:30:14'),('4ad35667870604a7a24ed4c027d75c7a582bfc328f6046d6eae9f7d988774aecc5dc557f95994983',2,1,'api','[]',0,'2021-10-21 13:51:12','2021-10-21 13:51:12','2022-10-21 21:51:12'),('4b1b563e064d18deba580d90c01e6077cbd7ecce4161066b7de44368f55761136f15aa0d1239dfd2',1,1,'web','[]',0,'2021-10-31 07:40:43','2021-10-31 07:40:43','2021-10-31 17:40:43'),('4c2aeca3a8a5da6bf1376c1b10cdb4548bd007d427bcb8a4689507fde5b18f07e3dca0036d62b9ec',1,1,'web','[]',0,'2021-09-09 09:34:54','2021-09-09 09:34:54','2021-09-09 19:34:54'),('4e65fb192ecc1cfa1d29c8271b2e287768f4bdcdd08382104a9543fad51c7b40ade6aafac60ac1fd',1,1,'web','[]',0,'2021-09-16 15:11:45','2021-09-16 15:11:45','2021-09-17 01:11:45'),('4f533410b054f4dc444c10fef264fef2c060186e70c98b606051b128338a83040c4d7bc21d32afd8',1,1,'web','[]',0,'2021-10-13 16:19:34','2021-10-13 16:19:34','2021-10-14 02:19:34'),('4ff53ce0fe973e28bdfdb9d75761799e4a7524d88de52ebd7707f49891882dee7db16a786a6d297a',2,1,'api','[]',0,'2021-10-19 13:51:49','2021-10-19 13:51:49','2022-10-19 21:51:49'),('5405db99efb288746683577b7ec49b3173a4fad9bf270bd67d6fc52267930cb2047904639dbc5987',2,1,'api','[]',0,'2021-11-05 14:13:27','2021-11-05 14:13:27','2022-11-05 22:13:27'),('547d7bf67bd0ea6a3bd9c5a174e5b7857196accc469c15fa9e224ec048378916b409cf7c7db2df62',1,1,'web','[]',1,'2021-09-15 06:05:37','2021-09-15 08:07:08','2021-09-15 16:05:37'),('5506f0b302fd5b7c2fd58a33d366e52672816016bb615b821b10f3981b2c7d83759d21ed1d684e87',2,1,'api','[]',0,'2021-10-22 16:44:02','2021-10-22 16:44:02','2022-10-23 00:44:02'),('55d2011cdee2ee53a54fa1a11e1996803e75dab21929b681196e60f455cf443a2ed04c0176c3608f',1,1,'web','[]',1,'2021-09-25 16:38:27','2021-09-25 16:38:54','2021-09-26 02:38:27'),('573d2eafb36f06d0baafb27308becccdae1348abfc4484c9c96d252bd49cb057e3307feb81b220fd',1,1,'web','[]',1,'2021-11-07 02:48:07','2021-11-07 02:49:01','2021-11-07 12:48:08'),('57413db417f859d16ba4591e3356e4de53c340505acbb3036ed2da4cb55bdc129722763b9751f96e',2,1,'api','[]',0,'2021-10-23 07:09:22','2021-10-23 07:09:22','2022-10-23 15:09:22'),('5771a8bb75830a9c6368e0ac22da716e7ede1cf70632644fd3f6ba92e4394b859b71e8b8d8feb6ef',1,1,'web','[]',1,'2021-11-07 02:49:25','2021-11-07 02:51:13','2021-11-07 12:49:25'),('59c602044583cada714ede36fa411ec8ee842d3c7fa98ec04b51d32be559a4b8c3d599b8943db5ae',1,1,'api','[]',0,'2021-10-19 13:29:19','2021-10-19 13:29:19','2022-10-19 21:29:19'),('5ae1a1f5644a643a6c041be928873770e0a7732cfb0d02f0854c10a53bdaa79ab925e7778536ae06',1,1,'web','[]',1,'2021-10-13 08:38:14','2021-10-13 08:57:45','2021-10-13 10:38:14'),('5b30e05aa6de32d7668254ce2cd86e4dd0979d93e54f8cb1fe1d64cf694443025c90ad2458f07d53',1,1,'web','[]',0,'2021-10-07 13:28:16','2021-10-07 13:28:16','2021-10-07 23:28:16'),('5ba2c5825d048e217b67c69ec34e123d620ab78978e30e4a504b950b407ecbaa565775ed34b2f8ef',1,1,'web','[]',1,'2021-09-22 15:56:06','2021-09-22 15:56:31','2021-09-23 01:56:06'),('5c3e04653e8c3df8ed0ade81094106cd1ca7e7bc195140a117b912053d797dcba7a0d99964d0cd87',1,1,'web','[]',0,'2021-10-01 13:43:33','2021-10-01 13:43:33','2021-10-01 23:43:33'),('5cca3c1bdb3bebbcccadc36546510445fa20ccaefecdbaa8f611cb643287b94a03aa55abce0ee023',1,1,'web','[]',0,'2021-10-30 16:21:25','2021-10-30 16:21:26','2021-10-31 02:21:26'),('5ccfea1f30bebf356d0155d50d632e909c794431a9c6da007980fa8cd036e64a2635222c366566eb',2,1,'api','[]',0,'2021-10-22 14:20:48','2021-10-22 14:20:48','2022-10-22 22:20:48'),('5da3bc287b4002d266a6b9bcacba1bb0061f616ba983dad03ae2defa34592a8e9ab124c48f5c892f',1,1,'web','[]',0,'2021-10-13 16:20:16','2021-10-13 16:20:16','2021-10-14 02:20:16'),('5ddc8795c34056297894ab14b18aa58d190e69a55c2c29271b7ad4e3066ab110768d37bcd2834e3e',1,1,'web','[]',1,'2021-09-08 14:44:37','2021-09-08 14:44:52','2021-09-09 00:44:37'),('5e2af4d9a776ad2056e4220121aeb97f3c53f0dc4b0affa8587bf58c15f528e764019ac715ab078c',1,1,'web','[]',0,'2021-09-25 16:38:57','2021-09-25 16:38:57','2021-09-26 02:38:57'),('5ea1eeb48b2e1a3643adb55822ee3eec42efa414917230a0c54f6dd2236d624678546d9bf8ce380f',2,1,'api','[]',0,'2021-10-23 14:39:13','2021-10-23 14:39:13','2022-10-23 22:39:13'),('5eabe0ccd901a2c1f04ee8aa23555b106816af2e1b731abf26b7a0a1e7605dc2a2e96ac2941c8f73',2,1,'api','[]',0,'2021-10-23 07:14:06','2021-10-23 07:14:06','2022-10-23 15:14:06'),('5f63519d7e5c14788ed32fe6ed4628ca9004fdf453c4c8682f9e6f0ecf78207c4ebf525f4e5e1093',2,1,'api','[]',0,'2021-10-21 14:57:49','2021-10-21 14:57:49','2022-10-21 22:57:49'),('5f9eb83f75e81d71ae984773ac3201d50baf332d333224144ac029ebed40550b212849193ce594e0',2,1,'api','[]',0,'2021-10-23 06:47:08','2021-10-23 06:47:08','2022-10-23 14:47:08'),('6018f0ce99e92a0a85a48a97dbf11b83053a3a290a65412c830cbba00cf6ac1cd12c754efc20cbac',2,1,'api','[]',0,'2021-10-23 15:33:50','2021-10-23 15:33:50','2022-10-23 23:33:50'),('607600f7052a64eda6e320e732f5146a349f34678be82815170a2a8554fa45bccfe2396909489619',1,1,'web','[]',0,'2021-10-09 14:37:09','2021-10-09 14:37:09','2021-10-10 00:37:09'),('61b3ef66b246d75f674e80c06954fc32351622fb169b20cdb2995725584a239d78c8c32366423d4a',1,1,'web','[]',1,'2021-10-13 16:19:03','2021-10-13 16:19:10','2021-10-14 02:19:03'),('62db6bda72a0ed6d8d2e01ae55bea6580456221909bcca5fe74453ef8cd137d9a1480d9b4b9382ac',1,1,'web','[]',0,'2021-09-25 07:34:41','2021-09-25 07:34:41','2021-09-25 17:34:41'),('63a1ac3e74539213fbb69015e963e8d9c5f868b2016f226f14631607c32309062fe734a9cebfe383',3,1,'api','[]',0,'2021-10-28 13:57:09','2021-10-28 13:57:09','2022-10-28 21:57:09'),('6408d6828ebb87e2442cc1c48b2bfe5be0c587550ceca34ede8d142f865351d44cbd45248b96c356',3,1,'api','[]',0,'2021-10-27 15:01:30','2021-10-27 15:01:30','2022-10-27 23:01:30'),('642992489e67d7feaaf1423806e5315771df1ce9f35086a5fcb55fe42b8423331a116e0d6dedbf8a',2,1,'api','[]',0,'2021-10-21 16:38:16','2021-10-21 16:38:16','2022-10-22 00:38:16'),('65c8a384c021ae1874d8124752926ddbaf9f6b12697a8f56ca9ccef2f853707dfe7c268499fdacdc',1,1,'web','[]',1,'2021-11-07 02:55:15','2021-11-07 03:01:47','2021-11-07 12:55:16'),('65d6bc4052063a2cec5de50939fa30bbce4ba41b168e1a470affe6ef251d76d9e9fb4d39ab9cb48f',2,1,'api','[]',0,'2021-11-02 13:36:07','2021-11-02 13:36:07','2022-11-02 21:36:07'),('6671091c5f8bf2b5842b680ab7584a3d0a37aed9bb6601eb9e47c1ec591c283e0c3ff6c963a3b5e3',1,1,'web','[]',1,'2021-10-24 13:55:10','2021-10-24 13:55:12','2021-10-24 23:55:10'),('668778df68372443987c34b747d8b96b23d5c5db1ba8b5d50db7738a7cc7db173844d4ff3b7de7b4',1,1,'web','[]',0,'2021-10-04 13:46:02','2021-10-04 13:46:03','2021-10-04 23:46:03'),('67281a9ba19c6e7bf71dcdae530953582ff9683270ba3c455a85cb0022615fbcde18b542a358ceaa',2,1,'api','[]',0,'2021-11-06 15:38:40','2021-11-06 15:38:40','2022-11-06 23:38:40'),('67a4893974f6d6b55f8138220b7503af0af3466cc9d7e4748fb6523a33b7eb0c2e9ab66439038586',1,1,'web','[]',0,'2021-10-27 14:54:24','2021-10-27 14:54:24','2021-10-28 00:54:24'),('6823638b3223a190b3b17747b80b16ec1f66e894aaa0467d79cfbb55d1ad2e8e369b18c3faa7a7c4',2,1,'api','[]',0,'2021-10-22 15:16:40','2021-10-22 15:16:40','2022-10-22 23:16:40'),('69be433b8524f1b518032206ff07e60ea58daca5ed453b7508de6ce3a55c89a1880fc49ed59d2698',6,1,'web','[]',1,'2021-09-08 14:44:56','2021-09-08 14:45:19','2021-09-09 00:44:56'),('6b07eb03d4531734225d8326bfdf7fdc60a2c1a01675a2310eda24713b3a291698ef15118a14d639',2,1,'api','[]',0,'2021-10-22 16:42:37','2021-10-22 16:42:37','2022-10-23 00:42:37'),('6bde3f8c3cbd7c40ba7b587a07618e8f51a5d81cb524216f6c423cc0f6b030aff41912fd418d848b',1,1,'web','[]',0,'2021-10-30 15:07:56','2021-10-30 15:07:56','2021-10-31 01:07:56'),('6d061f66b0e6c10966dfb87b121607d8dafda0a5039b97100be8f92f19610785dde82ac022166b1e',1,1,'api','[]',0,'2021-10-27 15:02:28','2021-10-27 15:02:28','2022-10-27 23:02:28'),('6dc50056d6871abbd4c55b4c9d226f6fc9746a3650661c1468824f4369030caf1984c280d294463c',1,1,'web','[]',0,'2021-11-06 06:03:38','2021-11-06 06:03:38','2021-11-06 16:03:38'),('6df9c605e46a3930cd9db6f4348a562276003b3a7162309057e33e57e3aaea4879517ae944d9b035',1,1,'api','[]',0,'2021-10-19 15:04:59','2021-10-19 15:04:59','2022-10-19 23:04:59'),('6f530652e0bef99334e00f55431d1ddd6d0234bbebcfcd99f9e995391b9ba87564bf753750a036a6',2,1,'api','[]',0,'2021-11-02 13:39:08','2021-11-02 13:39:08','2022-11-02 21:39:08'),('6fcaf6d8f2798688028d05ec97d6db035bc54f31e550dad7099cfd63e5d94c457c33add16def69e9',2,1,'api','[]',0,'2021-10-23 07:43:09','2021-10-23 07:43:09','2022-10-23 15:43:09'),('706aafe00f41300100d04cb83eee835fb35cb7404a2e64a59599485396f5072bcf450cfee7b64f28',2,1,'api','[]',0,'2021-10-19 15:05:40','2021-10-19 15:05:40','2022-10-19 23:05:40'),('714c25712ac6e0d14e66eb1bf1f2225e832bc165e46aa3033d7e0509abb06e217b458621f7fff118',1,1,'web','[]',0,'2021-09-24 09:22:07','2021-09-24 09:22:08','2021-09-24 19:22:08'),('7168a79bd4ceffccbebd76e3072f62589c39e7e8a1d72bbc2a34da6b340c3d24cd24c498c9e43e59',2,1,'api','[]',0,'2021-10-23 14:55:47','2021-10-23 14:55:47','2022-10-23 22:55:47'),('71e17b0dc3256ce5f238557bd5c77b07a7fb140467b7636bb77d306ed1b800f7d530212f7310b581',2,1,'api','[]',0,'2021-10-22 15:36:01','2021-10-22 15:36:01','2022-10-22 23:36:01'),('72bf6ddb30dc6316bf75091a830d0cd4525b72521c85bb4275a287e7190dce5c890604267fe11ec6',2,1,'api','[]',0,'2021-10-23 07:42:22','2021-10-23 07:42:22','2022-10-23 15:42:22'),('72e0a16fcaf777124baf313ef1a30d5e2012e19d0affefd717f959d6bb9abfe182b0b47365e4f106',3,1,'api','[]',0,'2021-10-28 13:10:58','2021-10-28 13:10:58','2022-10-28 21:10:58'),('7412849a81a32dafee639341af3c3d6eb64ebdb0bd88ec93e70d79b985260977fe81780ce72f1970',2,1,'api','[]',0,'2021-10-22 15:48:06','2021-10-22 15:48:06','2022-10-22 23:48:06'),('748981b6dd2236914ce9147fb8f05641873ad957be5c13878f50827e6ba23cf15d8347d2688547a0',2,1,'api','[]',0,'2021-10-19 14:59:56','2021-10-19 14:59:56','2022-10-19 22:59:56'),('7530d8b846de257950b3db768882b7984edde5aa8226ffccbad0d5e3c260d446337f8ac81203fbb2',1,1,'api','[]',0,'2021-10-19 13:29:35','2021-10-19 13:29:35','2022-10-19 21:29:35'),('75c73282110b2ed4b9b767669745a5b6e6b07fd22cbcab255a93124a6ff3d08ec4c4a23d52befa86',1,1,'web','[]',0,'2021-10-13 08:58:17','2021-10-13 08:58:17','2021-10-13 10:58:17'),('75d52bfaf6ae93429a6d80f4d4f10132eafb7721693af9f031315fe80f9ead3fbc4b88445fa3b903',1,1,'web','[]',0,'2021-10-13 18:17:47','2021-10-13 18:17:48','2021-10-13 20:17:48'),('76fd5306bbb0c2b67fd5d505d064900381127f94c25c8cb6292dc0d0fbd7d39ba40057ecd0474131',1,1,'web','[]',1,'2021-10-24 12:59:14','2021-10-24 13:20:13','2021-10-24 22:59:14'),('77d3689535db4482aca4c6a1c3f1ec93f394b7bceac6c947e52bb76e847f159c0d2a750223e06b56',1,1,'web','[]',1,'2021-09-27 12:39:35','2021-09-27 14:40:26','2021-09-27 22:39:35'),('7c2f2f39ffc82b369b617a4207b65feccb699cec7214039053f3f2fc39f410cbc151d54bc9bef7f0',1,1,'web','[]',1,'2021-10-24 13:56:40','2021-10-24 13:57:13','2021-10-24 23:56:40'),('7cec5b29982c7a468e89ea32ec9b091c7a12a697c12a19c4d433461869979aa8c7407776b263dc1e',1,1,'web','[]',0,'2021-10-31 07:16:40','2021-10-31 07:16:40','2021-10-31 17:16:40'),('7da288a93a01754c3ffe9ab1371224ea07cba47e214bdf89aaa6136fa9ecb3b501902e6b9a4f2446',1,1,'web','[]',1,'2021-10-10 08:57:55','2021-10-10 11:00:17','2021-10-10 18:57:56'),('7da98536470fc357a0e43f1d546c33ba814cc2eb5a2587afaba956feb61fab177685251e4c0749c1',6,1,'web','[]',1,'2021-09-11 14:48:47','2021-09-11 14:48:53','2021-09-12 00:48:48'),('7ddc0ed7d2b5c707640125d94dbc6c88b4255c98f49719b6952e41c72c4d1dd2060e406f2f24590d',1,1,'web','[]',0,'2021-09-14 14:26:02','2021-09-14 14:26:03','2021-09-15 00:26:03'),('7e23673c0ded50f79ca18e5a598d2fae5441d1c1e28ec39251af15b2b36ba2fbcb3f7a95e1c24559',1,1,'web','[]',0,'2021-09-17 08:07:30','2021-09-17 08:07:30','2021-09-17 18:07:30'),('7e236ab7d655baae506526806f1b9900e6168db7aeec7d932993a7c9bc92aa058492aa8757911ff4',1,1,'api','[]',0,'2021-10-19 13:29:29','2021-10-19 13:29:29','2022-10-19 21:29:29'),('7e6cf2a6be9b75f8321253d81dea5654ead3e59d9d530a64eb71aa32170cb6af54f0c8a9f38da802',1,1,'web','[]',1,'2021-10-24 13:56:19','2021-10-24 13:56:35','2021-10-24 23:56:19'),('802b9a205bfc79a35b83e079fc4c701fbc1ba643de03b464c790084593ed3e0cfd98f8e3590b0b3a',2,1,'api','[]',0,'2021-10-22 13:36:28','2021-10-22 13:36:28','2022-10-22 21:36:28'),('811971d43c272ae8d6c0e95e9614e2e292eb5337c228025b97d177cfb53489df7fa2deb6369a743f',2,1,'api','[]',0,'2021-10-22 15:15:34','2021-10-22 15:15:34','2022-10-22 23:15:34'),('84f1b14a1ce05b437b452bf492789715aa425dfbee1cfe383be3ee7c734630918918ded618f04312',2,1,'api','[]',0,'2021-10-22 15:10:23','2021-10-22 15:10:23','2022-10-22 23:10:23'),('8533fb848e04c415c46339e807294feb381ad3928662a2e042f54926c76aae39cebd39e27abdf0b2',2,1,'api','[]',0,'2021-10-23 07:28:56','2021-10-23 07:28:56','2022-10-23 15:28:56'),('85af61d60686cebcab45d66d1784635cd06d1f48de0e74c4696dc241d6ad6196411f4ea511c5c3e9',1,1,'web','[]',1,'2021-09-16 15:11:30','2021-09-16 15:11:42','2021-09-17 01:11:31'),('87d95dbd06fbc157b1d84f0ab88a7663e2157d523b5523ee2f177a23c463f3f9cf89bb52b209b63e',2,1,'api','[]',0,'2021-11-07 06:09:37','2021-11-07 06:09:37','2022-11-07 14:09:37'),('88a8e2d68b3655220cb48fdd97af95d9de3cdcd728c9581e64bcb597e3c4f405a404fccf54b9b9db',1,1,'web','[]',1,'2021-09-15 03:57:48','2021-09-15 06:05:32','2021-09-15 13:57:48'),('88ddf85d6484d5b4f86cf493d23e78c496ee67f25ea6f439d5851ade4726268b6b603d976d68b9bd',2,1,'api','[]',0,'2021-10-22 15:14:41','2021-10-22 15:14:41','2022-10-22 23:14:41'),('88ec5b7f8943a770a5976e9db42424de0fddaca1dd5cc28a08ee8220b270d4464d4d8760487d9f5d',2,1,'api','[]',0,'2021-10-22 14:54:05','2021-10-22 14:54:05','2022-10-22 22:54:05'),('8a9d54a9a1ed08a28e50c8f1714b6d5fa7a6ef07f079d14ae67bd78f23dc498fa6365e51673b5f25',1,1,'web','[]',0,'2021-10-13 17:59:34','2021-10-13 17:59:34','2021-10-13 19:59:34'),('8b2ed19d277c98cdffcbe2638c289b108ef913ffd592703906134a736000fb017af5996dbfefdcbd',2,1,'api','[]',0,'2021-10-21 16:16:50','2021-10-21 16:16:50','2022-10-22 00:16:50'),('8b52cf160309f69a43cbfa18374bdba3f6cd2060d665d15212c7330a1924ebd3d11c237e2f54bcb2',2,1,'api','[]',0,'2021-10-21 14:37:50','2021-10-21 14:37:50','2022-10-21 22:37:50'),('8cd5d8ea5798558cf01fb5cf345bc94632b2811edb6902315f4f61e4605b1d70cc2147a65a69b5e7',2,1,'api','[]',0,'2021-10-22 14:52:41','2021-10-22 14:52:41','2022-10-22 22:52:41'),('8cff10017fd983d304e4e2e4e03492852f631f568deee3631f63c784e859647c805efed10da4358c',1,1,'api','[]',0,'2021-10-19 15:03:42','2021-10-19 15:03:42','2022-10-19 23:03:42'),('8d33286516a932788bd8b5fdead8e20c9d9fe7129062b32349d3dddca533f3a4f40600eae4e273a0',1,1,'web','[]',0,'2021-10-13 15:20:12','2021-10-13 15:20:13','2021-10-14 01:20:13'),('8e3c2c264859f48930a1e5cb9e2629e4f8ae3caabfd914181c9ccb88446df190d8fa13fe86591dd9',2,1,'api','[]',0,'2021-10-22 14:57:54','2021-10-22 14:57:54','2022-10-22 22:57:54'),('8ebcd7b8da69e5c6c2f416799a8710467ccd7c698f0104020bbad846902e83be2374f644d7c35f57',6,1,'web','[]',1,'2021-09-08 14:42:41','2021-09-08 14:43:34','2021-09-09 00:42:41'),('905e9fe2644745aeddf61bb35b117d463a34e1e7d75726e9f786a0293cab3e5a0f011459a7abe329',2,1,'api','[]',0,'2021-10-23 08:17:43','2021-10-23 08:17:43','2022-10-23 16:17:43'),('921c10f5a6a563b1cc57b7a66677699be7ca655f45e2114cd586b71d35da379fe43189a9402af139',3,1,'api','[]',0,'2021-10-28 13:22:48','2021-10-28 13:22:48','2022-10-28 21:22:48'),('94fa30968611b5a85e748f571a2ee1ba56658516a404d81bd6ad7099d78a0e9a772b5d735f64e839',2,1,'api','[]',0,'2021-10-22 14:51:39','2021-10-22 14:51:39','2022-10-22 22:51:39'),('9510f673be539f50f41b4cb161ea6416c1959e2881d999a1c1810091efff3b0faa06d5c2c0f87110',1,1,'web','[]',0,'2021-10-07 16:57:35','2021-10-07 16:57:35','2021-10-08 02:57:35'),('9517050486bad4e56924b10b528509111a6d478e16e3df3d1255b09243e845be0a5d6587b49e240d',3,1,'api','[]',0,'2021-10-27 14:59:47','2021-10-27 14:59:47','2022-10-27 22:59:47'),('953c65b51d3e81e7cbed7ed5371876f3f5164728453895120086b4809eec805ab5de17b3bb59035f',2,1,'api','[]',0,'2021-11-02 14:05:37','2021-11-02 14:05:37','2022-11-02 22:05:37'),('95fd05e768e982b6cedd8e85fc22329676df8ad8ab444ca0e08fa2968de5e5e6b8fa7c65f816201b',1,1,'web','[]',0,'2021-10-03 05:26:18','2021-10-03 05:26:18','2021-10-03 15:26:18'),('960a92e4c94947a5c2e7e1127870e47e821f19d419082b2910d635bddcc3337c509b63cc81744b11',2,1,'api','[]',0,'2021-10-22 15:50:59','2021-10-22 15:50:59','2022-10-22 23:50:59'),('9675312b807c6eb4663710548d3d5b99befc050b039eb73c2ca3883105792ed16378fc7621d46031',2,1,'api','[]',0,'2021-10-19 14:42:31','2021-10-19 14:42:31','2022-10-19 22:42:31'),('96a5243a9c4b2738ac13ad8592515b5e85b79615430a703cf320bc4665885a60d5cbe3c3cc97f59f',3,1,'api','[]',0,'2021-10-28 13:24:08','2021-10-28 13:24:08','2022-10-28 21:24:08'),('97d813b904afc01b3c1e590836ce2ed510ecd656eb0e0eec3d6d8628fed4c4c30f7942b848cd79b4',1,1,'web','[]',1,'2021-09-10 08:59:20','2021-09-10 09:37:55','2021-09-10 18:59:20'),('9909993e4fc6052984064333767e21e90286ae082002b4188639747dbb7c83840c6d58edca335354',1,1,'web','[]',0,'2021-10-26 14:11:05','2021-10-26 14:11:05','2021-10-27 00:11:05'),('996e00448c7882df24ca0a551af0e974fb81cf5319c7d8c59d147834bd637242e62dd48d397623d9',1,1,'web','[]',0,'2021-09-17 01:06:00','2021-09-17 01:06:01','2021-09-17 11:06:01'),('9a1d8a0baf7c75df28abf9cffb3800dc4f63cb2295cb3dda85739a19a022b48fa8420045b20471ad',1,1,'web','[]',1,'2021-09-12 13:55:35','2021-09-12 15:56:15','2021-09-12 23:55:35'),('9a2ed9890446a40c7634c5df9013de8ca4b9189af89582ce3ad718ece84852c56cefd852dfa599f2',3,1,'api','[]',0,'2021-10-27 14:40:57','2021-10-27 14:40:57','2022-10-27 22:40:57'),('9bb9de9154a3fd2eadbba26922496bc50c6b9eb0fe8533551bb9a3e50554b84ea1d56285d9183d4b',2,1,'api','[]',0,'2021-10-22 13:29:16','2021-10-22 13:29:16','2022-10-22 21:29:16'),('9c67e33caf57f3a49a3ab5a06c7131767f3b33163418975c488555e6f7cbd0f0e7efaaca074cbbfa',1,1,'web','[]',0,'2021-10-09 06:14:04','2021-10-09 06:14:04','2021-10-09 16:14:04'),('9d087ced33af286be366d8844511b5fda25aa0b843e10cea6c88b322fb658272592c667fee828fbc',1,1,'web','[]',0,'2021-10-06 13:22:49','2021-10-06 13:22:49','2021-10-06 23:22:49'),('9d0debc21fd715730edefcedf878bbedbcf6b9949cdae0ebf0afb338cebd7092729c5fe88a2fc34a',1,1,'web','[]',0,'2021-09-28 13:11:57','2021-09-28 13:11:57','2021-09-28 23:11:57'),('9dbb52b88736446aa83df527a6712e05d017453f1e88943dbf4d1af6a4b205af9d4434deef6c2fd2',1,1,'web','[]',0,'2021-10-13 16:21:46','2021-10-13 16:21:46','2021-10-14 02:21:46'),('9e1986f8269b1156c3ebedb242b67d6669bd745d96a6474315fa4bda0697699c9612d514aeb8847b',1,1,'web','[]',0,'2021-10-24 13:20:18','2021-10-24 13:20:18','2021-10-24 23:20:18'),('9e4819025d7a7af3f5b131854c34ce0fc416c45481b8832cb780aac871982a81cd95e9d728983df6',1,1,'web','[]',0,'2021-09-12 04:00:02','2021-09-12 04:00:02','2021-09-12 14:00:02'),('9f9fa96bff5544290d20a2dda42744d14869b96e99ae3b3a63b61442f47e253f042b9cd9ef9f2edb',1,1,'web','[]',0,'2021-11-07 02:51:56','2021-11-07 02:51:56','2021-11-07 12:51:56'),('a05a59527818510ca12a59e58e36e0e50c83ce17151a82a7144d883a6c3502be798ca45bc5e72311',3,1,'api','[]',0,'2021-10-26 15:31:44','2021-10-26 15:31:44','2022-10-26 23:31:44'),('a0bc5174b443dc9868219f28b5e46a2a92366c83abb652bf0b4e917c3597d005d416adeca82fa383',1,1,'web','[]',0,'2021-09-26 13:03:17','2021-09-26 13:03:17','2021-09-26 23:03:17'),('a19f92ceaba19c9d6d517670c40c57cda6d35bf3942c7b8450a3a8ba96572c36e84af495b254d4b9',1,1,'web','[]',0,'2021-10-24 13:58:31','2021-10-24 13:58:31','2021-10-24 23:58:31'),('a1e3f9e729a6ea6baf7cb9c718b5868112c946cefd4da24e3d7467667cf2503fd19f918df88be38c',1,1,'web','[]',0,'2021-11-07 02:53:54','2021-11-07 02:53:55','2021-11-07 12:53:55'),('a2fc96e8aa03206e3a3cf6a2679118899084470db1216dc8b78bde74d08b8d57d360252acf81d036',2,1,'api','[]',0,'2021-10-22 14:26:20','2021-10-22 14:26:20','2022-10-22 22:26:20'),('a3ff3ddf840bbc85022b2211e27bbc5f8868d874c051105a660107ec4d22c87e47dc420d131b2b01',1,1,'web','[]',0,'2021-09-29 13:39:23','2021-09-29 13:39:23','2021-09-29 23:39:23'),('a61811f9af07317602d380fb2e5110ded8ef8f71e298a809066fad98bc29975557dd1534edcc878b',1,1,'web','[]',0,'2021-10-14 13:29:06','2021-10-14 13:29:06','2021-10-14 23:29:06'),('a78f78c845149f1db3cd2920b0520b65016775f12b66da3796b80fb6f9017b04c1c9908fa9467512',2,1,'api','[]',0,'2021-10-21 16:33:58','2021-10-21 16:33:58','2022-10-22 00:33:58'),('a88f69ac40daca9cf8f86bc25890a5e3cbbe238015dd71a10a966cf70d7cc4ebeae5d665d2eb86c1',2,1,'api','[]',0,'2021-10-22 15:03:41','2021-10-22 15:03:41','2022-10-22 23:03:41'),('a890a3071785ebce02a07ba458fed16366fc0877ab0a4be3c78da5a70025bef74777b722076547a6',1,1,'web','[]',0,'2021-09-29 13:26:32','2021-09-29 13:26:32','2021-09-29 23:26:32'),('a91c9e07b7d9a9c75dbc54d3f0bd46a4193a0918285f86f5414e1cf627ba4b6d13fd5172877d1f9a',1,1,'web','[]',0,'2021-10-12 18:50:03','2021-10-12 18:50:03','2021-10-12 20:50:03'),('a94f3f574eb63799ad41d9388e428a07e8facacec52d3c13f320373eae324d95f8c52cde89ff5c2b',1,1,'web','[]',0,'2021-10-24 13:56:06','2021-10-24 13:56:06','2021-10-24 23:56:06'),('ab0ef8b8ca129498f6551bb03393b1b996364bb8ad5d9906ad2923e6f94c3dcec32e539e841ef7e2',1,1,'web','[]',0,'2021-10-30 14:37:58','2021-10-30 14:37:58','2021-10-31 00:37:58'),('aef1fd9cc93688aa8ed2ef6bd87e4f79d20100ab1a1b8b2ca9145e6902ae42e12fdb733e473c57e9',2,1,'api','[]',0,'2021-10-23 07:42:38','2021-10-23 07:42:38','2022-10-23 15:42:38'),('b08dee864330dbbf4867864cbe7381e9698b7b4ea9a013ae3abf5bb8a63c1c73bb9e5818af5158be',1,1,'web','[]',0,'2021-09-10 08:09:42','2021-09-10 08:09:43','2021-09-10 18:09:43'),('b1df6013367a754de29e0850fe7e3f8faa94ebaba9a89310ed8371dd6b2190d7e034c428fb7d74be',2,1,'api','[]',0,'2021-11-02 12:54:03','2021-11-02 12:54:03','2022-11-02 20:54:03'),('b273e3f6df362f526545e021d64cd52257b64ecb933d8f8e3d075fbd9e7d23af2f3627d58f773abb',2,1,'api','[]',0,'2021-10-20 15:11:35','2021-10-20 15:11:35','2022-10-20 23:11:35'),('b28a1bf15abcfae48f3c9c992b6263d91816578718a796e64b96590cd675159ad11fe28fe231de7f',3,1,'api','[]',0,'2021-10-27 14:50:31','2021-10-27 14:50:31','2022-10-27 22:50:31'),('b2b592842e45efad7ba5888d54065d0161847062424727aa22727f7dacd53a8024fe2e6b730ee09b',1,1,'web','[]',0,'2021-09-11 15:02:24','2021-09-11 15:02:24','2021-09-12 01:02:24'),('b330953be9e602439192dfa1a9be9e3e9adc5f8cff4a66cfc5b3b86d8f4b47ef4da4a7dfbc0fa13e',2,1,'api','[]',0,'2021-10-22 15:01:17','2021-10-22 15:01:17','2022-10-22 23:01:17'),('b47e5aadb6a94b0b71a57d944f9d03df2d8952098f0e9ea6df6fd0ee6e544f60f807902893b494e8',1,1,'web','[]',0,'2021-10-31 13:19:58','2021-10-31 13:19:58','2021-10-31 23:19:58'),('b4bfbcf70877b6fc0de01b0cd3a12314fbe284e91199f3ddd4ed8104605b9955003fb1bb1d2da0cc',3,1,'api','[]',0,'2021-10-27 14:46:48','2021-10-27 14:46:48','2022-10-27 22:46:48'),('b4d85f0438812069d4aef85ea7b59badac4df5cc452100ba0c43e785f290f2f9799b88c177f2f261',1,1,'web','[]',0,'2021-10-02 03:50:22','2021-10-02 03:50:22','2021-10-02 13:50:22'),('b4e6a8fdd6a502c72af9eea21f0367e7a63469df3743bd967fa6aea232e6893dfb996bd2e2c9f93e',1,1,'web','[]',0,'2021-10-31 13:41:23','2021-10-31 13:41:24','2021-10-31 23:41:24'),('b4fe45aa2a549b5aa157e19913010404457ff1ae8d155060e114edb59f88b593f615b17e3f607f01',1,1,'web','[]',1,'2021-09-08 14:38:46','2021-09-08 14:39:09','2021-09-09 00:38:46'),('b55cf50297945e6ee362f3b665610a000dd259a9ad8294eafbeb3f69503adb92f6022e7dee4adf51',1,1,'web','[]',0,'2021-10-14 15:38:06','2021-10-14 15:38:06','2021-10-15 01:38:06'),('b58fc2f69b749a694af01991a5986de3c5bb2ab98c0e2f7592bc5be1add26a789c3d8b5f4aba5f01',1,1,'web','[]',0,'2021-09-11 14:48:59','2021-09-11 14:48:59','2021-09-12 00:48:59'),('b64d192c437498424b41cac88bd61830ce3c27b2b3483356b7bc2ec5ec330c67aabaa9b2f3bf906f',1,1,'api','[]',0,'2021-10-19 13:29:55','2021-10-19 13:29:55','2022-10-19 21:29:55'),('b677c901b2d1746e990fa8e13c83378a94347618a9f427a0abc2889dcb3ac91048ddd383275ed12d',1,1,'web','[]',0,'2021-09-25 14:23:12','2021-09-25 14:23:12','2021-09-26 00:23:12'),('b6c6cb32c48218a093b73c21b7fa9b0f0d41857b16c7146068e8d55dc57b6facc0c62f8992cc6a91',3,1,'api','[]',0,'2021-10-28 13:56:46','2021-10-28 13:56:46','2022-10-28 21:56:46'),('b7d21ca60fb8e3be7ded0addeb3ea6b4bd5d8093819b6265bec57962d6d931fc3de0efccde0ee3dd',2,1,'api','[]',0,'2021-10-19 14:41:11','2021-10-19 14:41:11','2022-10-19 22:41:11'),('b9c7a4661d13cc77a8f3abdbb8c29f4deebb88dd5aff061af7e05e66655f2b3fa5aebc8c56fe1bad',6,1,'web','[]',0,'2021-09-16 15:08:57','2021-09-16 15:08:57','2021-09-17 01:08:57'),('bab8cede54655d74cf7019e782824129c77a3b7592afa8d747dd86b0b2f12c68ed317b2c7abf161c',1,1,'web','[]',0,'2021-10-31 16:48:29','2021-10-31 16:48:29','2021-11-01 02:48:29'),('babfcfc8e56d5778778080cf3573737071b9f83a1674db3f63a97ee32bb2c4904b64a48402b3c022',1,1,'web','[]',0,'2021-09-25 07:34:22','2021-09-25 07:34:22','2021-09-25 17:34:22'),('bad4aaa7f38731e42a2efd6b79406844e528c82b66c38199960393f9938c7b8e3e8b7774b9198dc2',1,1,'web','[]',0,'2021-10-08 15:01:31','2021-10-08 15:01:31','2021-10-09 01:01:31'),('bb74ee0fdc4b6bb15a1972f57bd1ba99543b2d2b128ebd81cfe68ce1125099f4052a648441704163',2,1,'api','[]',0,'2021-10-21 14:58:39','2021-10-21 14:58:39','2022-10-21 22:58:39'),('bbf9436c6ef92d1e537a9fc7682e6b1ab88e955c72b134163332edfd8e049cd0b3b19ffa6061754b',1,1,'web','[]',0,'2021-09-08 15:19:26','2021-09-08 15:19:26','2021-09-09 01:19:26'),('be669700634ede0940bc62a16362c9467187ebe0101098f7781cd13f28d64e3a5c429bbe783494e8',2,1,'api','[]',0,'2021-10-22 15:54:25','2021-10-22 15:54:25','2022-10-22 23:54:25'),('be72e8534d5e0a002fafdde254f6fe2e7e217233c97c66882ecba625374e00caa875369451be4df9',1,1,'web','[]',0,'2021-09-16 15:13:17','2021-09-16 15:13:17','2021-09-17 01:13:17'),('bf414e4ceca5ec33126e84be55e2d8ca8085d00d4a556b048e0ee5a7e76002a27bf21234c4d3f629',1,1,'web','[]',0,'2021-09-27 14:40:30','2021-09-27 14:40:30','2021-09-28 00:40:30'),('bfd32fa2f3d9cfbb4b115d2d157d31c7ad19724295fea2ca42c494caa298284e6f378df278b16de1',1,1,'web','[]',0,'2021-11-02 12:43:18','2021-11-02 12:43:18','2021-11-02 22:43:18'),('c1310184a60eeea0a75d5cbb400eea00aab84d1c8d400f236cb7916efb4aaf198ad9805db9a32c14',1,1,'web','[]',0,'2021-09-23 14:37:55','2021-09-23 14:37:55','2021-09-24 00:37:55'),('c1e4c887596752204033c031bad5406faac8e2191b6efca2cc1d0fcf99881c6e93d6b14bd0f2b106',1,1,'web','[]',0,'2021-09-26 07:43:18','2021-09-26 07:43:18','2021-09-26 17:43:18'),('c1ed4157753927a2018b740c8a1e9c214b61de8976af1d9da8eac0cfa26ee164350a211d8cd45fd7',2,1,'api','[]',0,'2021-10-19 14:57:50','2021-10-19 14:57:50','2022-10-19 22:57:50'),('c36206cc47815c5cc87560c4032908d1c3db6fbdcf6c4acf5da00115056ac9f61cf16e66c109d9fa',1,1,'web','[]',0,'2021-10-30 06:26:52','2021-10-30 06:26:53','2021-10-30 16:26:53'),('c41537f315c1667b7552046eaa5f91c7f6b4d59cb9b8ead15013cc0d5f61ff85f6bed21160547d52',1,1,'web','[]',0,'2021-10-15 14:49:38','2021-10-15 14:49:39','2021-10-16 00:49:39'),('c50d89a9b45c7e4ad602d21f4a45b31d1a9cb449599f0203e2649135ba5b6e4df129c6d884f21505',1,1,'web','[]',0,'2021-09-21 14:59:18','2021-09-21 14:59:19','2021-09-22 00:59:19'),('c56d9bc93300a67f56a5f3ef863b65796d43333e22b8e29d88a96fbf12e7662c4e2d6c2c5453c32b',2,1,'api','[]',0,'2021-10-21 14:32:08','2021-10-21 14:32:08','2022-10-21 22:32:08'),('c72eb73398721d66b0185699edbd96528da88a2f9ead8006e265014864054e0404232b6efe58541a',2,1,'api','[]',0,'2021-10-22 15:14:53','2021-10-22 15:14:53','2022-10-22 23:14:53'),('c76f5ed991c37c04b60e6e83d9edce07a128fb6a71d98e080a9a4e0cc5f0cad46eb9beebf42d8687',1,1,'web','[]',0,'2021-09-16 15:15:13','2021-09-16 15:15:13','2021-09-17 01:15:13'),('c7aab81fcad10a1dfd9209da1f83223593e4bf9d8fcbdba73c66a4261e9bab6fe74115f622ce9e91',2,1,'api','[]',0,'2021-10-22 15:23:01','2021-10-22 15:23:01','2022-10-22 23:23:01'),('c7d31ad83cf9b4c52c7075885fa00905b17832c96db7480d7b16fd89f60b2a2f571e286b9632a2a8',1,1,'web','[]',0,'2021-10-13 15:52:20','2021-10-13 15:52:20','2021-10-13 17:52:20'),('c81d621176a5cc13b167f832f33a5a476a51efde4e67b06c41ec5e573463f5fe1e4408f61e63f058',2,1,'api','[]',0,'2021-10-22 15:49:12','2021-10-22 15:49:12','2022-10-22 23:49:12'),('c927a298a74f10862e7469f53bc16a106887fa13705cb68ab27b62abe806072ec8b4010af07120a9',1,1,'web','[]',0,'2021-09-29 08:21:22','2021-09-29 08:21:22','2021-09-29 18:21:22'),('c953f5a5f63cfef4fd1f27249f24c34c21bdc17c662dcaa3e14a854c8a3e95fc759e491cfc63b995',1,1,'web','[]',0,'2021-09-15 08:07:12','2021-09-15 08:07:12','2021-09-15 18:07:12'),('c9f6dfa92a01a4a6bbc18ca37faa17e75dd70bcc3d87602723cdfbf40d68fa6847f7baafa350e357',1,1,'web','[]',0,'2021-11-05 14:53:57','2021-11-05 14:53:57','2021-11-06 00:53:57'),('ca011d14c86c0989868dc0e1b07e5d9cc2fa280cbc1001942c6799f144c7e5eb059356b65c4a07e3',1,1,'web','[]',0,'2021-09-16 15:10:11','2021-09-16 15:10:11','2021-09-17 01:10:11'),('ca63052595fa9cccfe273d865ed91675d5161fb3c1cb882dbff6f4e1fafc5f4fa696eb9bbb210230',1,1,'web','[]',0,'2021-10-13 15:38:52','2021-10-13 15:38:52','2021-10-14 01:38:52'),('caf4326c154f8af87f4336fca62ef5a1c92593f5866dde4ac5174a195b1fe2dc5d1a64426a8e6fbc',2,1,'api','[]',0,'2021-10-22 14:40:34','2021-10-22 14:40:34','2022-10-22 22:40:34'),('cb6342967a68807c68bcacbde3dd457c312644efa6fe5be7c8796da74f869273989ac8e9abfb8261',2,1,'api','[]',0,'2021-10-19 13:30:13','2021-10-19 13:30:13','2022-10-19 21:30:13'),('cca0ceaf7489a52ed8e0b4945e4c1d3455b37e0e7ccde20d49950b118d07708bbb0f24d22424a4a6',1,1,'web','[]',0,'2021-09-12 09:00:10','2021-09-12 09:00:11','2021-09-12 19:00:11'),('cdb9e79b812b6c21bb3a205a8de7ead7845da9bcc3f069cceb96d9e7666c0cea8a7e99be6c3703e0',1,1,'web','[]',0,'2021-10-06 13:38:51','2021-10-06 13:38:51','2021-10-06 23:38:51'),('d012858e6c523f8459644670a315b5a4e3c7e06eb005d35a39d3f5780a7cf3defb95f21d9205c23c',1,1,'web','[]',0,'2021-09-17 00:49:00','2021-09-17 00:49:00','2021-09-17 10:49:00'),('d0b797aa4204cc0011bdd067522413e99d91cf70cb7a48f5fc55fd1c192cdd3e58f3a5c7c32185a4',1,1,'web','[]',0,'2021-11-07 02:53:23','2021-11-07 02:53:23','2021-11-07 12:53:23'),('d159d0e8451f14b2c4bb7206f8af27aa371278b4cbc2480c7c2f6b5441d76ab3ccb71672e8e2f54b',2,1,'api','[]',0,'2021-10-22 15:33:39','2021-10-22 15:33:39','2022-10-22 23:33:39'),('d17259f1393c0b59db6bdcac52629471d6634184962f94fe6fb29976983fa315f6d4d30d6484d90d',1,1,'web','[]',0,'2021-09-15 13:44:23','2021-09-15 13:44:23','2021-09-15 23:44:23'),('d25790a1299b58dd441a6a3cc169d140be9938806d48a3697238e6cb959d20feff8e78dadf38d7bf',1,1,'web','[]',0,'2021-09-29 12:30:57','2021-09-29 12:30:57','2021-09-29 22:30:57'),('d274e6ef0ecc99ec4a5d992488b6b0e3c5e454701439dcdd7cb4ecb68392d5d928e51c04300cfa52',2,1,'api','[]',0,'2021-11-08 13:41:37','2021-11-08 13:41:37','2022-11-08 21:41:37'),('d2fe5aa413e55c0bc1f3c205a9a3a90e3feb0db3c5610355b1ac02f06ce383444e2fdae72d58c6a1',2,1,'api','[]',0,'2021-10-22 15:32:15','2021-10-22 15:32:15','2022-10-22 23:32:15'),('d3aea61f4f251ed699fc970ae710de5290ad7276b33dc155c40dfef28a54dc787b32e08eb7b2020e',2,1,'api','[]',0,'2021-10-22 14:41:57','2021-10-22 14:41:57','2022-10-22 22:41:57'),('d452e23dfd8bf0ff6b27bda78398f9116ecb756de0c6fe961c3ddc4447b376e593c577649c15a1a2',2,1,'api','[]',0,'2021-10-22 14:59:09','2021-10-22 14:59:09','2022-10-22 22:59:09'),('d557ae54063081e084dd656a3c5d08a8f30f5993a31f602e11212b5d5e5dc103d18fc0d7d8ab4bd3',2,1,'api','[]',0,'2021-10-21 16:20:35','2021-10-21 16:20:35','2022-10-22 00:20:35'),('d6292c0a61eb317f49d8809da41fe82231f4e2501b2fe37f3d298e3c15e37c01e374ccce650283e8',1,1,'web','[]',0,'2021-10-13 16:22:24','2021-10-13 16:22:24','2021-10-14 02:22:24'),('d6843b00df890f41ab24da9df6690893c638c4d4700fe5da95165698d0bd7f2f8e6781270f6a4ae4',1,1,'web','[]',0,'2021-10-06 14:37:01','2021-10-06 14:37:01','2021-10-07 00:37:01'),('d9f9679050a33e218570bd729d0de5ab0d8e8fd45b3fe9e1cccbd1f76d7fb09076e625efd213991c',1,1,'web','[]',0,'2021-09-16 15:09:44','2021-09-16 15:09:45','2021-09-17 01:09:45'),('dae07bb88e0d886ee1accdd1c51cb5c4d60a3992d1f2e7170dd7b4f74f11bd5837097cddfc06a9b4',2,1,'api','[]',0,'2021-10-22 15:37:17','2021-10-22 15:37:17','2022-10-22 23:37:17'),('dbe34286252f501c07f79763f74aa97830095cf8fc56b09f422e4011e2be5d1a01e4743905b19da0',1,1,'web','[]',0,'2021-11-07 02:44:51','2021-11-07 02:44:52','2021-11-07 12:44:52'),('dd9a47a129d381c2c09336f11c762b8e554d15df2e041912f41e048b9489a54b340feaf34321c827',2,1,'api','[]',0,'2021-10-23 14:57:18','2021-10-23 14:57:18','2022-10-23 22:57:18'),('e1a0fd20d30d3e113c91ee50870dfd898a105ab26709e196e7aa74831ca831ead7598d80a10dee0f',1,1,'web','[]',0,'2021-10-13 15:13:40','2021-10-13 15:13:41','2021-10-14 01:13:41'),('e4923f347b850d2a305b2d6e0bafa5e37f4f73caa38a671e1de328b785acc8f4bfa2c8904a3c56af',1,1,'web','[]',0,'2021-09-10 13:04:11','2021-09-10 13:04:12','2021-09-10 23:04:12'),('e4f9da54b9b15837e1d4c0e96d5cede6915ff0383d40f6decda14c743b150b4510c44b79c6d97720',3,1,'api','[]',0,'2021-10-28 13:20:07','2021-10-28 13:20:07','2022-10-28 21:20:07'),('e61e61d26a359d042a663c3b63c043932887e909f09d4079623a304debb331c62e27f8f4151310d9',1,1,'web','[]',0,'2021-09-16 14:23:51','2021-09-16 14:23:52','2021-09-17 00:23:52'),('e66cb56c59fad3b5ba9972765aad3f0892ecfe56b51ad6b9e3f92b810f7e9f1c36a845fa7b404bf1',3,1,'api','[]',0,'2021-10-28 13:23:29','2021-10-28 13:23:29','2022-10-28 21:23:29'),('e6a4fbde8e2d6bd3e2c5635f57a1a950d651e9616eae7dad1fe3bec7cd5a88b2779613b92dd8c3ed',6,1,'web','[]',0,'2021-09-09 09:36:55','2021-09-09 09:36:55','2021-09-09 19:36:55'),('e7536e9f1accec603fc076850a2e013785d74d71335b0bbe3c01f0808c93c67791e3bb28382d6c5d',1,1,'web','[]',0,'2021-11-07 02:35:39','2021-11-07 02:35:39','2021-11-07 12:35:39'),('e756a2b679af71c7fcc3f7caa7c56cede7755153d0cbec4758dee65ccacea53c77c072afc9ac4927',2,1,'web','[]',0,'2021-09-08 14:45:25','2021-09-08 14:45:25','2021-09-09 00:45:25'),('e7d2f90f219e33a12c22ef3da552c20ab5c767232c28b763a97f486bc4c8964136a3ff5ba30432e6',2,1,'api','[]',0,'2021-10-21 14:56:46','2021-10-21 14:56:46','2022-10-21 22:56:46'),('e9e4f2dc5e6b4e04ef91151d0cb1e8c9053df792c0417c70bd0e5eaf0c66660f80ef3f2fe6594a91',2,1,'api','[]',0,'2021-10-21 13:04:21','2021-10-21 13:04:21','2022-10-21 21:04:21'),('eac9f25553b669f48f6bc9e5fc0014e57ec8de7007fbb12648549cfc85c473fab38af97a707117f6',1,1,'web','[]',0,'2021-10-12 13:19:49','2021-10-12 13:19:49','2021-10-12 15:19:49'),('eb8ba2a907444ce013a0a60656977bc6c8c29c4e9a86d267d2b3de8b5996925d4b46554b7cda56c1',1,1,'web','[]',0,'2021-10-29 14:40:02','2021-10-29 14:40:03','2021-10-30 00:40:03'),('ec697513ef083f6328c3d8851f0e3ddfceaf0e79894de894c6a3d56cac2448eca3ae40076989d709',2,1,'api','[]',0,'2021-10-22 15:13:01','2021-10-22 15:13:01','2022-10-22 23:13:01'),('edde2c7887b0ff4e141587a9ea00b46506871284264cdd82a1c0ea03165e29291dc3c421d7fbb81a',1,1,'web','[]',0,'2021-10-05 12:30:04','2021-10-05 12:30:05','2021-10-05 22:30:05'),('ef1ad15eacfb779f9cfa362bf8207c3fd2f52dd983accca8531eaa68cc420ff108361c8f358d95bb',1,1,'web','[]',0,'2021-10-24 12:50:32','2021-10-24 12:50:32','2021-10-24 22:50:32'),('f046bbbba02338c740f397c110c3c7d8d7bf15ce453f0829876a84163dc987953c164a37b3e770de',1,1,'web','[]',0,'2021-10-06 13:40:45','2021-10-06 13:40:45','2021-10-06 23:40:45'),('f06752a9a7057564db8b1efd828420039b8ed7ca8128b5f73cfe8b4d3e14a038abef90a8d7cab92f',1,1,'web','[]',0,'2021-10-06 13:36:18','2021-10-06 13:36:18','2021-10-06 23:36:18'),('f10eedb4511ed106e879ee209ea62ee3e2c89bb0535f8d7309f3dcb932b597c761bf7084a09d1a34',1,1,'web','[]',0,'2021-09-28 15:12:20','2021-09-28 15:12:20','2021-09-29 01:12:20'),('f1837b6d312adbd0912c9bf68fff3fc51713b833758ebe3a3e8bf40b8fd08aeb683b75ede41b391f',2,1,'api','[]',0,'2021-10-22 15:18:21','2021-10-22 15:18:21','2022-10-22 23:18:21'),('f41a015827bb5435e1517fe113ebaef0e8125f31bc5eca9399cf01e277718c0774405185c803e159',2,1,'api','[]',0,'2021-11-02 14:02:12','2021-11-02 14:02:12','2022-11-02 22:02:12'),('f5a784c2f3c57e404e23d30d2c9880246c3f3b1dcdd2284614cce91b53fbeadc91d923faad08033d',1,1,'web','[]',0,'2021-09-17 00:49:33','2021-09-17 00:49:33','2021-09-17 10:49:33'),('f6411bb7f60c2358cbcf0c50ba9a5a761f3ab3b7e072cba0e316fed3bfa6670bf1888b93a2e7de28',3,1,'api','[]',0,'2021-10-28 13:58:43','2021-10-28 13:58:43','2022-10-28 21:58:43'),('f6425ae326e43e937b3e2fbdf78ace712030be34018b8dac80017eb11b3823782c6b88df70bdc283',2,1,'api','[]',0,'2021-10-22 15:30:35','2021-10-22 15:30:35','2022-10-22 23:30:35'),('f65809e5254a7091ad91d6f95ca1cd884601125f1eeea5d334312595d14a7c702f51f9c7919c526d',3,1,'api','[]',0,'2021-10-28 13:01:41','2021-10-28 13:01:41','2022-10-28 21:01:41'),('f6ccca12949348016049643dad65d936d3cf78a71cfa5003bd5b87d01a3e14c665f26bb5fa289b0c',1,1,'web','[]',0,'2021-10-25 13:33:04','2021-10-25 13:33:04','2021-10-25 23:33:04'),('f70d1c9f190d3aa0c13985af639d9083179f9745944eb71e742c6ca72932f777ffeaa16a84169a3d',1,1,'web','[]',0,'2021-09-16 12:22:22','2021-09-16 12:22:23','2021-09-16 22:22:23'),('f741242f65ef04f3bcf57102a97aed934cfe43599878a0b6f09de781d955897b37a038fa204aa934',1,1,'web','[]',0,'2021-10-24 04:36:39','2021-10-24 04:36:40','2021-10-24 14:36:40'),('f7813d5a4b76ef46dc8deef6b46463a1d66e9f613b4d328513d749c60d8a29c9fe02e65299970def',1,1,'web','[]',0,'2021-09-16 15:16:04','2021-09-16 15:16:04','2021-09-17 01:16:04'),('f7c495e4edcc87a65ebc0715bb5b6ac2a8e3c2ecd26f701adfb731bb25cea9379adb1c058729828f',2,1,'api','[]',0,'2021-11-02 13:40:07','2021-11-02 13:40:07','2022-11-02 21:40:07'),('fa33bddb2efb5cce863d90efe0254809318066482e80ddd44eea939017436e731ef7cf4500f40a01',1,1,'web','[]',0,'2021-10-24 13:57:57','2021-10-24 13:57:57','2021-10-24 23:57:57'),('fa877c440c0095e9a92abf5347e5778e477937179d90de84b3fb4b9f15fe4d3e9925b2a32df8d1fe',2,1,'api','[]',0,'2021-10-20 15:12:01','2021-10-20 15:12:01','2022-10-20 23:12:01'),('faad062e503ade076f64b08786cd6a950ea99ae9539c739358d588b2c0dd60935b0586c2a00050b5',1,1,'web','[]',0,'2021-09-08 14:41:07','2021-09-08 14:41:07','2021-09-09 00:41:07'),('faae6424f0e76d083ef9fed7c79346617e138290c55f6e8d7c4c9964002de89d4bb08ba5d6ddddb0',1,1,'web','[]',0,'2021-10-30 15:06:59','2021-10-30 15:06:59','2021-10-31 01:06:59'),('fb00fe7c87893b6bcbaa24b99152706f6856f8614852c2d306278d3e209014f6af16fec5e6f39dc3',1,1,'web','[]',0,'2021-10-03 13:35:03','2021-10-03 13:35:03','2021-10-03 23:35:03'),('ff85261fcf5643ecbb4cd0a3427f514934242288c5afb05a0dc1e77d3aa313bf22b0c40a25286687',2,1,'api','[]',0,'2021-10-21 15:02:19','2021-10-21 15:02:19','2022-10-21 23:02:19');
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'set_basic','web','基本設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(2,'set_manager','web','人員管理','2021-09-08 13:59:43','2021-09-08 13:59:43'),(3,'set_message','web','簡訊設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(4,'news-type','web','最新消息分類','2021-09-10 14:52:43','2021-09-10 14:52:43'),(5,'news','web','最新消息管理','2021-09-10 14:52:43','2021-09-10 14:52:43'),(6,'cooking-type','web','烹飪教學分類','2021-09-16 02:50:00','2021-09-16 02:50:00'),(7,'cooking','web','烹飪教學管理','2021-09-16 02:50:00','2021-09-16 02:50:00'),(9,'product-type','web','產品分類','2021-09-21 15:00:00','2021-09-21 15:00:00'),(10,'product','web','產品管理','2021-09-21 15:00:00','2021-09-21 15:00:00'),(11,'directory','web','目錄管理','2021-09-25 16:00:00','2021-09-25 16:00:00'),(12,'put-on','web','上架管理','2021-09-25 16:00:00','2021-09-25 16:00:00'),(13,'banners','web','大圖輪播','2021-10-04 16:00:00','2021-10-04 16:00:00'),(14,'member','web','會員管理','2021-10-24 13:16:00','2021-10-24 13:16:00');
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
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片名稱',
  `product_id` int(11) NOT NULL COMMENT '分類ID',
  `path` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片路徑',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '圖片類型(web => 網頁版, mobile => 手機板)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (4,'t-ig.png',30,'product/zcQdK4Xna6TVVxtEXpEGExld7dttEA8nDMmVcCEM.png','web','2021-10-30 15:24:18','2021-10-30 15:24:18',NULL),(5,'giphy.gif',31,'product/uUc2epqkltC7KQlsWuy0KyRFqO92y1aSD7dwKx2w.gif','web','2021-10-30 15:34:03','2021-10-30 15:34:03',NULL),(6,'pic1.jpg',31,'product/cYdjC7yCB3yPWpaSdjbXBDJ34u57KzU8ngCWs0Eb.jpg','web','2021-10-30 15:34:11','2021-10-30 15:34:11',NULL),(7,'pic2.jpeg',31,'product/bYGz4hbXLXWWamocF7nWGTl7G4qsAJfIC1dxnPdW.jpg','web','2021-10-30 15:34:20','2021-10-30 15:34:20',NULL),(8,'cartoon.png',32,'product/qa4uJ9Co725XB8oX2PqEDQjicKW6yNS4LlbdgtFc.png','web','2021-10-30 15:37:21','2021-10-31 06:15:03','2021-10-31 06:15:03'),(9,'giphy.gif',32,'product/orZw80cwu1HsU3cCsdg0QwBNFNs8h9gsyo0sncrl.gif','web','2021-10-30 15:37:26','2021-10-30 16:31:01','2021-10-30 16:31:01'),(10,'pic1.jpg',32,'product/w4qaHeHkRFOjmPkr88Pcw7eCLl61obXkCIZhIlgV.jpg','web','2021-10-30 15:37:35','2021-10-30 16:31:01','2021-10-30 16:31:01'),(11,'pic2.jpeg',32,'product/WcRkr5cxcdV4EfU6YU91ZdwQcaRkw82SSz9pTBYZ.jpg','web','2021-10-30 15:37:40','2021-10-30 16:32:52','2021-10-30 16:32:52'),(12,'S__111558660.jpg',32,'product/ydXhhkVJ5mX0DBRYkErsrugNqGUGDbRjsgzBx02A.jpg','web','2021-10-30 15:37:51','2021-10-30 16:31:23','2021-10-30 16:31:23'),(13,'S__111558660.jpg',32,'product/FHcCt0Sb5oZuucndyW2kI0Yp3h0jgUN856cib4kq.jpg','web','2021-10-30 16:32:52','2021-10-31 06:15:03','2021-10-31 06:15:03'),(14,'t-facebook.png',32,'product/x9hGPKwr9Q8WJqUPwSC4AWD9GcBgLEfYrPdJrAfC.png','web','2021-10-30 16:32:52','2021-10-31 06:15:03','2021-10-31 06:15:03'),(15,'S__111558660.jpg',32,'product/RtgJA1YYyz1G81equRCKMqhkFiut5WO1F13MzWss.jpg','mobile','2021-10-31 06:40:06','2021-10-31 06:40:06',NULL),(16,'S__111558660.jpg',34,'product/pAeCp7qQbQuOG5vhhDCViDfeUlf0p2eSHt9ML7m2.jpg','web','2021-10-31 06:54:25','2021-10-31 07:01:14','2021-10-31 07:01:14'),(17,'t-facebook.png',34,'product/hlmBKHKLkwkGvfxYRC2ShhmyOM5uX4UjcNQZmwBM.png','web','2021-10-31 06:54:25','2021-10-31 06:59:51','2021-10-31 06:59:51'),(18,'S__111558660.jpg',34,'product/RXAD6XDaE4cFgowCOif4pR10d7wEKR6XGdY7lOTi.jpg','mobile','2021-10-31 06:54:26','2021-10-31 07:00:18','2021-10-31 07:00:18'),(20,'t-ig.png',34,'product/DE9afUxRYD8QbKb4NiCkDyBDP9hDqiwTbjAK1uCy.png','web','2021-10-31 07:01:05','2021-10-31 07:01:14','2021-10-31 07:01:14'),(21,'t-line.png',34,'product/JS6lPMxh0J0C1oERXkU6F1519BhkA2V9vzQkBaTX.png','mobile','2021-10-31 07:01:05','2021-10-31 07:01:05',NULL),(22,'t-line.png',34,'product/oJ3rjoVua558biYYFtM7O6pggfgpHt4aeuH8bKwQ.png','mobile','2021-10-31 07:01:15','2021-10-31 07:01:15',NULL),(23,'S__111558660.jpg',18,'product/4AXzvZoWgVGxLOVSO4Ji5oxQpdhPjlPPMRBj9cI9.jpg','web','2021-10-31 07:12:32','2021-10-31 07:27:52','2021-10-31 07:27:52'),(24,'t-facebook.png',18,'product/6nby7KuYoRAp1WwdWC9RIvDEduZB8RElUWiTqes6.png','web','2021-10-31 07:12:32','2021-10-31 07:27:36','2021-10-31 07:27:36'),(25,'t-ig.png',18,'product/OcgiK8cfMLSkzNsoNfRY83wuo6NVERDRAajePOgD.png','web','2021-10-31 07:12:33','2021-10-31 13:48:48','2021-10-31 13:48:48'),(26,'pic1.jpg',18,'product/p9pwEKR5InwSfBbps5v5ymID253Hf1e2BYdSitjk.jpg','mobile','2021-10-31 07:12:33','2021-10-31 07:27:52','2021-10-31 07:27:52'),(27,'pic2.jpeg',18,'product/PMfrfQbo16zrcGgsgtTyZXxbWMQx7yHxd0njiJ6f.jpg','mobile','2021-10-31 07:12:34','2021-10-31 07:27:36','2021-10-31 07:27:36'),(28,'S__111558660.jpg',18,'product/AmfOK3xx4s28SJ9K25JnIOPf3ZTNlaSmDHrWPnz6.jpg','mobile','2021-10-31 07:12:34','2021-10-31 13:48:50','2021-10-31 13:48:50'),(29,'t-line.png',18,'product/SLMw038cpjMsRbmpBKX5UpZxkvRxi1drCbwv0niz.png','web','2021-10-31 07:27:52','2021-10-31 13:48:49','2021-10-31 13:48:49'),(30,'t-line.png',18,'product/B9ydEvtEx75AqKjE4Ny9IyAeTsl7SMWmz8GrU1ly.png','mobile','2021-10-31 07:27:52','2021-10-31 13:48:51','2021-10-31 13:48:51'),(31,'t-facebook.png',18,'product/1rIPunxMOSIIoNIfc0CP493jcJhFGwKBepvWoh3m.png','web','2021-10-31 07:56:04','2021-10-31 13:48:50','2021-10-31 13:48:50'),(32,'giphy.gif',34,'product/0cmc0rQQeVaj3cC4E27hN8wFd3L8lVuxJvrKAfh0.gif','web','2021-10-31 13:05:56','2021-10-31 13:05:56',NULL),(33,'pic1.jpg',34,'product/kvE8HV2mGC2fYHLBnFKlDt8xRAsxx5tQAabclOqk.jpg','web','2021-10-31 13:05:57','2021-10-31 13:05:57',NULL),(34,'pic2.jpeg',34,'product/msTMkLkzzT9vOOiiyfttuC7WPlqC4ajmMnwNv375.jpg','web','2021-10-31 13:05:57','2021-10-31 13:05:57',NULL),(35,'S__111558660.jpg',35,'product/vkjueYBRFqe7l4EIHMbbmIcGE1PyARthaOLNPp9S.jpg','web','2021-10-31 13:20:58','2021-10-31 13:27:38','2021-10-31 13:27:38'),(36,'t-facebook.png',35,'product/RS584URIiUebEBv5xxp1ALjvMTzELenU7Zl7wJvF.png','web','2021-10-31 13:20:58','2021-10-31 13:25:33','2021-10-31 13:25:33'),(37,'t-ig.png',35,'product/ojPDxuuT08sXBjnANPx9FgIfLMhA2KTZ9FnrTqGr.png','web','2021-10-31 13:20:58','2021-10-31 13:25:33','2021-10-31 13:25:33'),(38,'生鮮配-0456.jpg',35,'product/EiZ9ocC5EndUg6MEYKwy9QZxMe3tn2Q5C6ZnIrMs.jpg','web','2021-10-31 13:25:19','2021-10-31 13:25:33','2021-10-31 13:25:33'),(39,'S__111558660.jpg',35,'product/Tx90SUQdjJUADC9CgrWFUioQc1HFSzOpFEgbeOrs.jpg','web','2021-10-31 13:27:17','2021-10-31 13:27:38','2021-10-31 13:27:38'),(40,'t-line.png',35,'product/6V0fS9U1XDSlXIsCeGGIOrqkRXYAmH2Kxkyggfgm.png','web','2021-10-31 13:27:18','2021-10-31 13:27:38','2021-10-31 13:27:38'),(41,'cartoon.png',35,'product/oy1sPMLGPMFHbQbnGQMZ34VuNdx8FE1xE5NQIyOC.png','web','2021-10-31 13:29:50','2021-10-31 13:29:50',NULL),(42,'giphy.gif',35,'product/qcFSf9CRRGA2DqM7z9E0r3mnQP3AN6K6KI001FON.gif','web','2021-10-31 13:29:50','2021-10-31 13:45:37','2021-10-31 13:45:37'),(43,'pic1.jpg',35,'product/qvqKXaUYmjb7cW0cp822j8pIKaJZqoey1JyOWL9J.jpg','web','2021-10-31 13:29:51','2021-10-31 13:35:20','2021-10-31 13:35:20'),(44,'S__111558660.jpg',35,'product/g6T58CGJ00lUWjOfJq9GTiyrjOagltWFET2mj1pF.jpg','web','2021-10-31 13:30:15','2021-10-31 13:35:20','2021-10-31 13:35:20'),(45,'t-facebook.png',35,'product/HmJoeVFdxFLZrckZVHVjJ8A1993HdqaWFg4jBwU3.png','web','2021-10-31 13:30:15','2021-10-31 13:35:20','2021-10-31 13:35:20'),(46,'t-facebook.png',35,'product/QO9Z7KYoX3c6LgZVoAu2DDBGOLv68xdYZf2d5C9m.png','web','2021-10-31 13:35:19','2021-10-31 13:45:37','2021-10-31 13:45:37'),(47,'t-ig.png',35,'product/3eyHa0PLmG9FAClqqtHXZGl6CCxayYc6drElwUxL.png','web','2021-10-31 13:35:20','2021-10-31 13:44:41','2021-10-31 13:44:41'),(48,'t-line.png',35,'product/GFB4FMoicYLVDCXpjLeznOgbOAGUe1F3UXpXib16.png','web','2021-10-31 13:35:20','2021-10-31 13:44:41','2021-10-31 13:44:41'),(49,'S__111558660.jpg',35,'product/0xDBXoS661is22NuDQscHRo0ktN6kpc0RJphGTze.jpg','web','2021-10-31 13:45:35','2021-10-31 13:45:35',NULL),(50,'t-facebook.png',35,'product/Wtr4FyVllZQuCaivLJB7XKXTRSVCeTDbyfOYOUlu.png','web','2021-10-31 13:45:36','2021-10-31 13:45:36',NULL),(51,'t-ig.png',35,'product/56fUA2KwnZXdU2C1sisWww4aHum6J2loAlgyg1iZ.png','web','2021-10-31 13:45:36','2021-10-31 13:45:36',NULL),(52,'t-line.png',35,'product/AKOOimRkzZhELg95uhkXtpuHcYklrxiD64sSJHrQ.png','web','2021-10-31 13:45:36','2021-10-31 13:45:36',NULL),(53,'S__111558660.jpg',18,'product/WkHiQDz7laJxcAC7OrIJRPnbVLME2sdDOjgge1mM.jpg','web','2021-10-31 13:49:03','2021-10-31 13:49:03',NULL),(54,'t-line.png',18,'product/isQe43bEduh1Sqj1PjjyUKUt1209U56RCd6C2XpL.png','mobile','2021-10-31 13:49:03','2021-10-31 13:49:03',NULL),(55,'pic2.jpeg',33,'product/xdsM59inr5zhtmT1jGEMcOZjOUtXv3FNUYvLik6n.jpg','web','2021-11-01 13:24:01','2021-11-01 13:24:01',NULL),(56,'S__111558660.jpg',33,'product/t24BvR02gAqpT1zyax5Xb20dCl34GNfQ5KppbZ4b.jpg','web','2021-11-01 13:24:02','2021-11-01 13:24:02',NULL),(57,'t-facebook.png',33,'product/GZr5toudYpGeHsEjnphD2TVlC5SR91sypv8qtQWc.png','web','2021-11-01 13:24:02','2021-11-01 13:24:02',NULL),(58,'t-ig.png',33,'product/t3CHTylHMTpcBnW9GxPmTRSIhzCyGSvlMfeEJVJs.png','web','2021-11-01 13:24:02','2021-11-01 13:24:02',NULL),(59,'t-ig.png',20,'product/6Er7NboyoiZbGAsX3F7WyvFKlIG1lRPP0gW2ZT9t.png','web','2021-11-01 13:24:22','2021-11-01 13:24:22',NULL),(60,'生鮮配-0456.jpg',20,'product/RN4YS1bPV3jXHiCzUatN1V0kJmNV5sciEToyU16N.jpg','web','2021-11-01 13:24:23','2021-11-01 13:24:23',NULL),(61,'giphy.gif',19,'product/jSdTv0puaDZP9ouMLZg0riIVr4UTrhAQ1h5MN5a5.gif','web','2021-11-01 13:24:36','2021-11-01 13:24:36',NULL);
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
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
  `unit` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '單位',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_specifications_product_id_index` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specifications`
--

LOCK TABLES `product_specifications` WRITE;
/*!40000 ALTER TABLE `product_specifications` DISABLE KEYS */;
INSERT INTO `product_specifications` VALUES (1,18,'product1',500,300,30,NULL,'2021-11-02 12:46:33','2021-11-02 12:46:39','2021-11-02 12:46:39'),(2,18,'product-規格1',500,400,50,NULL,'2021-11-02 12:46:56','2021-11-02 12:46:56',NULL),(3,18,'product-規格2',700,500,30,NULL,'2021-11-02 12:47:16','2021-11-02 12:47:16',NULL),(4,19,'123-規格1',300,200,10,'包','2021-11-02 12:47:35','2021-11-06 08:15:22',NULL),(5,19,'123-規格2',400,250,20,'包','2021-11-02 12:47:58','2021-11-06 08:14:52',NULL),(6,20,'測試flex產品-規格1',500,300,50,'包','2021-11-02 12:49:01','2021-11-06 08:16:07',NULL),(7,20,'測試flex產品-規格2',300,200,5,'包','2021-11-02 12:49:12','2021-11-06 08:16:04',NULL),(8,20,'測試flex產品-規格3',550,400,20,'包','2021-11-02 12:49:25','2021-11-06 08:16:01',NULL),(9,19,'123-規格3',500,300,25,'包','2021-11-06 08:15:39','2021-11-06 08:15:39',NULL),(10,20,'product-規格2',50,50,50,'50','2021-11-07 03:03:52','2021-11-07 03:03:56','2021-11-07 03:03:56'),(11,19,'123-規格4',20,20,20,'2','2021-11-07 03:04:53','2021-11-07 03:04:56','2021-11-07 03:04:56');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (4,'product-type1','2021-10-24 04:40:25','2021-10-24 04:40:25',NULL);
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
  `product_front_cover_image_id` int(11) DEFAULT NULL COMMENT '產品前台大圖ID',
  `keywords` text COLLATE utf8mb4_unicode_ci COMMENT '關鍵字',
  `description` longtext COLLATE utf8mb4_unicode_ci COMMENT '描述',
  `sales_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否暫停銷售(0 => 暫停, 1 => 開放)',
  `show_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否於上架管理顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_product_types_id_index` (`product_types_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (18,4,'product1',NULL,53,'1','null',1,1,'2021-10-24 04:41:07','2021-10-31 13:49:03',NULL),(19,4,'123',NULL,NULL,NULL,'null',1,1,'2021-10-24 12:50:51','2021-10-24 13:14:10',NULL),(20,4,'測試flex產品','<p><strong>test</strong></p>\n\n<p><strong>test</strong></p>\n\n<p><strong>test</strong></p>\n\n<p><strong>test</strong></p>\n\n<p><strong>testtesttest</strong></p>\n\n<p><strong>testtest</strong></p>\n\n<p><strong>testtesttesttest</strong></p>',NULL,'12345','test\ntest\ntest',1,1,'2021-10-24 14:28:16','2021-10-24 14:29:00',NULL),(21,4,'testasdasd',NULL,NULL,NULL,'null',0,0,'2021-10-30 15:06:46','2021-10-31 13:14:55','2021-10-31 13:14:55'),(22,4,'12345',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:07:43','2021-10-30 15:16:57','2021-10-30 15:16:57'),(23,4,'testtest',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:08:26','2021-10-30 15:16:57','2021-10-30 15:16:57'),(24,4,'asdasd',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:11:32','2021-10-30 15:16:57','2021-10-30 15:16:57'),(25,4,'setestst',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:12:35','2021-10-30 15:16:57','2021-10-30 15:16:57'),(26,4,'aaaa',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:12:59','2021-10-30 15:16:57','2021-10-30 15:16:57'),(27,4,'aaaaaaa',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:14:24','2021-10-30 15:16:57','2021-10-30 15:16:57'),(28,4,'123445',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:17:08','2021-10-31 13:14:55','2021-10-31 13:14:55'),(29,4,'sdafsdfsdf',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:19:00','2021-10-31 06:51:55','2021-10-31 06:51:55'),(30,4,'sdfsdfsf',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:24:17','2021-10-31 06:51:55','2021-10-31 06:51:55'),(31,4,'testtest',NULL,NULL,NULL,NULL,0,0,'2021-10-30 15:33:59','2021-10-31 06:51:55','2021-10-31 06:51:55'),(32,4,'aaaa',NULL,NULL,NULL,'null',0,0,'2021-10-30 15:37:12','2021-10-31 13:14:55','2021-10-31 13:14:55'),(33,4,'testtesttest',NULL,NULL,NULL,'null',0,1,'2021-10-31 06:52:09','2021-10-31 15:04:04',NULL),(34,4,'testtesttesttest',NULL,33,NULL,'null',0,1,'2021-10-31 06:54:24','2021-11-01 16:41:12',NULL),(35,4,'111',NULL,49,NULL,'null',1,1,'2021-10-31 13:20:57','2021-10-31 15:04:24',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `put_ons`
--

LOCK TABLES `put_ons` WRITE;
/*!40000 ALTER TABLE `put_ons` DISABLE KEYS */;
INSERT INTO `put_ons` VALUES (40,31,18,NULL,NULL,1,'2021-10-24 04:41:43','2021-10-24 04:41:55',NULL),(41,31,20,NULL,NULL,1,'2021-10-24 14:29:15','2021-10-24 14:29:23',NULL),(42,31,19,NULL,NULL,1,'2021-10-31 15:04:38','2021-10-31 15:04:53',NULL),(43,31,33,NULL,NULL,1,'2021-10-31 15:04:38','2021-10-31 15:04:53',NULL),(44,31,34,NULL,NULL,1,'2021-10-31 15:04:38','2021-10-31 15:04:53',NULL),(45,31,35,NULL,NULL,1,'2021-10-31 15:04:38','2021-10-31 15:04:53',NULL);
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(1,2),(1,3),(2,3),(3,3),(2,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_codes`
--

LOCK TABLES `sms_codes` WRITE;
/*!40000 ALTER TABLE `sms_codes` DISABLE KEYS */;
INSERT INTO `sms_codes` VALUES (1,'0987654321','93697','2021-10-18 15:10:21','2021-10-18 15:10:25','2021-10-18 15:10:25'),(2,'0922222222','61666','2021-10-18 15:11:14','2021-10-18 15:11:18','2021-10-18 15:11:18'),(3,'0933288334','65089','2021-10-26 14:36:54','2021-10-26 14:42:34','2021-10-26 14:42:34'),(4,'0933288331','57644','2021-10-26 14:38:09','2021-10-26 14:38:09',NULL),(5,'0933288334','35114','2021-10-26 14:42:36','2021-10-26 14:44:39','2021-10-26 14:44:39'),(6,'0933288334','74864','2021-10-26 14:44:42','2021-10-26 14:58:20','2021-10-26 14:58:20'),(7,'0933288334','74864','2021-10-26 14:45:15','2021-10-26 14:58:26','2021-10-26 14:58:26'),(8,'0933288334','54359','2021-10-26 14:58:22','2021-10-26 15:04:21','2021-10-26 15:04:21'),(9,'0933288334','54872','2021-10-26 14:58:29','2021-10-26 15:04:27','2021-10-26 15:04:27'),(10,'0933288334','64050','2021-10-26 15:04:24','2021-10-26 15:07:55','2021-10-26 15:07:55'),(11,'0933288334','70284','2021-10-26 15:04:29','2021-10-26 15:08:00','2021-10-26 15:08:00'),(12,'0933288334','78264','2021-10-26 15:07:55','2021-10-26 15:10:03','2021-10-26 15:10:03'),(13,'0933288334','28389','2021-10-26 15:08:01','2021-10-26 15:10:17','2021-10-26 15:10:17'),(14,'0933288334','84683','2021-10-26 15:10:03','2021-10-26 15:13:38','2021-10-26 15:13:38'),(15,'0933288334','05628','2021-10-26 15:10:17','2021-10-26 15:13:55','2021-10-26 15:13:55'),(16,'0933288334','83345','2021-10-26 15:13:38','2021-10-26 15:27:28','2021-10-26 15:27:28'),(17,'0933288334','53836','2021-10-26 15:13:56','2021-10-26 15:19:54','2021-10-26 15:19:54'),(18,'0933288334','78901','2021-10-26 15:19:54','2021-10-26 15:27:28','2021-10-26 15:27:28'),(19,'0933288334','57594','2021-10-26 15:22:51','2021-10-26 15:27:28','2021-10-26 15:27:28'),(20,'0933288334','99502','2021-10-26 15:27:29','2021-10-26 15:30:22','2021-10-26 15:30:22'),(21,'0933288334','10408','2021-10-26 15:30:25','2021-10-26 15:31:30','2021-10-26 15:31:30');
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

-- Dump completed on 2021-11-09  0:08:58
