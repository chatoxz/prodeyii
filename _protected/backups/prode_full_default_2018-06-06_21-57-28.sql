-- MySQL dump 10.13  Distrib 5.7.21, for Win64 (x86_64)
--
-- Host: localhost    Database: prode
-- ------------------------------------------------------
-- Server version	5.7.21

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin',2,1525809151),('admin',3,1525809254),('default',4,1525965610),('theCreator',1,1525371211);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,'Administrator of this application',NULL,NULL,1525371105,1525371105),('default',1,'Usuario Comun',NULL,NULL,1525371105,1525371105),('manageUsers',2,'Allows admin+ roles to manage users',NULL,NULL,1525371104,1525371104),('member',1,'Authenticated user, equal to \"@\"',NULL,NULL,1525371104,1525371104),('premium',1,'Premium users. Authenticated users with extra powers',NULL,NULL,1525371104,1525371104),('theCreator',1,'You!',NULL,NULL,1525371105,1525371105),('usePremiumContent',2,'Allows premium+ roles to use premium content',NULL,NULL,1525371104,1525371104);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('theCreator','admin'),('admin','default'),('admin','manageUsers'),('premium','member'),('default','premium'),('premium','usePremiumContent');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
INSERT INTO `auth_rule` VALUES ('isAuthor','O:25:\"app\\rbac\\rules\\AuthorRule\":3:{s:4:\"name\";s:8:\"isAuthor\";s:9:\"createdAt\";i:1525371104;s:9:\"updatedAt\";i:1525371104;}',1525371104,1525371104);
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_instancia` int(11) DEFAULT NULL,
  `mensaje` longtext COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Chat_1_idx` (`id_user`),
  KEY `fk_instancias_idx` (`id_instancia`),
  CONSTRAINT `fk_Chat_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_instancia_chat` FOREIGN KEY (`id_instancia`) REFERENCES `instancia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat`
--

LOCK TABLES `chat` WRITE;
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` VALUES (1,1,1,'Hola Bienvenidos ProdesMasters','0000-00-00 00:00:00'),(2,1,2,'Hola Bienvenidos Simios','0000-00-00 00:00:00'),(3,4,1,'Holis','2018-06-04 17:57:42'),(4,1,1,'pruebas','2018-06-04 18:49:24'),(5,4,1,'fmas pruebas','2018-06-04 18:49:49'),(6,1,2,'sfasd','2018-06-05 15:42:11'),(7,1,2,'asdfas','2018-06-05 15:43:52'),(8,1,2,'2222','2018-06-05 15:43:55'),(9,1,2,'23423234','2018-06-05 15:43:58'),(10,1,2,'s','2018-06-05 15:44:00'),(11,1,2,'2222','2018-06-05 15:44:07'),(12,1,1,'malditos malnacidossssss','2018-06-06 17:19:18'),(13,1,1,'kljk','2018-06-06 17:32:10'),(14,1,1,'lalala','2018-06-06 17:35:29'),(15,1,1,'asdads','2018-06-06 17:37:17');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instancia`
--

DROP TABLE IF EXISTS `instancia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instancia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_torneo` int(11) DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `max_participantes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_torneo_idx` (`id_torneo`),
  CONSTRAINT `fk_torneos` FOREIGN KEY (`id_torneo`) REFERENCES `torneo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instancia`
--

