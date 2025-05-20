-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: syscake
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
  KEY `fk_escritor_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_escritor_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escritors`
--

LOCK TABLES `escritors` WRITE;
/*!40000 ALTER TABLE `escritors` DISABLE KEYS */;
INSERT INTO `escritors` VALUES (1,2,'2025-05-20 12:18:21','2025-05-20 12:18:21',NULL);
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
  PRIMARY KEY (`ingrediente_id`,`receta_id`),
  KEY `fk_ingrediente_has_receta_receta1_idx` (`receta_id`),
  KEY `fk_ingrediente_has_receta_ingrediente1_idx` (`ingrediente_id`),
  CONSTRAINT `fk_ingrediente_has_receta_ingrediente1` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`),
  CONSTRAINT `fk_ingrediente_has_receta_receta1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingrediente_has_recetas`
--

LOCK TABLES `ingrediente_has_recetas` WRITE;
/*!40000 ALTER TABLE `ingrediente_has_recetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingrediente_has_recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes`
--

LOCK TABLES `ingredientes` WRITE;
/*!40000 ALTER TABLE `ingredientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruccions`
--

DROP TABLE IF EXISTS `instruccions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instruccions` (
  `id` int NOT NULL,
  `descripcion` mediumtext NOT NULL,
  `receta_id` int NOT NULL,
  `archivo_id` int NOT NULL,
  PRIMARY KEY (`id`,`receta_id`),
  KEY `fk_instrucciones_receta1_idx` (`receta_id`),
  KEY `fk_instrucciones_archivo1_idx` (`archivo_id`),
  CONSTRAINT `fk_instrucciones_archivo1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`),
  CONSTRAINT `fk_instrucciones_receta1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruccions`
--

LOCK TABLES `instruccions` WRITE;
/*!40000 ALTER TABLE `instruccions` DISABLE KEYS */;
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
INSERT INTO `lectors` VALUES (1,1,'2025-05-20 12:17:19','2025-05-20 12:17:19',NULL),(1,3,'2025-05-20 09:25:34','2025-05-20 09:25:34',NULL);
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
  PRIMARY KEY (`plan_id`,`receta_id`),
  KEY `fk_plan_has_receta_receta1_idx` (`receta_id`),
  KEY `fk_plan_has_receta_plan1_idx` (`plan_id`),
  KEY `fk_plan_has_receta_tipoComida1_idx` (`tipoComida_id`),
  CONSTRAINT `fk_plan_has_receta_plan1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  CONSTRAINT `fk_plan_has_receta_receta1` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`),
  CONSTRAINT `fk_plan_has_receta_tipoComida1` FOREIGN KEY (`tipoComida_id`) REFERENCES `tipocomidas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_has_recetas`
--

LOCK TABLES `plan_has_recetas` WRITE;
/*!40000 ALTER TABLE `plan_has_recetas` DISABLE KEYS */;
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
  `nombre` varchar(45) NOT NULL,
  `usuario_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plan_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_plan_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recetas`
--

DROP TABLE IF EXISTS `recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recetas` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `archivo_id` int NOT NULL,
  `tipoReceta_id` int NOT NULL,
  `escritor_usuario_id` int NOT NULL,
  `es_anonimo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_receta_archivo1_idx` (`archivo_id`),
  KEY `fk_receta_tipoReceta1_idx` (`tipoReceta_id`),
  KEY `fk_receta_escritor1_idx` (`escritor_usuario_id`),
  CONSTRAINT `fk_receta_archivo1` FOREIGN KEY (`archivo_id`) REFERENCES `archivos` (`id`),
  CONSTRAINT `fk_receta_escritor1` FOREIGN KEY (`escritor_usuario_id`) REFERENCES `escritors` (`usuario_id`),
  CONSTRAINT `fk_receta_tipoReceta1` FOREIGN KEY (`tipoReceta_id`) REFERENCES `tiporecetas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recetas`
--

LOCK TABLES `recetas` WRITE;
/*!40000 ALTER TABLE `recetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipocomidas`
--

DROP TABLE IF EXISTS `tipocomidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipocomidas` (
  `id` int NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipocomidas`
--

LOCK TABLES `tipocomidas` WRITE;
/*!40000 ALTER TABLE `tipocomidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipocomidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiporecetas`
--

DROP TABLE IF EXISTS `tiporecetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tiporecetas` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiporecetas`
--

LOCK TABLES `tiporecetas` WRITE;
/*!40000 ALTER TABLE `tiporecetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tiporecetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipounidads`
--

DROP TABLE IF EXISTS `tipounidads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipounidads` (
  `id` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ingrediente_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tipoUnidad_ingrediente1_idx` (`ingrediente_id`),
  CONSTRAINT `fk_tipoUnidad_ingrediente1` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipounidads`
--

LOCK TABLES `tipounidads` WRITE;
/*!40000 ALTER TABLE `tipounidads` DISABLE KEYS */;
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
  `correo` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Alfonso','correo@correo','Armando','$2y$10$sFbHaCrrH6s.pLOsnQ63G.k/zHcdkrJZhdjO6VxcxrVjIdf5q/2Dm','2025-05-17 23:56:17','2025-05-17 23:56:17',NULL),(2,'Raul','rPerez@correo.com','Perez','$2y$10$mgmqGZoMwbQkgFMAd.ngZ.9VYXCE4t7jqcloVTjnkyUsFTBB3M5LK','2025-05-20 11:31:30','2025-05-20 11:31:30',NULL),(3,'Cristian','caupancristian13@yahoo.com.ar','Cañupan','$2y$10$6scJUmlsJBFSs2kmxjcw7OQ/8wfU5wwebgITmoxJ1uGw85KQbHL2a','2025-05-20 09:25:34','2025-05-20 09:25:34',NULL);
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

-- Dump completed on 2025-05-20 12:59:16
