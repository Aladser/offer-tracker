-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: offer-tracker
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.22.04.1

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
-- Table structure for table `advertisers`
--

DROP TABLE IF EXISTS `advertisers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `advertisers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `advertisers_user_id_foreign` (`user_id`),
  CONSTRAINT `advertisers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertisers`
--

LOCK TABLES `advertisers` WRITE;
/*!40000 ALTER TABLE `advertisers` DISABLE KEYS */;
INSERT INTO `advertisers` VALUES (1,2),(2,3),(3,4);
/*!40000 ALTER TABLE `advertisers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
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
-- Table structure for table `failed_offer_clicks`
--

DROP TABLE IF EXISTS `failed_offer_clicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_offer_clicks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_offer_clicks`
--

LOCK TABLES `failed_offer_clicks` WRITE;
/*!40000 ALTER TABLE `failed_offer_clicks` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_offer_clicks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=434 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (303,'2023_10_17_205435_create_jobs_table',2),(421,'2014_10_12_100000_create_password_resets_table',3),(422,'2019_08_19_000000_create_failed_jobs_table',3),(423,'2019_12_14_000001_create_personal_access_tokens_table',3),(424,'2023_09_01_000001_create_system_options_table',3),(425,'2023_09_12_072436_create_user_roles_table',3),(426,'2023_09_12_072459_create_users_table',3),(427,'2023_09_12_080918_create_advertisers_table',3),(428,'2023_09_12_080919_create_webmasters_table',3),(429,'2023_09_14_081904_create_offer_themes_table',3),(430,'2023_09_14_082150_create_offers_table',3),(431,'2023_09_20_050802_create_offer_subscriptions_table',3),(432,'2023_09_28_000002_create_offer_clicks_table',3),(433,'2023_10_04_063454_create_failed_offer_clicks_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_clicks`
--

DROP TABLE IF EXISTS `offer_clicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_clicks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `income_part` double(3,2) unsigned NOT NULL DEFAULT '0.80',
  `webmaster_id` bigint unsigned NOT NULL,
  `offer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `offer_clicks_webmaster_id_foreign` (`webmaster_id`),
  KEY `offer_clicks_offer_id_foreign` (`offer_id`),
  CONSTRAINT `offer_clicks_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offer_clicks_webmaster_id_foreign` FOREIGN KEY (`webmaster_id`) REFERENCES `webmasters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_clicks`
--

LOCK TABLES `offer_clicks` WRITE;
/*!40000 ALTER TABLE `offer_clicks` DISABLE KEYS */;
INSERT INTO `offer_clicks` VALUES (1,'2023-10-22 01:16:37',0.80,1,2),(2,'2023-10-22 01:16:37',0.80,2,2),(3,'2023-10-22 01:16:37',0.80,1,3),(4,'2023-10-22 01:16:37',0.80,2,3),(5,'2023-10-22 01:16:37',0.80,3,3),(6,'2023-10-19 01:16:37',0.80,1,1),(7,'2023-07-22 01:16:37',0.80,2,1),(8,'2023-10-22 01:16:37',0.80,1,4),(9,'2023-10-22 01:16:37',0.80,3,4),(10,'2023-08-22 01:16:37',0.80,1,1),(11,'2021-10-22 01:16:37',0.80,1,1);
/*!40000 ALTER TABLE `offer_clicks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_subscriptions`
--

DROP TABLE IF EXISTS `offer_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `refcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `webmaster_id` bigint unsigned NOT NULL,
  `offer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `offer_subscriptions_webmaster_id_offer_id_unique` (`webmaster_id`,`offer_id`),
  UNIQUE KEY `offer_subscriptions_refcode_unique` (`refcode`),
  KEY `offer_subscriptions_offer_id_foreign` (`offer_id`),
  KEY `offer_subscriptions_webmaster_id_offer_id_refcode_index` (`webmaster_id`,`offer_id`,`refcode`),
  CONSTRAINT `offer_subscriptions_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offer_subscriptions_webmaster_id_foreign` FOREIGN KEY (`webmaster_id`) REFERENCES `webmasters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_subscriptions`
--

LOCK TABLES `offer_subscriptions` WRITE;
/*!40000 ALTER TABLE `offer_subscriptions` DISABLE KEYS */;
INSERT INTO `offer_subscriptions` VALUES (1,'1@1',1,1),(2,'1@4',1,4),(3,'1@5',1,5),(4,'2@1',2,1),(5,'2@2',2,2),(6,'3@1',3,1);
/*!40000 ALTER TABLE `offer_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offer_themes`
--

DROP TABLE IF EXISTS `offer_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offer_themes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `offer_themes_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offer_themes`
--

LOCK TABLES `offer_themes` WRITE;
/*!40000 ALTER TABLE `offer_themes` DISABLE KEYS */;
INSERT INTO `offer_themes` VALUES (1,'IT',NULL),(2,'образование',NULL),(3,'игры',NULL),(4,'спорт',NULL),(5,'отдых',NULL);
/*!40000 ALTER TABLE `offer_themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offers`
--

DROP TABLE IF EXISTS `offers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://laravel.su/docs/8.x',
  `price` int unsigned NOT NULL DEFAULT '0',
  `theme_id` bigint unsigned NOT NULL,
  `advertiser_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `offers_name_advertiser_id_unique` (`name`,`advertiser_id`),
  UNIQUE KEY `offers_name_unique` (`name`),
  KEY `offers_theme_id_foreign` (`theme_id`),
  KEY `offers_advertiser_id_foreign` (`advertiser_id`),
  CONSTRAINT `offers_advertiser_id_foreign` FOREIGN KEY (`advertiser_id`) REFERENCES `advertisers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offers_theme_id_foreign` FOREIGN KEY (`theme_id`) REFERENCES `offer_themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offers`
--

LOCK TABLES `offers` WRITE;
/*!40000 ALTER TABLE `offers` DISABLE KEYS */;
INSERT INTO `offers` VALUES (1,'Github','https://github.com/Aladser',30,1,1,1),(2,'Django','https://metanit.com/python/django/3.1.php',16,2,2,1),(3,'Laravel 8','https://laravel.su/docs/8.x',23,3,3,1),(4,'Laravel 10','https://laravel.com/docs/10.x',13,1,1,1),(5,'БЭМ','https://ru.bem.info/methodology/quick-start/',14,2,1,0),(6,'Boostrap','https://bootstrap-4.ru/docs/5.3/getting-started/introduction/',31,2,2,1),(7,'Яндекс','https://ya.ru/',34,1,2,0),(8,'Google','https://www.google.com/?hl=RU',49,1,3,1);
/*!40000 ALTER TABLE `offers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
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
-- Table structure for table `system_options`
--

DROP TABLE IF EXISTS `system_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_options` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_options`
--

LOCK TABLES `system_options` WRITE;
/*!40000 ALTER TABLE `system_options` DISABLE KEYS */;
INSERT INTO `system_options` VALUES ('commission','10');
/*!40000 ALTER TABLE `system_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,'администратор'),(3,'веб-мастер'),(2,'рекламодатель');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,1,1),(2,'advertiser1','advertiser1@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,2,1),(3,'advertiser2','advertiser2@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,2,1),(4,'advertiser3','advertiser3@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,2,1),(5,'webmaster1','webmaster1@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,3,1),(6,'webmaster2','webmaster2@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,3,1),(7,'webmaster3','webmaster3@mail.ru','$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',NULL,3,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webmasters`
--

DROP TABLE IF EXISTS `webmasters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `webmasters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `webmasters_user_id_foreign` (`user_id`),
  CONSTRAINT `webmasters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `webmasters`
--

LOCK TABLES `webmasters` WRITE;
/*!40000 ALTER TABLE `webmasters` DISABLE KEYS */;
INSERT INTO `webmasters` VALUES (1,5),(2,6),(3,7);
/*!40000 ALTER TABLE `webmasters` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-23 18:29:01