LOCK TABLES `instancia` WRITE;
/*!40000 ALTER TABLE `instancia` DISABLE KEYS */;
INSERT INTO `instancia` VALUES (1,2,'UNSTA',0),(2,2,'Simios',0);
/*!40000 ALTER TABLE `instancia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instancia_regla`
--

DROP TABLE IF EXISTS `instancia_regla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instancia_regla` (
  `id` int(11) NOT NULL,
  `id_instancia` int(11) NOT NULL,
  `regla` text CHARACTER SET latin1,
  PRIMARY KEY (`id`,`id_instancia`),
  KEY `fk_instancia_reglas_idx` (`id_instancia`),
  CONSTRAINT `fk_instancia_reglas` FOREIGN KEY (`id_instancia`) REFERENCES `instancia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instancia_regla`
--

LOCK TABLES `instancia_regla` WRITE;
/*!40000 ALTER TABLE `instancia_regla` DISABLE KEYS */;
INSERT INTO `instancia_regla` VALUES (1,1,'Las predicciones se pueden hacer hasta una hora antes del partido');
/*!40000 ALTER TABLE `instancia_regla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instancia_user`
--

DROP TABLE IF EXISTS `instancia_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instancia_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_instancia` int(11) DEFAULT NULL,
  `puntos` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_instancia_idx` (`id_instancia`),
  KEY `fk_user_idx` (`id_user`),
  CONSTRAINT `fk_instancias` FOREIGN KEY (`id_instancia`) REFERENCES `instancia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instancia_user`
--

LOCK TABLES `instancia_user` WRITE;
/*!40000 ALTER TABLE `instancia_user` DISABLE KEYS */;
INSERT INTO `instancia_user` VALUES (51,4,1,0),(52,1,1,5),(53,1,2,5),(54,2,1,5);
/*!40000 ALTER TABLE `instancia_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1525370647),('m141022_115823_create_user_table',1525370651),('m141022_115912_create_rbac_tables',1525370651);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (33,'A determinar'),(35,'A. Saudita'),(25,'Alemania'),(30,'Argelia'),(5,'Argentina'),(39,'Australia'),(29,'Belgica'),(4,'Bolivia'),(22,'Bosnia'),(9,'Brasil'),(1,'Chile'),(10,'Colombia'),(45,'Corea del Sur'),(14,'Costa Rica'),(42,'Croacia'),(40,'Dinamarca'),(3,'Ecuador'),(28,'EEUU'),(34,'Egipto'),(38,'España'),(18,'Francia'),(27,'Ghana'),(20,'Honduras'),(15,'Inglaterra'),(24,'Iran'),(41,'Islandia'),(16,'Italia'),(8,'Jamaica'),(37,'Japon'),(36,'Marruecos'),(2,'Mexico'),(23,'Nigeria'),(44,'Panama'),(7,'Paraguay'),(11,'Peru'),(48,'Polonia'),(26,'Portugal'),(32,'Rep.Corea'),(31,'Rusia'),(49,'Senegal'),(43,'Serbia'),(46,'Suecia'),(17,'Suiza'),(47,'Túnez'),(6,'Uruguay'),(12,'Venezuela');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partido`
--

DROP TABLE IF EXISTS `partido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partido` (
  `id` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `id_visitante` int(11) NOT NULL,
  `id_torneo` int(11) NOT NULL DEFAULT '1',
  `fecha` date DEFAULT NULL,
  `hora` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `lugar` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `instancia` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'Grupo',
  `goles_local` int(11) DEFAULT '0',
  `goles_visitante` int(11) DEFAULT '0',
  `jugado` int(11) DEFAULT '0',
  `grupo` varchar(45) COLLATE utf8_spanish_ci DEFAULT 'A',
  PRIMARY KEY (`id`),
  KEY `fk_torneo_idx` (`id_torneo`),
  KEY `fk_local_idx` (`id_local`),
  KEY `fk_visitante_idx` (`id_visitante`),
  CONSTRAINT `fk_local` FOREIGN KEY (`id_local`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_torneo` FOREIGN KEY (`id_torneo`) REFERENCES `torneo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_visitante` FOREIGN KEY (`id_visitante`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partido`
--

LOCK TABLES `partido` WRITE;
/*!40000 ALTER TABLE `partido` DISABLE KEYS */;
INSERT INTO `partido` VALUES (0,18,11,2,'2018-06-21','12:00','Ekaterimburgo','Grupo',0,0,0,'C'),(1,1,3,1,'2015-06-11','20:30','Est. Nacional','Grupo',2,0,1,'A'),(2,2,4,1,'2015-06-12','20:30','Viña del Mar','Grupo',0,0,1,'A'),(3,3,4,1,'2015-06-15','18:00','Balparaiso','Grupo',2,3,1,'A'),(4,1,2,1,'2015-06-15','20:30','Est. Nacional','Grupo',3,3,1,'A'),(5,2,3,1,'2015-06-19','18:00','Rancagua','Grupo',1,2,1,'A'),(6,1,4,1,'2015-06-19','20:30','Est. Nacional','Grupo',5,0,1,'A'),(7,6,8,1,'2015-06-13','14:00','Antofagasta','Grupo',1,0,1,'B'),(8,5,7,1,'2015-06-13','18:30','La Serena','Grupo',2,2,1,'B'),(9,7,8,1,'2015-06-16','18:00','Antofagasta','Grupo',1,0,1,'B'),(10,5,6,1,'2015-06-16','20:30','La Serena','Grupo',1,0,1,'B'),(11,6,7,1,'2015-06-20','16:00','La Serena','Grupo',1,1,1,'B'),(12,5,8,1,'2015-06-20','18:30','Viña del Mar','Grupo',1,0,1,'B'),(13,10,12,1,'2015-06-14','16:00','Rancagua','Grupo',0,1,1,'C'),(14,9,11,1,'2015-06-14','18:30','Temuco','Grupo',2,1,1,'C'),(15,9,10,1,'2015-06-17','20:30','Est. Monumental','Grupo',0,1,1,'C'),(16,11,12,1,'2015-06-18','20:30','Valparaiso','Grupo',1,0,1,'C'),(17,10,11,1,'2015-06-21','16:00','Temuco','Grupo',0,0,1,'C'),(18,9,12,1,'2015-06-21','16:30','Est. Monumental','Grupo',2,1,1,'C'),(19,1,6,1,'2015-06-24','20:30','Est. Monumental','Cuartos',1,0,1,NULL),(20,4,11,1,'2015-06-25','20:30','Temuco','Cuartos',1,3,1,NULL),(21,5,10,1,'2015-06-26','20:30','Vina del Mar','Cuartos',0,0,1,NULL),(22,9,7,1,'2015-06-27','18:30','','Cuartos',1,1,1,NULL),(23,1,11,1,'2015-06-29','20:30','','Semis',2,1,1,NULL),(24,5,7,1,'2015-06-30','20:30','','Semis',6,1,1,NULL),(25,11,7,1,'2015-07-03','20:30','','Tercer Puesto',0,0,0,NULL),(26,1,5,1,'2015-07-04','20:30','','Final',0,0,0,NULL),(27,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(28,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(29,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(30,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(31,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(32,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(33,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(34,33,33,1,'2015-07-04',NULL,NULL,'Octavos',0,0,0,NULL),(35,31,35,2,'2018-05-30','17:10','Luzhniki, Moscú','Grupo',1,0,1,'A'),(36,6,35,2,'2018-06-01','12:00','Rostov Del Don','Grupo',2,2,1,'A'),(37,35,34,2,'2018-05-31','11:00','Volgogrado','Grupo',2,0,1,'A'),(38,6,31,2,'2018-05-28','11:00','Samara','Grupo',2,2,1,'A'),(39,31,34,2,'2018-05-29','15:00','San Petersbrugo','Grupo',3,1,1,'A'),(40,34,6,2,'2018-05-31','09:00','Ekaterimburgo','Grupo',1,2,1,'A'),(41,36,24,2,'2018-06-15','12:00','San Petersburgo','Grupo',0,0,0,'B'),(42,26,38,2,'2018-06-15','15:00','Sochi','Grupo',0,0,0,'B'),(43,26,36,2,'2018-06-20','09:00','Luzhniki, Mosku','Grupo',0,0,0,'B'),(44,24,38,2,'2018-06-20','15:00','Kazán','Grupo',0,0,0,'B'),(45,38,26,2,'2018-06-25','15:00','Kalingrado','Grupo',0,0,0,'B'),(46,24,26,2,'2018-06-25','15:00','Saransk','Grupo',0,0,0,'B'),(47,18,39,2,'2018-06-16','07:00','Kazán','Grupo',0,0,0,'C'),(48,11,40,2,'2018-06-16','13:00','Saransk','Grupo',0,0,0,'C'),(49,40,39,2,'2018-06-20','12:00','Samara','Grupo',0,0,0,'C'),(50,39,11,2,'2018-06-26','11:00','Sochi','Grupo',0,0,0,'C'),(51,40,18,2,'2018-06-26','11:00','Luzhniki, Moscú','Grupo',0,0,0,'C'),(52,5,41,2,'2018-06-16','10:00','Del Spartak, Moscú','Grupo',0,0,0,'D'),(53,42,23,2,'2018-06-16','16:00','Kaliningrado','Grupo',0,0,0,'D'),(54,5,42,2,'2018-06-21','15:00','Nizhni Nóvgorod','Grupo',0,0,0,'D'),(55,23,41,2,'2018-06-22','12:00','Volgogrado','Grupo',0,0,0,'D'),(56,41,42,2,'2018-06-26','15:00','Rostov Del Don','Grupo',0,0,0,'D'),(57,23,30,2,'2018-06-26','15:00','San Petersburgo','Grupo',0,0,0,'D'),(58,14,43,2,'2018-06-17','09:00','Samara','Grupo',0,0,0,'E'),(59,9,17,2,'2018-06-17','15:00','Rostov Del Don','Grupo',0,0,0,'E'),(60,9,14,2,'2018-06-22','09:00','San Petersburgo','Grupo',0,0,0,'E'),(61,43,17,2,'2018-06-22','15:00','Kalingrado','Grupo',0,0,0,'E'),(62,17,14,2,'2018-06-27','15:00','Nizhni Nóvogorod','Grupo',0,0,0,'E'),(63,43,9,2,'2018-06-27','15:00','Del Spartak, Moscú','Grupo',0,0,0,'E'),(64,25,2,2,'2018-06-17','12:00','Luzhniki, Moscú','Grupo',0,0,0,'F'),(65,46,45,2,'2018-06-18','09:00','Nizhni Nóvgorog','Grupo',0,0,0,'F'),(66,25,46,2,'2018-06-23','12:00','Sochi','Grupo',0,0,0,'F'),(67,45,2,2,'2018-06-23','15:00','Rostov Del Don','Grupo',0,0,0,'F'),(68,2,46,2,'2018-06-27','11:00','Ekaterimburgo','Grupo',0,0,0,'F'),(69,45,25,2,'2018-06-27','11:00','Kazán','Grupo',0,0,0,'G'),(70,29,44,2,'2018-06-18','12:00','Sochi','Grupo',0,0,0,'G'),(71,47,15,2,'2018-06-18','15:00','Volgogrado','Grupo',0,0,0,'G'),(72,29,47,2,'2018-06-23','09:00','Del Spartak, Moscú','Grupo',0,0,0,'G'),(73,15,44,2,'2018-06-28','15:00','Saransk','Grupo',0,0,0,'G'),(74,15,29,2,'2018-06-28','15:00','Kalingrado','Grupo',0,0,0,'G'),(75,48,49,2,'2018-06-19','09:00','Del Spartak, Moscú','Grupo',0,0,0,'H'),(76,10,37,2,'2018-06-19','12:00','Saransk','Grupo',0,0,0,'H'),(77,37,49,2,'2018-06-24','12:00','Ekaterimburgo','Grupo',0,0,0,'H'),(78,48,10,2,'2018-06-24','15:00','Kazán','Grupo',0,0,0,'H'),(79,49,10,2,'2018-06-28','11:00','Samara','Grupo',0,0,0,'H'),(80,37,48,2,'2018-06-28','11:00','Volgogrado','Grupo',0,0,0,'H'),(81,33,33,2,'2018-06-30','11:00','Kazán','Octavos',0,0,0,''),(82,33,33,2,'2018-06-30','15:00','Sochi','Octavos',0,0,0,''),(83,33,33,2,'2018-07-01','11:00','Luzhniki, Moscú','Octavos',0,0,0,''),(84,33,33,2,'2018-07-01','15:00','Nizhni Nóvgorog','Octavos',0,0,0,''),(85,33,33,2,'2018-07-02','11:00','Samara','Octavos',0,0,0,''),(86,33,33,2,'2018-07-02','15:00','Rostov Del Don','Octavos',0,0,0,''),(87,33,33,2,'2018-07-03','11:00','San Petersburgo','Octavos',0,0,0,''),(88,33,33,2,'2018-07-03','15:00','Del Spartak, Moscú','Octavos',0,0,0,''),(89,33,33,2,'2018-07-06','11:00','Nizhni Nóvgorog','Cuartos',0,0,0,''),(90,33,33,2,'2018-07-06','15:00','Kazán','Cuartos',0,0,0,''),(91,33,33,2,'2018-07-07','11:00','Samara','Cuartos',0,0,0,''),(92,33,33,2,'2018-07-07','15:00','Sochi','Cuartos',0,0,0,''),(93,33,33,2,'2018-07-10','15:00','San Petersburgo','Semis',0,0,0,''),(94,33,33,2,'2018-07-11','15:00','Luzhniki, Moscú','Semis',0,0,0,''),(95,33,33,2,'2018-07-14','11:00','San Petersburgo','Tercer',0,0,0,''),(96,33,33,2,'2018-07-15','12:00','Luzhniki, Moscú','Final',0,0,0,''),(97,44,47,2,'2018-06-28','15:00','Saransk','Grupo',0,0,0,'G');
/*!40000 ALTER TABLE `partido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prediccion`
--

DROP TABLE IF EXISTS `prediccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prediccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_partido` int(11) NOT NULL,
  `id_instancia` int(11) DEFAULT '2',
  `goles_local` int(11) DEFAULT '0',
  `goles_visitante` int(11) DEFAULT '0',
  `resultado` int(11) DEFAULT '0',
  PRIMARY KEY (`id`,`id_user`,`id_partido`),
  KEY `fk_id_user_idx` (`id_user`),
  KEY `fk_partido_idx` (`id_partido`),
  KEY `fk_instancia_idx` (`id_instancia`),
  CONSTRAINT `fk_instancia` FOREIGN KEY (`id_instancia`) REFERENCES `instancia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_partido` FOREIGN KEY (`id_partido`) REFERENCES `partido` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prediccion`
--

LOCK TABLES `prediccion` WRITE;
/*!40000 ALTER TABLE `prediccion` DISABLE KEYS */;
INSERT INTO `prediccion` VALUES (2,1,38,2,0,0,1),(3,1,39,2,3,1,0),(4,1,35,2,0,0,1),(5,1,37,2,0,0,1),(6,1,40,2,0,0,1),(7,1,36,2,0,0,1),(8,1,41,2,0,0,1),(9,1,42,2,0,0,1),(10,1,43,2,0,0,1),(11,1,44,2,0,0,1),(12,1,45,2,0,0,1),(13,1,46,2,0,0,1),(14,1,52,1,0,0,1),(15,1,53,1,0,0,1),(16,1,54,1,0,0,1),(17,1,55,1,0,0,1),(18,1,56,1,0,0,1),(19,1,57,1,0,0,1),(20,1,41,1,0,0,1),(21,1,42,1,0,0,1),(22,1,43,1,0,0,1),(23,1,44,1,0,0,1),(24,1,45,1,0,0,1),(25,1,46,1,0,0,1),(26,1,75,1,0,0,1),(27,1,76,1,0,0,1),(28,1,77,1,0,0,1),(29,1,78,1,0,0,1),(30,1,79,1,0,0,1),(31,1,80,1,0,0,1),(32,1,70,1,0,0,1),(33,1,71,1,0,0,1),(34,1,72,1,0,0,1),(35,1,69,1,0,0,1),(36,1,73,1,0,0,1),(37,1,74,1,0,0,1),(38,1,97,1,0,0,1),(39,1,58,1,0,0,1),(40,1,59,1,0,0,1),(41,1,60,1,0,0,1),(42,1,61,1,0,0,1),(43,1,62,1,0,0,1),(44,1,63,1,0,0,1),(45,2,38,1,0,0,1),(46,2,39,1,3,1,1),(47,2,35,1,0,0,1),(48,2,37,1,0,0,1),(49,2,40,1,0,0,1),(50,2,36,1,0,0,1),(51,2,41,1,7,7,1),(52,2,42,1,7,7,1),(53,2,43,1,7,7,1),(54,2,44,1,7,7,1),(55,2,45,1,7,7,1),(56,2,46,1,7,7,1),(57,1,38,1,0,0,1),(58,1,39,1,3,1,1),(59,1,35,1,0,0,1),(60,1,37,1,0,0,1),(61,1,40,1,0,0,1),(62,1,36,1,0,0,1),(63,1,47,2,0,0,1),(64,1,48,2,0,0,1),(65,1,49,2,0,0,1),(66,1,0,2,0,0,1),(67,1,50,2,0,0,1),(68,1,51,2,0,0,1),(69,1,64,1,0,0,1),(70,1,65,1,0,0,1),(71,1,66,1,0,0,1),(72,1,67,1,0,0,1),(73,1,68,1,0,0,1);
/*!40000 ALTER TABLE `prediccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `torneo`
--

DROP TABLE IF EXISTS `torneo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `torneo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `partidos_grupo` int(11) DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `torneo`
--

LOCK TABLES `torneo` WRITE;
/*!40000 ALTER TABLE `torneo` DISABLE KEYS */;
INSERT INTO `torneo` VALUES (1,'Copa America 2015',NULL,NULL,6),(2,'Copa del mundo 2018','2018-06-14','2018-07-15',6);
/*!40000 ALTER TABLE `torneo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `puntos` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  UNIQUE KEY `account_activation_token` (`account_activation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'chatoxz','carrerasssebastian@gmail.com','$2y$13$5U9Cu.cjOQdsCUayjEfbTe/S3FjmH/cvVx052eWlVyMHK9d1gx32a',10,'eROKL7zP_ujxsgE27JJwLIHN0cqLenuG','i7jwObyFODfz9jdbBzeiRvxlbwSzH6KP_1526047767',NULL,1525371211,1527611655,1),(2,'ale','jadominguez.unt@gmail.com','$2y$13$EtsuZyZ02TTG4r1GJehsYO2ifZpefVIolANynwW5dpR.CCjbFntMK',10,'C77hBeAk4WTJv8W1MegIIk0NknfxdDRd',NULL,NULL,1525809151,1527611655,3),(3,'chelo','marcelomas@gmail.com','$2y$13$U87ZFfEq9b8oSF.GukcT1eNdLuAVnFlsJnU5/IBNs3v63Bw..Ji9e',10,'DRFBxpwqykjRmtlhFc1ezNg97-lNRp6E',NULL,NULL,1525809254,1525809254,0),(4,'dario','dpresti@unsta.edu.ar','$2y$13$qTSP4P/T9inCshQlO7Kq7eRzq8M1etQrGgpQLz0ymWVBGZBG9tKx6',10,'8KY6aWDjcUsUmVqI7JA--z1BwQwJI4AE',NULL,NULL,1525809359,1527611655,3),(5,'denge','jmgomez@unsta.edu.ar','$2y$13$QOfXiFQU3BiRsRBeQE7qK.Cn3n7SY8K1nPbc8FnmaBeuGzNx5.NZ.',10,'3odlj5DeTGM97OtTfyLiRio49JGqW42p',NULL,NULL,1527621814,1527621814,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-06 18:57:29
