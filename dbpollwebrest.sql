-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: dbpollwebrest
-- ------------------------------------------------------
-- Server version	5.7.21-log

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
-- Table structure for table `answer_instances`
--

DROP TABLE IF EXISTS `answer_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_instances` (
  `IDanswer` int(10) unsigned NOT NULL,
  `IDinstance` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IDanswer`,`IDinstance`),
  KEY `answers_instances` (`IDinstance`),
  CONSTRAINT `answers_instances` FOREIGN KEY (`IDinstance`) REFERENCES `instances` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `instances_answers` FOREIGN KEY (`IDanswer`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_instances`
--

LOCK TABLES `answer_instances` WRITE;
/*!40000 ALTER TABLE `answer_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer_instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answer` varchar(255) NOT NULL,
  `IDquestion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_questions` (`IDquestion`),
  CONSTRAINT `answers_questions` FOREIGN KEY (`IDquestion`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,'1',8),(2,'1',8),(3,'2',8),(4,'1',8);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instances`
--

DROP TABLE IF EXISTS `instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userStatus` tinyint(1) NOT NULL,
  `submission` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `IDuser` int(10) unsigned NOT NULL,
  `IDpoll` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `instances_users` (`IDuser`),
  KEY `instances_polls` (`IDpoll`),
  CONSTRAINT `instances_polls` FOREIGN KEY (`IDpoll`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `instances_users` FOREIGN KEY (`IDuser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instances`
--

LOCK TABLES `instances` WRITE;
/*!40000 ALTER TABLE `instances` DISABLE KEYS */;
INSERT INTO `instances` VALUES (5,0,'2019-08-13 20:38:50',4,5),(6,0,'2019-08-13 20:39:02',5,5),(7,0,'2019-08-13 20:39:07',6,5),(8,0,'2019-08-14 19:57:23',6,5),(9,0,'2019-08-14 19:57:42',6,5),(10,0,'2019-08-15 18:40:02',6,5),(11,0,'2019-09-09 21:35:36',5,1),(12,0,'2019-09-09 21:37:08',5,1);
/*!40000 ALTER TABLE `instances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `polls`
--

DROP TABLE IF EXISTS `polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `polls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idNum` varchar(255) NOT NULL,
  `title` varchar(32) NOT NULL,
  `openText` varchar(255) NOT NULL,
  `closeText` varchar(255) NOT NULL,
  `openPoll` tinyint(1) NOT NULL,
  `statePoll` tinyint(1) NOT NULL,
  `URLPoll` varchar(255) NOT NULL,
  `IDuser` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idNum` (`idNum`),
  UNIQUE KEY `URLPoll` (`URLPoll`),
  KEY `polls_users` (`IDuser`),
  CONSTRAINT `polls_users` FOREIGN KEY (`IDuser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `polls`
--

LOCK TABLES `polls` WRITE;
/*!40000 ALTER TABLE `polls` DISABLE KEYS */;
INSERT INTO `polls` VALUES (1,'1gTl6pc5mfNnG6xY','Sondaggio di prova 7','Testo di apertura','Testo di chiusura',0,1,'http://localhost:8000/api/v1/poll/',4),(3,'dGGqLFICrAIvzqOQ','Sondaggio di prova 8','Testo di apertura','Testo di chiusura',0,0,'http://localhost:8000/api/v1/poll/2',4),(4,'F3q0fk7I06R6TW3R','Profilazione Google','Testo di apertura','Testo di chiusura',0,0,'http://localhost:8000/api/v1/poll/4',4),(5,'OlvUDrksTFQE2lX3','sondaggio modificato','Testo di apertura','Testo di chiusura',0,0,'http://localhost:8000/api/v1/poll/5',4),(6,'P484jFD47cXd53MR','Profilazione Facebook','Testo di apertura','Testo di chiusura',0,0,'http://localhost:8000/api/v1/poll/6',4),(8,'AWWTnYPGjCOPTkGq','quanti id salti','Testo di apertura','Testo di chiusura',0,1,'http://localhost:8000/api/v1/poll/8',4),(9,'O3KU38ENA758kq1X','Scelta template','compila il sondaggio','grazie per la partecipazione',1,0,'http://localhost:8000/api/v1/poll/9',4),(10,'BuNKafOmhx3WbA0P','Scelta template','compila il sondaggio','grazie per la partecipazione',1,0,'http://localhost:8000/api/v1/poll/10',4),(12,'Bw2uW0MLN9wrbOAC','Scelta template','compila il sondaggio','grazie per la partecipazione',1,0,'http://localhost:8000/api/v1/poll/11',4);
/*!40000 ALTER TABLE `polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `positionNumber` int(10) unsigned NOT NULL,
  `uniqueCode` varchar(32) NOT NULL,
  `questionText` text NOT NULL,
  `note` varchar(32) NOT NULL DEFAULT 'NONE',
  `mandatory` tinyint(1) NOT NULL DEFAULT '1',
  `questionType` enum('SHORTTEXT','LONGTEXT','NUMBER','DATE','SINGLECHOISE','MULTIPLECHOISE') DEFAULT NULL,
  `minimum` varchar(32) NOT NULL DEFAULT 'NONE',
  `maximum` varchar(32) NOT NULL DEFAULT 'NONE',
  `questionOption` varchar(255) NOT NULL,
  `IDpoll` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueCode` (`uniqueCode`),
  KEY `questions_polls` (`IDpoll`),
  CONSTRAINT `questions_polls` FOREIGN KEY (`IDpoll`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (5,1,'ggqUaICjpEutlBDG','e\'questo il sondaggio 7?','NONE',1,'SINGLECHOISE','NONE','NONE','si $!br# no',1),(7,2,'NuAE9ulpaSK4K3VD','si puo\' cambiare la posizione?','NONE',1,'SINGLECHOISE','NONE','NONE','si $!br# no',1),(8,3,'1Jwir2Dmc86XTFwW','Holy grail?','NONE',1,'SINGLECHOISE','NONE','NONE','si $!br# no',1),(9,4,'ly1u3lxpUmKKSk7A','domanda modificata','NONE',1,'SINGLECHOISE','NONE','NONE','si $!br# no',1),(10,5,'9Mj6tGmizg3QXK3X','ste domande servono per fare numero?','NONE',1,'SINGLECHOISE','NONE','NONE','tante $!br# tante come seconda scelta',1),(12,6,'iirgzXEzH58YODsd','quante sono le domande?','NONE',1,'SINGLECHOISE','NONE','NONE','tante $!br# tante come seconda scelta',1),(18,1,'kOgqID98KsanWMTn','quante sono le domande?','NONE',1,'SINGLECHOISE','NONE','NONE','tante $!br# tante come seconda scelta',5),(19,2,'NzdluEQyw16zmpnU','questa è la prima domanda','NONE',1,'SINGLECHOISE','NONE','NONE','tante $!br# tante come seconda scelta',5);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ADMIN','RES','USER') NOT NULL,
  `api_token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Giorno','Giovanna','giogio@gmail.com','$2y$10$mtnkBVFeuHI/yr8JdnOcyeZDZfsYpaqa0dEVzb2.9AITW/AmmXOua','ADMIN','UzBNaFo0Zk1YMFRSM0FBRnVFbFI2MlFPVGg1TVVtME4xbWlDOFRzUmhENW5JVXFzZEd2M2dKZkVrcWtY'),(5,'DIO','Brando','DIO@brando.com','$2y$10$mn62QBji4I71e9G/ZiP0sefdIBtu4bOQWI8jfPPhNd/GqcJcUWvq6','RES','RXFGZ1BsTFRheXhQY2t6Wkt6TlFReFJzZWJUc205NkVET0pYTkE2VUFhRDFzSndsOFY2cWl2UjJTb2ky'),(6,'Jotaro','Kujo','JoJo@bjoestar.com','$2y$10$zD5fEQ/mPdE84mHOfo242O/uzBl0t9ipQfNb7bCJuZ32dohePl/zW','USER','cWJObjcwdTBUOGpQSzVnWVp6UVZ5NGFGZ2JNRkZROE9XSVptNTZTNzJhOXVnUkhaaVRPMHd4VnIwTlJz'),(7,'Johnatan','Joestar','JoJo@joestar.com','$2y$10$TuMS2jmAzkafrmNC8MwameJFH0TSN54HMXFsh6Ax2WKodAJT4X4Y2','RES','N3hGOVhHU083Q2ZpWVF1S2lyS0J4TzhLejFhS09RZDlseTFJeXdoTGdHNGlDRXFHTTFHMHJCUkFwU1F1');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-10  0:16:07
