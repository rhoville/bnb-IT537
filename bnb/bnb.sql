-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: bnb
-- ------------------------------------------------------
-- Server version	8.0.23

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
-- Current Database: `bnb`
--

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `adminID` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin','admin@ongaonga.co.nz','2023-08-28 21:46:14','2023-08-28 21:56:23');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking` (
  `bookingID` int unsigned NOT NULL AUTO_INCREMENT,
  `customerID` int unsigned NOT NULL,
  `roomID` int unsigned NOT NULL,
  `checkinDate` date NOT NULL,
  `checkoutDate` date NOT NULL,
  `contactNumber` varchar(50) NOT NULL,
  `extra` text NOT NULL,
  `review` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`bookingID`),
  KEY `fk_customerID` (`customerID`),
  KEY `fk_roomID` (`roomID`),
  CONSTRAINT `fk_customerID` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_roomID` FOREIGN KEY (`roomID`) REFERENCES `room` (`roomID`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (9,19,1,'2023-08-02','2023-09-06','(333) 123-2214','',NULL),(11,19,2,'2023-08-04','2023-09-08','(333) 123-2214','',NULL),(12,19,4,'2023-09-02','2023-09-08','(333) 123-2214','Free Wifi','Great view!'),(13,35,3,'2023-09-01','2023-09-11','(333) 123-2214','Wifi','Awesome');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `customerID` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `is_hashed` tinyint(1) NOT NULL DEFAULT '0',
  `country` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `phonenumber` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'Garrison','Jordan','sit.amet.ornare@nequesedsem.edu','password',0,'New Zealand','(032) 123-4567',0),(2,'Desiree','Collier','Maecenas@non.co.uk','',0,'','',0),(3,'Irene','Walker','id.erat.Etiam@id.org','',0,'','',0),(4,'Forrest','Baldwin','eget.nisi.dictum@a.com','',0,'','',0),(5,'Beverly','Sellers','ultricies.sem@pharetraQuisqueac.co.uk','',0,'','',0),(6,'Glenna','Kinney','dolor@orcilobortisaugue.org','',0,'','',0),(7,'Montana','Gallagher','sapien.cursus@ultriciesdignissimlacus.edu','',0,'','',0),(8,'Harlan','Lara','Duis@aliquetodioEtiam.edu','',0,'','',0),(9,'Benjamin','King','mollis@Nullainterdum.org','',0,'','',0),(10,'Rajah','Olsen','Vestibulum.ut.eros@nequevenenatislacus.ca','',0,'','',0),(11,'Castor','Kelly','Fusce.feugiat.Lorem@porta.co.uk','',0,'','',0),(12,'Omar','Oconnor','eu.turpis@auctorvelit.co.uk','',0,'','',0),(13,'Porter','Leonard','dui.Fusce@accumsanlaoreet.net','',0,'','',0),(14,'Buckminster','Gaines','convallis.convallis.dolor@ligula.co.uk','',0,'','',0),(15,'Hunter','Rodriquez','ridiculus.mus.Donec@est.co.uk','',0,'','',0),(16,'Zahir','Harper','vel@estNunc.com','',0,'','',0),(17,'Sopoline','Warner','vestibulum.nec.euismod@sitamet.co.uk','',0,'','',0),(18,'Burton','Parrish','consequat.nec.mollis@nequenonquam.org','',0,'','',0),(19,'Admin','Rose','admin','$2y$10$Gf5GOo8pAbvauDvs9JMypeqkJXGiVcJIdXo8BdJLjKxSqg3p.CgOS',1,'','',1),(20,'Barry','Burks','risus@libero.net','password',0,'','',0),(24,'Scotty','Natividad','scotty@gmail.com','$2y$10$.Ar82N64GvKzFWWEcNIUku.jR.KiDrcEhxs3Nmg81J8D5zUaxBaEy',1,'New Zealand','(034) 123-4567',0),(25,'Rhoville','Natividad','rhovillenatividad@yahoo.com','$2y$10$eaa6mrwqVHywC8f45XSk0eOQb7SijOPAPijsr.7/0RNw.6sF9Dwam',1,'New Zealand','(034) 123-4567',0),(26,'Angeli','Scotty','angeli@gmail.com','$2y$10$OaXDNWR6JTnEdiIJ/LQQ4.E.raIEQDKIC/75M8us1P0b.stASCrJG',0,NULL,NULL,0),(27,'Laura','Blaze','laura@gmail.com','$2y$10$AU0v4mb5ZkkyiVsUBuA8DON.ELPtJWGlBqLOalJMLHqGS/KGx5TZS',0,NULL,NULL,0),(34,'Merivale','Papanui','papanui@gmail.com','$2y$10$9oKHu6/OueP7TcuBMTbaaerpa5blBANIgy1jXH5JNVrnt4aHjch.q',0,NULL,NULL,0),(35,'Will','Dave','dave@gmail.com','$2y$10$pLZlrB3hTT8TwhCfJCZpqOq9FS2YmCOKCdTJAjPi1B3ND86pJFLWy',1,'New Zealand','(034) 123-4567',0);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `messageID` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `messages` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `messageID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (7,'Rhoville','angeli.rhoville@gmail.com','Hello!'),(8,'Angeli','scottyA@gmail.com','Scotty!'),(9,'Will','dave@gmail.com','Hello!');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `room` (
  `roomID` int unsigned NOT NULL AUTO_INCREMENT,
  `roomname` varchar(100) NOT NULL,
  `description` text,
  `roomtype` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `beds` int DEFAULT NULL,
  `availability` enum('Available','Occupied') DEFAULT NULL,
  PRIMARY KEY (`roomID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'Kellie','Stunning single bedroom, with great window view!','D',1,NULL),(2,'Herman','Lorem ipsum dolor sit amet, consectetuer','D',5,NULL),(3,'Scarlett','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur','D',2,NULL),(4,'Jelani','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam','S',2,NULL),(5,'Sonya','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.','S',5,NULL),(6,'Miranda','Lorem ipsum dolor sit amet, consectetuer adipiscing','S',4,NULL),(7,'Helen','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.','S',2,NULL),(8,'Octavia','Lorem ipsum dolor sit amet,','D',3,NULL),(9,'Gretchen','Lorem ipsum dolor sit','D',3,NULL),(10,'Bernard','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer','S',5,NULL),(11,'Dacey','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur','D',2,NULL),(12,'Preston','Lorem','D',2,NULL),(13,'Dane','Lorem ipsum dolor','S',4,NULL),(14,'Cole','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam','S',1,NULL),(16,'Scotty','Beautiful room','D',1,NULL),(18,'Jacinda','Good for family with children.','D',3,NULL);
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-31 13:25:38
