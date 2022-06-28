-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: rpg
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.20.04.3

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
-- Table structure for table `building_npc`
--

DROP TABLE IF EXISTS `building_npc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `building_npc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `building_id` bigint unsigned NOT NULL,
  `npc_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_npc_building_id_foreign` (`building_id`),
  KEY `building_npc_npc_id_foreign` (`npc_id`),
  CONSTRAINT `building_npc_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  CONSTRAINT `building_npc_npc_id_foreign` FOREIGN KEY (`npc_id`) REFERENCES `npcs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building_npc`
--

LOCK TABLES `building_npc` WRITE;
/*!40000 ALTER TABLE `building_npc` DISABLE KEYS */;
INSERT INTO `building_npc` VALUES (1,1,8,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `building_npc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `building_tile`
--

DROP TABLE IF EXISTS `building_tile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `building_tile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tile_id` bigint unsigned NOT NULL,
  `building_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `building_tile_tile_id_foreign` (`tile_id`),
  KEY `building_tile_building_id_foreign` (`building_id`),
  CONSTRAINT `building_tile_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  CONSTRAINT `building_tile_tile_id_foreign` FOREIGN KEY (`tile_id`) REFERENCES `tiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `building_tile`
--

LOCK TABLES `building_tile` WRITE;
/*!40000 ALTER TABLE `building_tile` DISABLE KEYS */;
INSERT INTO `building_tile` VALUES (1,1,1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(2,1,2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,1,3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,1,4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,1,5,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(6,1,6,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `building_tile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buildings`
--

DROP TABLE IF EXISTS `buildings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buildings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zone_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_zone_id_foreign` (`zone_id`),
  CONSTRAINT `buildings_zone_id_foreign` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buildings`
--

LOCK TABLES `buildings` WRITE;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` VALUES (1,'Farmhouse','An average sized farmhouse.',1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(2,'Church','A basic wooden church.',2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,'Shop','A generic, basic shop.',3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,'House','A standard wooden house.',4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,'Abandoned House','A rundown wooden house.',4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(6,'Empty House','The bed appears to have been made recently.',5,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `command_logs`
--

DROP TABLE IF EXISTS `command_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `command_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `command` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `command_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `command_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `command_logs`
--

LOCK TABLES `command_logs` WRITE;
/*!40000 ALTER TABLE `command_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `command_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edge_terrain`
--

DROP TABLE IF EXISTS `edge_terrain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edge_terrain` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `edge_id` bigint unsigned NOT NULL,
  `terrain_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edge_terrain`
--

LOCK TABLES `edge_terrain` WRITE;
/*!40000 ALTER TABLE `edge_terrain` DISABLE KEYS */;
INSERT INTO `edge_terrain` VALUES (1,4,1,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(3,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(4,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(5,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(6,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(7,3,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(8,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(9,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(10,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(11,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(12,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(13,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(14,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(15,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(16,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(17,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(18,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(19,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(20,3,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL);
/*!40000 ALTER TABLE `edge_terrain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edge_tile`
--

DROP TABLE IF EXISTS `edge_tile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edge_tile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `edge_id` bigint unsigned NOT NULL,
  `tile_id` bigint unsigned NOT NULL,
  `direction` enum('north','east','south','west') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'north',
  `is_road` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `edge_tile_tile_id_foreign` (`tile_id`),
  KEY `edge_tile_edge_id_foreign` (`edge_id`),
  CONSTRAINT `edge_tile_edge_id_foreign` FOREIGN KEY (`edge_id`) REFERENCES `edges` (`id`),
  CONSTRAINT `edge_tile_tile_id_foreign` FOREIGN KEY (`tile_id`) REFERENCES `tiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edge_tile`
--

LOCK TABLES `edge_tile` WRITE;
/*!40000 ALTER TABLE `edge_tile` DISABLE KEYS */;
INSERT INTO `edge_tile` VALUES (1,4,1,'north',1,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,4,1,'east',1,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(3,4,1,'south',1,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(4,4,1,'west',1,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(5,2,2,'north',1,'2022-06-21 08:42:00','2022-06-21 08:42:00',NULL),(6,4,2,'east',1,'2022-06-21 08:42:00','2022-06-21 08:42:00',NULL),(7,3,2,'south',0,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(8,2,2,'west',1,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(9,1,3,'north',1,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(10,2,3,'east',1,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(11,1,3,'south',0,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(12,1,3,'west',1,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(13,3,4,'north',0,'2022-06-21 08:42:02','2022-06-21 08:42:02',NULL),(14,1,4,'east',1,'2022-06-21 08:42:02','2022-06-21 08:42:02',NULL),(15,3,4,'south',1,'2022-06-21 08:42:02','2022-06-21 08:42:02',NULL),(16,4,4,'west',0,'2022-06-21 08:42:02','2022-06-21 08:42:02',NULL),(17,3,5,'north',1,'2022-06-21 08:43:06','2022-06-21 08:43:06',NULL),(18,1,5,'east',0,'2022-06-21 08:43:06','2022-06-21 08:43:06',NULL),(19,4,5,'south',0,'2022-06-21 08:43:06','2022-06-21 08:43:06',NULL),(20,1,5,'west',0,'2022-06-21 08:43:06','2022-06-21 08:43:06',NULL),(21,2,6,'north',0,'2022-06-21 08:43:15','2022-06-21 08:43:15',NULL),(22,2,6,'east',0,'2022-06-21 08:43:15','2022-06-21 08:43:15',NULL),(23,1,6,'south',1,'2022-06-21 08:43:15','2022-06-21 08:43:15',NULL),(24,4,6,'west',1,'2022-06-21 08:43:15','2022-06-21 08:43:15',NULL),(25,1,7,'north',1,'2022-06-21 08:43:28','2022-06-21 08:43:28',NULL),(26,1,7,'east',1,'2022-06-21 08:43:28','2022-06-21 08:43:28',NULL),(27,4,7,'south',0,'2022-06-21 08:43:28','2022-06-21 08:43:28',NULL),(28,4,7,'west',1,'2022-06-21 08:43:28','2022-06-21 08:43:28',NULL),(29,4,8,'north',1,'2022-06-21 08:43:45','2022-06-21 08:43:45',NULL),(30,4,8,'east',1,'2022-06-21 08:43:45','2022-06-21 08:43:45',NULL),(31,4,8,'south',0,'2022-06-21 08:43:46','2022-06-21 08:43:46',NULL),(32,4,8,'west',0,'2022-06-21 08:43:46','2022-06-21 08:43:46',NULL),(33,3,9,'north',0,'2022-06-21 08:44:01','2022-06-21 08:44:01',NULL),(34,1,9,'east',0,'2022-06-21 08:44:01','2022-06-21 08:44:01',NULL),(35,2,9,'south',0,'2022-06-21 08:44:01','2022-06-21 08:44:01',NULL),(36,1,9,'west',1,'2022-06-21 08:44:01','2022-06-21 08:44:01',NULL),(37,2,10,'north',1,'2022-06-21 08:44:25','2022-06-21 08:44:25',NULL),(38,2,10,'east',1,'2022-06-21 08:44:25','2022-06-21 08:44:25',NULL),(39,4,10,'south',1,'2022-06-21 08:44:25','2022-06-21 08:44:25',NULL),(40,1,10,'west',0,'2022-06-21 08:44:25','2022-06-21 08:44:25',NULL),(41,3,11,'north',1,'2022-06-21 08:44:26','2022-06-21 08:44:26',NULL),(42,4,11,'east',0,'2022-06-21 08:44:26','2022-06-21 08:44:26',NULL),(43,2,11,'south',1,'2022-06-21 08:44:26','2022-06-21 08:44:26',NULL),(44,4,11,'west',1,'2022-06-21 08:44:26','2022-06-21 08:44:26',NULL),(45,2,12,'north',0,'2022-06-21 08:44:35','2022-06-21 08:44:35',NULL),(46,4,12,'east',1,'2022-06-21 08:44:35','2022-06-21 08:44:35',NULL),(47,2,12,'south',0,'2022-06-21 08:44:35','2022-06-21 08:44:35',NULL),(48,2,12,'west',1,'2022-06-21 08:44:35','2022-06-21 08:44:35',NULL),(49,2,13,'north',1,'2022-06-21 08:44:38','2022-06-21 08:44:38',NULL),(50,2,13,'east',1,'2022-06-21 08:44:38','2022-06-21 08:44:38',NULL),(51,3,13,'south',1,'2022-06-21 08:44:38','2022-06-21 08:44:38',NULL),(52,3,13,'west',1,'2022-06-21 08:44:38','2022-06-21 08:44:38',NULL),(53,3,14,'north',1,'2022-06-21 08:44:41','2022-06-21 08:44:41',NULL),(54,4,14,'east',0,'2022-06-21 08:44:41','2022-06-21 08:44:41',NULL),(55,1,14,'south',1,'2022-06-21 08:44:41','2022-06-21 08:44:41',NULL),(56,4,14,'west',0,'2022-06-21 08:44:41','2022-06-21 08:44:41',NULL),(57,2,15,'north',0,'2022-06-21 08:44:57','2022-06-21 08:44:57',NULL),(58,1,15,'east',0,'2022-06-21 08:44:57','2022-06-21 08:44:57',NULL),(59,2,15,'south',1,'2022-06-21 08:44:57','2022-06-21 08:44:57',NULL),(60,4,15,'west',0,'2022-06-21 08:44:57','2022-06-21 08:44:57',NULL),(61,2,16,'north',1,'2022-06-21 08:51:00','2022-06-21 08:51:00',NULL),(62,2,16,'east',1,'2022-06-21 08:51:00','2022-06-21 08:51:00',NULL),(63,3,16,'south',1,'2022-06-21 08:51:00','2022-06-21 08:51:00',NULL),(64,2,16,'west',1,'2022-06-21 08:51:00','2022-06-21 08:51:00',NULL),(65,1,17,'north',1,'2022-06-21 08:51:01','2022-06-21 08:51:01',NULL),(66,4,17,'east',0,'2022-06-21 08:51:01','2022-06-21 08:51:01',NULL),(67,2,17,'south',1,'2022-06-21 08:51:01','2022-06-21 08:51:01',NULL),(68,3,17,'west',1,'2022-06-21 08:51:01','2022-06-21 08:51:01',NULL),(69,2,18,'north',1,'2022-06-21 08:51:11','2022-06-21 08:51:11',NULL),(70,2,18,'east',0,'2022-06-21 08:51:11','2022-06-21 08:51:11',NULL),(71,1,18,'south',1,'2022-06-21 08:51:11','2022-06-21 08:51:11',NULL),(72,1,18,'west',0,'2022-06-21 08:51:11','2022-06-21 08:51:11',NULL),(73,1,19,'north',1,'2022-06-21 08:51:16','2022-06-21 08:51:16',NULL),(74,1,19,'east',1,'2022-06-21 08:51:16','2022-06-21 08:51:16',NULL),(75,2,19,'south',1,'2022-06-21 08:51:16','2022-06-21 08:51:16',NULL),(76,2,19,'west',1,'2022-06-21 08:51:16','2022-06-21 08:51:16',NULL),(77,3,20,'north',0,'2022-06-21 08:51:17','2022-06-21 08:51:17',NULL),(78,2,20,'east',0,'2022-06-21 08:51:17','2022-06-21 08:51:17',NULL),(79,1,20,'south',1,'2022-06-21 08:51:17','2022-06-21 08:51:17',NULL),(80,2,20,'west',1,'2022-06-21 08:51:17','2022-06-21 08:51:17',NULL),(81,2,21,'north',0,'2022-06-21 08:51:51','2022-06-21 08:51:51',NULL),(82,2,21,'east',1,'2022-06-21 08:51:51','2022-06-21 08:51:51',NULL),(83,2,21,'south',0,'2022-06-21 08:51:51','2022-06-21 08:51:51',NULL),(84,2,21,'west',0,'2022-06-21 08:51:51','2022-06-21 08:51:51',NULL),(85,2,22,'north',0,'2022-06-21 08:52:09','2022-06-21 08:52:09',NULL),(86,2,22,'east',1,'2022-06-21 08:52:09','2022-06-21 08:52:09',NULL),(87,2,22,'south',0,'2022-06-21 08:52:09','2022-06-21 08:52:09',NULL),(88,3,22,'west',0,'2022-06-21 08:52:09','2022-06-21 08:52:09',NULL),(89,2,23,'north',0,'2022-06-21 08:52:16','2022-06-21 08:52:16',NULL),(90,2,23,'east',0,'2022-06-21 08:52:16','2022-06-21 08:52:16',NULL),(91,3,23,'south',0,'2022-06-21 08:52:16','2022-06-21 08:52:16',NULL),(92,1,23,'west',1,'2022-06-21 08:52:16','2022-06-21 08:52:16',NULL),(93,1,24,'north',0,'2022-06-21 08:53:20','2022-06-21 08:53:20',NULL),(94,2,24,'east',1,'2022-06-21 08:53:20','2022-06-21 08:53:20',NULL),(95,2,24,'south',0,'2022-06-21 08:53:20','2022-06-21 08:53:20',NULL),(96,3,24,'west',1,'2022-06-21 08:53:20','2022-06-21 08:53:20',NULL),(97,3,25,'north',0,'2022-06-21 08:53:36','2022-06-21 08:53:36',NULL),(98,3,25,'east',1,'2022-06-21 08:53:36','2022-06-21 08:53:36',NULL),(99,1,25,'south',0,'2022-06-21 08:53:36','2022-06-21 08:53:36',NULL),(100,4,25,'west',0,'2022-06-21 08:53:36','2022-06-21 08:53:36',NULL),(101,2,26,'north',0,'2022-06-21 08:54:24','2022-06-21 08:54:24',NULL),(102,2,26,'east',1,'2022-06-21 08:54:24','2022-06-21 08:54:24',NULL),(103,2,26,'south',0,'2022-06-21 08:54:24','2022-06-21 08:54:24',NULL),(104,2,26,'west',1,'2022-06-21 08:54:24','2022-06-21 08:54:24',NULL),(105,3,27,'north',0,'2022-06-21 08:54:26','2022-06-21 08:54:26',NULL),(106,2,27,'east',1,'2022-06-21 08:54:26','2022-06-21 08:54:26',NULL),(107,3,27,'south',1,'2022-06-21 08:54:26','2022-06-21 08:54:26',NULL),(108,2,27,'west',1,'2022-06-21 08:54:26','2022-06-21 08:54:26',NULL),(109,2,28,'north',0,'2022-06-21 08:54:30','2022-06-21 08:54:30',NULL),(110,3,28,'east',1,'2022-06-21 08:54:30','2022-06-21 08:54:30',NULL),(111,1,28,'south',1,'2022-06-21 08:54:30','2022-06-21 08:54:30',NULL),(112,2,28,'west',1,'2022-06-21 08:54:30','2022-06-21 08:54:30',NULL),(113,1,29,'north',1,'2022-06-21 08:54:39','2022-06-21 08:54:39',NULL),(114,2,29,'east',0,'2022-06-21 08:54:39','2022-06-21 08:54:39',NULL),(115,2,29,'south',1,'2022-06-21 08:54:39','2022-06-21 08:54:39',NULL),(116,4,29,'west',1,'2022-06-21 08:54:39','2022-06-21 08:54:39',NULL),(117,3,30,'north',1,'2022-06-21 08:54:41','2022-06-21 08:54:41',NULL),(118,4,30,'east',1,'2022-06-21 08:54:41','2022-06-21 08:54:41',NULL),(119,1,30,'south',1,'2022-06-21 08:54:41','2022-06-21 08:54:41',NULL),(120,2,30,'west',1,'2022-06-21 08:54:41','2022-06-21 08:54:41',NULL),(121,1,31,'north',1,'2022-06-21 08:54:46','2022-06-21 08:54:46',NULL),(122,2,31,'east',0,'2022-06-21 08:54:46','2022-06-21 08:54:46',NULL),(123,4,31,'south',0,'2022-06-21 08:54:46','2022-06-21 08:54:46',NULL),(124,1,31,'west',1,'2022-06-21 08:54:46','2022-06-21 08:54:46',NULL),(125,1,32,'north',0,'2022-06-21 08:54:57','2022-06-21 08:54:57',NULL),(126,1,32,'east',1,'2022-06-21 08:54:57','2022-06-21 08:54:57',NULL),(127,2,32,'south',0,'2022-06-21 08:54:57','2022-06-21 08:54:57',NULL),(128,2,32,'west',1,'2022-06-21 08:54:57','2022-06-21 08:54:57',NULL),(129,2,33,'north',0,'2022-06-21 08:55:06','2022-06-21 08:55:06',NULL),(130,2,33,'east',1,'2022-06-21 08:55:06','2022-06-21 08:55:06',NULL),(131,1,33,'south',0,'2022-06-21 08:55:06','2022-06-21 08:55:06',NULL),(132,4,33,'west',0,'2022-06-21 08:55:06','2022-06-21 08:55:06',NULL),(133,2,34,'north',1,'2022-06-21 08:55:27','2022-06-21 08:55:27',NULL),(134,1,34,'east',0,'2022-06-21 08:55:27','2022-06-21 08:55:27',NULL),(135,1,34,'south',1,'2022-06-21 08:55:27','2022-06-21 08:55:27',NULL),(136,2,34,'west',0,'2022-06-21 08:55:27','2022-06-21 08:55:27',NULL),(137,1,35,'north',1,'2022-06-21 08:55:28','2022-06-21 08:55:28',NULL),(138,2,35,'east',0,'2022-06-21 08:55:28','2022-06-21 08:55:28',NULL),(139,3,35,'south',1,'2022-06-21 08:55:29','2022-06-21 08:55:29',NULL),(140,2,35,'west',1,'2022-06-21 08:55:29','2022-06-21 08:55:29',NULL),(141,3,36,'north',1,'2022-06-21 08:55:30','2022-06-21 08:55:30',NULL),(142,3,36,'east',1,'2022-06-21 08:55:30','2022-06-21 08:55:30',NULL),(143,3,36,'south',1,'2022-06-21 08:55:30','2022-06-21 08:55:30',NULL),(144,1,36,'west',0,'2022-06-21 08:55:31','2022-06-21 08:55:31',NULL),(145,4,37,'north',0,'2022-06-21 08:55:41','2022-06-21 08:55:41',NULL),(146,2,37,'east',1,'2022-06-21 08:55:41','2022-06-21 08:55:41',NULL),(147,3,37,'south',0,'2022-06-21 08:55:41','2022-06-21 08:55:41',NULL),(148,2,37,'west',0,'2022-06-21 08:55:41','2022-06-21 08:55:41',NULL),(149,3,38,'north',1,'2022-06-21 08:55:46','2022-06-21 08:55:46',NULL),(150,1,38,'east',1,'2022-06-21 08:55:46','2022-06-21 08:55:46',NULL),(151,2,38,'south',0,'2022-06-21 08:55:46','2022-06-21 08:55:46',NULL),(152,3,38,'west',1,'2022-06-21 08:55:46','2022-06-21 08:55:46',NULL),(153,2,39,'north',0,'2022-06-21 08:59:12','2022-06-21 08:59:12',NULL),(154,3,39,'east',1,'2022-06-21 08:59:12','2022-06-21 08:59:12',NULL),(155,3,39,'south',0,'2022-06-21 08:59:12','2022-06-21 08:59:12',NULL),(156,2,39,'west',0,'2022-06-21 08:59:12','2022-06-21 08:59:12',NULL),(157,2,40,'north',1,'2022-06-21 08:59:28','2022-06-21 08:59:28',NULL),(158,2,40,'east',1,'2022-06-21 08:59:28','2022-06-21 08:59:28',NULL),(159,1,40,'south',1,'2022-06-21 08:59:28','2022-06-21 08:59:28',NULL),(160,1,40,'west',1,'2022-06-21 08:59:28','2022-06-21 08:59:28',NULL),(161,2,41,'north',1,'2022-06-21 08:59:29','2022-06-21 08:59:29',NULL),(162,1,41,'east',0,'2022-06-21 08:59:29','2022-06-21 08:59:29',NULL),(163,1,41,'south',1,'2022-06-21 08:59:29','2022-06-21 08:59:29',NULL),(164,2,41,'west',1,'2022-06-21 08:59:30','2022-06-21 08:59:30',NULL),(165,1,42,'north',1,'2022-06-21 08:59:45','2022-06-21 08:59:45',NULL),(166,4,42,'east',1,'2022-06-21 08:59:45','2022-06-21 08:59:45',NULL),(167,3,42,'south',1,'2022-06-21 08:59:45','2022-06-21 08:59:45',NULL),(168,2,42,'west',0,'2022-06-21 08:59:45','2022-06-21 08:59:45',NULL),(169,1,43,'north',1,'2022-06-21 08:59:58','2022-06-21 08:59:58',NULL),(170,2,43,'east',0,'2022-06-21 08:59:58','2022-06-21 08:59:58',NULL),(171,2,43,'south',1,'2022-06-21 08:59:58','2022-06-21 08:59:58',NULL),(172,2,43,'west',0,'2022-06-21 08:59:58','2022-06-21 08:59:58',NULL),(173,2,44,'north',1,'2022-06-21 09:07:25','2022-06-21 09:07:25',NULL),(174,1,44,'east',1,'2022-06-21 09:07:25','2022-06-21 09:07:25',NULL),(175,1,44,'south',0,'2022-06-21 09:07:25','2022-06-21 09:07:25',NULL),(176,2,44,'west',1,'2022-06-21 09:07:25','2022-06-21 09:07:25',NULL),(177,1,45,'north',0,'2022-06-21 09:07:30','2022-06-21 09:07:30',NULL),(178,2,45,'east',1,'2022-06-21 09:07:30','2022-06-21 09:07:30',NULL),(179,4,45,'south',1,'2022-06-21 09:07:30','2022-06-21 09:07:30',NULL),(180,2,45,'west',1,'2022-06-21 09:07:30','2022-06-21 09:07:30',NULL),(181,1,46,'north',0,'2022-06-21 09:07:33','2022-06-21 09:07:33',NULL),(182,2,46,'east',1,'2022-06-21 09:07:34','2022-06-21 09:07:34',NULL),(183,4,46,'south',1,'2022-06-21 09:07:34','2022-06-21 09:07:34',NULL),(184,2,46,'west',0,'2022-06-21 09:07:34','2022-06-21 09:07:34',NULL),(185,4,47,'north',1,'2022-06-21 09:07:39','2022-06-21 09:07:39',NULL),(186,1,47,'east',1,'2022-06-21 09:07:39','2022-06-21 09:07:39',NULL),(187,2,47,'south',1,'2022-06-21 09:07:39','2022-06-21 09:07:39',NULL),(188,3,47,'west',0,'2022-06-21 09:07:39','2022-06-21 09:07:39',NULL),(189,4,48,'north',1,'2022-06-21 09:07:57','2022-06-21 09:07:57',NULL),(190,3,48,'east',0,'2022-06-21 09:07:57','2022-06-21 09:07:57',NULL),(191,3,48,'south',1,'2022-06-21 09:07:57','2022-06-21 09:07:57',NULL),(192,1,48,'west',1,'2022-06-21 09:07:57','2022-06-21 09:07:57',NULL),(193,2,49,'north',1,'2022-06-21 09:08:01','2022-06-21 09:08:01',NULL),(194,1,49,'east',1,'2022-06-21 09:08:01','2022-06-21 09:08:01',NULL),(195,3,49,'south',1,'2022-06-21 09:08:01','2022-06-21 09:08:01',NULL),(196,1,49,'west',1,'2022-06-21 09:08:01','2022-06-21 09:08:01',NULL),(197,1,50,'north',0,'2022-06-21 09:08:03','2022-06-21 09:08:03',NULL),(198,1,50,'east',1,'2022-06-21 09:08:03','2022-06-21 09:08:03',NULL),(199,3,50,'south',1,'2022-06-21 09:08:03','2022-06-21 09:08:03',NULL),(200,3,50,'west',1,'2022-06-21 09:08:04','2022-06-21 09:08:04',NULL),(201,2,51,'north',0,'2022-06-21 09:08:13','2022-06-21 09:08:13',NULL),(202,3,51,'east',1,'2022-06-21 09:08:13','2022-06-21 09:08:13',NULL),(203,1,51,'south',1,'2022-06-21 09:08:13','2022-06-21 09:08:13',NULL),(204,2,51,'west',1,'2022-06-21 09:08:13','2022-06-21 09:08:13',NULL),(205,1,52,'north',1,'2022-06-21 09:08:17','2022-06-21 09:08:17',NULL),(206,2,52,'east',1,'2022-06-21 09:08:17','2022-06-21 09:08:17',NULL),(207,2,52,'south',1,'2022-06-21 09:08:17','2022-06-21 09:08:17',NULL),(208,1,52,'west',0,'2022-06-21 09:08:17','2022-06-21 09:08:17',NULL),(209,2,53,'north',1,'2022-06-21 09:08:22','2022-06-21 09:08:22',NULL),(210,1,53,'east',0,'2022-06-21 09:08:22','2022-06-21 09:08:22',NULL),(211,1,53,'south',1,'2022-06-21 09:08:22','2022-06-21 09:08:22',NULL),(212,2,53,'west',1,'2022-06-21 09:08:22','2022-06-21 09:08:22',NULL),(213,1,54,'north',1,'2022-06-21 09:08:24','2022-06-21 09:08:24',NULL),(214,4,54,'east',0,'2022-06-21 09:08:24','2022-06-21 09:08:24',NULL),(215,2,54,'south',1,'2022-06-21 09:08:24','2022-06-21 09:08:24',NULL),(216,2,54,'west',1,'2022-06-21 09:08:24','2022-06-21 09:08:24',NULL),(217,3,55,'north',1,'2022-06-21 09:08:26','2022-06-21 09:08:26',NULL),(218,1,55,'east',0,'2022-06-21 09:08:26','2022-06-21 09:08:26',NULL),(219,1,55,'south',1,'2022-06-21 09:08:26','2022-06-21 09:08:26',NULL),(220,1,55,'west',0,'2022-06-21 09:08:26','2022-06-21 09:08:26',NULL),(221,1,56,'north',1,'2022-06-21 09:08:42','2022-06-21 09:08:42',NULL),(222,4,56,'east',0,'2022-06-21 09:08:42','2022-06-21 09:08:42',NULL),(223,3,56,'south',1,'2022-06-21 09:08:42','2022-06-21 09:08:42',NULL),(224,1,56,'west',1,'2022-06-21 09:08:42','2022-06-21 09:08:42',NULL),(225,3,57,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(226,3,57,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(227,3,57,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(228,3,57,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(229,3,58,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(230,3,58,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(231,3,58,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(232,3,58,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(233,3,59,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(234,3,59,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(235,3,59,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(236,3,59,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(237,3,58,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(238,3,58,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(239,3,58,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(240,3,58,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(241,3,60,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(242,3,60,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(243,3,60,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(244,3,60,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(245,3,61,'north',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(246,3,61,'east',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(247,3,61,'south',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(248,3,61,'west',0,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(249,3,60,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(250,3,60,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(251,3,60,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(252,3,60,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(253,3,62,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(254,3,62,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(255,3,62,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(256,3,62,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(257,3,63,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(258,3,63,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(259,3,63,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(260,3,63,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(261,3,62,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(262,3,62,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(263,3,62,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(264,3,62,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(265,3,64,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(266,3,64,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(267,3,64,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(268,3,64,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(269,3,64,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(270,3,64,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(271,3,64,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(272,3,64,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(273,3,63,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(274,3,63,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(275,3,63,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(276,3,63,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(277,3,65,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(278,3,65,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(279,3,65,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(280,3,65,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(281,3,65,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(282,3,65,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(283,3,65,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(284,3,65,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(285,3,66,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(286,3,66,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(287,3,66,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(288,3,66,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(289,3,66,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(290,3,66,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(291,3,66,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(292,3,66,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(293,3,61,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(294,3,61,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(295,3,61,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(296,3,61,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(297,3,59,'north',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(298,3,59,'east',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(299,3,59,'south',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(300,3,59,'west',0,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(301,3,68,'north',0,'2022-06-21 09:09:20','2022-06-21 09:09:20',NULL),(302,4,68,'east',0,'2022-06-21 09:09:20','2022-06-21 09:09:20',NULL),(303,1,68,'south',1,'2022-06-21 09:09:20','2022-06-21 09:09:20',NULL),(304,4,68,'west',0,'2022-06-21 09:09:20','2022-06-21 09:09:20',NULL),(305,4,69,'north',1,'2022-06-21 09:11:41','2022-06-21 09:11:41',NULL),(306,1,69,'east',1,'2022-06-21 09:11:41','2022-06-21 09:11:41',NULL),(307,1,69,'south',0,'2022-06-21 09:11:41','2022-06-21 09:11:41',NULL),(308,1,69,'west',1,'2022-06-21 09:11:41','2022-06-21 09:11:41',NULL),(309,4,70,'north',0,'2022-06-21 09:11:54','2022-06-21 09:11:54',NULL),(310,1,70,'east',1,'2022-06-21 09:11:54','2022-06-21 09:11:54',NULL),(311,1,70,'south',1,'2022-06-21 09:11:54','2022-06-21 09:11:54',NULL),(312,3,70,'west',1,'2022-06-21 09:11:54','2022-06-21 09:11:54',NULL),(313,1,71,'north',0,'2022-06-21 09:27:27','2022-06-21 09:27:27',NULL),(314,4,71,'east',0,'2022-06-21 09:27:27','2022-06-21 09:27:27',NULL),(315,4,71,'south',1,'2022-06-21 09:27:27','2022-06-21 09:27:27',NULL),(316,1,71,'west',0,'2022-06-21 09:27:27','2022-06-21 09:27:27',NULL);
/*!40000 ALTER TABLE `edge_tile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `edges`
--

DROP TABLE IF EXISTS `edges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `edges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `edges`
--

LOCK TABLES `edges` WRITE;
/*!40000 ALTER TABLE `edges` DISABLE KEYS */;
INSERT INTO `edges` VALUES (1,'Dirt','A dusty, dirty patch of land.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,'Sandy','A dry, sandy area.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(3,'Water','A watery area.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(4,'Grass','A grassy field.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL);
/*!40000 ALTER TABLE `edges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `effect_item`
--

DROP TABLE IF EXISTS `effect_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `effect_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `item_id` bigint unsigned NOT NULL,
  `effect_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `effect_item_item_id_foreign` (`item_id`),
  KEY `effect_item_effect_id_foreign` (`effect_id`),
  CONSTRAINT `effect_item_effect_id_foreign` FOREIGN KEY (`effect_id`) REFERENCES `effects` (`id`),
  CONSTRAINT `effect_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `effect_item`
--

LOCK TABLES `effect_item` WRITE;
/*!40000 ALTER TABLE `effect_item` DISABLE KEYS */;
INSERT INTO `effect_item` VALUES (1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1);
/*!40000 ALTER TABLE `effect_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `effects`
--

DROP TABLE IF EXISTS `effects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `effects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` smallint NOT NULL,
  `health_change` smallint NOT NULL,
  `mana_change` smallint NOT NULL,
  `stamina_change` smallint NOT NULL,
  `strength_change` smallint NOT NULL,
  `luck_change` smallint NOT NULL,
  `damage_change` smallint NOT NULL,
  `armor_change` smallint NOT NULL,
  `speed_change` smallint NOT NULL,
  `critical_chance` smallint unsigned NOT NULL,
  `critical_damage` smallint NOT NULL,
  `compounds` tinyint(1) NOT NULL,
  `compound_chance` smallint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `effects`
--

LOCK TABLES `effects` WRITE;
/*!40000 ALTER TABLE `effects` DISABLE KEYS */;
INSERT INTO `effects` VALUES (1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,'Tetanus','The sword was rusty',-1,-5,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `effects` ENABLE KEYS */;
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
-- Table structure for table `inventories`
--

DROP TABLE IF EXISTS `inventories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `gold` bigint unsigned NOT NULL,
  `size` smallint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `inventories_user_id_foreign` (`user_id`),
  CONSTRAINT `inventories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventories`
--

LOCK TABLES `inventories` WRITE;
/*!40000 ALTER TABLE `inventories` DISABLE KEYS */;
INSERT INTO `inventories` VALUES (1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,0,5),(2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,2,0,5),(3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,3,0,5),(4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,4,0,5);
/*!40000 ALTER TABLE `inventories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_item`
--

DROP TABLE IF EXISTS `inventory_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `inventory_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `inventory_item_inventory_id_foreign` (`inventory_id`),
  KEY `inventory_item_item_id_foreign` (`item_id`),
  CONSTRAINT `inventory_item_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  CONSTRAINT `inventory_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_item`
--

LOCK TABLES `inventory_item` WRITE;
/*!40000 ALTER TABLE `inventory_item` DISABLE KEYS */;
INSERT INTO `inventory_item` VALUES (1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1),(2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,2),(3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,3);
/*!40000 ALTER TABLE `inventory_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` bigint unsigned NOT NULL,
  `interactive` tinyint(1) NOT NULL DEFAULT '0',
  `wieldable` tinyint(1) NOT NULL DEFAULT '0',
  `throwable` tinyint(1) NOT NULL DEFAULT '0',
  `wearable` tinyint(1) NOT NULL DEFAULT '0',
  `consumable` tinyint(1) NOT NULL DEFAULT '0',
  `stackable` tinyint(1) NOT NULL DEFAULT '0',
  `durability` smallint unsigned NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,'Rusty Sword','A rusty sword',2,1,1,0,0,0,0,5),(2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,'Robust Sword','A robust sword',5,1,1,0,0,0,0,55),(3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,'Logs','A bundle of logs',2,1,0,0,0,0,1,100);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (19,'2014_10_12_000000_create_users_table',1),(20,'2014_10_12_100000_create_password_resets_table',1),(21,'2019_08_19_000000_create_failed_jobs_table',1),(22,'2019_12_14_000001_create_personal_access_tokens_table',1),(23,'2022_06_10_024657_create_inventories_table',1),(24,'2022_06_10_025725_create_items_table',1),(25,'2022_06_11_061729_create_command_logs_table',1),(26,'2022_06_13_054641_create_tiles_table',1),(27,'2022_06_19_022944_create_move_logs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `move_logs`
--

DROP TABLE IF EXISTS `move_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `move_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `old_tile_id` bigint unsigned NOT NULL,
  `new_tile_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `move_logs_user_id_foreign` (`user_id`),
  KEY `move_logs_old_tile_id_foreign` (`old_tile_id`),
  KEY `move_logs_new_tile_id_foreign` (`new_tile_id`),
  CONSTRAINT `move_logs_new_tile_id_foreign` FOREIGN KEY (`new_tile_id`) REFERENCES `tiles` (`id`),
  CONSTRAINT `move_logs_old_tile_id_foreign` FOREIGN KEY (`old_tile_id`) REFERENCES `tiles` (`id`),
  CONSTRAINT `move_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `move_logs`
--

LOCK TABLES `move_logs` WRITE;
/*!40000 ALTER TABLE `move_logs` DISABLE KEYS */;
INSERT INTO `move_logs` VALUES (1,1,1,2,'2022-06-21 08:42:01','2022-06-21 08:42:01'),(2,1,2,3,'2022-06-21 08:42:01','2022-06-21 08:42:01'),(3,1,3,4,'2022-06-21 08:42:03','2022-06-21 08:42:03'),(4,1,4,5,'2022-06-21 08:43:06','2022-06-21 08:43:06'),(5,1,5,4,'2022-06-21 08:43:11','2022-06-21 08:43:11'),(6,1,4,3,'2022-06-21 08:43:14','2022-06-21 08:43:14'),(7,1,3,2,'2022-06-21 08:43:15','2022-06-21 08:43:15'),(8,1,2,1,'2022-06-21 08:43:15','2022-06-21 08:43:15'),(9,1,1,6,'2022-06-21 08:43:16','2022-06-21 08:43:16'),(10,1,6,7,'2022-06-21 08:43:29','2022-06-21 08:43:29'),(11,1,7,8,'2022-06-21 08:43:46','2022-06-21 08:43:46'),(12,1,8,7,'2022-06-21 08:44:01','2022-06-21 08:44:01'),(13,1,7,9,'2022-06-21 08:44:01','2022-06-21 08:44:01'),(14,1,9,7,'2022-06-21 08:44:10','2022-06-21 08:44:10'),(15,1,7,8,'2022-06-21 08:44:11','2022-06-21 08:44:11'),(16,1,8,1,'2022-06-21 08:44:24','2022-06-21 08:44:24'),(17,1,1,10,'2022-06-21 08:44:25','2022-06-21 08:44:25'),(18,1,10,11,'2022-06-21 08:44:27','2022-06-21 08:44:27'),(19,1,11,12,'2022-06-21 08:44:35','2022-06-21 08:44:35'),(20,1,12,13,'2022-06-21 08:44:39','2022-06-21 08:44:39'),(21,1,13,14,'2022-06-21 08:44:42','2022-06-21 08:44:42'),(22,1,14,3,'2022-06-21 08:44:43','2022-06-21 08:44:43'),(23,1,3,2,'2022-06-21 08:44:56','2022-06-21 08:44:56'),(24,1,2,15,'2022-06-21 08:44:57','2022-06-21 08:44:57'),(25,1,15,2,'2022-06-21 08:50:54','2022-06-21 08:50:54'),(26,1,2,1,'2022-06-21 08:50:56','2022-06-21 08:50:56'),(27,1,1,10,'2022-06-21 08:50:57','2022-06-21 08:50:57'),(28,1,10,11,'2022-06-21 08:50:58','2022-06-21 08:50:58'),(29,1,11,16,'2022-06-21 08:51:01','2022-06-21 08:51:01'),(30,1,16,17,'2022-06-21 08:51:02','2022-06-21 08:51:02'),(31,1,17,18,'2022-06-21 08:51:12','2022-06-21 08:51:12'),(32,1,18,19,'2022-06-21 08:51:17','2022-06-21 08:51:17'),(33,1,19,20,'2022-06-21 08:51:18','2022-06-21 08:51:18'),(34,1,20,21,'2022-06-21 08:51:52','2022-06-21 08:51:52'),(35,1,21,20,'2022-06-21 08:52:01','2022-06-21 08:52:01'),(36,1,20,19,'2022-06-21 08:52:04','2022-06-21 08:52:04'),(37,1,19,22,'2022-06-21 08:52:09','2022-06-21 08:52:09'),(38,1,22,19,'2022-06-21 08:52:16','2022-06-21 08:52:16'),(39,1,19,23,'2022-06-21 08:52:17','2022-06-21 08:52:17'),(40,1,23,19,'2022-06-21 08:52:22','2022-06-21 08:52:22'),(41,1,19,18,'2022-06-21 08:53:07','2022-06-21 08:53:07'),(42,1,18,17,'2022-06-21 08:53:08','2022-06-21 08:53:08'),(43,1,17,16,'2022-06-21 08:53:09','2022-06-21 08:53:09'),(44,1,16,11,'2022-06-21 08:53:12','2022-06-21 08:53:12'),(45,1,11,16,'2022-06-21 08:53:20','2022-06-21 08:53:20'),(46,1,16,24,'2022-06-21 08:53:21','2022-06-21 08:53:21'),(47,1,24,16,'2022-06-21 08:53:27','2022-06-21 08:53:27'),(48,1,16,17,'2022-06-21 08:53:33','2022-06-21 08:53:33'),(49,1,17,25,'2022-06-21 08:53:37','2022-06-21 08:53:37'),(50,1,25,17,'2022-06-21 08:54:18','2022-06-21 08:54:18'),(51,1,17,16,'2022-06-21 08:54:20','2022-06-21 08:54:20'),(52,1,16,26,'2022-06-21 08:54:25','2022-06-21 08:54:25'),(53,1,26,27,'2022-06-21 08:54:26','2022-06-21 08:54:26'),(54,1,27,28,'2022-06-21 08:54:31','2022-06-21 08:54:31'),(55,1,28,29,'2022-06-21 08:54:40','2022-06-21 08:54:40'),(56,1,29,30,'2022-06-21 08:54:42','2022-06-21 08:54:42'),(57,1,30,31,'2022-06-21 08:54:47','2022-06-21 08:54:47'),(58,1,31,32,'2022-06-21 08:54:58','2022-06-21 08:54:58'),(59,1,32,31,'2022-06-21 08:55:05','2022-06-21 08:55:05'),(60,1,31,30,'2022-06-21 08:55:06','2022-06-21 08:55:06'),(61,1,30,33,'2022-06-21 08:55:07','2022-06-21 08:55:07'),(62,1,33,30,'2022-06-21 08:55:23','2022-06-21 08:55:23'),(63,1,30,29,'2022-06-21 08:55:24','2022-06-21 08:55:24'),(64,1,29,34,'2022-06-21 08:55:28','2022-06-21 08:55:28'),(65,1,34,35,'2022-06-21 08:55:29','2022-06-21 08:55:29'),(66,1,35,36,'2022-06-21 08:55:31','2022-06-21 08:55:31'),(67,1,36,35,'2022-06-21 08:55:40','2022-06-21 08:55:40'),(68,1,35,37,'2022-06-21 08:55:42','2022-06-21 08:55:42'),(69,1,37,35,'2022-06-21 08:55:43','2022-06-21 08:55:43'),(70,1,35,36,'2022-06-21 08:55:46','2022-06-21 08:55:46'),(71,1,36,38,'2022-06-21 08:55:47','2022-06-21 08:55:47'),(72,1,38,39,'2022-06-21 08:59:13','2022-06-21 08:59:13'),(73,1,39,38,'2022-06-21 08:59:28','2022-06-21 08:59:28'),(74,1,38,40,'2022-06-21 08:59:29','2022-06-21 08:59:29'),(75,1,40,41,'2022-06-21 08:59:30','2022-06-21 08:59:30'),(76,1,41,42,'2022-06-21 08:59:46','2022-06-21 08:59:46'),(77,1,42,41,'2022-06-21 08:59:56','2022-06-21 08:59:56'),(78,1,41,40,'2022-06-21 08:59:57','2022-06-21 08:59:57'),(79,1,40,43,'2022-06-21 08:59:59','2022-06-21 08:59:59'),(80,1,43,44,'2022-06-21 09:07:26','2022-06-21 09:07:26'),(81,1,44,45,'2022-06-21 09:07:32','2022-06-21 09:07:32'),(82,1,45,46,'2022-06-21 09:07:35','2022-06-21 09:07:35'),(83,1,46,47,'2022-06-21 09:07:40','2022-06-21 09:07:40'),(84,1,47,48,'2022-06-21 09:07:59','2022-06-21 09:07:59'),(85,1,48,47,'2022-06-21 09:08:00','2022-06-21 09:08:00'),(86,1,47,49,'2022-06-21 09:08:02','2022-06-21 09:08:02'),(87,1,49,50,'2022-06-21 09:08:05','2022-06-21 09:08:05'),(88,1,50,51,'2022-06-21 09:08:14','2022-06-21 09:08:14'),(89,1,51,52,'2022-06-21 09:08:19','2022-06-21 09:08:19'),(90,1,52,53,'2022-06-21 09:08:23','2022-06-21 09:08:23'),(91,1,53,54,'2022-06-21 09:08:25','2022-06-21 09:08:25'),(92,1,54,55,'2022-06-21 09:08:27','2022-06-21 09:08:27'),(93,1,56,68,'2022-06-21 09:09:21','2022-06-21 09:09:21'),(94,1,68,56,'2022-06-21 09:11:41','2022-06-21 09:11:41'),(95,1,56,69,'2022-06-21 09:11:42','2022-06-21 09:11:42'),(96,1,69,70,'2022-06-21 09:11:55','2022-06-21 09:11:55'),(97,1,70,69,'2022-06-21 09:27:24','2022-06-21 09:27:24'),(98,1,69,71,'2022-06-21 09:27:28','2022-06-21 09:27:28');
/*!40000 ALTER TABLE `move_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `npc_tile`
--

DROP TABLE IF EXISTS `npc_tile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `npc_tile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tile_id` bigint unsigned NOT NULL,
  `npc_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `npc_tile_tile_id_foreign` (`tile_id`),
  KEY `npc_tile_npc_id_foreign` (`npc_id`),
  CONSTRAINT `npc_tile_npc_id_foreign` FOREIGN KEY (`npc_id`) REFERENCES `npcs` (`id`),
  CONSTRAINT `npc_tile_tile_id_foreign` FOREIGN KEY (`tile_id`) REFERENCES `tiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `npc_tile`
--

LOCK TABLES `npc_tile` WRITE;
/*!40000 ALTER TABLE `npc_tile` DISABLE KEYS */;
INSERT INTO `npc_tile` VALUES (1,1,1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(2,1,2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,1,3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,1,4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,1,5,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(6,1,6,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(7,1,7,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `npc_tile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `npcs`
--

DROP TABLE IF EXISTS `npcs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `npcs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `npcs`
--

LOCK TABLES `npcs` WRITE;
/*!40000 ALTER TABLE `npcs` DISABLE KEYS */;
INSERT INTO `npcs` VALUES (1,'Chef Isaac','A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',1,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(2,'Priest Peter','A priest of the church. He speaks in foreign tongues and wears a pendant with what looks like a squid.',2,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,'Asselin Alderman','A very friendly person. He is holding a heavy book and seems to know what he is talking about.',3,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,'Vicar Bertaut','A scar under his eye, and a beard that is a bit too long. The quality of his armor is lacking but he sports expensive jewelry.',4,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,'Edrick Fryee','Wearing an unfamiliar animal skin, he plays a beautiful and unique string instrument of his own creation.',5,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(6,'Thistle Tatume','Mystical eyes look back at you, inviting you for a drink.',6,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(7,'Sylvia Wescotte','A beautiful girl that appears to be poverty-stricken. She works hard and shares little information.',7,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(8,'Gibb Wyon','An experienced farmer, born and raised. His clothing looks worn.',8,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `npcs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `occupations`
--

DROP TABLE IF EXISTS `occupations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `occupations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `occupations`
--

LOCK TABLES `occupations` WRITE;
/*!40000 ALTER TABLE `occupations` DISABLE KEYS */;
INSERT INTO `occupations` VALUES (1,'Chef','A talented cook by nature.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(2,'Priest','Lives and works in the church.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,'Guide','Offers guidance.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,'Guard','A pay-to-play mercenary.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,'Bard','Sing me a song, you\'re the music man.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(6,'Bartender','Serves you food and beverages, and maybe has heard a thing or two.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(7,'Barmaid','Serves you food and beverages, and maybe has heard a thing or two.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(8,'Farmer','Works the farm.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(9,'Clerk','Works the cash register.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(10,'Cook','Cooks the food.','2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `occupations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_name_index` (`name`)
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'bot-managed','98ac3ba8df038e472a362e1f31bf6bb21481352645a587750b25a681861d980b','[\"*\"]','2022-06-26 03:57:43','2022-06-21 08:41:43','2022-06-26 03:57:43'),(2,'App\\Models\\User',6,'bot-managed','14922097750b90eb62bcd96b72d8c09f32688367486cc35187f52e98458c4b80','[\"*\"]',NULL,'2022-06-26 21:55:56','2022-06-26 21:55:56'),(3,'App\\Models\\User',6,'bot-managed','2b6e9a3a37cdd28294edf73bff5d9050dcdd46cdc98b074e66cc7c926dcd2f2e','[\"*\"]',NULL,'2022-06-26 22:00:32','2022-06-26 22:00:32');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terrain_tile`
--

DROP TABLE IF EXISTS `terrain_tile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terrain_tile` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tile_id` bigint unsigned NOT NULL,
  `terrain_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terrain_tile`
--

LOCK TABLES `terrain_tile` WRITE;
/*!40000 ALTER TABLE `terrain_tile` DISABLE KEYS */;
INSERT INTO `terrain_tile` VALUES (1,57,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(2,58,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(3,59,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(4,58,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(5,60,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(6,61,2,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(7,60,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(8,62,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(9,63,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(10,62,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(11,64,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(12,64,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(13,63,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(14,65,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(15,65,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(16,66,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(17,66,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(18,61,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(19,59,2,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL);
/*!40000 ALTER TABLE `terrain_tile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `terrains`
--

DROP TABLE IF EXISTS `terrains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `terrains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `terrains`
--

LOCK TABLES `terrains` WRITE;
/*!40000 ALTER TABLE `terrains` DISABLE KEYS */;
INSERT INTO `terrains` VALUES (1,'Grassy','A grassy field.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,'Water','A watery area.','2022-06-21 04:27:23','2022-06-21 04:27:23',NULL);
/*!40000 ALTER TABLE `terrains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiles`
--

DROP TABLE IF EXISTS `tiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `discovered_by` bigint unsigned DEFAULT NULL,
  `psuedo_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x` bigint NOT NULL,
  `y` bigint NOT NULL,
  `max_trees` smallint unsigned NOT NULL DEFAULT '0',
  `available_trees` smallint unsigned NOT NULL DEFAULT '0',
  `last_disturbed` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tiles_psuedo_id_unique` (`psuedo_id`),
  KEY `tiles_discovered_by_foreign` (`discovered_by`),
  CONSTRAINT `tiles_discovered_by_foreign` FOREIGN KEY (`discovered_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiles`
--

LOCK TABLES `tiles` WRITE;
/*!40000 ALTER TABLE `tiles` DISABLE KEYS */;
INSERT INTO `tiles` VALUES (1,NULL,'0,0',0,0,15,15,NULL,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,1,'-1,0',-1,0,74,74,NULL,'2022-06-21 08:42:00','2022-06-21 08:42:00',NULL),(3,1,'-2,0',-2,0,99,99,NULL,'2022-06-21 08:42:01','2022-06-21 08:42:01',NULL),(4,1,'-3,0',-3,0,63,63,NULL,'2022-06-21 08:42:02','2022-06-21 08:42:02',NULL),(5,1,'-3,-1',-3,-1,100,100,NULL,'2022-06-21 08:43:05','2022-06-21 08:43:05',NULL),(6,1,'1,0',1,0,79,79,NULL,'2022-06-21 08:43:15','2022-06-21 08:43:15',NULL),(7,1,'1,-1',1,-1,56,56,NULL,'2022-06-21 08:43:28','2022-06-21 08:43:28',NULL),(8,1,'0,-1',0,-1,83,83,NULL,'2022-06-21 08:43:45','2022-06-21 08:43:45',NULL),(9,1,'2,-1',2,-1,39,39,NULL,'2022-06-21 08:44:01','2022-06-21 08:44:01',NULL),(10,1,'0,1',0,1,89,89,NULL,'2022-06-21 08:44:25','2022-06-21 08:44:25',NULL),(11,1,'0,2',0,2,43,43,NULL,'2022-06-21 08:44:26','2022-06-21 08:44:26',NULL),(12,1,'-1,2',-1,2,74,74,NULL,'2022-06-21 08:44:34','2022-06-21 08:44:34',NULL),(13,1,'-2,2',-2,2,45,45,NULL,'2022-06-21 08:44:38','2022-06-21 08:44:38',NULL),(14,1,'-2,1',-2,1,10,10,NULL,'2022-06-21 08:44:41','2022-06-21 08:44:41',NULL),(15,1,'-1,1',-1,1,23,23,NULL,'2022-06-21 08:44:57','2022-06-21 08:44:57',NULL),(16,1,'0,3',0,3,74,74,NULL,'2022-06-21 08:51:00','2022-06-21 08:51:00',NULL),(17,1,'0,4',0,4,40,40,NULL,'2022-06-21 08:51:01','2022-06-21 08:51:01',NULL),(18,1,'0,5',0,5,56,56,NULL,'2022-06-21 08:51:11','2022-06-21 08:51:11',NULL),(19,1,'0,6',0,6,73,73,NULL,'2022-06-21 08:51:16','2022-06-21 08:51:16',NULL),(20,1,'0,7',0,7,30,30,NULL,'2022-06-21 08:51:17','2022-06-21 08:51:17',NULL),(21,1,'-1,7',-1,7,40,40,NULL,'2022-06-21 08:51:51','2022-06-21 08:51:51',NULL),(22,1,'-1,6',-1,6,63,63,NULL,'2022-06-21 08:52:09','2022-06-21 08:52:09',NULL),(23,1,'1,6',1,6,42,42,NULL,'2022-06-21 08:52:16','2022-06-21 08:52:16',NULL),(24,1,'-1,3',-1,3,96,96,NULL,'2022-06-21 08:53:20','2022-06-21 08:53:20',NULL),(25,1,'-1,4',-1,4,52,52,NULL,'2022-06-21 08:53:36','2022-06-21 08:53:36',NULL),(26,1,'1,3',1,3,50,50,NULL,'2022-06-21 08:54:24','2022-06-21 08:54:24',NULL),(27,1,'2,3',2,3,99,99,NULL,'2022-06-21 08:54:25','2022-06-21 08:54:25',NULL),(28,1,'3,3',3,3,61,61,NULL,'2022-06-21 08:54:30','2022-06-21 08:54:30',NULL),(29,1,'3,2',3,2,84,84,NULL,'2022-06-21 08:54:38','2022-06-21 08:54:38',NULL),(30,1,'2,2',2,2,48,48,NULL,'2022-06-21 08:54:41','2022-06-21 08:54:41',NULL),(31,1,'2,1',2,1,22,22,NULL,'2022-06-21 08:54:46','2022-06-21 08:54:46',NULL),(32,1,'1,1',1,1,53,53,NULL,'2022-06-21 08:54:57','2022-06-21 08:54:57',NULL),(33,1,'1,2',1,2,52,52,NULL,'2022-06-21 08:55:06','2022-06-21 08:55:06',NULL),(34,1,'3,1',3,1,17,17,NULL,'2022-06-21 08:55:27','2022-06-21 08:55:27',NULL),(35,1,'3,0',3,0,94,94,NULL,'2022-06-21 08:55:28','2022-06-21 08:55:28',NULL),(36,1,'3,-1',3,-1,100,100,NULL,'2022-06-21 08:55:30','2022-06-21 08:55:30',NULL),(37,1,'2,0',2,0,35,35,NULL,'2022-06-21 08:55:41','2022-06-21 08:55:41',NULL),(38,1,'3,-2',3,-2,98,98,NULL,'2022-06-21 08:55:46','2022-06-21 08:55:46',NULL),(39,1,'2,-2',2,-2,24,24,NULL,'2022-06-21 08:59:12','2022-06-21 08:59:12',NULL),(40,1,'4,-2',4,-2,72,72,NULL,'2022-06-21 08:59:28','2022-06-21 08:59:28',NULL),(41,1,'5,-2',5,-2,64,64,NULL,'2022-06-21 08:59:29','2022-06-21 08:59:29',NULL),(42,1,'5,-3',5,-3,91,91,NULL,'2022-06-21 08:59:45','2022-06-21 08:59:45',NULL),(43,1,'4,-3',4,-3,95,95,NULL,'2022-06-21 08:59:58','2022-06-21 08:59:58',NULL),(44,1,'4,-4',4,-4,35,35,NULL,'2022-06-21 09:07:25','2022-06-21 09:07:25',NULL),(45,1,'3,-4',3,-4,46,46,NULL,'2022-06-21 09:07:30','2022-06-21 09:07:30',NULL),(46,1,'2,-4',2,-4,30,30,NULL,'2022-06-21 09:07:33','2022-06-21 09:07:33',NULL),(47,1,'2,-5',2,-5,98,98,NULL,'2022-06-21 09:07:39','2022-06-21 09:07:39',NULL),(48,1,'3,-5',3,-5,71,71,NULL,'2022-06-21 09:07:57','2022-06-21 09:07:57',NULL),(49,1,'2,-6',2,-6,68,68,NULL,'2022-06-21 09:08:01','2022-06-21 09:08:01',NULL),(50,1,'1,-6',1,-6,77,77,NULL,'2022-06-21 09:08:03','2022-06-21 09:08:03',NULL),(51,1,'0,-6',0,-6,21,21,NULL,'2022-06-21 09:08:13','2022-06-21 09:08:13',NULL),(52,1,'-1,-6',-1,-6,23,23,NULL,'2022-06-21 09:08:17','2022-06-21 09:08:17',NULL),(53,1,'-1,-5',-1,-5,92,92,NULL,'2022-06-21 09:08:22','2022-06-21 09:08:22',NULL),(54,1,'-1,-4',-1,-4,96,96,NULL,'2022-06-21 09:08:24','2022-06-21 09:08:24',NULL),(55,1,'-1,-3',-1,-3,29,29,NULL,'2022-06-21 09:08:26','2022-06-21 09:08:26',NULL),(56,1,'-1,-2',-1,-2,0,0,NULL,'2022-06-21 09:08:42','2022-06-21 09:08:42',NULL),(57,NULL,'0,-5',0,-5,0,0,NULL,'2022-06-21 09:08:44','2022-06-21 09:08:44',NULL),(58,NULL,'0,-4',0,-4,0,0,NULL,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(59,NULL,'1,-5',1,-5,0,0,NULL,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(60,NULL,'0,-3',0,-3,0,0,NULL,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(61,NULL,'1,-4',1,-4,0,0,NULL,'2022-06-21 09:08:45','2022-06-21 09:08:45',NULL),(62,NULL,'0,-2',0,-2,0,0,NULL,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(63,NULL,'1,-3',1,-3,0,0,NULL,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(64,NULL,'1,-2',1,-2,0,0,NULL,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(65,NULL,'2,-3',2,-3,0,0,NULL,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(66,NULL,'3,-3',3,-3,0,0,NULL,'2022-06-21 09:08:46','2022-06-21 09:08:46',NULL),(68,1,'-1,-1',-1,-1,51,51,NULL,'2022-06-21 09:09:20','2022-06-21 09:09:20',NULL),(69,1,'-2,-2',-2,-2,53,53,NULL,'2022-06-21 09:11:41','2022-06-21 09:11:41',NULL),(70,1,'-3,-2',-3,-2,90,90,NULL,'2022-06-21 09:11:54','2022-06-21 09:11:54',NULL),(71,1,'-2,-1',-2,-1,100,100,NULL,'2022-06-21 09:27:27','2022-06-21 09:27:27',NULL);
/*!40000 ALTER TABLE `tiles` ENABLE KEYS */;
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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thieving` mediumint unsigned NOT NULL DEFAULT '0',
  `fishing` mediumint unsigned NOT NULL DEFAULT '0',
  `mining` mediumint unsigned NOT NULL DEFAULT '0',
  `woodcutting` mediumint unsigned NOT NULL DEFAULT '0',
  `cooking` mediumint unsigned NOT NULL DEFAULT '0',
  `smithing` mediumint unsigned NOT NULL DEFAULT '0',
  `fletching` mediumint unsigned NOT NULL DEFAULT '0',
  `crafting` mediumint unsigned NOT NULL DEFAULT '0',
  `herblore` mediumint unsigned NOT NULL DEFAULT '0',
  `agility` mediumint unsigned NOT NULL DEFAULT '0',
  `farming` mediumint unsigned NOT NULL DEFAULT '0',
  `hunter` mediumint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hitpoints` mediumint unsigned NOT NULL DEFAULT '1',
  `mana` mediumint unsigned NOT NULL DEFAULT '1',
  `tile_id` bigint unsigned NOT NULL DEFAULT '1',
  `building_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `users_tile_id_foreign` (`tile_id`),
  KEY `users_building_id_foreign` (`building_id`),
  CONSTRAINT `users_building_id_foreign` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`),
  CONSTRAINT `users_tile_id_foreign` FOREIGN KEY (`tile_id`) REFERENCES `tiles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Dragon','$2y$10$x6Y1U8RCssg.IqOUk7MQQOngUvYCmntyaxLP2UR1BiZUyzy5ov/rq',1,NULL,0,0,0,5,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-26 03:50:48',NULL,1,1,1,NULL),(2,'TechSquid','$2y$10$mOK0QZvQH8qpzD3wAUQSB.MXT1U22cAvtmdCnKjMUy/nK.DzNy/zS',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL),(3,'Aaron','$2y$10$eqmujVfQpDwzo9eJFJz45ecUNZHRTAUl2e5lG.QPWD5O14ysO36lK',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL),(4,'Manderz','$2y$10$ycyAk0j2j/tMwCuOJjIqwOXpXQVIxagC7ga5EhCn/yV4LtGG9AaKG',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL),(5,'james','$2y$10$OEUxB0aT1y3/rLNGrIxh8OdY2G9pHjEm/d.DrX.hd2VLCq6bI9vT2',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL),(6,'Helix','$2y$10$B.wzWPJMmvYvsXPqLbLa..qlA1Us.Z/eYiNz7aoDVAN5.IhdMHIxG',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL),(7,'Shrimp','$2y$10$pB5S4GHXxckQ8ujVu4H9..H1khSRmyu0q0wu7RFRn5cvReny52Yqa',0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL,1,1,1,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones`
--

DROP TABLE IF EXISTS `zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_shop` tinyint(1) NOT NULL DEFAULT '0',
  `is_pub` tinyint(1) NOT NULL DEFAULT '0',
  `is_house` tinyint(1) NOT NULL DEFAULT '0',
  `is_accessible` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `is_bed` tinyint(1) NOT NULL DEFAULT '0',
  `is_pilferable` tinyint(1) NOT NULL DEFAULT '0',
  `last_pilfered` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zones_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones`
--

LOCK TABLES `zones` WRITE;
/*!40000 ALTER TABLE `zones` DISABLE KEYS */;
INSERT INTO `zones` VALUES (1,'Farmhouse','Generic farmhouses.',0,0,0,1,0,0,0,NULL,'2022-06-21 04:27:23','2022-06-21 04:27:23',NULL),(2,'Chuch','Generic, basic churches.',0,0,0,1,0,0,0,NULL,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(3,'Shop','Generic, basic shops.',1,0,0,1,0,0,0,NULL,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(4,'House','Generic, basic houses.',0,0,1,1,0,0,0,NULL,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL),(5,'House with a Bed','Resting is available in this house.',0,0,1,1,0,1,0,NULL,'2022-06-21 04:27:24','2022-06-21 04:27:24',NULL);
/*!40000 ALTER TABLE `zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-26 12:01:47
