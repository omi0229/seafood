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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (46,'2014_10_12_000000_create_users_table',1),(47,'2014_10_12_100000_create_password_resets_table',1),(48,'2016_06_01_000001_create_oauth_auth_codes_table',1),(49,'2016_06_01_000002_create_oauth_access_tokens_table',1),(50,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(51,'2016_06_01_000004_create_oauth_clients_table',1),(52,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(53,'2019_08_19_000000_create_failed_jobs_table',1),(54,'2019_12_14_000001_create_personal_access_tokens_table',1),(58,'2021_09_07_130852_create_permission_tables',2);
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
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
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
INSERT INTO `oauth_access_tokens` VALUES ('03c194723438e7173f83fe05e477d8ca183fb505b58147f2af656c99095968a6b34e04ef1291e590',3,1,'web','[]',1,'2021-09-06 05:26:32','2021-09-06 05:26:36','2021-09-06 15:26:33'),('1679ba63dda72a3e41da4ac6923a1e807c95f31615f65852f82b4d6f0912ee78f36af769f0f9f499',1,1,'web','[]',1,'2021-09-07 13:55:55','2021-09-07 13:56:36','2021-09-07 23:55:56'),('1e42da1f5841c335e23e59caa2f8e59fe7aad493c331957ef2b820a36cf013376d9c95c9f9f8cc51',1,1,'web','[]',0,'2021-09-07 14:24:29','2021-09-07 14:24:29','2021-09-08 00:24:29'),('2449645a3e64a3064f0e5eb9737ec651aa33923f5196f67def7b88ad9158e36be204acb9a39671cf',3,1,'web','[]',1,'2021-09-06 08:44:05','2021-09-06 09:02:14','2021-09-06 18:44:06'),('36f947dee77a05488bc4b6d4706c0cbeea7b0c747f06503061e955bf6a8bc76c0dae6401772a0ab2',2,1,'web','[]',0,'2021-09-07 14:28:01','2021-09-07 14:28:01','2021-09-08 00:28:01'),('3da27c340e4fd6d7024dcd7a6e406fd2229e8baf000b2f02a49bdd9d6bb0ddfc28a4cf6d878c08d4',2,1,'web','[]',0,'2021-09-07 07:12:07','2021-09-07 07:12:07','2021-09-07 17:12:07'),('419071ac6f07e9c9ee4a02adf3d2162863b037d82dc2aee400aedba9506b1170b35a511fb2498e66',2,1,'web','[]',1,'2021-09-06 05:07:18','2021-09-06 05:26:23','2021-09-06 15:07:19'),('42666ef09ff07fdbc6ff105ce91e7d58852db5a3917952576296cdf6ea9dd6ff9e10bda16dd8ad00',104,1,'web','[]',0,'2021-09-06 09:41:20','2021-09-06 09:41:20','2021-09-06 19:41:20'),('44b4592559c77e714d3b480a8235d144beb948d2a39da31d8bb0f7a3c0f191bbe4026f9977150269',1,1,'web','[]',1,'2021-09-06 09:02:19','2021-09-06 09:03:47','2021-09-06 19:02:19'),('57c8c97a16d4ddddd84c130d644e69088951857e62c29ca170b449f0e9038aadba3cc42f663739ab',107,1,'web','[]',0,'2021-09-06 13:36:49','2021-09-06 13:36:49','2021-09-06 23:36:49'),('5b59735a4a47eb723e8bad54af03e857a9b8dd4d200e7bd3df2f6687ef7d1bea38a156174597db87',2,1,'web','[]',1,'2021-09-07 14:23:33','2021-09-07 14:24:22','2021-09-08 00:23:34'),('6fdabb86b6f5f946968775ff17324073ddc509b52ab7022b266f5c7857db7311feb0186b48ece943',3,1,'web','[]',1,'2021-09-06 05:26:48','2021-09-06 05:27:02','2021-09-06 15:26:49'),('7860c837eb8173aeb5b9cccf2af615d18373c2a68b45411ed15cb0c246e9038bb6bd9e4e04c162f8',1,1,'web','[]',0,'2021-09-06 03:02:21','2021-09-06 03:02:22','2021-09-06 13:02:22'),('7c6ba745f8ea18edda61790a29047e869d704d9a13a5ab25f7a91c593833de062414759c5d4e5215',2,1,'web','[]',0,'2021-09-06 07:20:47','2021-09-06 07:20:48','2021-09-06 17:20:48'),('870e8e4541c6c1c8c9b9569db43797ea57d055f3ce4c08115616a8618aae1ce61d5dfa1c0a3389e2',2,1,'web','[]',1,'2021-09-07 14:20:14','2021-09-07 14:20:34','2021-09-08 00:20:14'),('87a57c2d71c19801dd267471307d3951594330a70438d584c94491d319161c25ec6d02c77e44ec03',1,1,'web','[]',1,'2021-09-07 14:02:37','2021-09-07 14:20:08','2021-09-08 00:02:38'),('8c7efc06ddd29f52f630a052e363c84adae3a2bdd0a2d64b597db2f8915275b4fafb9ff3cf05dde9',1,1,'web','[]',0,'2021-09-06 05:32:13','2021-09-06 05:32:14','2021-09-06 15:32:14'),('9219aefbfeb639f1ed2ba9664ae7c296cb16ffc911a513c1982275a31669f05c98a6ecd629efa5be',2,1,'web','[]',1,'2021-09-07 12:39:03','2021-09-07 13:22:13','2021-09-07 22:39:03'),('a063da298fc889884e2de1f002b993fb5d074edab075755e45aa28d27329ab0f8dee9333aa66cdb8',104,1,'web','[]',1,'2021-09-06 11:38:27','2021-09-06 11:39:21','2021-09-06 21:38:27'),('a0c6ce2eddb3e3b6b16cbb567b1c7c85f7ebbccade97b1b6fa373c99e8fee23de1da70b192e08fb0',2,1,'web','[]',0,'2021-09-07 14:20:47','2021-09-07 14:20:47','2021-09-08 00:20:47'),('a8d5aa1885c73ccf83248ba9b5fe3a369a51af38426f510470d45bc2ce7b1715d01b3abdee3a4db9',1,1,'web','[]',1,'2021-09-06 03:27:20','2021-09-06 05:07:13','2021-09-06 13:27:20'),('aa44a7d326192ae0518e88f052f0786ef5cefb3b8c5b7333d227be8b490de23c4012b9dd42d5e26f',2,1,'web','[]',0,'2021-09-07 05:10:35','2021-09-07 05:10:35','2021-09-07 15:10:35'),('c0ee0a4f047dcc6d385fc0af2bfc29ee7c805003c3ade37bcf2fd73966335433ab20e046a3be9d6c',2,1,'web','[]',0,'2021-09-06 08:04:17','2021-09-06 08:04:18','2021-09-06 18:04:18'),('c40946551e1d3c05ef43e5fddc5044345bf920e0386069219f3abb4ef888f077a90b2d6f57144b99',92,1,'web','[]',0,'2021-09-06 11:40:44','2021-09-06 11:40:44','2021-09-06 21:40:44'),('c51401307852762a55645a29370df98bbafddb10d105c12f91cb1a88082b9b0cfebc8fe2e2385493',2,1,'web','[]',0,'2021-09-07 14:21:41','2021-09-07 14:21:42','2021-09-08 00:21:42'),('dfed6b1b1dd75ce1b9bfc6f853071ae9aff98ebbfa231ad09f7eb39450a394881ff82774ee5167e2',104,1,'web','[]',0,'2021-09-06 09:04:05','2021-09-06 09:04:05','2021-09-06 19:04:05'),('e50773ee9753d77c782229e5d2255a5a7988f77b11c4cac3cafaafe154fe5bb374b5b49aa3628000',1,1,'web','[]',0,'2021-09-07 13:22:22','2021-09-07 13:22:22','2021-09-07 23:22:22'),('e718d447147210d0e4df77f146ae3a9a425201930c26fd61f2a11593610b696346f90339319ee72f',1,1,'web','[]',0,'2021-09-06 02:54:29','2021-09-06 02:54:29','2021-09-06 12:54:29'),('eb7b0cb577dcb5cd85fe1d937f3b3a6e6777a0c820be9b08df4c3ccef2248f0c02a23da192ab8a65',2,1,'web','[]',0,'2021-09-07 14:27:45','2021-09-07 14:27:45','2021-09-08 00:27:45'),('ed00d5b98edd50bbd85e6a1b8aca9311d707fdc3d2b5215151e54af38aef79f4629eafc59a5f34e6',2,1,'web','[]',0,'2021-09-07 13:51:01','2021-09-07 13:51:01','2021-09-07 23:51:01'),('ef121ad664ad838f29cb1d654db61a0e2ffc1f6aca42a4b3d99d70573973eade378f424eb8b1b6ba',2,1,'web','[]',0,'2021-09-06 07:26:04','2021-09-06 07:26:04','2021-09-06 17:26:04'),('f8f710dac2242a417276d4932d757ef813be6b89931381995f7bfa08ed44b67ef7b1b1720dda1653',104,1,'web','[]',0,'2021-09-06 11:39:27','2021-09-06 11:39:27','2021-09-06 21:39:27');
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
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','ZfQpbgNCxlhZoAcCjbC9L5ZwOdHYOIomWJUmi6wP',NULL,'http://localhost',1,0,0,'2021-09-06 02:54:25','2021-09-06 02:54:25'),(2,NULL,'Laravel Password Grant Client','BFC1qSph8CrJcodmDu3dXmi3Vhf6Mh3XI3tS5RoK','users','http://localhost',0,1,0,'2021-09-06 02:54:25','2021-09-06 02:54:25');
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
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2021-09-06 02:54:25','2021-09-06 02:54:25');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'set_basic','web','基本設定','2021-09-07 13:32:34','2021-09-07 13:32:34'),(2,'set_manager','web','人員管理','2021-09-07 13:32:34','2021-09-07 13:32:34'),(3,'set_message','web','簡訊設定','2021-09-07 13:32:34','2021-09-07 13:32:34');
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
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'系統管理者','web','2021-09-07 13:32:33','2021-09-07 13:32:33',NULL);
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
  `role_id` tinyint(3) unsigned NOT NULL COMMENT '權限ID',
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '帳號啟用狀態(0 => 停用, 1 => 啟用)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','系統管理者','josh.chiang@aibitechcology.com',NULL,'$2y$10$RZ235w3Xoni5rF7ND7L8VOpNK4wmatj3.rYu7FCRgZCAE7wqwTK46',NULL,1,0,NULL,'2021-09-06 12:50:34',NULL),(2,'josh','凡','aaa@aaa.com',NULL,'$2y$10$IEuXFg9H/jP55ZSc9ILTh.L2w/WJQhi1kiK6EY2hNZix.p9zqRJfC',NULL,1,0,'2021-09-06 05:06:46','2021-09-06 08:56:39',NULL),(3,'test1','test1','bbb@bbb.com',NULL,'$2y$10$FMqUucbsnbs5ilCRUuatz.ebLY1ssIDDuRjqoA3r/1vfBJls2o4j.',NULL,1,1,'2021-09-06 05:25:58','2021-09-06 07:23:49',NULL),(4,'test2','test2','ccc@ccc.com',NULL,'$2y$10$9C4BI.egehe5.qJ/Aneo1OF.3KxwKkZ8KpskdE4FRclSI/pvRn4x2',NULL,1,1,'2021-09-06 06:00:08','2021-09-06 13:22:45',NULL),(5,'test3','test3','eee@eee.com',NULL,'$2y$10$aMqdQ4X2Krcy.e906aWX4O8.9RrLC/T0tDW93Nnn9p1cEi5cZ.AES',NULL,1,1,'2021-09-06 06:10:58','2021-09-06 13:18:54',NULL),(6,'test4','test4','ggg@ggg.com',NULL,'$2y$10$wVNo8mWA4ZbpsXQD9LHwzetwLH8gZUVIFbwCB2hg8svOxE7IFaUQ.',NULL,1,1,'2021-09-06 06:13:31','2021-09-06 13:47:08','2021-09-06 13:47:08'),(7,'test5','test5','aaa@aaa.com',NULL,'$2y$10$LOzmx9sv9pjmJ45Uyk.uH.RbWZXI3YEFb1K/BBA8E2BcfxI7ShitW',NULL,1,1,'2021-09-06 06:14:20','2021-09-06 13:47:08','2021-09-06 13:47:08'),(8,'test6','test6','ttt@ttt.com',NULL,'$2y$10$dq1XMPiUEK8z2dsAHqmaxeEOKCaj4JiTopdTg485NwgXLGOAQZLrW',NULL,1,1,'2021-09-06 06:15:00','2021-09-06 13:21:24',NULL),(9,'test7','test7','aaa@aaa.com',NULL,'$2y$10$zRd8uv1cFua6RqmuvTzpJONZU0AACg8PtUh35LPvxa48kq34h7Bu6',NULL,1,1,'2021-09-06 06:15:23','2021-09-06 13:20:11',NULL),(10,'test8','test8','aaa@aaa.com',NULL,'$2y$10$KF33ZJ4ZZnSXQuiaokgO4.xScVH4oKz7NOZ0JHUTXOtJq7K.pqAoG',NULL,1,1,'2021-09-06 06:15:33','2021-09-06 13:20:31',NULL),(11,'test9','test9','aaa@aaa.com',NULL,'$2y$10$NmUitni6ByGwhN/8bRhqEeWLNg5jNEow135jP.kg8j0JRLXn7Hjiq',NULL,1,1,'2021-09-06 06:15:53','2021-09-06 06:15:53',NULL),(12,'test10','test10','test10@test.com',NULL,'$2y$10$G7fyPVKx4FCD817.7G.8COTD0XKGnkshFQFrJ3cDBy5f3NkHhLtC2',NULL,1,1,'2021-09-06 06:51:02','2021-09-06 12:51:56',NULL),(13,'test11','test11','test11@test.com',NULL,'$2y$10$Yem2jAkgV7QaQnuG1KNjR.ub2NZmYdRC/l0q.ZxtmrgCdRN3w4KNe',NULL,1,1,'2021-09-06 06:51:02','2021-09-06 12:51:56',NULL),(14,'test12','test12','test12@test.com',NULL,'$2y$10$O.iwSIdwx1DoUSZIUqpssuGDqxNxFZx3N/H0KUfRPxP/FNZRubxgO',NULL,1,1,'2021-09-06 06:51:02','2021-09-06 12:51:56',NULL),(15,'test13','test13','test13@test.com',NULL,'$2y$10$ncKIO07Mdqfnf0auF.rCue/lhQ97Xf5jO6EO3GIes5JxrUpwAZ1bm',NULL,1,1,'2021-09-06 06:51:02','2021-09-06 12:51:56',NULL),(16,'test14','test14','test14@test.com',NULL,'$2y$10$3wSzmw0Hah3cvKj2GmIBJ.jzaYvXl57/FQoVgIuprtydMMGpSNha6',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(17,'test15','test15','test15@test.com',NULL,'$2y$10$rICDeqKHsgVc3YYyDvHlrevQDyKHBGw9QB62r/zIKBJ57sqUs2d.6',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(18,'test16','test16','test16@test.com',NULL,'$2y$10$H/SC2H5qXSfcivw/9g9W6.YuUW3laxvOrtwHn7XMXdcE54zuf/s5K',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(19,'test17','test17','test17@test.com',NULL,'$2y$10$k5KXhPHRiieMoC5s74AxQeAGYjOfgu1GGdHnz83Sndgjkq586UzVu',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(20,'test18','test18','test18@test.com',NULL,'$2y$10$sAi5e6F1GRUSeMh4o3aHI.Qo3Y9/rKS0rLskLlQj/uTaMPgVUoqKi',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(21,'test19','test19','test19@test.com',NULL,'$2y$10$AlIMWGu62cI/r6a3Bvl3M.q08ggWHh7ooMj9rsy4sTI4Acnbg.BEq',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 12:51:56',NULL),(22,'test20','test20','test20@test.com',NULL,'$2y$10$f9sck./dzgnL1l8waJt3P.PxaO5H6LwfABQwxnFYnkw4pfSBPuLDi',NULL,1,1,'2021-09-06 06:51:03','2021-09-06 06:51:03',NULL),(23,'test21','test21','test21@test.com',NULL,'$2y$10$QWVhgtXQEYmOf0VoE8lFRuM.awX.0JYEZX1CbW2F5v4ujTn7Ndtkq',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 06:51:04',NULL),(24,'test22','test22','test22@test.com',NULL,'$2y$10$nl8e294kpIrNpq70/zJRzeXPbeGqviJf/88GINnvlp3ZLHlDZvCEy',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 06:51:04',NULL),(25,'test23','test23','test23@test.com',NULL,'$2y$10$PWIij/v4zEMozii9n.jtBO8eAM63aQjzts1fru.kN3H2SJay/MFR2',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 06:51:04',NULL),(26,'test24','test24','test24@test.com',NULL,'$2y$10$SBOC.P.4jeRJFXVl1RW8cuG7g5BWONDgeQ8CDAribTqK7PoVEbGIy',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 06:51:04',NULL),(27,'test25','test25','test25@test.com',NULL,'$2y$10$I2ToM4RaldQ4lfbkv9rooOWHCheTXQSMnUUg.DhaX0aH8o1QUJzO.',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 06:51:04',NULL),(28,'test26','test26','test26@test.com',NULL,'$2y$10$2MwmITBj.dI9blpYDnE1lumtFXeCO1UBB7mpszF1v1U1wiaTiUinC',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 13:21:44',NULL),(29,'test27','test27','test27@test.com',NULL,'$2y$10$fxUr2Wg9OtBTlOPHOQ3LieIZFd7FoTiUyYAJcXNv9JN/jjWDAi8OG',NULL,1,1,'2021-09-06 06:51:04','2021-09-06 13:21:44',NULL),(30,'test28','test28','test28@test.com',NULL,'$2y$10$Bp6J21icRxMRyHuM/d4cjO5xqtgyDI9q3Vc6dbn9owBuuLnLlQT9K',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:21:44',NULL),(31,'test29','test29','test29@test.com',NULL,'$2y$10$RjQZTV.KyYJ1xbvldvw/NeC2tpQa/p1Z.DvuxL3Cb.Rc5jSKqPzeS',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:21:44',NULL),(32,'test30','test30','test30@test.com',NULL,'$2y$10$DjyVW7ViyfQXHoPX2pTkxepvPk9X9RfnjRyytn20uYUFzk0RNXNCC',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:01:12',NULL),(33,'test31','test31','test31@test.com',NULL,'$2y$10$fUeJms4wq2x1x7T6vmx7lONTotb7UeOOK.UP.i6RadecG9IWZD2OK',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:01:12',NULL),(34,'test32','test32','test32@test.com',NULL,'$2y$10$SeRH7.GpPvT/Cgkmk4DjguhNmsRikAWh4x.BlfXTuwbhUW.aekvfK',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:01:12',NULL),(35,'test33','test33','test33@test.com',NULL,'$2y$10$V.ebdXhd3OVjJAik50r/6OBL6.MBg8rDQwuoyTtK.cwNZFnHXCouC',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:02:38',NULL),(36,'test34','test34','test34@test.com',NULL,'$2y$10$BMR/jY68ETbIuQThVGPig.scx04SbuDv2vvbLgFiYoLBLoDfOGzJa',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:02:38',NULL),(37,'test35','test35','test35@test.com',NULL,'$2y$10$biNxYY3PGi64s7tOpeEzLuiXC6GXnlzbtvWwme2y5eS5M1ccV6eHu',NULL,1,1,'2021-09-06 06:51:05','2021-09-06 13:02:38',NULL),(38,'test36','test36','test36@test.com',NULL,'$2y$10$dW1w4b9DNeRwHnGb18bg5uRySVyIwavkIzuZSWrIMkqNzDfK7Lkgi',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(39,'test37','test37','test37@test.com',NULL,'$2y$10$SCTVVhcQIxwFXNJi3UQXAexxxbn5y1CVpDL7fNZhipHDNSO0vqAXK',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(40,'test38','test38','test38@test.com',NULL,'$2y$10$9fJUnGx5usi8Ln1C/aRuq.VQ4olp79VQ6Ew.ivGscZDCgmOHGbaIu',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(41,'test39','test39','test39@test.com',NULL,'$2y$10$mXhU5BB8kCMcpXTMg.CozOb.FM/EJn84RIJTP4T1BpIfWifcnVYoW',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(42,'test40','test40','test40@test.com',NULL,'$2y$10$i0JnhHQhXMmHT3Ifb9QXDeRbKq2uo/6xJNcKJm1llN2owEsmjY/LS',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(43,'test41','test41','test41@test.com',NULL,'$2y$10$hylLDz38CalaQL9qfqY7Ae6kKjcRr/a0pOVlmYlB.naDp38DLQnWO',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(44,'test42','test42','test42@test.com',NULL,'$2y$10$FmaYw3H2NTySXAzO.ngzkejw4cE71HT4fF4fZb79XUFJY/6zZ9QYu',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:02:38',NULL),(45,'test43','test43','test43@test.com',NULL,'$2y$10$617WhM4a0i6f2Rb0t4704eqdIb5umNdynxiRU/gH/lfydbnolLy5q',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:04:02',NULL),(46,'test44','test44','test44@test.com',NULL,'$2y$10$taixX37vBdw.AYiCfr8Ym.ZdGXvTOxAbpeNGz.g3VRNRSGuyQIqmS',NULL,1,1,'2021-09-06 06:51:06','2021-09-06 13:04:02',NULL),(47,'test45','test45','test45@test.com',NULL,'$2y$10$LkeOQpkgoa.7yeaD6quzNuwYsVmCyu4Mmoy2r9/6cc7W4vLyMCQCG',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(48,'test46','test46','test46@test.com',NULL,'$2y$10$JT5x0WQgI1Z6ZBhkNOE2oOkQy0DXmbZIaokE1VTYioOs1TUsppRNe',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(49,'test47','test47','test47@test.com',NULL,'$2y$10$fgT7Wo6kXVFGVgJaabodi.9dy/MfbPuBbISzYST9dqsJRiL7CnSBu',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(50,'test48','test48','test48@test.com',NULL,'$2y$10$Omx6qz7pkfaOu.6EvibvrOlu.EXAK1d.i5CiwQsd2h4p33P9j9NSK',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(51,'test49','test49','test49@test.com',NULL,'$2y$10$pTgJmr.IMyFPnG3eE7HWbukTecpj7twEuBgqwmm9tx7abYdFV509m',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(52,'test50','test50','test50@test.com',NULL,'$2y$10$gETro4gJsGUkotliTvlJduXpxQNhDfvuBsIBVnwbBZGNdthN.dWQq',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(53,'test51','test51','test51@test.com',NULL,'$2y$10$D1yVizOiriRZ6rT/aTNBwOeqplYNRo6KjzoX8wG2L1VyQJ8DnTg5y',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(54,'test52','test52','test52@test.com',NULL,'$2y$10$yDy11URSQZHKP1uJxFiUueGskCvszWUYPMmbEDLDy3JT7SfQAF6me',NULL,1,1,'2021-09-06 06:51:07','2021-09-06 13:04:02',NULL),(55,'test53','test53','test53@test.com',NULL,'$2y$10$HCXjCosZCuRHtprXez02FezvhOPzklKRVwXja6h2PKpzlFtnjTiCa',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:09',NULL),(56,'test54','test54','test54@test.com',NULL,'$2y$10$2z9rZSkDWU2PF.cRNmfeJODP.ma2qids53fPzvG91qs6HrxQBhdKW',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:09',NULL),(57,'test55','test55','test55@test.com',NULL,'$2y$10$cUnhaMiD1RHjP9J2jQXdZuCUqSWQDsiHo.z0ljhekZVNDH.WFziVu',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:09',NULL),(58,'test56','test56','test56@test.com',NULL,'$2y$10$FXIXtCT95GBH90Zb4Vbg4uITC1CLzBNGVuXkuQHjDh9Xn0hgu7oxS',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:13',NULL),(59,'test57','test57','test57@test.com',NULL,'$2y$10$ogSAmHIMPbp.VPTePC1gdexW65sOES/WTmPRC8kfWoS68ur9xYn2O',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:13',NULL),(60,'test58','test58','test58@test.com',NULL,'$2y$10$OdSRW6Zp3Wtfxr1G1M5ijO9AakSniniyBm7NuiX0epnW8s4KR.U5a',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:05:13',NULL),(61,'test59','test59','test59@test.com',NULL,'$2y$10$xZ/4CHAUzcjH6Ol7fkQDze3krC6BWtvw/z/ca5bm.29BqiZeFVDK2',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:25:00','2021-09-06 13:25:00'),(62,'test60','test60','test60@test.com',NULL,'$2y$10$64ltH28RjJiLWxoce8PMyO3/LvTKHoH3ZeRtEa3FNXP9yFm7TWilG',NULL,1,1,'2021-09-06 06:51:08','2021-09-06 13:25:00','2021-09-06 13:25:00'),(63,'test61','test61','test61@test.com',NULL,'$2y$10$7sAliZYUfRB/LyzewdO3CeXim0eGtHpsXicyOnpapJwf8H7ne6vTi',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(64,'test62','test62','test62@test.com',NULL,'$2y$10$PumKhgIPWoGJzSQriFIOW.eGk6SAysMLPzCBmf..1ftOljbH6aCaO',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(65,'test63','test63','test63@test.com',NULL,'$2y$10$sXLCVqDY4wnvOfiQ8Jz7mOIXApkDoJghPtSQNulg0wY6OEbPpR4dy',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(66,'test64','test64','test64@test.com',NULL,'$2y$10$O4edQd3Hr.69/Tn1NNokx.dLilQUTDW6Ng2h6NxCJ3uvjwNX3G1sG',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(67,'test65','test65','test65@test.com',NULL,'$2y$10$gGYuJth0/.7fi3fITxmyrOs.9bv8gtinkwe.SKp0K2V1CL3s1cYG2',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(68,'test66','test66','test66@test.com',NULL,'$2y$10$WsY3qEtyO2./BkxAboAIleDVhewd/VIBl7Su1Xnegx9U66isZJ4Sm',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(69,'test67','test67','test67@test.com',NULL,'$2y$10$NZaUbJX0biLYTeWTGwLIBuWBs0.aiEIpFy97aRYYgMEcLOXf7MF9y',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(70,'test68','test68','test68@test.com',NULL,'$2y$10$pI95tm2MM6o1m4w6sezij.TQoUPyqAH8x4vyi35yubvgWOTGFz.QO',NULL,1,1,'2021-09-06 06:51:09','2021-09-06 13:25:00','2021-09-06 13:25:00'),(71,'test69','test69','test69@test.com',NULL,'$2y$10$RpNnzszuCdeksrJQk0vOgeeekn7/ZSAjxw4xOgQyvmjeTtSHsYreC',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:25:05','2021-09-06 13:25:05'),(72,'test70','test70','test70@test.com',NULL,'$2y$10$JowP5A51E8SPo/LUqylw3uTu5Ms7HiLLUWlsb90txryqOY17QDOJi',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:25:05','2021-09-06 13:25:05'),(73,'test71','test71','test71@test.com',NULL,'$2y$10$vdeM5FOH.mh/7ECIBfOlHOA/lvEOMfeq4JYKLeWvHrn4R4jvpAaBq',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:25:05','2021-09-06 13:25:05'),(74,'test72','test72','test72@test.com',NULL,'$2y$10$gqBUz/FYEnNdRScik7GqkOj0IHntW03OM4lOf2I64QIInwK5emmqq',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:25:05','2021-09-06 13:25:05'),(75,'test73','test73','test73@test.com',NULL,'$2y$10$Cb82O4aC3gzWcDd.SsPde.7lWhwq6GYR9NhH6JRLrmOvfdmuI8hUi',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:15:37','2021-09-06 13:15:37'),(76,'test74','test74','test74@test.com',NULL,'$2y$10$ao6Eh7hbWBCC0NqT/NuJLe/b.aZnR6tqR2tr.p/FJI0ttAvjGByeW',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:15:37','2021-09-06 13:15:37'),(77,'test75','test75','test75@test.com',NULL,'$2y$10$/RDbJgYOfFP.2jRmokaW7On.gR7H6sLN75u2znJQsz4OckO2UWYwG',NULL,1,1,'2021-09-06 06:51:10','2021-09-06 13:15:37','2021-09-06 13:15:37'),(78,'test76','test76','test76@test.com',NULL,'$2y$10$TLzLiFswdL0ay5sHxjqVau31pc1k9HBY3BDccKsMUBzHValOX9zA.',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 13:08:35','2021-09-06 13:08:35'),(79,'test77','test77','test77@test.com',NULL,'$2y$10$bdzNha1a3kLeng4HUKSMNuq75a1Y0C02PqRomvD08Z9.98JLY/rie',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 13:08:35','2021-09-06 13:08:35'),(80,'test78','test78','test78@test.com',NULL,'$2y$10$J2fORj7O341AIIJ2FxpI6.5apJrt2kDBBfMU4pc8Heri2aFLQx/em',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 13:08:35','2021-09-06 13:08:35'),(81,'test79','test79','test79@test.com',NULL,'$2y$10$oaGW9I6mKnd3xPZCeW4mHOZh9SqJoRFBdNOCSVMF744g0saVlzx46',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 13:08:35','2021-09-06 13:08:35'),(82,'test80','test80','test80@test.com',NULL,'$2y$10$Up5pFIt872saWcQrvc1QruWYtQu8THF/R.hbsT4qsYol2IYUJX55q',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 12:59:31','2021-09-06 12:59:31'),(83,'test81','test81','test81@test.com',NULL,'$2y$10$pU6WwaVsV36iQ5vDiUS0U.00voondK4DAVOtSPTf3olmulhm2lAWq',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 12:59:31','2021-09-06 12:59:31'),(84,'test82','test82','test82@test.com',NULL,'$2y$10$PcRwN/bKipm6/9gaUPcgZO7mbDo8b3ZKClMozFiGclKWYQh5BZDqi',NULL,1,1,'2021-09-06 06:51:11','2021-09-06 12:59:31','2021-09-06 12:59:31'),(85,'test83','test83','test83@test.com',NULL,'$2y$10$YnsTgsc.TSPMJyYBR1R2MOfySsLwdC6QjRflHQmM01lJCD3Q4Iui2',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 12:59:31','2021-09-06 12:59:31'),(86,'test84','test84','test84@test.com',NULL,'$2y$10$yZ23NnkSrJ9gofpZto8srOGvUFZ8RfO5fJmBb9cmVW.DN7UAfAOZy',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 13:08:35','2021-09-06 13:08:35'),(87,'test85','test85','test85@test.com',NULL,'$2y$10$51ayajQR4wDkANy3ytUgiOJekKy70vEhcrTnNQW3BEk3Vto3uRQim',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 13:08:35','2021-09-06 13:08:35'),(88,'test86','test86','test86@test.com',NULL,'$2y$10$aJx5xFkn.haV5/OEOVJrL.iVAP8V3EcCY5wVo5.MnQueexf5BEFd6',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 13:08:35','2021-09-06 13:08:35'),(89,'test87','test87','test87@test.com',NULL,'$2y$10$BkYV5mSKGgatD8AaCTPxQORSj70Ir7B8Dq56pwRa.ywWg1KrVVu2y',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 13:08:35','2021-09-06 13:08:35'),(90,'test88','test88','test88@test.com',NULL,'$2y$10$eowZSoA2WniKghVEir7PUe/9kQ6xVkr34pQv6agzc3ubtkvlS2HdC',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 13:08:35','2021-09-06 13:08:35'),(91,'test89','test89','test89@test.com',NULL,'$2y$10$4QLcR12dl33EObq3GVm/4O57Ij3UB9YrXvYMIXT2Iyl1OaQWMCHf2',NULL,1,1,'2021-09-06 06:51:12','2021-09-06 08:56:18','2021-09-06 08:56:18'),(92,'test90','test90','test90@test.com',NULL,'$2y$10$i2qY3iErpx1hMUgRg8Uz0OzQFL4GtmHMQMOwoquwPeCo7TPT0UYFO',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 13:08:35','2021-09-06 13:08:35'),(93,'test91','test91','test91@test.com',NULL,'$2y$10$sAfgcJigPv4t4foukfH4LOhhMquIQW9EFZuNhxnrxLokpTCYXxnVu',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(94,'test92','test92','test92@test.com',NULL,'$2y$10$ZaCToFRWjtJ4q9wxKsEQDeWlw63OW8PqH6kRIUuvoktpF57q9h6i6',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(95,'test93','test93','test93@test.com',NULL,'$2y$10$bvCthvbps9eSPNnV6WSnuukXc62dAOA/Dfip9VTzaRykv3VoW1buG',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(96,'test94','test94','test94@test.com',NULL,'$2y$10$8m6nwfkFSoLw0U1pelzS/.walntbqyP26ZLwGBCNPmKDMNCP2scVC',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(97,'test95','test95','test95@test.com',NULL,'$2y$10$6Kl5h/GPvJ9vIdpqhBwDf.RIhMH8ys0g3/91.UnIrMdZlULStfx9i',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(98,'test96','test96','test96@test.com',NULL,'$2y$10$0U.1BAPxDJKclEUKedhNpu.0HC3ksKtxVYxqsUCuwXSkRgeyUgPlu',NULL,1,1,'2021-09-06 06:51:13','2021-09-06 12:50:40','2021-09-06 12:50:40'),(99,'test97','test97','test97@test.com',NULL,'$2y$10$R.v.Uj/DyczG9tj3St8l1eq59hLkh6GnFJ037jyEK1YqCaafGFDSi',NULL,1,1,'2021-09-06 06:51:14','2021-09-06 12:50:40','2021-09-06 12:50:40'),(100,'test98','test98','test98@test.com',NULL,'$2y$10$4yRAVxWk3tvOBhZlWzrZze88KWjM7RkT.6uX.pqOFfbwSKzGuJ2ty',NULL,1,1,'2021-09-06 06:51:14','2021-09-06 12:50:40','2021-09-06 12:50:40'),(101,'test99','test99','test99@test.com',NULL,'$2y$10$TGWkdYxIwLjiDAVR9GIkOuNaNdqpgJLFitr9tcz5jTD1fMOY66pCO',NULL,1,1,'2021-09-06 06:51:14','2021-09-06 12:50:40','2021-09-06 12:50:40'),(102,'test100','test100','test100@test.com',NULL,'$2y$10$kYbhQZ5CIvOzWi9SLBuVVOamkLVD5ARSHactZjXZ8wlExrJfeYo5W',NULL,1,1,'2021-09-06 06:51:14','2021-09-06 12:50:40','2021-09-06 12:50:40'),(103,'testtest','testtest','test@gmail.com',NULL,'$2y$10$Vg3yGG.4yjupK1UgOiqH0.QzBBeF6puWI0bY.1fC8rTsacUKEuijm',NULL,1,1,'2021-09-06 08:15:55','2021-09-06 12:51:37','2021-09-06 12:51:37'),(104,'josh','凡','aaa@aaa.com',NULL,'$2y$10$amPb78mXLAQ/NKk17xd/quOQGLlmXTF3nBqRxzNN0t8nMW9qKfE.K',NULL,1,0,'2021-09-06 09:01:01','2021-09-06 13:06:50','2021-09-06 13:06:50'),(105,'testtesttest','testtesttest','aaa@aaa.com',NULL,'$2y$10$qD84LUCeGEH/c1Z4cDlmLuLaRKRYOpHlK8BK6Vu8HgYXvfG5kK/x.',NULL,1,1,'2021-09-06 12:51:24','2021-09-06 12:51:37','2021-09-06 12:51:37'),(106,'test100','test100','aaa@aaa.com',NULL,'$2y$10$WwbqlndRNaFPtWyqCHVZ3uRvJBZOrFjqFagZWEgsc/k2vbD0FuyJO',NULL,1,1,'2021-09-06 13:15:13','2021-09-06 13:21:44','2021-09-06 13:21:44'),(107,'testtest4','testtest4','aaa@aaa.com',NULL,'$2y$10$AJHwBFk5vlKgDSHWimfSq.P3envmosS5SW.zEeAio6lzmaZxlPg5q',NULL,1,1,'2021-09-06 13:36:30','2021-09-06 13:36:30',NULL);
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

-- Dump completed on 2021-09-07 22:28:45
