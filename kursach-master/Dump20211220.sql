CREATE DATABASE  IF NOT EXISTS `kursach` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kursach`;
-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: kursach
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bets` (
  `id_bets` bigint NOT NULL AUTO_INCREMENT,
  `id_lot` bigint NOT NULL,
  `id_user` bigint NOT NULL,
  `bet` varchar(10) NOT NULL,
  `date_bet` varchar(20) NOT NULL,
  PRIMARY KEY (`id_bets`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bets`
--

LOCK TABLES `bets` WRITE;
/*!40000 ALTER TABLE `bets` DISABLE KEYS */;
INSERT INTO `bets` VALUES (30,46,30,'10','03.03.2018 22:56'),(31,46,32,'24','03.03.2018 22:59'),(32,46,31,'100','03.03.2018 23:01'),(33,46,32,'111','04.03.2018 10:11'),(34,48,32,'15','05.03.2018 13:47'),(35,48,30,'25','05.03.2018 15:40'),(36,49,32,'133','05.03.2018 15:44'),(37,48,32,'buy','05.03.2018 16:16'),(38,45,31,'buy','05.03.2018 16:37'),(39,50,30,'41','11.03.2018 12:16'),(40,81,32,'buy','28.04.2018 09:39'),(41,86,43,'100','01.05.2018 15:50'),(42,83,43,'buy','01.05.2018 16:11'),(43,12,47,'546','28.11.2021 21:17'),(44,1,47,'buy','28.11.2021 23:48'),(45,12,47,'5555','01.12.2021 18:27'),(46,90,49,'buy','01.12.2021 19:33'),(47,91,47,'124','01.12.2021 20:28'),(48,87,50,'3333','03.12.2021 12:22'),(49,87,50,'buy','03.12.2021 12:22'),(50,93,49,'456','20.12.2021 18:50'),(51,93,49,'buy','20.12.2021 18:50');
/*!40000 ALTER TABLE `bets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id_category` bigint NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Сувениры и подарки'),(2,'Компьютеры и оргтехника'),(3,'Ювелирные изделия, бижутерия, часы'),(4,'Транспорт'),(5,'Телефоны, связь и навигация');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id_comments` bigint NOT NULL AUTO_INCREMENT,
  `id_lot` bigint NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date_dispatch` varchar(20) NOT NULL,
  `id_users` bigint NOT NULL,
  PRIMARY KEY (`id_comments`),
  KEY `id_lot` (`id_lot`),
  KEY `id_users` (`id_users`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_lot`) REFERENCES `lot` (`id_lot`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,12,'123','19.12.2021 21:51',49),(2,11,'3','20.12.2021 00:07',32),(3,11,'5','20.12.2021 00:09',32),(4,1,'доставили вовремя и недорого, всё работает, спасибо!','20.12.2021 18:26',47);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `issues`
--

DROP TABLE IF EXISTS `issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `issues` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `id_user` bigint NOT NULL,
  `title` varchar(50) NOT NULL,
  `priority` int NOT NULL,
  `question` longtext NOT NULL,
  `date_submit` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `issues`
--

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;
INSERT INTO `issues` VALUES (1,49,'asd',1,'ddddd','30.11.2021 17:59'),(2,47,'ytre564',1,'45764657','03.12.2021 12:53');
/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lot`
--

DROP TABLE IF EXISTS `lot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lot` (
  `id_lot` bigint NOT NULL AUTO_INCREMENT,
  `lot_name` varchar(100) NOT NULL,
  `start_price` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL,
  `decription` varchar(1000) NOT NULL,
  `id_users` bigint NOT NULL,
  `date_start` varchar(20) NOT NULL,
  `date_end` varchar(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `delivery` varchar(200) NOT NULL,
  `id_subcategory` bigint NOT NULL,
  PRIMARY KEY (`id_lot`),
  KEY `id_users` (`id_users`),
  KEY `id_subcategory` (`id_subcategory`),
  CONSTRAINT `lot_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lot_ibfk_2` FOREIGN KEY (`id_subcategory`) REFERENCES `subcategory` (`id_subcategory`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lot`
--

LOCK TABLES `lot` WRITE;
/*!40000 ALTER TABLE `lot` DISABLE KEYS */;
INSERT INTO `lot` VALUES (1,'материнская плата','100','5000','хорошая материнская плата',32,'02.12.2021 17:02','31.12.2021 17:02','Россия, Москва','за ваш счет',6),(2,'efadawdasds','','453354435','asdsad awdwacv dawdcawd',30,'27.04.2018 14:46','03.02.2018 14:46','ewqqwewqeq','s dasd asdas',5),(3,'anewmeta','1','66666','topoptoaptoaptoat',32,'27.04.2018 17:27','06.05.2017 17:27','sdadadsada','asdadsada',5),(4,'wqeewqwqeweq','5','','wqeweqewqweqewq',32,'27.04.2018 17:28','01.06.2018 17:28','tamtam','tedatyda',4),(5,'asdsaddadada','2','222','asdsadadadsadadsa',32,'27.04.2018 17:39','29.04.2017 00:00','43141dsadsada','sdsdsadasda',7),(6,'норм время','3','21321321','топ описаниеывфы',32,'27.04.2018 17:40','17.05.2018 17:40','йцуййцу','йцуйуйу',7),(7,'хг9ыфпвахг9ПХИЦ№','43','5223','фывфимфаф фммфц аф',32,'27.04.2018 17:42','04.05.2018 17:42','25ваМЫУАуым ауы','ываыаа',5),(8,'пафв выа а выа   прфи 4рфу','55','34353','ываымаыаыва',30,'27.04.2018 17:56','01.05.2018 17:56','тамамамам','тутатататат',9),(9,'sdd fsd fsd ffgddsf  sfgdsdsfdsf','4','','dsfdsfdf    dfsdf',30,'27.04.2018 18:17','28.04.2018 18:17','sda aad asddsa','dsd dsa asds',21),(10,'asd asdadvadfad adgawvd','5555','235235235','dawdgafa vd',32,'28.04.2018 10:12','05.05.2018 10:12','тамтамтам','wvgerwfwefw',8),(11,'5 eatgeyhgae yheg','','53453535','refae aergaeg',44,'30.04.2018 19:01','31.05.2018 19:01','354353aaf aef','asdfsa fsdf',13),(12,'newnwewnewnw','65','','dfwecv3wqf4gsf hsfh s',46,'30.04.2018 23:54','30.04.2018 23:54','wfdsfvs bfasfvse','sf4fwefge4a gthjsagh',14),(87,'2413','2314','4231','1243',47,'28.11.2021 21:54','30.11.2021 21:54','142346534365653465346534','142334654653653465346453',4),(90,'фывап','2345','354','4231',47,'01.12.2021 19:02','24.12.2021 19:02','54323545234','54323543542',7),(91,'gsdf','123','123123','gsdf',49,'01.12.2021 20:23','09.12.2021 20:23','asfdfasdafsd','fdsfsda',8),(93,'тестовый лот','123','9999','тестовое описание',47,'20.12.2021 18:45','30.12.2021 18:45','Россия, город Калуга, Пролетарский район','СДЕК или почта России, на ваш выбор',6);
/*!40000 ALTER TABLE `lot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `date_dispatch` text NOT NULL,
  `from_id_users` bigint NOT NULL,
  `to_id_users` bigint NOT NULL,
  `unread` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (40,'привет','30.04.2018 18:54',30,32,0),(43,'сосед','30.04.2018 22:55',32,30,0),(44,'ты кто?','30.04.2018 22:56',32,44,0),(45,'фгрвфовзифв','30.04.2018 23:30',45,32,1),(46,'еруфреуфреуфрфеуреуф','30.04.2018 23:31',45,44,0),(47,'ир43пцм5и4рп','30.04.2018 23:31',45,30,1),(49,'ehtrfeatheahaheaa','30.04.2018 23:49',32,42,1),(50,'privet','30.04.2018 23:54',46,32,0),(51,'ssssssssssss','01.05.2018 14:10',32,30,1),(52,'sadsadsadsadsadsa','01.05.2018 16:18',32,43,1),(53,'Пользователь <strong><a href=\'../cabinet/index.php?nav=msg&id=47\'>1234656</a></strong> купил ваш лот <strong><a href=\"../lot/index.php?id=1\">#1 материнская плата</a></strong> <i>28.11.2021</i> в <i>23:48</i>.','28.11.2021 23:48',1,32,1),(54,'123123','01.12.2021 13:32',49,44,1),(55,'312132','01.12.2021 14:03',49,47,1),(56,'41441414','01.12.2021 14:03',47,49,1),(57,'Пользователь <strong><a href=\'../cabinet/index.php?nav=msg&id=49\'>gleb</a></strong> купил ваш лот <strong><a href=\"../lot/index.php?id=90\">#90 фывап</a></strong> <i>01.12.2021</i> в <i>19:33</i>.','01.12.2021 19:33',1,47,1),(58,'Пользователь <strong><a href=\'../cabinet/index.php?nav=msg&id=50\'>testlogin</a></strong> купил ваш лот <strong><a href=\"../lot/index.php?id=87\">#87 2413</a></strong> <i>03.12.2021</i> в <i>12:22</i>.','03.12.2021 12:22',1,47,1),(59,'31','19.12.2021 23:24',49,44,1),(60,'test','19.12.2021 23:25',44,49,1),(61,'123','19.12.2021 23:36',44,32,1),(62,'3','19.12.2021 23:44',44,45,1),(63,'321','20.12.2021 00:06',32,45,1),(64,'123','20.12.2021 00:14',49,47,1),(65,'123','20.12.2021 00:39',32,30,1),(66,'Пользователь <strong><a href=\'../cabinet/index.php?nav=msg&id=49\'>gleb</a></strong> купил ваш лот <strong><a href=\"../lot/index.php?id=93\">#93 тестовый лот</a></strong> <i>20.12.2021</i> в <i>18:50</i>.','20.12.2021 18:50',1,47,1);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id_news` bigint NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `date_submit` date NOT NULL,
  PRIMARY KEY (`id_news`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'Запуск сайта','Описание','2021-11-30'),(2,'Новость №2','Описание','2021-12-02'),(3,'Новость №3','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempore totam cumque minus dolor, corporis corrupti, harum ab deserunt amet in.','2021-12-03');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategory`
--

DROP TABLE IF EXISTS `subcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subcategory` (
  `id_subcategory` bigint NOT NULL AUTO_INCREMENT,
  `subcategory` varchar(50) NOT NULL,
  `id_category` bigint NOT NULL,
  PRIMARY KEY (`id_subcategory`),
  KEY `id_subcategory` (`id_subcategory`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategory`
--

LOCK TABLES `subcategory` WRITE;
/*!40000 ALTER TABLE `subcategory` DISABLE KEYS */;
INSERT INTO `subcategory` VALUES (3,'Сувениры',1),(4,'Открытки',1),(5,'Аксессуары',2),(6,'Комплектующие',2),(7,'Остальное',2),(8,'Автомобили',4),(9,'Автозапчасти',4),(10,'Аксессуары',4),(11,'Оборудование',4),(12,'Драгоценные камни',3),(13,'Часы',3),(14,'Серьги',3),(15,'Цепочки',3),(16,'Кольца',3),(17,'Остальное',3),(18,'Сотовые телефоны и смарфоны',5),(19,'Аксессуары',5),(20,'Запчасти и оборудование',5),(21,'Навигаторы',5),(24,'Остальное',5);
/*!40000 ALTER TABLE `subcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id_users` bigint NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rating` bigint NOT NULL,
  `date_registration` varchar(20) NOT NULL,
  `money` varchar(10) NOT NULL,
  `image` varchar(500) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `info` longtext,
  `last_enter` varchar(20) NOT NULL,
  PRIMARY KEY (`id_users`),
  KEY `id_users` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Уведомление','$2y$10$I/3rT3LdeBWtpgZF4j9gP.E2s33rl8WZT2DQOk0cyc03rHeMh13om','1',1,'1','1','1',NULL,NULL,NULL,'20.12.2021 00:28'),(30,'user','$2y$10$8W0orHheqEE42BKdWodUvutuhCvlQ7KU.K3SUEWlQF4Aux/a85yDa','mail@mail.mail',0,'2018-02-18','8860','1',NULL,'',NULL,'30.04.2018 23:29'),(32,'admin','$2y$10$I/3rT3LdeBWtpgZF4j9gP.E2s33rl8WZT2DQOk0cyc03rHeMh13om','admin@mail.mail',0,'02.03.2018 15:38','376','1',NULL,'',NULL,'20.12.2021 00:39'),(42,'fgh','$2y$10$1gKlQ5.rI4lEY.1H1nI4v.NMki.mIn9pkc8618f3F9K8lEl76tbOm','qwe@qwe.qweee',0,'2018.04.19 15:21','0','0',NULL,'',NULL,'2018.04.19 15:21'),(43,'ooo','$2y$10$QydNt6BE9J5yBwaS7C9HZ.m8U5y6C4Sor5GCo9P1eOUSxQRGWQwUy','d@sd.sad',0,'2018.04.19 15:26','0','0',NULL,'',NULL,'01.05.2018 15:14'),(44,'user123','$2y$10$PS4miXHZaBJr/S1my8xazuO20NLMBjYwYEdd9nTgv.OJlGGPy4AQ.','qwe@asd.d',0,'19.04.2018 15:27','','44',NULL,'',NULL,'19.12.2021 23:32'),(45,'kisa','$2y$10$2mVxgwUn0nloCuFyRVDmT.Y5B3OylxnDOtw6dl6I2SZjK.PU7OgZ6','asd@asd.asd',0,'2018.04.23 17:51','0','0',NULL,'',NULL,'30.04.2018 23:30'),(46,'new','$2y$10$UElMKlJFeFUQwP1/0t14mOcn6RZeNhTs4kJUtt5V2VBhpRGLWS.6C','ajdaj@asdas.asdihoa',0,'30.04.2018 23:50','0','0',NULL,'',NULL,'30.04.2018 23:50'),(47,'1234656','$2y$10$omLVMhGeDpcEvLi.6SMCauAiSySgREvzueqkdSMPRpF7xZ9Rsp6pm','xirouz@gmail.com',0,'28.11.2021 20:47','0','47','1','3',NULL,'20.12.2021 18:51'),(48,'asdasd','$2y$10$p1sAeaCVzkojej3nVdZJueVwf.RoWMw.Y6xIesKfgtcZYZwYwx0Mq','asd@v.r',0,'29.11.2021 14:44','0','48','1','14','321','29.11.2021 14:44'),(49,'gleb','$2y$10$Xu1mHozjnnF1eqoNlR/ZWOX/.j7L5wMkYkBO9GP6tZlD3ospYhLk6','a@g.t',0,'30.11.2021 17:30','0','0','0','0',NULL,'20.12.2021 18:46'),(50,'testlogin','$2y$10$XCbxN3r9Y25FIX5PTuvIgOvPGkFK6AcNYbUoG8zAz.tCJ9oSBxJb2','test@mail.ru',0,'03.12.2021 12:21','0','0','0','0',NULL,'03.12.2021 12:21'),(51,'test123','$2y$10$kf/3jFR.iDD6Yf0kd6sG0eKC6IDH74mGKgPAGU0B82xCTHLA4uezG','asd@g.r',0,'19.12.2021 17:53','0','0','0','0',NULL,'19.12.2021 17:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'kursach'
--

--
-- Dumping routines for database 'kursach'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-12-20 19:22:03
