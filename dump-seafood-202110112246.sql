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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'cartoon.png','banners/1wtqiNRcS6n5ezCq0n9Nj7fBkjfdXexxQNRKOzqh.png','生鮮配-0456.jpg','banners/r2ejRipAYGXOZP5yFIuaMiD3ba4stBxAW1J4Nt5E.jpg','12345',0,1,'2021-10-06 14:43:11','2021-10-07 14:02:42','2021-10-07 14:02:42'),(2,'pic2.jpeg','banners/L2B4QYeOg5hUmeNuhvK1pR387ODZ3GfK9PDXh1K9.jpg','S__111558660.jpg','banners/UMXQ7kiKTJpO4DkiJgGrPIq4e42veGjkdaQ88Dbm.jpg','12345',0,1,'2021-10-06 15:05:59','2021-10-07 14:02:42','2021-10-07 14:02:42'),(3,'pic1.jpg','banners/Tng1zS5fAzQ3Zy4Fy1cKSIRyITSRWunGtmJqac5D.jpg','pic2.jpeg','banners/IZO1fghqtM9hrykqoIfFXKXbdYdN3UpJJfo0zOQh.jpg',NULL,0,0,'2021-10-07 13:44:33','2021-10-07 14:02:42','2021-10-07 14:02:42'),(4,'S__111558660.jpg','banners/MpdmbzJUKZn55gH8Rb6fVTvBwJCdIUQxFpD6TUNE.jpg','生鮮配-0456.jpg','banners/4U0YCN8bdZ9DLl26HDj3Enf4zHECeLYJxlLhLhJ7.jpg','sadsad',0,1,'2021-10-07 13:44:50','2021-10-07 14:02:42','2021-10-07 14:02:42'),(5,'pic2.jpeg','banners/vIu9fgdhC5UsvU42oTLzLT4wLMdSAQ2lY4zhNGuV.jpg','S__111558660.jpg','banners/N2VV2WY0qYA1lmMCYlN721Rl9es974SuqA9xvVxZ.jpg',NULL,0,0,'2021-10-07 13:44:59','2021-10-07 13:57:47','2021-10-07 13:57:47'),(6,'pic1.jpg','banners/CXta3mmoIQoThsPWNuu8MAtSNQQPnz0IDSThvgJg.jpg','S__111558660.jpg','banners/iUctR6Nko3I7Kt0sBRc1e6BDlK9gSB2jzpXA4KTY.jpg','123123',0,0,'2021-10-07 13:58:07','2021-10-07 14:02:42','2021-10-07 14:02:42'),(7,'S__111558660.jpg','banners/ZgHXlEEV4kJjjR1Puck1WWFStnk85K2DVhBACG0v.jpg','生鮮配-0456.jpg','banners/tS1TEoeQ9FTJbijtQndLvNTIkjxHYIv9vyqkBIf9.jpg','https://www.google.com.tw',0,1,'2021-10-07 14:02:51','2021-10-07 14:43:52',NULL),(8,'生鮮配-0456.jpg','banners/o0EtSjIAtL6YrndERUKHfQHJecS5rYvVPfQApIcx.jpg','S__111558660.jpg','banners/Cw9YiT8LFDjGOgDN2NHLybAlUY174Zcl4lAOHWLR.jpg','https://www.google.com.tw',1,1,'2021-10-07 14:02:58','2021-10-07 14:43:02',NULL),(9,'pic1.jpg','banners/qgTYGWP18nqttUE1CG8N88enZ6mfZ9tkxdiYbMzn.jpg','生鮮配-0456.jpg','banners/6jj2cImDdKA11qNHEMMnOG6O8DCoi1jI1ykSVIPI.jpg',NULL,0,1,'2021-10-07 14:37:05','2021-10-07 14:42:57',NULL);
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
INSERT INTO `cooking` VALUES (1,1,'測試教學','2021-10-09 15:48:00','2021-10-29 15:48:00',NULL,NULL,'','1Qv7Q3sBRKw',1,1,'2021-10-09 07:48:50','2021-10-09 16:31:19',NULL),(2,1,'測試教學2','2021-10-15 22:40:00','2021-10-30 22:40:00',NULL,NULL,'','eVTXPUF4Oz4',0,1,'2021-10-09 14:40:20','2021-10-09 14:40:29',NULL),(3,1,'測試教學其他1','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:09','2021-10-09 15:21:32',NULL),(4,1,'測試教學其他2','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:09','2021-10-09 15:21:36',NULL),(5,1,'測試教學其他3','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:09','2021-10-09 15:21:39',NULL),(6,1,'測試教學其他4','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:21:44',NULL),(7,1,'測試教學其他5','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:21:47',NULL),(8,1,'測試教學其他6','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:21:50',NULL),(9,1,'測試教學其他7','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:21:53',NULL),(10,1,'測試教學其他8','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:21:58',NULL),(11,1,'測試教學其他9','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:22:02',NULL),(12,1,'測試教學其他10','2021-10-09 23:21:00','2021-10-09 23:31:00',NULL,NULL,'','n0LM1ZnIdPk',1,1,'2021-10-09 15:21:10','2021-10-09 15:22:06',NULL),(13,1,'測試教學666','2021-10-09 23:24:00','2021-10-29 23:24:00',NULL,NULL,'','TV6-AKEwyfU',0,1,'2021-10-09 15:24:19','2021-10-09 15:24:33',NULL);
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
INSERT INTO `cooking_types` VALUES (1,'cooking1','2021-09-25 17:02:16','2021-09-25 17:02:16',NULL),(2,'cooking2','2021-10-09 07:37:53','2021-10-09 07:37:53',NULL);
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
INSERT INTO `directories` VALUES (1,'directory1','2021-09-25 16:57:13','2021-09-25 16:57:13',NULL),(2,'directory2','2021-09-25 16:58:56','2021-09-25 16:58:56',NULL),(3,'directory3','2021-09-25 16:59:01','2021-09-25 16:59:01',NULL),(4,'directory4','2021-09-25 16:59:05','2021-09-25 16:59:05',NULL),(5,'directory5','2021-09-25 16:59:08','2021-09-25 16:59:08',NULL),(6,'directory6','2021-09-25 16:59:12','2021-09-25 16:59:12',NULL),(7,'directory7','2021-09-25 16:59:26','2021-09-25 16:59:26',NULL),(8,'directory8','2021-09-25 16:59:30','2021-09-25 17:02:46','2021-09-25 17:02:46'),(9,'directory9','2021-09-25 16:59:34','2021-09-25 16:59:34',NULL),(10,'directory10','2021-09-25 16:59:37','2021-09-25 16:59:37',NULL),(11,'directory11','2021-09-25 16:59:40','2021-09-25 16:59:40',NULL),(12,'directory12','2021-10-10 09:01:35',NULL,NULL),(13,'directory13','2021-10-10 09:01:35',NULL,NULL),(14,'directory14','2021-10-10 09:01:35',NULL,NULL),(15,'directory15','2021-10-10 09:01:35',NULL,NULL),(16,'directory16','2021-10-10 09:01:35',NULL,NULL),(17,'directory17','2021-10-10 09:01:35',NULL,NULL),(18,'directory18','2021-10-10 09:01:35',NULL,NULL),(19,'directory19','2021-10-10 09:01:35',NULL,NULL),(20,'directory20','2021-10-10 09:01:35',NULL,NULL),(21,'directory21','2021-10-10 09:01:35',NULL,NULL),(22,'directory22','2021-10-10 09:01:35',NULL,NULL),(23,'directory23','2021-10-10 09:01:36',NULL,NULL),(24,'directory24','2021-10-10 09:01:36',NULL,NULL),(25,'directory25','2021-10-10 09:01:36',NULL,NULL),(26,'directory26','2021-10-10 09:01:36',NULL,NULL),(27,'directory27','2021-10-10 09:01:36',NULL,NULL),(28,'directory28','2021-10-10 09:01:36',NULL,NULL),(29,'directory29','2021-10-10 09:01:36',NULL,NULL),(30,'directory30','2021-10-10 09:01:36',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (59,'2014_10_12_000000_create_users_table',1),(60,'2014_10_12_100000_create_password_resets_table',1),(61,'2016_06_01_000001_create_oauth_auth_codes_table',1),(62,'2016_06_01_000002_create_oauth_access_tokens_table',1),(63,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(64,'2016_06_01_000004_create_oauth_clients_table',1),(65,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(66,'2019_08_19_000000_create_failed_jobs_table',1),(67,'2019_12_14_000001_create_personal_access_tokens_table',1),(68,'2021_09_07_130852_create_permission_tables',1),(70,'2021_09_10_161057_create_config_table',2),(97,'2021_09_11_225050_create_news_types_table',3),(98,'2021_09_11_225633_create_news_table',3),(99,'2021_09_16_225751_create_cooking_types_table',3),(100,'2021_09_16_225841_create_cooking_table',3),(101,'2021_09_21_231939_create_product_types_table',3),(102,'2021_09_21_232050_create_products_table',3),(103,'2021_09_22_221925_create_product_specifications_table',4),(104,'2021_09_26_004328_create_directories_table',5),(107,'2021_09_26_154842_create_put_ons_table',6),(112,'2021_10_05_155315_create_carts_table',7),(113,'2021_10_06_213105_create_banners_table',7);
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,1,'test1','2021-09-23 22:22:00','2021-09-30 22:22:00','href','<p><strong>test1</strong></p>','123','生鮮配-0456.jpg','news/6ZN2ZD9YMd6rVSLyT3zphoNzG4CtXFH2mDEoyDY4.jpg',NULL,NULL,0,0,0,'2021-09-23 14:22:28','2021-10-01 15:04:55',NULL),(2,1,'測試標題2','2021-10-01 21:44:00','2021-10-15 21:44:00',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','cartoon.png','news/WVBlJOB1yXniuFcU4gqpw6Zep14wZBUc9QV0lrqf.png',0,0,1,'2021-10-01 13:44:16','2021-10-01 13:44:16',NULL),(3,2,'測試標題3','2021-10-01 21:44:00','2021-10-28 21:44:00','null','<p><strong>測試</strong></p>\n\n<h2 style=\"font-style:italic;\"><strong>測試<em>測試測試測試測試</em></strong><code><big>測<small>試測試測試</small></big></code></h2>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試</strong></p>\n\n<p><strong>測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試測試</strong></p>','1,12,123,1234,12345,測試','生鮮配-0456.jpg','news/10JOhUY2H5tQbLoMJSzVPoPAasyZ7SOITCxRfVmG.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',0,0,1,'2021-10-01 13:44:37','2021-10-03 05:37:58',NULL),(4,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-1','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(5,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-2','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(6,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-3','2021-10-02 11:57:00','2021-10-28 11:57:00','null',NULL,NULL,'pic2.jpeg','news/zntE9Yjf4fedPsVPe4ERQPu5UO8tkWGCLXHSHnUq.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,1,'2021-10-02 03:57:21','2021-10-08 15:45:16',NULL),(7,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-4','2021-10-02 11:57:00','2021-10-22 11:57:00','null',NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,0,'2021-10-02 03:57:21','2021-10-08 15:01:52',NULL),(8,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-5','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(9,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-6','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(10,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-7','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(11,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-8','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(12,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-9','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(13,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-10','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(14,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-11','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(15,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-12','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(16,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-13','2021-10-02 11:57:21','2021-10-02 11:57:21',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:21','2021-10-02 03:57:21',NULL),(17,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-14','2021-10-02 11:57:00','2021-10-28 11:57:00','null',NULL,NULL,'pic1.jpg','news/eBbYWxCdwnPEI2oovgUQw07FRWO0ZakB9tSI24bK.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,0,'2021-10-02 03:57:22','2021-10-08 15:44:57',NULL),(18,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-15','2021-10-02 11:57:00','2021-10-22 11:57:00','null',NULL,NULL,'pic1.jpg','news/JXY0nJDVjnJZwBundgAcWeMjfoa9Uq5HdePaD08O.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,1,'2021-10-02 03:57:22','2021-10-09 06:20:01',NULL),(19,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-16','2021-10-02 11:57:00','2021-10-23 11:57:00','null',NULL,NULL,'cartoon.png','news/rS9DwumoWliEQk6R4uZB4V6u3BP62zgfNowQc77c.png','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,1,'2021-10-02 03:57:22','2021-10-08 15:45:05',NULL),(20,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-17','2021-10-02 11:57:00','2021-10-22 11:57:00','null',NULL,NULL,'S__111558660.jpg','news/aobb4GZIN4DwwWhDyLJ1Ir5P3nAVLHy40lsrUPD2.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,1,'2021-10-02 03:57:22','2021-10-09 06:21:54',NULL),(21,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-18','2021-10-02 11:57:00','2021-10-21 11:57:00','null',NULL,NULL,'生鮮配-0456.jpg','news/a6PG1fIyscnIdGcqG8YjbS6JWWZXtafebISjhWp0.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,1,1,'2021-10-02 03:57:22','2021-10-09 06:22:04',NULL),(22,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-19','2021-10-02 11:57:22','2021-10-02 11:57:22',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:22','2021-10-02 03:57:22',NULL),(23,2,'這是測試news這是測試news這是測試news這是測試news這是測試news-20','2021-10-02 11:57:22','2021-10-02 11:57:22',NULL,NULL,NULL,'S__111558660.jpg','news/y2xXGBBBce9gR0OdaVR8M5eXGU4N3bNuTfcBek2P.jpg','S__111558660.jpg','news/6kmfHW6Su9598mWjoTYopMq97R5MsCDwQdeYKCCA.jpg',1,0,1,'2021-10-02 03:57:22','2021-10-02 03:57:22',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_types`
--

LOCK TABLES `news_types` WRITE;
/*!40000 ALTER TABLE `news_types` DISABLE KEYS */;
INSERT INTO `news_types` VALUES (1,'test1','2021-09-23 14:22:05','2021-09-23 14:22:05',NULL),(2,'test2','2021-10-01 13:43:44','2021-10-01 13:43:44',NULL);
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
INSERT INTO `oauth_access_tokens` VALUES ('008feb84ee179a01db2bfcb40cf2f37b998afb51e52746c15ee1f2f93981b626becc6192cdc27b54',1,1,'web','[]',0,'2021-10-10 15:41:12','2021-10-10 15:41:12','2021-10-11 01:41:12'),('01af7e627d2484d3beed145cf5f5d265c4572efeb5569a87088f8e6325e228d25f5bd749278c9e13',1,1,'web','[]',0,'2021-09-12 15:56:21','2021-09-12 15:56:21','2021-09-13 01:56:21'),('0305e1fd08b58a779f4a19c98532de6d75b3b60698ec01260166125de16186986489994e5add0758',1,1,'web','[]',1,'2021-09-11 15:01:11','2021-09-11 15:01:14','2021-09-12 01:01:11'),('0321e36ab6c54fb5ba96a2f02cae4e0ab991734a5abd58e566067a248e37cd3b4e2acd0cfa0c8a0c',1,1,'web','[]',0,'2021-09-11 15:00:42','2021-09-11 15:00:42','2021-09-12 01:00:42'),('032ca3bc0a5cd947427258b9566399d2d7de734160568f67c70a21c2b10b98ef2900a2cc2866239c',1,1,'web','[]',1,'2021-09-10 14:53:21','2021-09-23 14:37:36','2021-09-11 00:53:22'),('070088d3bacbfe2a22a20f87ec11adb95aa9949a9897eeb2a95cd168728883c85f7642ebc4a33c51',1,1,'web','[]',1,'2021-09-24 09:11:46','2021-09-24 09:19:08','2021-09-24 19:11:46'),('09ca5667078cfbc6a5ecefb62c24cf603f35506180aadd2b451124c97e80832aa0057d3be59ce463',1,1,'web','[]',1,'2021-09-29 13:46:34','2021-10-06 13:36:07','2021-09-29 23:46:34'),('0bb2766900fbcc983f284cb5c56af0ba8da57a29c9d29164eebe499a2aa24f5a9c4b6298803b579c',6,1,'web','[]',1,'2021-09-09 09:34:19','2021-09-09 09:34:48','2021-09-09 19:34:20'),('0e1fe67c16c982de984ea04e6fb3fb5db71b62da2570d47cb87e1dd4cf837f854364aebd9736373f',1,1,'web','[]',1,'2021-09-08 14:39:23','2021-09-08 14:39:51','2021-09-09 00:39:23'),('0f6635182d9263240c7ef522812e9c73b3e5f4c20434a5695ca990212178fde468935b43828bb474',1,1,'web','[]',0,'2021-09-28 12:35:10','2021-09-28 12:35:10','2021-09-28 22:35:10'),('16687fc35570fed23327014b4caef403528d5a67baecffda05ce3682f90b6498a509275ca7c857f6',1,1,'web','[]',0,'2021-09-17 09:37:28','2021-09-17 09:37:28','2021-09-17 19:37:28'),('16f2e339085b5967dc9acc43bdabe0e395e0a580044195884c8ec3b837551de4b0d88cee2dd7877f',1,1,'web','[]',0,'2021-09-16 15:12:38','2021-09-16 15:12:39','2021-09-17 01:12:39'),('1ef3a529c346441b368520d7c8a56d3eb0af99c22ec4a1aab45306d3e274ab7bd2a990cf7a295e57',1,1,'web','[]',1,'2021-09-09 09:30:52','2021-09-09 09:34:14','2021-09-09 19:30:53'),('1f1dbda287cac52bc4bcf090942405198e011764c513e15c07db00083938998934753ed34878c9f7',6,1,'web','[]',1,'2021-09-08 14:43:40','2021-09-08 14:44:27','2021-09-09 00:43:40'),('212aa580e74247356500629e2583c51d2761f24b7c2621e0c06f40232b6e4b2c4c9e631cb2f10d30',1,1,'web','[]',1,'2021-09-16 15:08:24','2021-09-16 15:08:42','2021-09-17 01:08:25'),('26e7619fd88048364e403e1d5c64d3e30dd9d979d97e23b239b8227ef0a37cc1d6df14cd0d4b068e',1,1,'web','[]',0,'2021-10-06 13:36:11','2021-10-06 13:36:11','2021-10-06 23:36:11'),('2996d2c18a7f1f0b679163c40cc18b4266b3572c4b5a87a5e80ac3e94678729bdf21cc4ba3034d51',1,1,'web','[]',1,'2021-09-29 13:32:12','2021-09-29 13:39:14','2021-09-29 23:32:13'),('2c9dd06edeb6d47d94724f91f90a6b0157b5d758b5ba86da2443634f951fb5b6b8c5790ca7dc206d',1,1,'web','[]',0,'2021-09-21 15:08:57','2021-09-21 15:08:57','2021-09-22 01:08:57'),('2d0df6d3e9db1c6dcc8546b4886b7d7f7be01460a4e3882c8c050fb2d8db312cb05d3d3714609ea5',1,1,'web','[]',1,'2021-09-11 14:58:24','2021-09-11 15:00:27','2021-09-12 00:58:24'),('2da5f751e49fe494ddfa11ffe684bb2d3fb06d7a69d73fea50334cafb377724542368e5747db8261',1,1,'web','[]',0,'2021-09-12 09:19:16','2021-09-12 09:19:16','2021-09-12 19:19:16'),('32d076cdc7797ea66a0478a655f2f3a9e1fab2612e1c874f1bd4d15240e09685ce28f4821b49ed0a',1,1,'web','[]',0,'2021-09-23 12:32:40','2021-09-23 12:32:40','2021-09-23 22:32:40'),('353cc442bee7a88e491a7d4296c0e17f8bc52e7ae169be75bf38d88e82843b1c7a5f9549dbb96876',1,1,'web','[]',0,'2021-10-10 11:00:21','2021-10-10 11:00:21','2021-10-10 21:00:21'),('37b30a35fbf9812434ac18b1457387c97bd84ec4876cc2edcffb3389f460132e425b7fad08c66d20',6,1,'web','[]',1,'2021-09-08 14:39:57','2021-09-08 14:40:31','2021-09-09 00:39:57'),('38101ea2a8e547a83e0b035fdd3ed45a91072f89c55a13cb536ee9615a1406fd9d0e8b01eae21637',1,1,'web','[]',0,'2021-10-09 08:22:50','2021-10-09 08:22:50','2021-10-09 18:22:50'),('3a8b78f1ded48dec925a756a44f3e0b993c518aec5a8736414674848203a4028d79fdc0ba4b20f74',1,1,'web','[]',1,'2021-10-06 13:39:02','2021-10-06 13:40:09','2021-10-06 23:39:02'),('3b92b464f479300d53874e3107fd3a6055a336690c23409f394196e6a2065b451038f2e5f1bee457',1,1,'web','[]',0,'2021-09-12 09:19:24','2021-09-12 09:19:24','2021-09-12 19:19:24'),('3cb6d20d59762fc0a0f63a60957203b731c78969ff899a6fe692de09b2594e10e9ef69d6b9738dd8',1,1,'web','[]',0,'2021-09-16 16:02:46','2021-09-16 16:02:47','2021-09-17 02:02:47'),('407f12f62b13e3cc947410b07bdbfec8f701db8c191d0f77ec0847162a623027a038936dfeb30cea',1,1,'web','[]',1,'2021-09-22 13:15:09','2021-09-22 15:56:01','2021-09-22 23:15:09'),('4398267a9c616dbac8ef6ed03005b6039cf691c8a622f40bc06ac3eeb96159b86790692827f3f4c6',1,1,'web','[]',1,'2021-09-25 06:40:27','2021-09-25 07:34:18','2021-09-25 16:40:28'),('4ac60479342dd9e1645245b8ee5b2bde235efae0966ace18da06de47939bbf13cf4994201304bcb0',1,1,'web','[]',0,'2021-09-09 08:30:14','2021-09-09 08:30:14','2021-09-09 18:30:14'),('4c2aeca3a8a5da6bf1376c1b10cdb4548bd007d427bcb8a4689507fde5b18f07e3dca0036d62b9ec',1,1,'web','[]',0,'2021-09-09 09:34:54','2021-09-09 09:34:54','2021-09-09 19:34:54'),('4e65fb192ecc1cfa1d29c8271b2e287768f4bdcdd08382104a9543fad51c7b40ade6aafac60ac1fd',1,1,'web','[]',0,'2021-09-16 15:11:45','2021-09-16 15:11:45','2021-09-17 01:11:45'),('547d7bf67bd0ea6a3bd9c5a174e5b7857196accc469c15fa9e224ec048378916b409cf7c7db2df62',1,1,'web','[]',1,'2021-09-15 06:05:37','2021-09-15 08:07:08','2021-09-15 16:05:37'),('55d2011cdee2ee53a54fa1a11e1996803e75dab21929b681196e60f455cf443a2ed04c0176c3608f',1,1,'web','[]',1,'2021-09-25 16:38:27','2021-09-25 16:38:54','2021-09-26 02:38:27'),('5b30e05aa6de32d7668254ce2cd86e4dd0979d93e54f8cb1fe1d64cf694443025c90ad2458f07d53',1,1,'web','[]',0,'2021-10-07 13:28:16','2021-10-07 13:28:16','2021-10-07 23:28:16'),('5ba2c5825d048e217b67c69ec34e123d620ab78978e30e4a504b950b407ecbaa565775ed34b2f8ef',1,1,'web','[]',1,'2021-09-22 15:56:06','2021-09-22 15:56:31','2021-09-23 01:56:06'),('5c3e04653e8c3df8ed0ade81094106cd1ca7e7bc195140a117b912053d797dcba7a0d99964d0cd87',1,1,'web','[]',0,'2021-10-01 13:43:33','2021-10-01 13:43:33','2021-10-01 23:43:33'),('5ddc8795c34056297894ab14b18aa58d190e69a55c2c29271b7ad4e3066ab110768d37bcd2834e3e',1,1,'web','[]',1,'2021-09-08 14:44:37','2021-09-08 14:44:52','2021-09-09 00:44:37'),('5e2af4d9a776ad2056e4220121aeb97f3c53f0dc4b0affa8587bf58c15f528e764019ac715ab078c',1,1,'web','[]',0,'2021-09-25 16:38:57','2021-09-25 16:38:57','2021-09-26 02:38:57'),('607600f7052a64eda6e320e732f5146a349f34678be82815170a2a8554fa45bccfe2396909489619',1,1,'web','[]',0,'2021-10-09 14:37:09','2021-10-09 14:37:09','2021-10-10 00:37:09'),('62db6bda72a0ed6d8d2e01ae55bea6580456221909bcca5fe74453ef8cd137d9a1480d9b4b9382ac',1,1,'web','[]',0,'2021-09-25 07:34:41','2021-09-25 07:34:41','2021-09-25 17:34:41'),('668778df68372443987c34b747d8b96b23d5c5db1ba8b5d50db7738a7cc7db173844d4ff3b7de7b4',1,1,'web','[]',0,'2021-10-04 13:46:02','2021-10-04 13:46:03','2021-10-04 23:46:03'),('69be433b8524f1b518032206ff07e60ea58daca5ed453b7508de6ce3a55c89a1880fc49ed59d2698',6,1,'web','[]',1,'2021-09-08 14:44:56','2021-09-08 14:45:19','2021-09-09 00:44:56'),('714c25712ac6e0d14e66eb1bf1f2225e832bc165e46aa3033d7e0509abb06e217b458621f7fff118',1,1,'web','[]',0,'2021-09-24 09:22:07','2021-09-24 09:22:08','2021-09-24 19:22:08'),('77d3689535db4482aca4c6a1c3f1ec93f394b7bceac6c947e52bb76e847f159c0d2a750223e06b56',1,1,'web','[]',1,'2021-09-27 12:39:35','2021-09-27 14:40:26','2021-09-27 22:39:35'),('7da288a93a01754c3ffe9ab1371224ea07cba47e214bdf89aaa6136fa9ecb3b501902e6b9a4f2446',1,1,'web','[]',1,'2021-10-10 08:57:55','2021-10-10 11:00:17','2021-10-10 18:57:56'),('7da98536470fc357a0e43f1d546c33ba814cc2eb5a2587afaba956feb61fab177685251e4c0749c1',6,1,'web','[]',1,'2021-09-11 14:48:47','2021-09-11 14:48:53','2021-09-12 00:48:48'),('7ddc0ed7d2b5c707640125d94dbc6c88b4255c98f49719b6952e41c72c4d1dd2060e406f2f24590d',1,1,'web','[]',0,'2021-09-14 14:26:02','2021-09-14 14:26:03','2021-09-15 00:26:03'),('7e23673c0ded50f79ca18e5a598d2fae5441d1c1e28ec39251af15b2b36ba2fbcb3f7a95e1c24559',1,1,'web','[]',0,'2021-09-17 08:07:30','2021-09-17 08:07:30','2021-09-17 18:07:30'),('85af61d60686cebcab45d66d1784635cd06d1f48de0e74c4696dc241d6ad6196411f4ea511c5c3e9',1,1,'web','[]',1,'2021-09-16 15:11:30','2021-09-16 15:11:42','2021-09-17 01:11:31'),('88a8e2d68b3655220cb48fdd97af95d9de3cdcd728c9581e64bcb597e3c4f405a404fccf54b9b9db',1,1,'web','[]',1,'2021-09-15 03:57:48','2021-09-15 06:05:32','2021-09-15 13:57:48'),('8ebcd7b8da69e5c6c2f416799a8710467ccd7c698f0104020bbad846902e83be2374f644d7c35f57',6,1,'web','[]',1,'2021-09-08 14:42:41','2021-09-08 14:43:34','2021-09-09 00:42:41'),('9510f673be539f50f41b4cb161ea6416c1959e2881d999a1c1810091efff3b0faa06d5c2c0f87110',1,1,'web','[]',0,'2021-10-07 16:57:35','2021-10-07 16:57:35','2021-10-08 02:57:35'),('95fd05e768e982b6cedd8e85fc22329676df8ad8ab444ca0e08fa2968de5e5e6b8fa7c65f816201b',1,1,'web','[]',0,'2021-10-03 05:26:18','2021-10-03 05:26:18','2021-10-03 15:26:18'),('97d813b904afc01b3c1e590836ce2ed510ecd656eb0e0eec3d6d8628fed4c4c30f7942b848cd79b4',1,1,'web','[]',1,'2021-09-10 08:59:20','2021-09-10 09:37:55','2021-09-10 18:59:20'),('996e00448c7882df24ca0a551af0e974fb81cf5319c7d8c59d147834bd637242e62dd48d397623d9',1,1,'web','[]',0,'2021-09-17 01:06:00','2021-09-17 01:06:01','2021-09-17 11:06:01'),('9a1d8a0baf7c75df28abf9cffb3800dc4f63cb2295cb3dda85739a19a022b48fa8420045b20471ad',1,1,'web','[]',1,'2021-09-12 13:55:35','2021-09-12 15:56:15','2021-09-12 23:55:35'),('9c67e33caf57f3a49a3ab5a06c7131767f3b33163418975c488555e6f7cbd0f0e7efaaca074cbbfa',1,1,'web','[]',0,'2021-10-09 06:14:04','2021-10-09 06:14:04','2021-10-09 16:14:04'),('9d087ced33af286be366d8844511b5fda25aa0b843e10cea6c88b322fb658272592c667fee828fbc',1,1,'web','[]',0,'2021-10-06 13:22:49','2021-10-06 13:22:49','2021-10-06 23:22:49'),('9d0debc21fd715730edefcedf878bbedbcf6b9949cdae0ebf0afb338cebd7092729c5fe88a2fc34a',1,1,'web','[]',0,'2021-09-28 13:11:57','2021-09-28 13:11:57','2021-09-28 23:11:57'),('9e4819025d7a7af3f5b131854c34ce0fc416c45481b8832cb780aac871982a81cd95e9d728983df6',1,1,'web','[]',0,'2021-09-12 04:00:02','2021-09-12 04:00:02','2021-09-12 14:00:02'),('a0bc5174b443dc9868219f28b5e46a2a92366c83abb652bf0b4e917c3597d005d416adeca82fa383',1,1,'web','[]',0,'2021-09-26 13:03:17','2021-09-26 13:03:17','2021-09-26 23:03:17'),('a3ff3ddf840bbc85022b2211e27bbc5f8868d874c051105a660107ec4d22c87e47dc420d131b2b01',1,1,'web','[]',0,'2021-09-29 13:39:23','2021-09-29 13:39:23','2021-09-29 23:39:23'),('a890a3071785ebce02a07ba458fed16366fc0877ab0a4be3c78da5a70025bef74777b722076547a6',1,1,'web','[]',0,'2021-09-29 13:26:32','2021-09-29 13:26:32','2021-09-29 23:26:32'),('b08dee864330dbbf4867864cbe7381e9698b7b4ea9a013ae3abf5bb8a63c1c73bb9e5818af5158be',1,1,'web','[]',0,'2021-09-10 08:09:42','2021-09-10 08:09:43','2021-09-10 18:09:43'),('b2b592842e45efad7ba5888d54065d0161847062424727aa22727f7dacd53a8024fe2e6b730ee09b',1,1,'web','[]',0,'2021-09-11 15:02:24','2021-09-11 15:02:24','2021-09-12 01:02:24'),('b4d85f0438812069d4aef85ea7b59badac4df5cc452100ba0c43e785f290f2f9799b88c177f2f261',1,1,'web','[]',0,'2021-10-02 03:50:22','2021-10-02 03:50:22','2021-10-02 13:50:22'),('b4fe45aa2a549b5aa157e19913010404457ff1ae8d155060e114edb59f88b593f615b17e3f607f01',1,1,'web','[]',1,'2021-09-08 14:38:46','2021-09-08 14:39:09','2021-09-09 00:38:46'),('b58fc2f69b749a694af01991a5986de3c5bb2ab98c0e2f7592bc5be1add26a789c3d8b5f4aba5f01',1,1,'web','[]',0,'2021-09-11 14:48:59','2021-09-11 14:48:59','2021-09-12 00:48:59'),('b677c901b2d1746e990fa8e13c83378a94347618a9f427a0abc2889dcb3ac91048ddd383275ed12d',1,1,'web','[]',0,'2021-09-25 14:23:12','2021-09-25 14:23:12','2021-09-26 00:23:12'),('b9c7a4661d13cc77a8f3abdbb8c29f4deebb88dd5aff061af7e05e66655f2b3fa5aebc8c56fe1bad',6,1,'web','[]',0,'2021-09-16 15:08:57','2021-09-16 15:08:57','2021-09-17 01:08:57'),('babfcfc8e56d5778778080cf3573737071b9f83a1674db3f63a97ee32bb2c4904b64a48402b3c022',1,1,'web','[]',0,'2021-09-25 07:34:22','2021-09-25 07:34:22','2021-09-25 17:34:22'),('bad4aaa7f38731e42a2efd6b79406844e528c82b66c38199960393f9938c7b8e3e8b7774b9198dc2',1,1,'web','[]',0,'2021-10-08 15:01:31','2021-10-08 15:01:31','2021-10-09 01:01:31'),('bbf9436c6ef92d1e537a9fc7682e6b1ab88e955c72b134163332edfd8e049cd0b3b19ffa6061754b',1,1,'web','[]',0,'2021-09-08 15:19:26','2021-09-08 15:19:26','2021-09-09 01:19:26'),('be72e8534d5e0a002fafdde254f6fe2e7e217233c97c66882ecba625374e00caa875369451be4df9',1,1,'web','[]',0,'2021-09-16 15:13:17','2021-09-16 15:13:17','2021-09-17 01:13:17'),('bf414e4ceca5ec33126e84be55e2d8ca8085d00d4a556b048e0ee5a7e76002a27bf21234c4d3f629',1,1,'web','[]',0,'2021-09-27 14:40:30','2021-09-27 14:40:30','2021-09-28 00:40:30'),('c1310184a60eeea0a75d5cbb400eea00aab84d1c8d400f236cb7916efb4aaf198ad9805db9a32c14',1,1,'web','[]',0,'2021-09-23 14:37:55','2021-09-23 14:37:55','2021-09-24 00:37:55'),('c1e4c887596752204033c031bad5406faac8e2191b6efca2cc1d0fcf99881c6e93d6b14bd0f2b106',1,1,'web','[]',0,'2021-09-26 07:43:18','2021-09-26 07:43:18','2021-09-26 17:43:18'),('c50d89a9b45c7e4ad602d21f4a45b31d1a9cb449599f0203e2649135ba5b6e4df129c6d884f21505',1,1,'web','[]',0,'2021-09-21 14:59:18','2021-09-21 14:59:19','2021-09-22 00:59:19'),('c76f5ed991c37c04b60e6e83d9edce07a128fb6a71d98e080a9a4e0cc5f0cad46eb9beebf42d8687',1,1,'web','[]',0,'2021-09-16 15:15:13','2021-09-16 15:15:13','2021-09-17 01:15:13'),('c927a298a74f10862e7469f53bc16a106887fa13705cb68ab27b62abe806072ec8b4010af07120a9',1,1,'web','[]',0,'2021-09-29 08:21:22','2021-09-29 08:21:22','2021-09-29 18:21:22'),('c953f5a5f63cfef4fd1f27249f24c34c21bdc17c662dcaa3e14a854c8a3e95fc759e491cfc63b995',1,1,'web','[]',0,'2021-09-15 08:07:12','2021-09-15 08:07:12','2021-09-15 18:07:12'),('ca011d14c86c0989868dc0e1b07e5d9cc2fa280cbc1001942c6799f144c7e5eb059356b65c4a07e3',1,1,'web','[]',0,'2021-09-16 15:10:11','2021-09-16 15:10:11','2021-09-17 01:10:11'),('cca0ceaf7489a52ed8e0b4945e4c1d3455b37e0e7ccde20d49950b118d07708bbb0f24d22424a4a6',1,1,'web','[]',0,'2021-09-12 09:00:10','2021-09-12 09:00:11','2021-09-12 19:00:11'),('cdb9e79b812b6c21bb3a205a8de7ead7845da9bcc3f069cceb96d9e7666c0cea8a7e99be6c3703e0',1,1,'web','[]',0,'2021-10-06 13:38:51','2021-10-06 13:38:51','2021-10-06 23:38:51'),('d012858e6c523f8459644670a315b5a4e3c7e06eb005d35a39d3f5780a7cf3defb95f21d9205c23c',1,1,'web','[]',0,'2021-09-17 00:49:00','2021-09-17 00:49:00','2021-09-17 10:49:00'),('d17259f1393c0b59db6bdcac52629471d6634184962f94fe6fb29976983fa315f6d4d30d6484d90d',1,1,'web','[]',0,'2021-09-15 13:44:23','2021-09-15 13:44:23','2021-09-15 23:44:23'),('d25790a1299b58dd441a6a3cc169d140be9938806d48a3697238e6cb959d20feff8e78dadf38d7bf',1,1,'web','[]',0,'2021-09-29 12:30:57','2021-09-29 12:30:57','2021-09-29 22:30:57'),('d6843b00df890f41ab24da9df6690893c638c4d4700fe5da95165698d0bd7f2f8e6781270f6a4ae4',1,1,'web','[]',0,'2021-10-06 14:37:01','2021-10-06 14:37:01','2021-10-07 00:37:01'),('d9f9679050a33e218570bd729d0de5ab0d8e8fd45b3fe9e1cccbd1f76d7fb09076e625efd213991c',1,1,'web','[]',0,'2021-09-16 15:09:44','2021-09-16 15:09:45','2021-09-17 01:09:45'),('e4923f347b850d2a305b2d6e0bafa5e37f4f73caa38a671e1de328b785acc8f4bfa2c8904a3c56af',1,1,'web','[]',0,'2021-09-10 13:04:11','2021-09-10 13:04:12','2021-09-10 23:04:12'),('e61e61d26a359d042a663c3b63c043932887e909f09d4079623a304debb331c62e27f8f4151310d9',1,1,'web','[]',0,'2021-09-16 14:23:51','2021-09-16 14:23:52','2021-09-17 00:23:52'),('e6a4fbde8e2d6bd3e2c5635f57a1a950d651e9616eae7dad1fe3bec7cd5a88b2779613b92dd8c3ed',6,1,'web','[]',0,'2021-09-09 09:36:55','2021-09-09 09:36:55','2021-09-09 19:36:55'),('e756a2b679af71c7fcc3f7caa7c56cede7755153d0cbec4758dee65ccacea53c77c072afc9ac4927',2,1,'web','[]',0,'2021-09-08 14:45:25','2021-09-08 14:45:25','2021-09-09 00:45:25'),('edde2c7887b0ff4e141587a9ea00b46506871284264cdd82a1c0ea03165e29291dc3c421d7fbb81a',1,1,'web','[]',0,'2021-10-05 12:30:04','2021-10-05 12:30:05','2021-10-05 22:30:05'),('f046bbbba02338c740f397c110c3c7d8d7bf15ce453f0829876a84163dc987953c164a37b3e770de',1,1,'web','[]',0,'2021-10-06 13:40:45','2021-10-06 13:40:45','2021-10-06 23:40:45'),('f06752a9a7057564db8b1efd828420039b8ed7ca8128b5f73cfe8b4d3e14a038abef90a8d7cab92f',1,1,'web','[]',0,'2021-10-06 13:36:18','2021-10-06 13:36:18','2021-10-06 23:36:18'),('f10eedb4511ed106e879ee209ea62ee3e2c89bb0535f8d7309f3dcb932b597c761bf7084a09d1a34',1,1,'web','[]',0,'2021-09-28 15:12:20','2021-09-28 15:12:20','2021-09-29 01:12:20'),('f5a784c2f3c57e404e23d30d2c9880246c3f3b1dcdd2284614cce91b53fbeadc91d923faad08033d',1,1,'web','[]',0,'2021-09-17 00:49:33','2021-09-17 00:49:33','2021-09-17 10:49:33'),('f70d1c9f190d3aa0c13985af639d9083179f9745944eb71e742c6ca72932f777ffeaa16a84169a3d',1,1,'web','[]',0,'2021-09-16 12:22:22','2021-09-16 12:22:23','2021-09-16 22:22:23'),('f7813d5a4b76ef46dc8deef6b46463a1d66e9f613b4d328513d749c60d8a29c9fe02e65299970def',1,1,'web','[]',0,'2021-09-16 15:16:04','2021-09-16 15:16:04','2021-09-17 01:16:04'),('faad062e503ade076f64b08786cd6a950ea99ae9539c739358d588b2c0dd60935b0586c2a00050b5',1,1,'web','[]',0,'2021-09-08 14:41:07','2021-09-08 14:41:07','2021-09-09 00:41:07'),('fb00fe7c87893b6bcbaa24b99152706f6856f8614852c2d306278d3e209014f6af16fec5e6f39dc3',1,1,'web','[]',0,'2021-10-03 13:35:03','2021-10-03 13:35:03','2021-10-03 23:35:03');
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
INSERT INTO `product_specifications` VALUES (1,1,'1',1,1,1,'2021-09-24 09:26:55','2021-09-24 09:26:55',NULL),(2,2,'test',100,100,1,'2021-09-24 09:27:19','2021-09-24 09:27:19',NULL),(3,3,'product3',500,200,50,'2021-09-24 09:28:23','2021-09-25 14:27:00',NULL),(4,3,'test3',50,20,3,'2021-09-24 09:30:34','2021-09-24 09:30:34',NULL),(5,3,'product4',200,200,52,'2021-09-25 07:30:08','2021-09-25 07:30:08',NULL),(6,3,'product5',100,100,100,'2021-09-25 07:33:25','2021-09-25 07:33:25',NULL),(7,3,'product6',50,50,50,'2021-09-25 07:34:58','2021-09-25 15:00:27',NULL),(8,3,'product7',500,500,500,'2021-09-25 07:37:24','2021-09-25 07:37:24',NULL),(9,3,'product8',35,35,35,'2021-09-25 14:27:59','2021-09-25 14:30:06',NULL),(10,3,'product9',15,15,15,'2021-09-25 14:28:52','2021-09-25 15:05:11','2021-09-25 15:05:11'),(11,3,'product10',10,10,10,'2021-09-25 14:29:32','2021-09-25 15:05:11','2021-09-25 15:05:11'),(12,3,'product11',20,20,2000,'2021-09-25 14:29:38','2021-09-25 15:04:36','2021-09-25 15:04:36'),(13,6,'規格1',200,100,10,'2021-10-04 14:51:00','2021-10-04 14:51:00',NULL),(14,6,'規格2',300,150,10,'2021-10-04 14:51:13','2021-10-04 14:51:13',NULL),(15,6,'規格3',500,250,0,'2021-10-04 14:51:24','2021-10-04 14:51:24',NULL);
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
INSERT INTO `product_types` VALUES (1,'test1','2021-09-23 12:34:19','2021-09-23 12:34:19',NULL),(2,'product-type2','2021-09-23 13:58:14','2021-09-23 13:58:14',NULL),(3,'product-type1','2021-09-27 12:43:49','2021-09-27 12:43:49',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,'test1',NULL,'S__111558660.jpg','product/Rv3LRQ0fz9UmUqce9SfqAkSZSm3wlEFtAuxw9TDh.jpg','生鮮配-0456.jpg','product/xirDHMuCU58G4NF0SVwqsYtVHSRFxJVM63l0PvRk.jpg',NULL,'null',1,1,'2021-09-23 00:50:50','2021-10-04 13:46:26',NULL),(2,2,'product2',NULL,'cartoon.png','product/ssZtPvjYsgFgf1zUIF9tfnySIrB2tNYmwPO9STmu.png','生鮮配-0456.jpg','product/YIKVWo1prfHsf4hIdGF1KBjjhjanlldJL1vpWxM9.jpg',NULL,'null',1,1,'2021-09-23 14:11:37','2021-10-04 13:46:56',NULL),(3,2,'product3','<p><strong>test</strong></p>','S__111558660.jpg','product/CueLdbhogo2hM9hArjnAAx4G0SiMefoRX8ovjzJs.jpg','S__111558660.jpg','product/bg6PPyaVwJbIFCAw3xDhs4ulJ2zsbyAYBMuCI7zd.jpg','product3,test,test2','1234567890',0,1,'2021-09-23 14:13:49','2021-10-04 13:47:02',NULL),(4,3,'product-type1-商品',NULL,'cartoon.png','product/HVPsAwIpOPTwbxj3hozsgYJJsMbe694aKkwkzcCm.png','生鮮配-0456.jpg','product/LEUl8JhPynwlpRBhf09ncmD4PUV6Eez4k2UGOFC8.jpg',NULL,'null',0,1,'2021-09-27 12:44:15','2021-10-03 15:22:12',NULL),(5,3,'test2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2021-09-29 09:19:42','2021-09-29 09:19:42',NULL),(6,1,'test3','<p><strong>12345</strong></p>\n\n<p><strong>12345</strong></p>\n\n<p><strong>12345</strong></p>\n\n<p><strong>12345</strong></p>\n\n<p><strong>12345</strong></p>\n\n<p>&nbsp;</p>\n\n<p><strong><img alt=\"\" src=\"data:image/png;base64,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\" style=\"height:221px; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; width:228px\" /></strong></p>','生鮮配-0456.jpg','product/RNBMHCXkmA2av5ruIQl6jPHyNoJm7K2mpKqYSMc9.jpg','S__111558660.jpg','product/TRzmXHrht58NrJ3lK1vERm9Uq2F7MWh1MX0XrjIg.jpg',NULL,'大特賣!!!\nGOOD!!!\nGOOD!!!',0,1,'2021-09-29 09:19:52','2021-10-04 15:21:08',NULL),(7,2,'test4',NULL,'生鮮配-0456.jpg','product/SoDYG1yQ3PfJnEfAw6itXKfkg5vIMGhJCbeyWfl1.jpg','cartoon.png','product/rAnS7JQ8HesYcGYpZiREg6twMzWV8GJm7fjMu7D7.png',NULL,'null',0,1,'2021-09-29 09:20:06','2021-10-04 13:47:11',NULL),(8,1,'test5',NULL,'S__111558660.jpg','product/qGjG4bWE2zEd2XLvNCvh4Z5l8FSedS7IlmEt4Dod.jpg','生鮮配-0456.jpg','product/rgIrMmp267qJf8loeFeD3N6wxZrUXdgdh26JQNVY.jpg',NULL,'null',0,1,'2021-09-29 09:20:14','2021-10-03 15:22:44',NULL),(9,1,'test6',NULL,NULL,NULL,NULL,NULL,NULL,'null',0,1,'2021-09-29 09:20:22','2021-09-29 09:25:11',NULL),(10,1,'test7',NULL,NULL,NULL,NULL,NULL,NULL,'null',0,1,'2021-09-29 09:20:35','2021-09-29 09:25:17',NULL),(11,2,'test8',NULL,NULL,NULL,NULL,NULL,NULL,'null',0,1,'2021-09-29 09:20:46','2021-09-29 09:26:14',NULL),(12,3,'1009測試商品',NULL,'pic1.jpg','product/lV7crazStDkVcfpSh7zhXiQIoG7RzROW5LwBUkIK.jpg',NULL,NULL,NULL,NULL,1,1,'2021-10-09 15:30:18','2021-10-09 15:30:18',NULL),(13,3,'1009測試商品2',NULL,'生鮮配-0456.jpg','product/BHyIJ71r3ITMeyhEWDotpHReFnAmM7qDDYkNTSHx.jpg',NULL,NULL,NULL,NULL,1,1,'2021-10-09 15:31:09','2021-10-09 15:31:09',NULL);
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
INSERT INTO `put_ons` VALUES (1,1,1,NULL,NULL,0,'2021-09-28 13:13:02','2021-09-28 13:38:29','2021-09-28 13:38:29'),(2,1,2,NULL,NULL,1,'2021-09-28 13:13:02','2021-09-28 13:38:29','2021-09-28 13:38:29'),(3,1,3,NULL,NULL,2,'2021-09-28 13:13:02','2021-09-28 13:38:29','2021-09-28 13:38:29'),(4,2,4,NULL,NULL,1,'2021-09-28 13:37:17','2021-10-10 15:44:37',NULL),(5,1,1,NULL,NULL,0,'2021-09-28 13:39:46','2021-09-28 13:41:13','2021-09-28 13:41:13'),(6,1,2,NULL,NULL,1,'2021-09-28 13:39:46','2021-09-28 13:41:13','2021-09-28 13:41:13'),(7,1,3,NULL,NULL,2,'2021-09-28 13:39:47','2021-09-28 13:41:13','2021-09-28 13:41:13'),(8,1,1,NULL,NULL,0,'2021-09-28 13:42:32','2021-09-28 14:10:35','2021-09-28 14:10:35'),(9,1,2,NULL,NULL,0,'2021-09-28 14:09:32','2021-09-28 14:10:35','2021-09-28 14:10:35'),(10,1,3,NULL,NULL,0,'2021-09-28 14:09:32','2021-09-29 12:44:53','2021-09-29 12:44:53'),(11,1,4,NULL,NULL,1,'2021-09-28 14:10:29','2021-10-03 15:13:32',NULL),(12,1,1,NULL,NULL,0,'2021-09-28 14:10:52','2021-09-29 12:44:54','2021-09-29 12:44:54'),(13,1,6,NULL,NULL,1,'2021-09-29 09:25:35','2021-10-03 15:13:32',NULL),(14,1,8,NULL,NULL,1,'2021-09-29 09:25:36','2021-10-03 15:13:32',NULL),(15,1,9,NULL,NULL,1,'2021-09-29 09:25:37','2021-10-03 15:13:32',NULL),(16,1,10,NULL,NULL,1,'2021-09-29 09:25:38','2021-10-03 15:13:32',NULL),(17,1,2,NULL,NULL,0,'2021-09-29 09:25:38','2021-09-29 12:44:54','2021-09-29 12:44:54'),(18,1,7,NULL,NULL,0,'2021-09-29 09:25:38','2021-09-29 12:44:54','2021-09-29 12:44:54'),(19,1,5,NULL,NULL,0,'2021-09-29 09:25:38','2021-09-29 12:44:00','2021-09-29 12:44:00'),(20,1,11,NULL,NULL,0,'2021-09-29 09:26:30','2021-09-29 09:29:24','2021-09-29 09:29:24'),(21,1,11,NULL,NULL,0,'2021-09-29 09:30:26','2021-09-29 09:30:49','2021-09-29 09:30:49'),(22,1,11,NULL,NULL,0,'2021-09-29 09:36:09','2021-09-29 09:36:18','2021-09-29 09:36:18'),(23,1,11,NULL,NULL,0,'2021-09-29 12:32:57','2021-09-29 12:44:54','2021-09-29 12:44:54'),(24,2,3,NULL,NULL,1,'2021-09-29 12:45:04','2021-10-10 15:44:37',NULL),(25,2,2,NULL,NULL,1,'2021-09-29 12:45:04','2021-10-10 15:44:37',NULL),(26,1,1,NULL,NULL,1,'2021-09-29 12:57:07','2021-10-03 15:13:32',NULL),(27,1,2,NULL,NULL,1,'2021-09-29 12:57:08','2021-10-03 15:13:32',NULL),(28,1,3,NULL,NULL,1,'2021-09-29 12:57:09','2021-10-03 15:13:32',NULL),(29,1,7,NULL,NULL,1,'2021-09-29 12:57:10','2021-10-03 15:13:32',NULL),(30,1,11,NULL,NULL,1,'2021-09-29 12:57:11','2021-10-03 15:13:32',NULL),(31,1,5,NULL,NULL,1,'2021-09-29 12:57:12','2021-09-29 13:49:13',NULL),(32,1,12,NULL,NULL,1,'2021-10-09 15:30:28','2021-10-09 15:30:45',NULL),(33,1,13,NULL,NULL,1,'2021-10-09 15:31:19','2021-10-09 15:31:26',NULL),(34,3,4,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL),(35,3,5,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL),(36,3,12,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL),(37,3,13,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL),(38,3,2,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL),(39,3,7,NULL,NULL,1,'2021-10-10 15:44:55','2021-10-10 15:45:01',NULL);
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

-- Dump completed on 2021-10-11 22:46:48