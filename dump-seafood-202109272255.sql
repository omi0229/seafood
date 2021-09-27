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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cooking_types`
--

LOCK TABLES `cooking_types` WRITE;
/*!40000 ALTER TABLE `cooking_types` DISABLE KEYS */;
INSERT INTO `cooking_types` VALUES (1,'cooking1','2021-09-25 17:02:16','2021-09-25 17:02:16',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directories`
--

LOCK TABLES `directories` WRITE;
/*!40000 ALTER TABLE `directories` DISABLE KEYS */;
INSERT INTO `directories` VALUES (1,'directory1','2021-09-25 16:57:13','2021-09-25 16:57:13',NULL),(2,'directory2','2021-09-25 16:58:56','2021-09-25 16:58:56',NULL),(3,'directory3','2021-09-25 16:59:01','2021-09-25 16:59:01',NULL),(4,'directory4','2021-09-25 16:59:05','2021-09-25 16:59:05',NULL),(5,'directory5','2021-09-25 16:59:08','2021-09-25 16:59:08',NULL),(6,'directory6','2021-09-25 16:59:12','2021-09-25 16:59:12',NULL),(7,'directory7','2021-09-25 16:59:26','2021-09-25 16:59:26',NULL),(8,'directory8','2021-09-25 16:59:30','2021-09-25 17:02:46','2021-09-25 17:02:46'),(9,'directory9','2021-09-25 16:59:34','2021-09-25 16:59:34',NULL),(10,'directory10','2021-09-25 16:59:37','2021-09-25 16:59:37',NULL),(11,'directory11','2021-09-25 16:59:40','2021-09-25 16:59:40',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (59,'2014_10_12_000000_create_users_table',1),(60,'2014_10_12_100000_create_password_resets_table',1),(61,'2016_06_01_000001_create_oauth_auth_codes_table',1),(62,'2016_06_01_000002_create_oauth_access_tokens_table',1),(63,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(64,'2016_06_01_000004_create_oauth_clients_table',1),(65,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(66,'2019_08_19_000000_create_failed_jobs_table',1),(67,'2019_12_14_000001_create_personal_access_tokens_table',1),(68,'2021_09_07_130852_create_permission_tables',1),(70,'2021_09_10_161057_create_config_table',2),(97,'2021_09_11_225050_create_news_types_table',3),(98,'2021_09_11_225633_create_news_table',3),(99,'2021_09_16_225751_create_cooking_types_table',3),(100,'2021_09_16_225841_create_cooking_table',3),(101,'2021_09_21_231939_create_product_types_table',3),(102,'2021_09_21_232050_create_products_table',3),(103,'2021_09_22_221925_create_product_specifications_table',4),(104,'2021_09_26_004328_create_directories_table',5),(106,'2021_09_26_154842_create_put_ons_table',6);
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
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '設為跑馬燈顯示(0 => 不顯示, 1 => 顯示)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_news_types_id_index` (`news_types_id`),
  KEY `news_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,1,'test1','2021-09-23 22:22:00','2021-09-30 22:22:00','href','<p><strong>test1</strong></p>','123',NULL,NULL,NULL,NULL,0,0,'2021-09-23 14:22:28','2021-09-23 14:22:32',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_types`
--

LOCK TABLES `news_types` WRITE;
/*!40000 ALTER TABLE `news_types` DISABLE KEYS */;
INSERT INTO `news_types` VALUES (1,'test1','2021-09-23 14:22:05','2021-09-23 14:22:05',NULL);
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
INSERT INTO `oauth_access_tokens` VALUES ('01af7e627d2484d3beed145cf5f5d265c4572efeb5569a87088f8e6325e228d25f5bd749278c9e13',1,1,'web','[]',0,'2021-09-12 15:56:21','2021-09-12 15:56:21','2021-09-13 01:56:21'),('0305e1fd08b58a779f4a19c98532de6d75b3b60698ec01260166125de16186986489994e5add0758',1,1,'web','[]',1,'2021-09-11 15:01:11','2021-09-11 15:01:14','2021-09-12 01:01:11'),('0321e36ab6c54fb5ba96a2f02cae4e0ab991734a5abd58e566067a248e37cd3b4e2acd0cfa0c8a0c',1,1,'web','[]',0,'2021-09-11 15:00:42','2021-09-11 15:00:42','2021-09-12 01:00:42'),('032ca3bc0a5cd947427258b9566399d2d7de734160568f67c70a21c2b10b98ef2900a2cc2866239c',1,1,'web','[]',1,'2021-09-10 14:53:21','2021-09-23 14:37:36','2021-09-11 00:53:22'),('070088d3bacbfe2a22a20f87ec11adb95aa9949a9897eeb2a95cd168728883c85f7642ebc4a33c51',1,1,'web','[]',1,'2021-09-24 09:11:46','2021-09-24 09:19:08','2021-09-24 19:11:46'),('0bb2766900fbcc983f284cb5c56af0ba8da57a29c9d29164eebe499a2aa24f5a9c4b6298803b579c',6,1,'web','[]',1,'2021-09-09 09:34:19','2021-09-09 09:34:48','2021-09-09 19:34:20'),('0e1fe67c16c982de984ea04e6fb3fb5db71b62da2570d47cb87e1dd4cf837f854364aebd9736373f',1,1,'web','[]',1,'2021-09-08 14:39:23','2021-09-08 14:39:51','2021-09-09 00:39:23'),('16687fc35570fed23327014b4caef403528d5a67baecffda05ce3682f90b6498a509275ca7c857f6',1,1,'web','[]',0,'2021-09-17 09:37:28','2021-09-17 09:37:28','2021-09-17 19:37:28'),('16f2e339085b5967dc9acc43bdabe0e395e0a580044195884c8ec3b837551de4b0d88cee2dd7877f',1,1,'web','[]',0,'2021-09-16 15:12:38','2021-09-16 15:12:39','2021-09-17 01:12:39'),('1ef3a529c346441b368520d7c8a56d3eb0af99c22ec4a1aab45306d3e274ab7bd2a990cf7a295e57',1,1,'web','[]',1,'2021-09-09 09:30:52','2021-09-09 09:34:14','2021-09-09 19:30:53'),('1f1dbda287cac52bc4bcf090942405198e011764c513e15c07db00083938998934753ed34878c9f7',6,1,'web','[]',1,'2021-09-08 14:43:40','2021-09-08 14:44:27','2021-09-09 00:43:40'),('212aa580e74247356500629e2583c51d2761f24b7c2621e0c06f40232b6e4b2c4c9e631cb2f10d30',1,1,'web','[]',1,'2021-09-16 15:08:24','2021-09-16 15:08:42','2021-09-17 01:08:25'),('2c9dd06edeb6d47d94724f91f90a6b0157b5d758b5ba86da2443634f951fb5b6b8c5790ca7dc206d',1,1,'web','[]',0,'2021-09-21 15:08:57','2021-09-21 15:08:57','2021-09-22 01:08:57'),('2d0df6d3e9db1c6dcc8546b4886b7d7f7be01460a4e3882c8c050fb2d8db312cb05d3d3714609ea5',1,1,'web','[]',1,'2021-09-11 14:58:24','2021-09-11 15:00:27','2021-09-12 00:58:24'),('2da5f751e49fe494ddfa11ffe684bb2d3fb06d7a69d73fea50334cafb377724542368e5747db8261',1,1,'web','[]',0,'2021-09-12 09:19:16','2021-09-12 09:19:16','2021-09-12 19:19:16'),('32d076cdc7797ea66a0478a655f2f3a9e1fab2612e1c874f1bd4d15240e09685ce28f4821b49ed0a',1,1,'web','[]',0,'2021-09-23 12:32:40','2021-09-23 12:32:40','2021-09-23 22:32:40'),('37b30a35fbf9812434ac18b1457387c97bd84ec4876cc2edcffb3389f460132e425b7fad08c66d20',6,1,'web','[]',1,'2021-09-08 14:39:57','2021-09-08 14:40:31','2021-09-09 00:39:57'),('3b92b464f479300d53874e3107fd3a6055a336690c23409f394196e6a2065b451038f2e5f1bee457',1,1,'web','[]',0,'2021-09-12 09:19:24','2021-09-12 09:19:24','2021-09-12 19:19:24'),('3cb6d20d59762fc0a0f63a60957203b731c78969ff899a6fe692de09b2594e10e9ef69d6b9738dd8',1,1,'web','[]',0,'2021-09-16 16:02:46','2021-09-16 16:02:47','2021-09-17 02:02:47'),('407f12f62b13e3cc947410b07bdbfec8f701db8c191d0f77ec0847162a623027a038936dfeb30cea',1,1,'web','[]',1,'2021-09-22 13:15:09','2021-09-22 15:56:01','2021-09-22 23:15:09'),('4398267a9c616dbac8ef6ed03005b6039cf691c8a622f40bc06ac3eeb96159b86790692827f3f4c6',1,1,'web','[]',1,'2021-09-25 06:40:27','2021-09-25 07:34:18','2021-09-25 16:40:28'),('4ac60479342dd9e1645245b8ee5b2bde235efae0966ace18da06de47939bbf13cf4994201304bcb0',1,1,'web','[]',0,'2021-09-09 08:30:14','2021-09-09 08:30:14','2021-09-09 18:30:14'),('4c2aeca3a8a5da6bf1376c1b10cdb4548bd007d427bcb8a4689507fde5b18f07e3dca0036d62b9ec',1,1,'web','[]',0,'2021-09-09 09:34:54','2021-09-09 09:34:54','2021-09-09 19:34:54'),('4e65fb192ecc1cfa1d29c8271b2e287768f4bdcdd08382104a9543fad51c7b40ade6aafac60ac1fd',1,1,'web','[]',0,'2021-09-16 15:11:45','2021-09-16 15:11:45','2021-09-17 01:11:45'),('547d7bf67bd0ea6a3bd9c5a174e5b7857196accc469c15fa9e224ec048378916b409cf7c7db2df62',1,1,'web','[]',1,'2021-09-15 06:05:37','2021-09-15 08:07:08','2021-09-15 16:05:37'),('55d2011cdee2ee53a54fa1a11e1996803e75dab21929b681196e60f455cf443a2ed04c0176c3608f',1,1,'web','[]',1,'2021-09-25 16:38:27','2021-09-25 16:38:54','2021-09-26 02:38:27'),('5ba2c5825d048e217b67c69ec34e123d620ab78978e30e4a504b950b407ecbaa565775ed34b2f8ef',1,1,'web','[]',1,'2021-09-22 15:56:06','2021-09-22 15:56:31','2021-09-23 01:56:06'),('5ddc8795c34056297894ab14b18aa58d190e69a55c2c29271b7ad4e3066ab110768d37bcd2834e3e',1,1,'web','[]',1,'2021-09-08 14:44:37','2021-09-08 14:44:52','2021-09-09 00:44:37'),('5e2af4d9a776ad2056e4220121aeb97f3c53f0dc4b0affa8587bf58c15f528e764019ac715ab078c',1,1,'web','[]',0,'2021-09-25 16:38:57','2021-09-25 16:38:57','2021-09-26 02:38:57'),('62db6bda72a0ed6d8d2e01ae55bea6580456221909bcca5fe74453ef8cd137d9a1480d9b4b9382ac',1,1,'web','[]',0,'2021-09-25 07:34:41','2021-09-25 07:34:41','2021-09-25 17:34:41'),('69be433b8524f1b518032206ff07e60ea58daca5ed453b7508de6ce3a55c89a1880fc49ed59d2698',6,1,'web','[]',1,'2021-09-08 14:44:56','2021-09-08 14:45:19','2021-09-09 00:44:56'),('714c25712ac6e0d14e66eb1bf1f2225e832bc165e46aa3033d7e0509abb06e217b458621f7fff118',1,1,'web','[]',0,'2021-09-24 09:22:07','2021-09-24 09:22:08','2021-09-24 19:22:08'),('77d3689535db4482aca4c6a1c3f1ec93f394b7bceac6c947e52bb76e847f159c0d2a750223e06b56',1,1,'web','[]',1,'2021-09-27 12:39:35','2021-09-27 14:40:26','2021-09-27 22:39:35'),('7da98536470fc357a0e43f1d546c33ba814cc2eb5a2587afaba956feb61fab177685251e4c0749c1',6,1,'web','[]',1,'2021-09-11 14:48:47','2021-09-11 14:48:53','2021-09-12 00:48:48'),('7ddc0ed7d2b5c707640125d94dbc6c88b4255c98f49719b6952e41c72c4d1dd2060e406f2f24590d',1,1,'web','[]',0,'2021-09-14 14:26:02','2021-09-14 14:26:03','2021-09-15 00:26:03'),('7e23673c0ded50f79ca18e5a598d2fae5441d1c1e28ec39251af15b2b36ba2fbcb3f7a95e1c24559',1,1,'web','[]',0,'2021-09-17 08:07:30','2021-09-17 08:07:30','2021-09-17 18:07:30'),('85af61d60686cebcab45d66d1784635cd06d1f48de0e74c4696dc241d6ad6196411f4ea511c5c3e9',1,1,'web','[]',1,'2021-09-16 15:11:30','2021-09-16 15:11:42','2021-09-17 01:11:31'),('88a8e2d68b3655220cb48fdd97af95d9de3cdcd728c9581e64bcb597e3c4f405a404fccf54b9b9db',1,1,'web','[]',1,'2021-09-15 03:57:48','2021-09-15 06:05:32','2021-09-15 13:57:48'),('8ebcd7b8da69e5c6c2f416799a8710467ccd7c698f0104020bbad846902e83be2374f644d7c35f57',6,1,'web','[]',1,'2021-09-08 14:42:41','2021-09-08 14:43:34','2021-09-09 00:42:41'),('97d813b904afc01b3c1e590836ce2ed510ecd656eb0e0eec3d6d8628fed4c4c30f7942b848cd79b4',1,1,'web','[]',1,'2021-09-10 08:59:20','2021-09-10 09:37:55','2021-09-10 18:59:20'),('996e00448c7882df24ca0a551af0e974fb81cf5319c7d8c59d147834bd637242e62dd48d397623d9',1,1,'web','[]',0,'2021-09-17 01:06:00','2021-09-17 01:06:01','2021-09-17 11:06:01'),('9a1d8a0baf7c75df28abf9cffb3800dc4f63cb2295cb3dda85739a19a022b48fa8420045b20471ad',1,1,'web','[]',1,'2021-09-12 13:55:35','2021-09-12 15:56:15','2021-09-12 23:55:35'),('9e4819025d7a7af3f5b131854c34ce0fc416c45481b8832cb780aac871982a81cd95e9d728983df6',1,1,'web','[]',0,'2021-09-12 04:00:02','2021-09-12 04:00:02','2021-09-12 14:00:02'),('a0bc5174b443dc9868219f28b5e46a2a92366c83abb652bf0b4e917c3597d005d416adeca82fa383',1,1,'web','[]',0,'2021-09-26 13:03:17','2021-09-26 13:03:17','2021-09-26 23:03:17'),('b08dee864330dbbf4867864cbe7381e9698b7b4ea9a013ae3abf5bb8a63c1c73bb9e5818af5158be',1,1,'web','[]',0,'2021-09-10 08:09:42','2021-09-10 08:09:43','2021-09-10 18:09:43'),('b2b592842e45efad7ba5888d54065d0161847062424727aa22727f7dacd53a8024fe2e6b730ee09b',1,1,'web','[]',0,'2021-09-11 15:02:24','2021-09-11 15:02:24','2021-09-12 01:02:24'),('b4fe45aa2a549b5aa157e19913010404457ff1ae8d155060e114edb59f88b593f615b17e3f607f01',1,1,'web','[]',1,'2021-09-08 14:38:46','2021-09-08 14:39:09','2021-09-09 00:38:46'),('b58fc2f69b749a694af01991a5986de3c5bb2ab98c0e2f7592bc5be1add26a789c3d8b5f4aba5f01',1,1,'web','[]',0,'2021-09-11 14:48:59','2021-09-11 14:48:59','2021-09-12 00:48:59'),('b677c901b2d1746e990fa8e13c83378a94347618a9f427a0abc2889dcb3ac91048ddd383275ed12d',1,1,'web','[]',0,'2021-09-25 14:23:12','2021-09-25 14:23:12','2021-09-26 00:23:12'),('b9c7a4661d13cc77a8f3abdbb8c29f4deebb88dd5aff061af7e05e66655f2b3fa5aebc8c56fe1bad',6,1,'web','[]',0,'2021-09-16 15:08:57','2021-09-16 15:08:57','2021-09-17 01:08:57'),('babfcfc8e56d5778778080cf3573737071b9f83a1674db3f63a97ee32bb2c4904b64a48402b3c022',1,1,'web','[]',0,'2021-09-25 07:34:22','2021-09-25 07:34:22','2021-09-25 17:34:22'),('bbf9436c6ef92d1e537a9fc7682e6b1ab88e955c72b134163332edfd8e049cd0b3b19ffa6061754b',1,1,'web','[]',0,'2021-09-08 15:19:26','2021-09-08 15:19:26','2021-09-09 01:19:26'),('be72e8534d5e0a002fafdde254f6fe2e7e217233c97c66882ecba625374e00caa875369451be4df9',1,1,'web','[]',0,'2021-09-16 15:13:17','2021-09-16 15:13:17','2021-09-17 01:13:17'),('bf414e4ceca5ec33126e84be55e2d8ca8085d00d4a556b048e0ee5a7e76002a27bf21234c4d3f629',1,1,'web','[]',0,'2021-09-27 14:40:30','2021-09-27 14:40:30','2021-09-28 00:40:30'),('c1310184a60eeea0a75d5cbb400eea00aab84d1c8d400f236cb7916efb4aaf198ad9805db9a32c14',1,1,'web','[]',0,'2021-09-23 14:37:55','2021-09-23 14:37:55','2021-09-24 00:37:55'),('c1e4c887596752204033c031bad5406faac8e2191b6efca2cc1d0fcf99881c6e93d6b14bd0f2b106',1,1,'web','[]',0,'2021-09-26 07:43:18','2021-09-26 07:43:18','2021-09-26 17:43:18'),('c50d89a9b45c7e4ad602d21f4a45b31d1a9cb449599f0203e2649135ba5b6e4df129c6d884f21505',1,1,'web','[]',0,'2021-09-21 14:59:18','2021-09-21 14:59:19','2021-09-22 00:59:19'),('c76f5ed991c37c04b60e6e83d9edce07a128fb6a71d98e080a9a4e0cc5f0cad46eb9beebf42d8687',1,1,'web','[]',0,'2021-09-16 15:15:13','2021-09-16 15:15:13','2021-09-17 01:15:13'),('c953f5a5f63cfef4fd1f27249f24c34c21bdc17c662dcaa3e14a854c8a3e95fc759e491cfc63b995',1,1,'web','[]',0,'2021-09-15 08:07:12','2021-09-15 08:07:12','2021-09-15 18:07:12'),('ca011d14c86c0989868dc0e1b07e5d9cc2fa280cbc1001942c6799f144c7e5eb059356b65c4a07e3',1,1,'web','[]',0,'2021-09-16 15:10:11','2021-09-16 15:10:11','2021-09-17 01:10:11'),('cca0ceaf7489a52ed8e0b4945e4c1d3455b37e0e7ccde20d49950b118d07708bbb0f24d22424a4a6',1,1,'web','[]',0,'2021-09-12 09:00:10','2021-09-12 09:00:11','2021-09-12 19:00:11'),('d012858e6c523f8459644670a315b5a4e3c7e06eb005d35a39d3f5780a7cf3defb95f21d9205c23c',1,1,'web','[]',0,'2021-09-17 00:49:00','2021-09-17 00:49:00','2021-09-17 10:49:00'),('d17259f1393c0b59db6bdcac52629471d6634184962f94fe6fb29976983fa315f6d4d30d6484d90d',1,1,'web','[]',0,'2021-09-15 13:44:23','2021-09-15 13:44:23','2021-09-15 23:44:23'),('d9f9679050a33e218570bd729d0de5ab0d8e8fd45b3fe9e1cccbd1f76d7fb09076e625efd213991c',1,1,'web','[]',0,'2021-09-16 15:09:44','2021-09-16 15:09:45','2021-09-17 01:09:45'),('e4923f347b850d2a305b2d6e0bafa5e37f4f73caa38a671e1de328b785acc8f4bfa2c8904a3c56af',1,1,'web','[]',0,'2021-09-10 13:04:11','2021-09-10 13:04:12','2021-09-10 23:04:12'),('e61e61d26a359d042a663c3b63c043932887e909f09d4079623a304debb331c62e27f8f4151310d9',1,1,'web','[]',0,'2021-09-16 14:23:51','2021-09-16 14:23:52','2021-09-17 00:23:52'),('e6a4fbde8e2d6bd3e2c5635f57a1a950d651e9616eae7dad1fe3bec7cd5a88b2779613b92dd8c3ed',6,1,'web','[]',0,'2021-09-09 09:36:55','2021-09-09 09:36:55','2021-09-09 19:36:55'),('e756a2b679af71c7fcc3f7caa7c56cede7755153d0cbec4758dee65ccacea53c77c072afc9ac4927',2,1,'web','[]',0,'2021-09-08 14:45:25','2021-09-08 14:45:25','2021-09-09 00:45:25'),('f5a784c2f3c57e404e23d30d2c9880246c3f3b1dcdd2284614cce91b53fbeadc91d923faad08033d',1,1,'web','[]',0,'2021-09-17 00:49:33','2021-09-17 00:49:33','2021-09-17 10:49:33'),('f70d1c9f190d3aa0c13985af639d9083179f9745944eb71e742c6ca72932f777ffeaa16a84169a3d',1,1,'web','[]',0,'2021-09-16 12:22:22','2021-09-16 12:22:23','2021-09-16 22:22:23'),('f7813d5a4b76ef46dc8deef6b46463a1d66e9f613b4d328513d749c60d8a29c9fe02e65299970def',1,1,'web','[]',0,'2021-09-16 15:16:04','2021-09-16 15:16:04','2021-09-17 01:16:04'),('faad062e503ade076f64b08786cd6a950ea99ae9539c739358d588b2c0dd60935b0586c2a00050b5',1,1,'web','[]',0,'2021-09-08 14:41:07','2021-09-08 14:41:07','2021-09-09 00:41:07');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'set_basic','web','基本設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(2,'set_manager','web','人員管理','2021-09-08 13:59:43','2021-09-08 13:59:43'),(3,'set_message','web','簡訊設定','2021-09-08 13:59:43','2021-09-08 13:59:43'),(4,'news-type','web','最新消息分類','2021-09-10 14:52:43','2021-09-10 14:52:43'),(5,'news','web','最新消息管理','2021-09-10 14:52:43','2021-09-10 14:52:43'),(6,'cooking-type','web','烹飪教學分類','2021-09-16 02:50:00','2021-09-16 02:50:00'),(7,'cooking','web','烹飪教學管理','2021-09-16 02:50:00','2021-09-16 02:50:00'),(9,'product-type','web','產品分類','2021-09-21 15:00:00','2021-09-21 15:00:00'),(10,'product','web','產品管理','2021-09-21 15:00:00','2021-09-21 15:00:00'),(11,'directory','web','目錄管理','2021-09-25 16:00:00','2021-09-25 16:00:00'),(12,'put-on','web','上架管理','2021-09-25 16:00:00','2021-09-25 16:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specifications`
--

LOCK TABLES `product_specifications` WRITE;
/*!40000 ALTER TABLE `product_specifications` DISABLE KEYS */;
INSERT INTO `product_specifications` VALUES (1,1,'1',1,1,1,'2021-09-24 09:26:55','2021-09-24 09:26:55',NULL),(2,2,'test',100,100,1,'2021-09-24 09:27:19','2021-09-24 09:27:19',NULL),(3,3,'product3',500,200,50,'2021-09-24 09:28:23','2021-09-25 14:27:00',NULL),(4,3,'test3',50,20,3,'2021-09-24 09:30:34','2021-09-24 09:30:34',NULL),(5,3,'product4',200,200,52,'2021-09-25 07:30:08','2021-09-25 07:30:08',NULL),(6,3,'product5',100,100,100,'2021-09-25 07:33:25','2021-09-25 07:33:25',NULL),(7,3,'product6',50,50,50,'2021-09-25 07:34:58','2021-09-25 15:00:27',NULL),(8,3,'product7',500,500,500,'2021-09-25 07:37:24','2021-09-25 07:37:24',NULL),(9,3,'product8',35,35,35,'2021-09-25 14:27:59','2021-09-25 14:30:06',NULL),(10,3,'product9',15,15,15,'2021-09-25 14:28:52','2021-09-25 15:05:11','2021-09-25 15:05:11'),(11,3,'product10',10,10,10,'2021-09-25 14:29:32','2021-09-25 15:05:11','2021-09-25 15:05:11'),(12,3,'product11',20,20,2000,'2021-09-25 14:29:38','2021-09-25 15:04:36','2021-09-25 15:04:36');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,'test1',NULL,NULL,NULL,NULL,NULL,NULL,'null',1,1,'2021-09-23 00:50:50','2021-09-27 12:44:36',NULL),(2,2,'product2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2021-09-23 14:11:37','2021-09-23 14:11:37',NULL),(3,2,'product3','<p><strong>test</strong></p>',NULL,NULL,'S__111558660.jpg','product/bg6PPyaVwJbIFCAw3xDhs4ulJ2zsbyAYBMuCI7zd.jpg','product3,test,test2','1234567890',0,1,'2021-09-23 14:13:49','2021-09-27 12:44:32',NULL),(4,3,'product-type1-商品',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1,'2021-09-27 12:44:15','2021-09-27 12:44:15',NULL);
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
  `start_date` datetime NOT NULL COMMENT '開始上架時間',
  `end_date` datetime NOT NULL COMMENT '下架時間',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '上架狀態(0 => 下架, 1 => 上架-不依據時間上下架, 2 => 上架-依據時間上下架)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `put_ons_directories_id_index` (`directories_id`),
  KEY `put_ons_product_id_index` (`product_id`),
  KEY `put_ons_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(9,1),(10,1),(11,1),(12,1),(1,2),(1,3),(2,3),(3,3),(2,4);
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

-- Dump completed on 2021-09-27 22:56:00
