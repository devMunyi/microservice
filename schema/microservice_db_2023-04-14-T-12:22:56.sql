-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: microservice_db
-- ------------------------------------------------------
-- Server version	8.0.32-0ubuntu0.20.04.2

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
-- Table structure for table `tbl_companies`
--

DROP TABLE IF EXISTS `tbl_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_companies` (
  `id` mediumint NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_companies`
--

LOCK TABLES `tbl_companies` WRITE;
/*!40000 ALTER TABLE `tbl_companies` DISABLE KEYS */;
INSERT INTO `tbl_companies` VALUES (1,'Company 1',1),(2,'Company 2',1),(3,'Company 3',1),(4,'Company 4',1),(5,'Company 5',1),(6,'Company 6',1),(7,'Company 7',1),(8,'Company 8',1),(9,'Company 9',1),(10,'Company 10',1);
/*!40000 ALTER TABLE `tbl_companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_events`
--

DROP TABLE IF EXISTS `tbl_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tbl` varchar(30) NOT NULL,
  `fld` int NOT NULL,
  `event_details` varchar(250) NOT NULL,
  `event_date` datetime NOT NULL,
  `event_by` int NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_events`
--

LOCK TABLES `tbl_events` WRITE;
/*!40000 ALTER TABLE `tbl_events` DISABLE KEYS */;
INSERT INTO `tbl_events` VALUES (1,'tbl_services',1,'Service updated at [2023-02-25 11:47] by [Sam Munyi{1}]','2023-02-25 11:47:00',1,1),(2,'tbl_services',1,'Service updated at [2023-02-25 11:48] by [Sam Munyi{1}]','2023-02-25 11:48:00',1,1),(3,'tbl_services',1,'Service updated at [2023-02-25 11:49] by [Sam Munyi{1}]','2023-02-25 11:49:00',1,1),(4,'tbl_services',1,'Service updated at [2023-02-25 12:20] by [Sam Munyi{1}]','2023-02-25 12:20:00',1,1),(5,'tbl_services',1,'Service updated at [2023-02-25 12:20] by [Sam Munyi{1}]','2023-02-25 12:20:00',1,1),(6,'tbl_services',1,'Service updated at [2023-02-27 09:06] by [Sam Munyi{1}]','2023-02-27 09:06:00',1,1),(7,'tbl_services',1,'Service updated at [2023-03-03 12:30] by [Sam Munyi{1}]','2023-03-03 12:30:00',1,1);
/*!40000 ALTER TABLE `tbl_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_frequencies`
--

DROP TABLE IF EXISTS `tbl_frequencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_frequencies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `value` tinyint NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_frequencies`
--

LOCK TABLES `tbl_frequencies` WRITE;
/*!40000 ALTER TABLE `tbl_frequencies` DISABLE KEYS */;
INSERT INTO `tbl_frequencies` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,1),(17,17,1),(18,18,1),(19,19,1),(20,20,1),(21,21,1),(22,22,1),(23,23,1),(24,24,1),(25,25,1),(26,26,1),(27,27,1),(28,28,1),(29,29,1),(30,30,1),(31,31,1),(32,32,1),(33,33,1),(34,34,1),(35,35,1),(36,36,1),(37,37,1),(38,38,1),(39,39,1),(40,40,1),(41,41,1),(42,42,1),(43,43,1),(44,44,1),(45,45,1),(46,46,1),(47,47,1),(48,48,1),(49,49,1),(50,50,1),(51,51,1),(52,52,1),(53,53,1),(54,54,1),(55,55,1),(56,56,1),(57,57,1),(58,58,1),(59,59,1),(60,60,1);
/*!40000 ALTER TABLE `tbl_frequencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_logs`
--

DROP TABLE IF EXISTS `tbl_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `log` varchar(200) NOT NULL,
  `logged_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `service_id` int NOT NULL COMMENT 'Referencing table tbl_services column id',
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_logs`
--

LOCK TABLES `tbl_logs` WRITE;
/*!40000 ALTER TABLE `tbl_logs` DISABLE KEYS */;
INSERT INTO `tbl_logs` VALUES (1,'Failed with code 0','2023-02-25 10:35:28',3,1),(2,'Success','2023-02-25 10:38:10',1,1),(3,'Success','2023-02-25 10:43:10',1,1),(4,'Success','2023-02-25 10:56:37',1,1),(5,'Success','2023-02-25 11:02:11',1,1),(6,'Success','2023-02-25 11:05:08',1,1),(7,'Success','2023-02-25 13:00:08',1,1),(8,'Success','2023-02-25 14:00:04',1,1),(9,'Success','2023-02-25 15:00:05',1,1),(10,'Success','2023-02-25 16:00:06',1,1),(11,'Success','2023-02-25 17:00:04',1,1),(12,'Success','2023-02-25 18:00:06',1,1),(13,'Success','2023-02-25 19:00:06',1,1),(14,'Success','2023-02-25 20:00:05',1,1),(15,'Success','2023-02-25 21:00:06',1,1),(16,'Success','2023-02-25 22:00:04',1,1),(17,'Success','2023-02-25 23:00:06',1,1),(18,'Success','2023-02-26 00:00:07',2,1),(19,'Success','2023-02-26 00:00:11',1,1),(20,'Success','2023-02-26 01:00:05',1,1),(21,'Success','2023-02-26 02:00:05',1,1),(22,'Failed with code 504','2023-02-26 03:01:31',1,1),(23,'Success','2023-02-26 04:00:06',1,1),(24,'Success','2023-02-26 05:00:06',1,1),(25,'Success','2023-02-26 06:00:06',1,1),(26,'Success','2023-02-26 07:00:05',1,1),(27,'Success','2023-02-26 08:00:05',1,1),(28,'Success','2023-02-26 09:00:05',1,1),(29,'Success','2023-02-26 10:00:06',1,1),(30,'Success','2023-02-26 11:00:06',1,1),(31,'Success','2023-02-26 12:00:05',1,1),(32,'Success','2023-02-26 13:00:05',1,1),(33,'Success','2023-02-26 14:00:05',1,1),(34,'Success','2023-02-26 15:00:05',1,1),(35,'Success','2023-02-26 16:00:04',1,1),(36,'Success','2023-02-26 17:00:05',1,1),(37,'Success','2023-02-26 18:00:06',1,1),(38,'Success','2023-02-26 19:00:06',1,1),(39,'Success','2023-02-26 20:00:05',1,1),(40,'Success','2023-02-26 21:00:05',1,1),(41,'Success','2023-02-26 22:00:05',1,1),(42,'Success','2023-02-26 23:00:06',1,1),(43,'Success','2023-02-27 00:00:07',2,1),(44,'Success','2023-02-27 00:00:11',1,1),(45,'Success','2023-02-27 01:00:05',1,1),(46,'Success','2023-02-27 02:00:05',1,1),(47,'Success','2023-02-27 03:00:07',1,1),(48,'Success','2023-02-27 04:00:05',1,1),(49,'Success','2023-02-27 05:00:07',1,1),(50,'Success','2023-02-27 06:00:06',1,1),(51,'Failed with code 504','2023-02-27 07:01:02',1,1),(52,'Success','2023-02-27 08:00:05',1,1),(53,'Success','2023-02-27 09:00:05',1,1),(54,'Success with an execution time of 3.3170580863953 seconds','2023-02-27 10:00:08',1,1),(55,'Success with an execution time of 3.5587301254272 seconds','2023-02-27 11:00:08',1,1),(56,'Success with an execution time of 3.644623041153 seconds','2023-02-27 12:00:10',1,1),(57,'Success with an execution time of 3.2781939506531 seconds','2023-02-27 13:00:10',1,1),(58,'Success with an execution time of 2.7057199478149 seconds','2023-02-27 14:00:07',1,1),(59,'Success with an execution time of 3.3831651210785 seconds','2023-02-27 15:00:05',1,1),(60,'Failed with code 500 and execution time of 2.1528902053833 seconds','2023-02-27 16:00:04',1,1),(61,'Success with an execution time of 4.3467450141907 seconds','2023-02-27 17:00:05',1,1),(62,'Success with an execution time of 4.1716899871826 seconds','2023-02-27 18:00:05',1,1),(63,'Success with an execution time of 4.0197539329529 seconds','2023-02-27 19:00:05',1,1),(64,'Success with an execution time of 4.2945230007172 seconds','2023-02-27 20:00:06',1,1),(65,'Success with an execution time of 4.0487198829651 seconds','2023-02-27 21:00:05',1,1),(66,'Success with an execution time of 4.198322057724 seconds','2023-02-27 22:00:05',1,1),(67,'Success with an execution time of 3.9697937965393 seconds','2023-02-27 23:00:05',1,1),(68,'Success with an execution time of 4.9567968845367 seconds','2023-02-28 00:00:06',2,1),(69,'Success with an execution time of 2.8523991107941 seconds','2023-02-28 00:00:09',1,1),(70,'Success with an execution time of 3.7895171642303 seconds','2023-02-28 01:00:05',1,1),(71,'Success with an execution time of 3.8463668823242 seconds','2023-02-28 02:00:05',1,1),(72,'Success with an execution time of 4.6280660629272 seconds','2023-02-28 03:00:06',1,1),(73,'Success with an execution time of 4.3833348751068 seconds','2023-02-28 04:00:05',1,1),(74,'Success with an execution time of 3.6792559623718 seconds','2023-02-28 05:00:05',1,1),(75,'Success with an execution time of 4.4477231502533 seconds','2023-02-28 06:00:06',1,1),(76,'Success with an execution time of 4.0699918270111 seconds','2023-02-28 07:00:06',1,1),(77,'Success with an execution time of 4.037887096405 seconds','2023-02-28 08:00:05',1,1),(78,'Success with an execution time of 3.9491300582886 seconds','2023-02-28 09:00:05',1,1),(79,'Success with an execution time of 6.070995092392 seconds','2023-02-28 10:00:08',1,1),(80,'Success with an execution time of 4.2173221111298 seconds','2023-02-28 11:00:06',1,1),(81,'Success with an execution time of 3.814337015152 seconds','2023-02-28 12:00:05',1,1),(82,'Success with an execution time of 3.6971001625061 seconds','2023-02-28 13:00:05',1,1),(83,'Success with an execution time of 4.3622879981995 seconds','2023-02-28 14:00:06',1,1),(84,'Success with an execution time of 4.1203141212463 seconds','2023-02-28 15:00:05',1,1),(85,'Success with an execution time of 3.304239988327 seconds','2023-02-28 16:00:04',1,1),(86,'Success with an execution time of 4.138190984726 seconds','2023-02-28 17:00:06',1,1),(87,'Success with an execution time of 3.8112559318542 seconds','2023-02-28 18:00:05',1,1),(88,'Success with an execution time of 4.3652169704437 seconds','2023-02-28 19:00:05',1,1),(89,'Success with an execution time of 3.8903260231018 seconds','2023-02-28 20:00:05',1,1),(90,'Success with an execution time of 4.9826490879059 seconds','2023-02-28 21:00:06',1,1),(91,'Success with an execution time of 4.2492389678955 seconds','2023-02-28 22:00:05',1,1),(92,'Success with an execution time of 4.0357291698456 seconds','2023-02-28 23:00:06',1,1),(93,'Success with an execution time of 3.7733550071716 seconds','2023-03-01 00:00:04',2,1),(94,'Success with an execution time of 3.3247389793396 seconds','2023-03-01 00:00:08',1,1),(95,'Success with an execution time of 3.4963290691376 seconds','2023-03-01 01:00:05',1,1),(96,'Success with an execution time of 3.7666580677032 seconds','2023-03-01 02:00:04',1,1),(97,'Success with an execution time of 6.0536489486694 seconds','2023-03-01 03:00:07',1,1),(98,'Success with an execution time of 5.0346808433533 seconds','2023-03-01 04:00:06',1,1),(99,'Success with an execution time of 4.0616018772125 seconds','2023-03-01 05:00:05',1,1),(100,'Success with an execution time of 4.3432841300964 seconds','2023-03-01 06:00:05',1,1),(101,'Failed with code 0 and execution time of 30.030735969543 seconds','2023-03-01 07:00:33',1,1),(102,'Failed with code 0 and execution time of 30.172515869141 seconds','2023-03-01 08:00:47',1,1),(103,'Failed with code 0 and execution time of 30.344918012619 seconds','2023-03-01 09:00:54',1,1),(104,'Failed with code 0 and execution time of 30.251585006714 seconds','2023-03-01 10:00:52',1,1),(105,'Failed with code 0 and execution time of 30.163719892502 seconds','2023-03-01 11:00:46',1,1),(106,'Failed with code 0 and execution time of 30.318261861801 seconds','2023-03-01 12:00:49',1,1),(107,'Failed with code 0 and execution time of 30.256607055664 seconds','2023-03-01 13:00:32',1,1),(108,'Failed with code 0 and execution time of 30.34818482399 seconds','2023-03-01 14:00:57',1,1),(109,'Failed with code 0 and execution time of 30.122700929642 seconds','2023-03-01 15:00:38',1,1),(110,'Success with an execution time of 4.7107591629028 seconds','2023-03-01 16:00:06',1,1),(111,'Success with an execution time of 3.9886569976807 seconds','2023-03-01 17:00:05',1,1),(112,'Success with an execution time of 4.0606219768524 seconds','2023-03-01 18:00:06',1,1),(113,'Success with an execution time of 4.2486209869385 seconds','2023-03-01 19:00:05',1,1),(114,'Success with an execution time of 3.713397026062 seconds','2023-03-01 20:00:05',1,1),(115,'Success with an execution time of 3.7885670661926 seconds','2023-03-01 21:00:05',1,1),(116,'Success with an execution time of 4.4706490039825 seconds','2023-03-01 22:00:06',1,1),(117,'Success with an execution time of 4.614410161972 seconds','2023-03-01 23:00:06',1,1),(118,'Failed with code 0 and execution time of 30.181108951569 seconds','2023-03-02 00:00:54',2,1),(119,'Failed with code 0 and execution time of 30.536295890808 seconds','2023-03-02 00:02:05',1,1),(120,'Success with an execution time of 4.6392838954926 seconds','2023-03-03 00:00:06',2,1),(121,'Success with an execution time of 4.0407321453094 seconds','2023-03-03 12:31:06',1,1),(122,'Success with an execution time of 3.519730091095 seconds','2023-03-03 13:31:04',1,1),(123,'Success with an execution time of 2.8816001415253 seconds','2023-03-03 14:31:04',1,1),(124,'Success with an execution time of 3.0363919734955 seconds','2023-03-03 15:31:04',1,1),(125,'Success with an execution time of 6.2758429050446 seconds','2023-03-03 16:31:07',1,1),(126,'Success with an execution time of 3.3303680419922 seconds','2023-03-03 17:31:05',1,1),(127,'Success with an execution time of 5.5327479839325 seconds','2023-03-03 18:31:06',1,1),(128,'Success with an execution time of 3.6197609901428 seconds','2023-03-03 19:31:05',1,1),(129,'Success with an execution time of 4.1032249927521 seconds','2023-03-03 20:31:05',1,1),(130,'Success with an execution time of 3.5422101020813 seconds','2023-03-03 21:31:04',1,1),(131,'Success with an execution time of 4.0133771896362 seconds','2023-03-03 22:31:05',1,1),(132,'Success with an execution time of 3.703861951828 seconds','2023-03-03 23:31:05',1,1),(133,'Success with an execution time of 5.2942531108856 seconds','2023-03-04 00:00:06',2,1),(134,'Success with an execution time of 3.7644040584564 seconds','2023-03-04 00:31:05',1,1),(135,'Success with an execution time of 4.017128944397 seconds','2023-03-04 01:31:05',1,1),(136,'Success with an execution time of 3.8539669513702 seconds','2023-03-04 02:31:05',1,1),(137,'Success with an execution time of 3.6079888343811 seconds','2023-03-04 03:31:05',1,1),(138,'Success with an execution time of 3.3703968524933 seconds','2023-03-04 04:31:04',1,1),(139,'Success with an execution time of 4.1719269752502 seconds','2023-03-04 05:31:06',1,1),(140,'Success with an execution time of 3.5184199810028 seconds','2023-03-04 06:31:05',1,1),(141,'Failed with code 0 and execution time of 30.185396194458 seconds','2023-03-04 07:31:55',1,1),(142,'Failed with code 502 and execution time of 0.022578001022339 seconds','2023-03-05 00:00:01',2,1),(143,'Failed with code 502 and execution time of 0.029891967773438 seconds','2023-03-06 00:00:01',2,1),(144,'Failed with code 502 and execution time of 0.02031397819519 seconds','2023-03-07 00:00:01',2,1),(145,'Failed with code 502 and execution time of 0.019012928009033 seconds','2023-03-08 00:00:01',2,1),(146,'Failed with code 502 and execution time of 0.065474033355713 seconds','2023-03-09 00:00:01',2,1),(147,'Failed with code 502 and execution time of 0.056730031967163 seconds','2023-03-10 00:00:01',2,1),(148,'Failed with code 502 and execution time of 0.019235134124756 seconds','2023-03-11 00:00:01',2,1),(149,'Failed with code 502 and execution time of 0.011201143264771 seconds','2023-03-12 00:00:01',2,1),(150,'Failed with code 502 and execution time of 0.016641139984131 seconds','2023-03-13 00:00:01',2,1),(151,'Failed with code 502 and execution time of 0.017551898956299 seconds','2023-03-14 00:00:01',2,1),(152,'Failed with code 502 and execution time of 0.017391920089722 seconds','2023-03-15 00:00:01',2,1),(153,'Failed with code 502 and execution time of 0.015974998474121 seconds','2023-03-16 00:00:01',2,1),(154,'Failed with code 502 and execution time of 0.015506982803345 seconds','2023-03-17 00:00:01',2,1),(155,'Failed with code 502 and execution time of 0.016171216964722 seconds','2023-03-18 00:00:01',2,1),(156,'Failed with code 502 and execution time of 0.017390012741089 seconds','2023-03-19 00:00:01',2,1),(157,'Failed with code 502 and execution time of 0.015827178955078 seconds','2023-03-20 00:00:01',2,1),(158,'Failed with code 502 and execution time of 0.017251968383789 seconds','2023-03-21 00:00:01',2,1),(159,'Failed with code 502 and execution time of 0.016628980636597 seconds','2023-03-22 00:00:01',2,1),(160,'Failed with code 502 and execution time of 0.024894952774048 seconds','2023-03-23 00:00:01',2,1),(161,'Failed with code 502 and execution time of 0.039000988006592 seconds','2023-03-24 00:00:01',2,1),(162,'Failed with code 502 and execution time of 0.015218019485474 seconds','2023-03-25 00:00:01',2,1),(163,'Failed with code 502 and execution time of 0.017231941223145 seconds','2023-03-26 00:00:01',2,1),(164,'Failed with code 502 and execution time of 0.020004987716675 seconds','2023-03-27 00:00:01',2,1),(165,'Failed with code 502 and execution time of 0.015528202056885 seconds','2023-03-28 00:00:01',2,1),(166,'Failed with code 502 and execution time of 0.045030832290649 seconds','2023-03-29 00:00:02',2,1),(167,'Failed with code 502 and execution time of 0.014342069625854 seconds','2023-03-30 00:00:01',2,1),(168,'Failed with code 502 and execution time of 0.01750111579895 seconds','2023-03-31 00:00:01',2,1),(169,'Failed with code 502 and execution time of 0.038467884063721 seconds','2023-04-01 00:00:01',2,1),(170,'Failed with code 502 and execution time of 0.028609991073608 seconds','2023-04-02 00:00:01',2,1),(171,'Failed with code 502 and execution time of 0.062656879425049 seconds','2023-04-03 00:00:01',2,1),(172,'Failed with code 502 and execution time of 0.016479969024658 seconds','2023-04-04 00:00:02',2,1),(173,'Failed with code 502 and execution time of 0.019685983657837 seconds','2023-04-05 00:00:01',2,1),(174,'Failed with code 502 and execution time of 0.026165962219238 seconds','2023-04-06 00:00:02',2,1),(175,'Failed with code 502 and execution time of 0.015941143035889 seconds','2023-04-07 00:00:01',2,1),(176,'Failed with code 502 and execution time of 0.014420986175537 seconds','2023-04-08 00:00:01',2,1),(177,'Failed with code 502 and execution time of 0.014235973358154 seconds','2023-04-09 00:00:01',2,1),(178,'Failed with code 502 and execution time of 0.017726182937622 seconds','2023-04-10 00:00:01',2,1),(179,'Failed with code 502 and execution time of 0.02681303024292 seconds','2023-04-11 00:00:01',2,1),(180,'Failed with code 502 and execution time of 0.018523931503296 seconds','2023-04-12 00:00:01',2,1),(181,'Failed with code 502 and execution time of 0.018209934234619 seconds','2023-04-13 00:00:01',2,1),(182,'Failed with code 502 and execution time of 0.018877029418945 seconds','2023-04-14 00:00:01',2,1);
/*!40000 ALTER TABLE `tbl_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_services`
--

DROP TABLE IF EXISTS `tbl_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_id` mediumint NOT NULL COMMENT 'from tbl_companies table',
  `service_title` varchar(100) NOT NULL,
  `service_address` varchar(250) NOT NULL,
  `last_run_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `next_run_datetime` datetime NOT NULL,
  `unit` tinyint NOT NULL,
  `frequency` tinyint NOT NULL,
  `is_executed` char(3) NOT NULL DEFAULT 'No',
  `repeated` char(5) NOT NULL DEFAULT 'Yes',
  `added_by` int NOT NULL,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_services`
--

LOCK TABLES `tbl_services` WRITE;
/*!40000 ALTER TABLE `tbl_services` DISABLE KEYS */;
INSERT INTO `tbl_services` VALUES (1,1,'Backup ZIDI db every one hour','https://backgen.net/backup?googleDriveFolderId=15m3F0shKCSvp4pBin99DKA5wEdQKlCbm&numOfFilesToLeave=3&serverAddress=159.203.186.99&dbName=bg_db&dbUsername=jonah&dbPassword=Q324_h982778','2023-03-04 07:31:00','2023-03-04 08:31:00',2,1,'No','Yes',1,'2023-02-23 20:34:26','2023-03-04 07:32:41',1),(2,1,'Backup ZIDI db at midnight everyday','https://backgen.net/backup?googleDriveFolderId=1UqWS0S7j-gFw-C5gZuHnWpRbaZWAYSx6&numOfFilesToLeave=2&serverAddress=159.203.186.99&dbName=bg_db&dbUsername=jonah&dbPassword=Q324_h982778','2023-04-14 00:00:00','2023-04-15 00:00:00',2,24,'No','Yes',1,'2023-02-23 20:35:56','2023-04-14 00:00:02',1);
/*!40000 ALTER TABLE `tbl_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tokens`
--

DROP TABLE IF EXISTS `tbl_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `token` varchar(245) NOT NULL,
  `creation_date` datetime NOT NULL,
  `expiry_date` datetime NOT NULL,
  `device_id` varchar(245) DEFAULT NULL,
  `browsername` varchar(250) DEFAULT NULL,
  `IPAddress` varchar(45) DEFAULT NULL,
  `OS` varchar(55) DEFAULT NULL,
  `usages` int DEFAULT '0',
  `status` int NOT NULL COMMENT '1-valid, 0-expired',
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tokens`
--

LOCK TABLES `tbl_tokens` WRITE;
/*!40000 ALTER TABLE `tbl_tokens` DISABLE KEYS */;
INSERT INTO `tbl_tokens` VALUES (1,1,'s2GqqTZzdeeAuBN6fbz4drkc2n8Ifg9zed1lZ5Q0AUfGfInNQEOdqWKzKydp8MPv','2023-02-23 20:33:00','2023-02-24 08:27:00','','','','',0,0),(2,1,'FDpHVo4P9u2XSchDsvwKFBwBXtDHu20ROSVxlN4vFzTB1Io5sD1kkvd91NVpNpsC','2023-02-24 08:27:00','2023-02-24 11:07:00','','','','',0,0),(3,1,'ldLWnvaL8EyEytUNOL2FaR83V80nDsdEtmaj5uyZpOd64JxaClJ3GjUD82k126DC','2023-02-25 09:30:00','2023-02-25 11:25:00','','','','',0,0),(4,2,'SaRH5jHNTohAU8Z7nQU949BOl9ma6aUZRRRmZrFaPvBvv9zCKWzh0D9sPwYnJ802','2023-02-25 11:29:00','2023-03-27 00:00:00','','','','',0,1),(5,1,'zsiHWPKvoPqqMHP3QEKAmsD8nNVjn522yZS7BPvby3nbtOaFRzMMDMUYOWP4Xa3J','2023-02-25 11:45:00','2023-02-25 11:46:00','','','','',0,0),(6,1,'sDuYjGM0cQpGtfL9JsG9PE21bONJp5GbUV4E5dplzF3KszAmQYPvjN6hBrEgue38','2023-02-25 11:46:00','2023-02-25 12:19:00','','','','',0,0),(7,1,'BePE3EK0Wi3p2hMo2wYAMGNWQfXYKXLUGWfSDhMxuo6fFMmSWYD4qPMwaSYo1djg','2023-02-25 12:19:00','2023-02-25 12:21:00','','','','',0,0),(8,1,'6xtgOCyv3oYWnNFOhHNmW2Iza7O6z3lWM0VKMEjWTAPX2HFj0ZOdYihabV3NlWmC','2023-02-25 12:22:00','2023-02-25 13:47:00','','','','',0,0),(9,1,'1Db4HYztaKQv579wbPr2JUMvNdhntnDeTlkWaY4IyVdNzroWWFkM1R3YziZiAIFB','2023-02-25 13:47:00','2023-02-25 13:47:00','','','','',0,0),(10,1,'SWxotWppNCLqmihm9tjVurltJqaM9bkX7m73TPR1PcTxOz4eSLZobv9l7eehVbZS','2023-02-25 13:47:00','2023-02-25 13:48:00','','','','',0,0),(11,1,'6a5L3NlCN8GioVcllLRme44rbsD70etSMTvWK4dCFY9YAworO0yOcSp1cUoUxe24','2023-02-25 15:23:00','2023-02-25 16:03:00','','','','',0,0),(12,1,'IH9lOsrii4GSfbuVj89uOrlNbXeK3Ruj2BcBRGDh2dWXz0TzuYWAEzlZGeZobVyl','2023-02-25 16:03:00','2023-02-27 08:54:00','','','','',0,0),(13,1,'dO2UhbSIJxlNuYghREoPF81miN0bz6WE6K3Hv2iBeOgyWGNndbf14WoD8c2eAPq8','2023-02-27 08:54:00','2023-02-27 09:57:00','','','','',0,0),(14,1,'DHcGEswQffYeYftdHKGQWpPNNRzqfyRXZbVuYmRkKcRV6GgmgMcbKBnZ9Lgnd3Z1','2023-02-27 09:57:00','2023-02-27 16:53:00','','','','',0,0),(15,1,'AVRDSeCH8m0gVCQPHejc5YdYdbIEesnxlaAZhRDbphTBANTJ89k9EZjshCcInZ1h','2023-02-27 16:53:00','2023-03-03 12:28:00','','','','',0,0),(16,1,'3tjyQIZtE6d5Ngs71ijAPYtnp8D8QiwuuIIb9Bi2W2qDOYQGVrDZZ7y6SRRhmYfq','2023-03-03 12:28:00','2023-03-03 14:20:00','','','','',0,0),(17,1,'jE7CckR2zKlLNBqFoSx1sY7pCJNCez5LbwBvtMukrddyJ4mPfAh37n88L3do0732','2023-03-03 14:20:00','2023-03-03 18:19:00','','','','',0,0),(18,1,'nkIvWn1n9NxpVDgGTSKCIa38briyLYhMEnwS04JyPRs2jesfVlGOA7s3zgSo5z7K','2023-03-03 18:19:00','2023-03-03 19:21:00','','','','',0,0),(19,1,'lAnxILeSJ7nqLYTD3UcBDagySUWrohW78gQVif2lrUAlCiMBtuoXpYbFZJw57PjH','2023-03-03 19:21:00','2023-03-26 15:28:00','','','','',0,0),(20,1,'DpfSLkw3ngMsvyWn1EK2J4d8nl2csStiEI5Kc78wKVrP9bVS4k7Sc5G6YTgahyvK','2023-03-26 15:28:00','2023-04-11 18:57:00','','','','',0,0),(21,1,'RMddSdn6UiEWaey95Eu3wAoD5lQt6YYQ48RIf7Ho2PPVnwvCw3u5JoSS24OQHizR','2023-04-11 18:57:00','2023-04-14 12:17:00','','','','',0,0),(22,1,'qvVVN5kWn7O2OXetrOjkGcxPiO26WRzPI3G9iqzMmpgfRiA8ac9dFGDcs4neuhtY','2023-04-14 12:17:00','2023-05-14 00:00:00','','','','',0,1);
/*!40000 ALTER TABLE `tbl_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_units`
--

DROP TABLE IF EXISTS `tbl_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_units`
--

LOCK TABLES `tbl_units` WRITE;
/*!40000 ALTER TABLE `tbl_units` DISABLE KEYS */;
INSERT INTO `tbl_units` VALUES (1,'Minutes',1),(2,'Hours',1),(3,'Days',1),(4,'Weeks',1),(5,'Months',1),(6,'Years',1);
/*!40000 ALTER TABLE `tbl_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user_groups`
--

DROP TABLE IF EXISTS `tbl_user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_user_groups` (
  `uid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user_groups`
--

LOCK TABLES `tbl_user_groups` WRITE;
/*!40000 ALTER TABLE `tbl_user_groups` DISABLE KEYS */;
INSERT INTO `tbl_user_groups` VALUES (1,'Super Admin','Given rights to do all operations in the system including deleting data. Some rights are assigned by default ',1),(2,'Admin','Restricted Administrative Functionalilties',1),(3,'Front Office','Minimal Permissions to view and add information',1);
/*!40000 ALTER TABLE `tbl_user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid_v4` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified` char(10) NOT NULL DEFAULT 'No',
  `company_id` int NOT NULL,
  `user_group` int NOT NULL DEFAULT '3',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int NOT NULL DEFAULT '2' COMMENT '0 - deleted/blocked\r\n1 - active/approved\r\n2 - Pending/to be approved\r\n\r\n',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid_v4_index` (`uuid_v4`),
  KEY `user_group_index` (`user_group`),
  KEY `email_confirmed` (`email_verified`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'922172b3-7459-4396-b712-99ef7ca4d2b6','Sam Munyi','samunyi90@gmail.com','$2y$12$bn1DNKiI2OEqbdDGeAagT.la8SFs3MxJm1ZriXtkGT.dERnc0a5RG','No',1,1,'2023-02-25 11:45:15','2023-02-25 11:45:41',1);
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-14 12:22:56
