-- MySQL dump 10.13  Distrib 8.0.16, for osx10.13 (x86_64)
--
-- Host: localhost    Database: tree_network
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_user`
--

DROP TABLE IF EXISTS `app_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `app_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar_id` int(11) DEFAULT NULL,
  `locale_id` int(11) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `born_at` date DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_place` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `email2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usernameCanonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_88BDF3E9C05FB297` (`confirmation_token`),
  UNIQUE KEY `UNIQ_88BDF3E986383B10` (`avatar_id`),
  KEY `IDX_88BDF3E9E559DFD1` (`locale_id`),
  KEY `IDX_88BDF3E9708A0E0` (`gender_id`),
  CONSTRAINT `FK_88BDF3E9708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `FK_88BDF3E986383B10` FOREIGN KEY (`avatar_id`) REFERENCES `avatar` (`id`),
  CONSTRAINT `FK_88BDF3E9E559DFD1` FOREIGN KEY (`locale_id`) REFERENCES `locale` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user`
--

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` VALUES (1,1,NULL,3,1,NULL,'2001-01-01 03:52:24',NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}','37825091','Ba','Bechir','1999-12-30','I\'m a fullstack web developer. Co-Founder and CEO of Rimotor','Medina Gounass','2019-09-10 09:47:46','bechir07@outlook.fr','bechiirr71@gmail.com','bechiirr71@gmail.com','randomdev','randomdev','$2y$13$lBWT3YkR5E.MozMCqRXgRu1SR8K2Hq7szZ8iYfHT0bX8ofF649C92'),(2,2,NULL,3,1,NULL,'2019-09-28 06:47:20',NULL,NULL,'a:0:{}',NULL,'Soumaré','Diafra','1997-12-31','À la recherche d\'une belle fille à marier...','Nouakchott','2019-09-22 21:11:44',NULL,'thediaff@gmail.com','thediaff@gmail.com','thediaff','thediaff','$2y$13$Mj9gB9QhE84fubGP6m/XbetTNsXm2sSQA.5XrQOmw3bBs8E6LYTg.'),(3,NULL,NULL,NULL,1,NULL,'2019-09-28 01:43:17',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,'2019-09-28 01:43:12',NULL,'zaenma@gmail.com','zaenma@gmail.com','zaenma','zaenma','$2y$13$NDFOOdaCJT7ENoEhTjss9.NiMHpg1c7iHZOtqvSeRidK9KNKsjZ4W'),(4,NULL,NULL,NULL,1,NULL,'2019-09-28 01:45:30',NULL,NULL,'a:0:{}',NULL,NULL,NULL,NULL,NULL,NULL,'2019-09-28 01:45:29',NULL,'djeinagaye@gmail.com','djeinagaye@gmail.com','djeina','djeina','$2y$13$srR3Wjb28.vfhbcTN9G5D.F5tjqAX7oBeTspqV2Hj77/qU2g17pWm'),(9,5,NULL,3,0,NULL,NULL,NULL,NULL,'a:0:{}',NULL,'Issmaila','Ba',NULL,NULL,NULL,'2019-09-29 05:00:40',NULL,NULL,NULL,NULL,NULL,NULL),(10,NULL,NULL,4,0,NULL,NULL,NULL,NULL,'a:0:{}',NULL,'Aissata','Sy',NULL,NULL,NULL,'2019-09-29 05:01:06',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avatar`
--

DROP TABLE IF EXISTS `avatar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `avatar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatar`
--

LOCK TABLES `avatar` WRITE;
/*!40000 ALTER TABLE `avatar` DISABLE KEYS */;
INSERT INTO `avatar` VALUES (1,'21e099b291b52931de8f5cc6dbd2ea3369b36eac.jpg','2019-09-27 17:41:24'),(2,'1644ef14fc826a19f0b12023f08009193e851bda.jpg','2019-09-28 06:49:26'),(5,'c839b2a54d322669cb08f3965652c10538a46a44.jpg','2019-09-29 05:00:40');
/*!40000 ALTER TABLE `avatar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `birth_place`
--

DROP TABLE IF EXISTS `birth_place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `birth_place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `birth_place`
--

LOCK TABLES `birth_place` WRITE;
/*!40000 ALTER TABLE `birth_place` DISABLE KEYS */;
/*!40000 ALTER TABLE `birth_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D5B0234F92F3E70` (`country_id`),
  CONSTRAINT `FK_2D5B0234F92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` tinytext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (3,'word.male'),(4,'word.female');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FA76ED395` (`user_id`),
  CONSTRAINT `FK_C53D045FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (7,1,'d75928e30f36dce8b8c857818f10cfb9ef66f392.jpg','2019-09-27 19:00:45'),(10,1,'5324aef15ae230e1d6176c4fe33e3ce66869387e.jpg','2019-09-27 19:04:05'),(11,1,'7dbec2326f51b2b2aa3985b62f8033dd9b8eadef.jpg','2019-09-27 19:04:05'),(12,1,'dbd5e9e3ed9a1b41e324b5eac53d24696eef131c.jpg','2019-09-27 19:04:05'),(13,1,'3e7b52a6a8e2f10584ee3bee63fad6b57670801f.jpg','2019-09-27 19:04:05'),(14,1,'16ce209dd449f90387e9cb1cb6308a7464ef41e1.jpg','2019-09-27 19:04:05'),(15,1,'454069b3b7bd4cd029fe948964d1ed37470cfa01.jpg','2019-09-27 19:04:05'),(16,1,'5df923889c6cbe1a6cb1c4c6303de02d55bd7a30.jpg','2019-09-27 19:04:05'),(17,2,'93f5d3190e3908682f0d77ea55c0afd67b96ea24.jpg','2019-09-28 06:51:24'),(18,2,'fd9b392a2d9c7f6bac7f4b643a9830058aeb6684.jpg','2019-09-28 06:51:24'),(19,1,'318e9f24a21f10c828177c49116b85e846b92147.jpg','2019-09-29 01:28:44'),(20,1,'69b98bebc4b5c9b0583171947dce47ebc9d9ae0d.jpg','2019-09-29 01:28:44'),(21,1,'0b5f01b6f5ef5f6000e85cd8385d669148050d04.jpg','2019-09-29 01:28:44'),(22,1,'ffc8f61f8ecfe2f734c4016ec24caea4f8698801.jpg','2019-09-29 01:30:34'),(23,1,'d90e2959f619b2b0f142a270ffb3011389f37595.jpg','2019-09-29 01:30:34'),(24,1,'781919e98ed327301c357af97b5284a4a09d2d4f.png','2019-09-29 01:30:34');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
INSERT INTO `language` VALUES (6,'app.lang.fr'),(7,'app.lang.en'),(8,'app.lang.ar'),(9,'app.lang.plr'),(10,'app.lang.wlf');
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_category_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `inverse_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_36AC99F1DFC611B1` (`link_category_id`),
  KEY `IDX_36AC99F17E3C61F9` (`owner_id`),
  KEY `IDX_36AC99F18408CB69` (`inverse_id`),
  CONSTRAINT `FK_36AC99F17E3C61F9` FOREIGN KEY (`owner_id`) REFERENCES `app_user` (`id`),
  CONSTRAINT `FK_36AC99F18408CB69` FOREIGN KEY (`inverse_id`) REFERENCES `app_user` (`id`),
  CONSTRAINT `FK_36AC99F1DFC611B1` FOREIGN KEY (`link_category_id`) REFERENCES `link_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (5,30,9,1),(6,27,1,9),(7,43,10,1),(8,40,1,10);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_category`
--

DROP TABLE IF EXISTS `link_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `link_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inverse` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE67908708A0E0` (`gender_id`),
  CONSTRAINT `FK_CBE67908708A0E0` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_category`
--

LOCK TABLES `link_category` WRITE;
/*!40000 ALTER TABLE `link_category` DISABLE KEYS */;
INSERT INTO `link_category` VALUES (27,3,'word.father','word.son'),(28,3,'word.brother','word.inv_brother'),(29,3,'word.uncle','word.nephew'),(30,3,'word.son','word.inv_son'),(31,3,'word.husband','word.wife'),(32,3,'word.grand_father','word.inv_grand_father'),(33,3,'word.stepfather','word.stepchild'),(34,3,'word.stepchild','word.stepfather'),(35,3,'word.half_brother','word.half_brother'),(36,3,'word.brother_in_law','word.inv_brother_in_law'),(37,3,'word.friend','word.inv_friend'),(38,3,'word.cousin','word.inv_cousin'),(39,3,'word.nephew','word.uncle'),(40,4,'word.mother','word.daughter'),(41,4,'word.sister','word.sister'),(42,4,'word.aunt','word.niece'),(43,4,'word.daughter','word.mother'),(44,4,'word.wife','word.husband'),(45,4,'word.grand_mother','word.inv_grand_monther'),(46,4,'word.stepmother','word.stepdaughter'),(47,4,'word.stepdaughter','word.stepmother'),(48,4,'word.half_sister','word.half_sister'),(49,4,'word.sister_in_law','word.inv_sister_in_law'),(50,4,'word.m_friend','word.m_friend'),(51,4,'word.m_cousin','word.m_cousin'),(52,4,'word.niece','word.aunt');
/*!40000 ALTER TABLE `link_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locale`
--

DROP TABLE IF EXISTS `locale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `locale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locale`
--

LOCK TABLES `locale` WRITE;
/*!40000 ALTER TABLE `locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-08 21:31:38
