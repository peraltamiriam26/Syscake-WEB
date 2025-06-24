-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: syscakeweb
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `archivos`
--

DROP TABLE IF EXISTS `archivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivos` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ruta` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos`
--

LOCK TABLES `archivos` WRITE;
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escritors`
--

DROP TABLE IF EXISTS `escritors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escritors` (
  `esEscritor` tinyint(1) NOT NULL,
  `usuario_id` int NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`),
  KEY `fk_escritor_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_escritor_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escritors`
--

LOCK TABLES `escritors` WRITE;
/*!40000 ALTER TABLE `escritors` DISABLE KEYS */;
INSERT INTO `escritors` VALUES (1,2,'2025-05-20 12:18:21','2025-05-20 12:18:21',NULL),(1,7,'2025-05-27 17:55:54','2025-05-27 17:55:54',NULL),(1,17,'2025-05-26 21:48:20','2025-05-26 21:48:20',NULL),(1,18,'2025-05-27 16:13:30','2025-05-27 16:13:30',NULL);
/*!40000 ALTER TABLE `escritors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingrediente_has_recetas`
--

DROP TABLE IF EXISTS `ingrediente_has_recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingrediente_has_recetas` (
  `ingrediente_id` int NOT NULL,
  `receta_id` int NOT NULL,
  `cantidad` double NOT NULL,
  `tipounidad_id` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ingrediente_id`,`receta_id`),
  KEY `fk_ingrediente_has_receta_receta1_idx` (`receta_id`),
  KEY `fk_ingrediente_has_receta_ingrediente1_idx` (`ingrediente_id`),
  KEY `ingrediente_has_recetas_tipounidads_FK` (`tipounidad_id`),
  CONSTRAINT `ingrediente_has_recetas_ingredientes_FK` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`),
  CONSTRAINT `ingrediente_has_recetas_recetas_FK` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`),
  CONSTRAINT `ingrediente_has_recetas_tipounidads_FK` FOREIGN KEY (`tipounidad_id`) REFERENCES `tipounidads` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediente_has_recetas`
--

LOCK TABLES `ingrediente_has_recetas` WRITE;
/*!40000 ALTER TABLE `ingrediente_has_recetas` DISABLE KEYS */;
INSERT INTO `ingrediente_has_recetas` VALUES (1,4,500,2,NULL,NULL,NULL),(1,12,1,1,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL),(1,13,180,2,'2025-06-23 16:36:57','2025-06-23 16:36:57',NULL),(2,13,6,3,'2025-06-23 16:36:57','2025-06-23 16:36:57',NULL),(3,4,1,2,NULL,NULL,NULL),(3,12,5,2,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL),(5,4,20,2,NULL,NULL,NULL),(5,12,25,2,NULL,NULL,NULL),(7,12,180,2,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL),(9,5,500,2,NULL,NULL,NULL),(10,12,100,2,NULL,NULL,NULL),(12,4,550,6,NULL,NULL,NULL),(13,4,1,7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ingrediente_has_recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_At` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes`
--

LOCK TABLES `ingredientes` WRITE;
/*!40000 ALTER TABLE `ingredientes` DISABLE KEYS */;
INSERT INTO `ingredientes` VALUES (1,'Harina','2025-05-31 14:43:32','2025-05-31 14:43:32',NULL),(2,'Huevo','2025-05-31 14:43:41','2025-05-31 14:43:41',NULL),(3,'Azúcar','2025-05-31 14:43:49','2025-05-31 14:43:49',NULL),(4,'Jugo de limón','2025-05-31 14:44:06','2025-06-22 22:10:08','2025-06-22 22:10:08'),(5,'Sal','2025-05-31 14:44:15','2025-05-31 14:44:15',NULL),(6,'Frutilla','2025-05-31 14:44:25','2025-05-31 14:44:25',NULL),(7,'Leche','2025-05-31 14:44:36','2025-05-31 14:44:36',NULL),(8,'Oregano','2025-05-31 14:44:49','2025-05-31 14:44:49',NULL),(9,'Papa','2025-06-08 14:40:51','2025-06-08 14:40:51',NULL),(10,'Jamón','2025-06-22 16:51:40','2025-06-22 16:51:40',NULL),(11,'Queso dambo','2025-06-22 16:52:00','2025-06-22 16:52:38',NULL),(12,'Agua','2025-06-24 00:12:52','2025-06-24 00:12:52',NULL),(13,'Aceite de oliva','2025-06-24 00:13:10','2025-06-24 00:13:10',NULL);
/*!40000 ALTER TABLE `ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruccions`
--

DROP TABLE IF EXISTS `instruccions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruccions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` mediumtext NOT NULL,
  `receta_id` int NOT NULL,
  `archivo_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `orden` int NOT NULL,
  PRIMARY KEY (`id`,`receta_id`),
  KEY `fk_instrucciones_receta1_idx` (`receta_id`),
  KEY `fk_instrucciones_archivo1_idx` (`archivo_id`),
  CONSTRAINT `fk_instrucciones_archivo1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`),
  CONSTRAINT `instruccions_recetas_FK` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruccions`
--

LOCK TABLES `instruccions` WRITE;
/*!40000 ALTER TABLE `instruccions` DISABLE KEYS */;
INSERT INTO `instruccions` VALUES (1,'MEZCLADO: Disolver la levadura en la leche tibia. Colocar la harina en forma de corona y, en medio, el huevo, la leche con la levadura, el azúcar y el aceite. La sal por alrededor. Mezclar todo con la mano hasta que esté bien integrado.',12,NULL,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL,1),(2,'AMASADO: Volcar la mezcla en la mesada enharinada y amasar el pan de molde casero 15 minutos, dale que te dale que te dal, sin parar. Dar cariño, eh. Que la masa no se crea que no la querés. Una vez terminado el amasado la masa de pan lactal estará tierna. Colocar en un bol aceitado, tapar con un repasador y dejar levar hasta que duplique su volumen, suele ser 1 hora.',12,NULL,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL,2),(3,'FORMADO DEL PAN LACTAL: Sacar el bollo de masa del bol, colocar sobre la mesada y aplastar levemente con los dedos o con un palo de amasar. Se “desinflará”. “Enrollar” como se ve en el video hasta que quede una especie de tubo. Menos mal que soy Youtubber porque explicando con palabras me muero de hambre. Bueno, colocar este tubo en un molde para pan o, como hice yo, en una budinera. Vos también lo vas a hacer en una budinera, NADIE tiene molde para pan. Tapar de nuevo con un repasador y dejar levar otra vez hasta que duplique su volumen.',12,NULL,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL,3),(4,'HORNEADO: Una vez que el pan lactal duplicó su volumen, meter en horno precalentado a 200 grados. Cuando lo metés, bajá el horno a 180º. Se hornea unos 35-40 minutos, hasta que esté dorado. Y listo! ya tenés tu pan de molde casero.',12,NULL,'2025-06-23 15:57:24','2025-06-23 15:57:24',NULL,4),(5,'Precalentar el horno a 180 °C y enmantecar un molde de vidrio.',13,NULL,'2025-06-23 16:36:57','2025-06-23 16:36:57',NULL,1),(6,'Pasados 40 – 50 minutos de levado, pasar la masa con cuidado a la mesada, con amor y sin romperla. ',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,1),(7,'Comenzar a aplastarla con la palma de la mano y con mucho cuidado solo para desgasificarla.',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,2),(8,'Cortar en 4 pedazos (para 4 pizzas) y hacer una bolita con cada pedazo de masa, reservar.',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,3),(9,'Estirar cada bollo por separado amasando siempre con la mano. Una vez que esté un poco estirada, colocarla en la pizzera con aceite en la base para que no se pegue. Continuar estirando para darle la forma de la pizzera. Si la masa rebota mucho hay que dejarla descansar por 5 minutos más.',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,4),(10,'Tapar las masas estiradas con un repasador y dejarla reposar 40 minutos más o menos, para lograr un segundo levado.',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,5),(11,'10 o 15 minutos antes de que termine el segundo levado precalentar el horno al máximo.',4,NULL,'2025-06-24 00:12:19','2025-06-24 00:12:19',NULL,6),(12,'Cortar la pechuga en tiritas. Si quisieran podrían utilizar las pechugas enteras, pero tardará más en cocinarse. Al cortarla en cubos o tiras facilitamos su cocción.',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,1),(13,'Salpimentarla y unirla con la crema y la mostaza, mezclando bien hasta integrar totalmente.',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,2),(14,'Poner en microondas por 1 minuto a potencia máxima. Sacar y revolver.',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,3),(15,'Volver al microondas por 2 minutos más. Revolver nuevamente.',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,4),(16,'A partir de aquí se le puede dar un minuto más, eso es a gusto. A mí me gusta así porque sino queda muy seco el pollo. También depende de cada microondas, algunos cocinan más rápido que otros y viceversa, por lo que ustedes deberán estar atentos para lograr la cocción justa (siempre poniendo lapsos cortos de 1 o 2 minutos hasta lograr la cocción).',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,5),(17,'Colocar semillas de mostaza por arriba y cebolla de verdeo picada antes de llevar a la mesa.',5,NULL,'2025-06-24 09:20:34','2025-06-24 09:20:34',NULL,6);
/*!40000 ALTER TABLE `instruccions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lectors`
--

DROP TABLE IF EXISTS `lectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lectors` (
  `esLector` tinyint(1) NOT NULL,
  `usuario_id` int NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  KEY `fk_lector_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_lector_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lectors`
--

LOCK TABLES `lectors` WRITE;
/*!40000 ALTER TABLE `lectors` DISABLE KEYS */;
INSERT INTO `lectors` VALUES (1,1,'2025-05-20 12:17:19','2025-05-20 12:17:19',NULL),(1,3,'2025-05-20 09:25:34','2025-05-20 09:25:34',NULL),(1,16,'2025-05-26 21:43:26','2025-05-26 21:43:26',NULL);
/*!40000 ALTER TABLE `lectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_has_recetas`
--

DROP TABLE IF EXISTS `plan_has_recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plan_has_recetas` (
  `plan_id` int NOT NULL,
  `receta_id` int NOT NULL,
  `tipoComida_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`plan_id`,`receta_id`,`tipoComida_id`),
  KEY `fk_plan_has_receta_receta1_idx` (`receta_id`),
  KEY `fk_plan_has_receta_plan1_idx` (`plan_id`),
  KEY `fk_plan_has_receta_tipoComida1_idx` (`tipoComida_id`),
  CONSTRAINT `fk_plan_has_receta_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  CONSTRAINT `plan_has_recetas_recetas_FK` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`),
  CONSTRAINT `plan_has_recetas_tipocomidas_FK` FOREIGN KEY (`tipoComida_id`) REFERENCES `tipocomidas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_has_recetas`
--

LOCK TABLES `plan_has_recetas` WRITE;
/*!40000 ALTER TABLE `plan_has_recetas` DISABLE KEYS */;
INSERT INTO `plan_has_recetas` VALUES (4,3,1,'2025-06-15 21:36:10','2025-06-15 21:36:10',NULL),(4,4,2,'2025-06-15 21:36:10','2025-06-15 21:36:10',NULL),(4,5,4,'2025-06-15 21:36:10','2025-06-15 21:36:10',NULL),(5,5,4,'2025-06-22 16:36:01','2025-06-22 16:36:01',NULL),(5,6,2,'2025-06-22 16:36:01','2025-06-22 16:36:01',NULL),(5,7,1,'2025-06-22 16:36:01','2025-06-22 16:36:01',NULL),(6,2,4,'2025-06-20 23:39:22','2025-06-20 23:39:22',NULL),(6,4,4,'2025-06-20 23:39:22','2025-06-20 23:39:22',NULL),(6,6,2,'2025-06-20 23:39:22','2025-06-20 23:39:22',NULL),(6,7,3,'2025-06-20 23:39:22','2025-06-20 23:39:22',NULL),(7,5,2,'2025-06-22 16:31:27','2025-06-22 16:31:27',NULL),(7,7,1,'2025-06-22 16:31:27','2025-06-22 16:31:27',NULL),(9,7,1,'2025-06-22 16:51:09','2025-06-22 16:51:09',NULL),(10,1,1,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(10,5,4,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(10,6,2,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(10,7,3,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(10,12,3,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(10,13,1,'2025-06-24 10:04:21','2025-06-24 10:04:21',NULL),(11,7,1,'2025-06-23 20:30:01','2025-06-23 20:30:01',NULL),(11,12,3,'2025-06-23 20:30:01','2025-06-23 20:30:01',NULL),(12,6,2,'2025-06-23 22:24:18','2025-06-23 22:24:18',NULL),(12,13,1,'2025-06-23 22:24:18','2025-06-23 22:24:18',NULL),(13,12,1,'2025-06-23 22:24:44','2025-06-23 22:24:44',NULL);
/*!40000 ALTER TABLE `plan_has_recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `usuario_id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plan_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_plan_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (4,'2025-06-16',7,'2025-06-15 21:36:10','2025-06-15 21:36:10',NULL),(5,'2025-06-27',7,'2025-06-16 00:23:07','2025-06-22 16:36:01',NULL),(6,'2025-06-20',7,'2025-06-20 22:39:19','2025-06-20 22:39:19',NULL),(7,'2025-06-25',7,'2025-06-21 16:13:16','2025-06-22 16:31:27',NULL),(9,'2025-06-22',7,'2025-06-22 16:51:09','2025-06-22 16:51:09',NULL),(10,'2025-06-24',7,'2025-06-23 20:24:53','2025-06-23 20:24:53',NULL),(11,'2025-06-29',7,'2025-06-23 20:30:01','2025-06-23 20:30:01',NULL),(12,'2025-06-24',16,'2025-06-23 22:24:18','2025-06-23 22:24:18',NULL),(13,'2025-06-23',16,'2025-06-23 22:24:44','2025-06-23 22:24:44',NULL);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recetas`
--

DROP TABLE IF EXISTS `recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recetas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `archivo_id` int DEFAULT NULL,
  `tipoReceta_id` int DEFAULT NULL,
  `escritor_usuario_id` int NOT NULL,
  `es_anonimo` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_receta_archivo1_idx` (`archivo_id`),
  KEY `fk_receta_tipoReceta1_idx` (`tipoReceta_id`),
  KEY `fk_receta_escritor1_idx` (`escritor_usuario_id`),
  CONSTRAINT `fk_receta_archivo1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`),
  CONSTRAINT `fk_receta_escritor1` FOREIGN KEY (`escritor_usuario_id`) REFERENCES `escritors` (`usuario_id`),
  CONSTRAINT `recetas_tiporecetas_FK` FOREIGN KEY (`tipoReceta_id`) REFERENCES `tiporecetas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recetas`
--

LOCK TABLES `recetas` WRITE;
/*!40000 ALTER TABLE `recetas` DISABLE KEYS */;
INSERT INTO `recetas` VALUES (1,'Alfajor',NULL,NULL,17,1,'2025-06-20 23:39:22',NULL,NULL),(2,'Tarta',NULL,NULL,17,0,'2025-06-20 23:39:22',NULL,NULL),(3,'Torta matilda',NULL,NULL,2,1,'2025-06-20 23:39:22',NULL,NULL),(4,'Prepizza',NULL,1,7,1,'2025-06-20 23:39:22','2025-06-24 00:12:19',NULL),(5,'Pollo a la crema al microondas',NULL,1,7,0,'2025-06-20 23:39:22','2025-06-24 09:20:47',NULL),(6,'Pastel de papa',NULL,NULL,2,1,'2025-06-20 23:39:22',NULL,NULL),(7,'Medialunas',NULL,NULL,7,1,'2025-06-20 23:39:22',NULL,NULL),(12,'Pan de molde',NULL,1,7,0,'2025-06-23 15:57:24','2025-06-23 22:47:28',NULL),(13,'Bizcochuelo tres leches',NULL,2,7,0,'2025-06-23 16:36:57','2025-06-23 20:52:30',NULL);
/*!40000 ALTER TABLE `recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocomidas`
--

DROP TABLE IF EXISTS `tipocomidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocomidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocomidas`
--

LOCK TABLES `tipocomidas` WRITE;
/*!40000 ALTER TABLE `tipocomidas` DISABLE KEYS */;
INSERT INTO `tipocomidas` VALUES (1,'DESAYUNO','2025-05-31 14:43:32',NULL,NULL),(2,'ALMUERZO','2025-05-31 14:43:32',NULL,NULL),(3,'MERIENDA','2025-05-31 14:43:32',NULL,NULL),(4,'CENA','2025-05-31 14:43:32',NULL,NULL);
/*!40000 ALTER TABLE `tipocomidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiporecetas`
--

DROP TABLE IF EXISTS `tiporecetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiporecetas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiporecetas`
--

LOCK TABLES `tiporecetas` WRITE;
/*!40000 ALTER TABLE `tiporecetas` DISABLE KEYS */;
INSERT INTO `tiporecetas` VALUES (1,'SALADO','2025-06-22 16:51:09','2025-06-23 20:49:56',NULL),(2,'DULCE','2025-06-23 20:43:01','2025-06-23 20:43:01',NULL);
/*!40000 ALTER TABLE `tiporecetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipounidads`
--

DROP TABLE IF EXISTS `tipounidads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipounidads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipounidads`
--

LOCK TABLES `tipounidads` WRITE;
/*!40000 ALTER TABLE `tipounidads` DISABLE KEYS */;
INSERT INTO `tipounidads` VALUES (1,'KILOS','2025-06-20 23:39:22',NULL,NULL),(2,'GRAMOS','2025-06-20 23:39:22',NULL,NULL),(3,'UNIDAD','2025-06-20 23:39:22',NULL,NULL),(5,'LITROS','2025-06-23 19:49:24','2025-06-23 19:49:24',NULL),(6,'MILILITROS (ML)','2025-06-24 00:17:50','2025-06-24 00:17:50',NULL),(7,'CANTIDAD NECESARIA (C/N)','2025-06-24 00:18:04','2025-06-24 00:18:04',NULL);
/*!40000 ALTER TABLE `tipounidads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `remember_token` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Alfonso','correo@correo','Armando','$2y$10$sFbHaCrrH6s.pLOsnQ63G.k/zHcdkrJZhdjO6VxcxrVjIdf5q/2Dm','2025-05-17 23:56:17','2025-05-17 23:56:17',NULL,NULL),(2,'Raul','rPerez@correo.com','Perez','$2y$10$mgmqGZoMwbQkgFMAd.ngZ.9VYXCE4t7jqcloVTjnkyUsFTBB3M5LK','2025-05-20 11:31:30','2025-05-20 11:31:30',NULL,NULL),(3,'Cristian','caupancristian13@yahoo.com.ar','Cañupan','$2y$10$6scJUmlsJBFSs2kmxjcw7OQ/8wfU5wwebgITmoxJ1uGw85KQbHL2a','2025-05-20 09:25:34','2025-05-20 09:25:34',NULL,NULL),(7,'Miriam Gisel','peraltamiriam26@gmail.com','Peralta','$2y$10$QmwCH/BTLhhn8qx80qUucuXNN4EwyENlR8cKulLACavU1WcbZIOBi','2025-06-22 16:53:31','2025-05-26 21:05:58',NULL,NULL),(16,'Ejemplo','lector@correo.com','Lector','$2y$10$MOMgq7VgUsf.GrrSxXvyOOqPs29ejxuNTXeCvhl3i5T9OHlgzuk2e','2025-05-26 21:43:26','2025-05-26 21:43:26',NULL,NULL),(17,'Ejemplo','escritor@correo.com','Escritor','$2y$10$qOWQvv2EXAz9llYvL7g/5OZLiAULBmN4IkzOFdOQmkPV3oF2zar/y','2025-05-26 21:48:20','2025-05-26 21:48:20',NULL,NULL),(18,'Ejemplo','ejemplo@correo.com','Ejemplo','$2y$10$/7a/HFQrjnrYkgdcI2E2Ie052J6gS.X7UhLhbhnF8vx3s1Ia.XWGu','2025-05-27 16:13:15','2025-05-27 16:13:15',NULL,NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-24 10:06:43
