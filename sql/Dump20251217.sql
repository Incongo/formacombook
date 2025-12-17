CREATE DATABASE  IF NOT EXISTS `formacombook` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `formacombook`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: formacombook
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `comentarios_id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario_padre_id` int(11) DEFAULT NULL,
  `usuarios_id` int(11) NOT NULL,
  `fotos_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`comentarios_id`),
  KEY `usuarios_id` (`usuarios_id`),
  KEY `fotos_id` (`fotos_id`),
  KEY `fk_comentario_padre` (`comentario_padre_id`),
  CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`),
  CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`fotos_id`) REFERENCES `fotos` (`fotos_id`),
  CONSTRAINT `fk_comentario_padre` FOREIGN KEY (`comentario_padre_id`) REFERENCES `comentarios` (`comentarios_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,NULL,17,105,'me guta','2025-12-16 19:08:07'),(2,NULL,17,99,'me gusta','2025-12-16 19:49:18'),(3,NULL,17,99,'me gusta','2025-12-16 19:51:11'),(4,NULL,17,99,'me gusta','2025-12-16 19:51:15'),(5,NULL,17,99,'me gusta','2025-12-16 19:52:42'),(6,NULL,17,99,'me gusta','2025-12-16 19:53:45'),(7,NULL,16,102,'meeeee','2025-12-16 19:55:41'),(8,NULL,17,101,'dddfd','2025-12-16 19:56:17'),(9,8,16,101,'dsssd','2025-12-16 19:56:41'),(10,8,16,101,'dsssd','2025-12-16 19:58:15');
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fotos`
--

DROP TABLE IF EXISTS `fotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fotos` (
  `fotos_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`fotos_id`),
  KEY `fk_fotos_usuarios_idx` (`usuarios_id`),
  CONSTRAINT `fk_fotos_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fotos`
--

LOCK TABLES `fotos` WRITE;
/*!40000 ALTER TABLE `fotos` DISABLE KEYS */;
INSERT INTO `fotos` VALUES (1,1,'Atardecer en la ciudad','Un cielo anaranjado iluminando los edificios del centro.','/uploads/fotos/foto1.jpg','2024-02-01 18:22:11'),(2,1,'Sombras en la pared','Juego de luces y sombras en una calle estrecha.','/uploads/fotos/foto2.jpg','2024-02-03 11:14:55'),(3,1,'Calle mojada','Reflejos tras una lluvia ligera en el casco urbano.','/uploads/fotos/foto3.jpg','2024-02-05 09:44:21'),(4,2,'Montañas nevadas','Vista panorámica de una cordillera cubierta de nieve.','/uploads/fotos/foto4.jpg','2024-02-02 10:12:33'),(5,2,'Lago cristalino','Agua transparente rodeada de vegetación.','/uploads/fotos/foto5.jpg','2024-02-04 16:55:12'),(6,2,'Sendero natural','Un camino rodeado de árboles y flores silvestres.','/uploads/fotos/foto6.jpg','2024-02-06 13:27:49'),(7,3,'Retrato en estudio','Iluminación suave para resaltar las facciones.','/uploads/fotos/foto7.jpg','2024-02-01 15:10:05'),(8,3,'Mirada profunda','Retrato en blanco y negro con fuerte contraste.','/uploads/fotos/foto8.jpg','2024-02-03 17:44:22'),(9,3,'Sonrisa natural','Captura espontánea durante una sesión.','/uploads/fotos/foto9.jpg','2024-02-07 12:33:18'),(10,4,'Mariposa azul','Primer plano de una mariposa posada en una flor.','/uploads/fotos/foto10.jpg','2024-02-02 09:55:41'),(11,4,'Gotas de rocío','Detalle macro de gotas sobre una hoja.','/uploads/fotos/foto11.jpg','2024-02-04 08:21:12'),(12,4,'Ojo de gato','Primerísimo plano del ojo de un felino.','/uploads/fotos/foto12.jpg','2024-02-06 19:03:27'),(13,5,'Luz dorada','Retrato iluminado por el sol del atardecer.','/uploads/fotos/foto13.jpg','2024-02-01 18:11:09'),(14,5,'Sombras largas','Sombras proyectadas al final del día.','/uploads/fotos/foto14.jpg','2024-02-03 14:22:55'),(15,5,'Reflejo en ventana','Luz natural entrando por una ventana antigua.','/uploads/fotos/foto15.jpg','2024-02-05 10:44:33'),(16,6,'Mercado local','Colores y texturas de un mercado tradicional.','/uploads/fotos/foto16.jpg','2024-02-02 11:33:12'),(17,6,'Templo antiguo','Arquitectura histórica en un viaje reciente.','/uploads/fotos/foto17.jpg','2024-02-04 17:12:44'),(18,6,'Calles de noche','Ambiente nocturno en una ciudad asiática.','/uploads/fotos/foto18.jpg','2024-02-06 21:55:29'),(19,7,'Cielo estrellado','Fotografía nocturna con larga exposición.','/uploads/fotos/foto19.jpg','2024-02-01 23:44:11'),(20,7,'Vía Láctea','Captura de la galaxia en una noche despejada.','/uploads/fotos/foto20.jpg','2024-02-03 01:12:55'),(21,7,'Luna llena','La luna en su punto más brillante.','/uploads/fotos/foto21.jpg','2024-02-05 22:33:18'),(22,8,'Retrato emocional','Expresión intensa capturada en un instante.','/uploads/fotos/foto22.jpg','2024-02-02 13:12:41'),(23,8,'Sonrisa tímida','Retrato natural con luz suave.','/uploads/fotos/foto23.jpg','2024-02-04 15:44:12'),(24,8,'Mirada perdida','Retrato artístico con fondo desenfocado.','/uploads/fotos/foto24.jpg','2024-02-06 17:03:27'),(25,9,'Edificio moderno','Arquitectura contemporánea con líneas limpias.','/uploads/fotos/foto25.jpg','2024-02-01 10:22:11'),(26,9,'Puente iluminado','Fotografía nocturna de un puente urbano.','/uploads/fotos/foto26.jpg','2024-02-03 20:14:55'),(27,9,'Escalera espiral','Diseño arquitectónico desde arriba.','/uploads/fotos/foto27.jpg','2024-02-05 09:44:21'),(28,10,'Minimalismo blanco','Composición limpia con tonos claros.','/uploads/fotos/foto28.jpg','2024-02-02 12:12:33'),(29,10,'Silla solitaria','Objeto aislado en un fondo neutro.','/uploads/fotos/foto29.jpg','2024-02-04 16:55:12'),(30,10,'Líneas paralelas','Juego visual con líneas repetidas.','/uploads/fotos/foto30.jpg','2024-02-06 13:27:49'),(31,11,'Niño jugando','Momento espontáneo en un parque.','/uploads/fotos/foto31.jpg','2024-02-01 15:10:05'),(32,11,'Pareja caminando','Escena natural en una calle concurrida.','/uploads/fotos/foto32.jpg','2024-02-03 17:44:22'),(33,11,'Perro corriendo','Captura dinámica de un perro feliz.','/uploads/fotos/foto33.jpg','2024-02-07 12:33:18'),(34,12,'Concepto azul','Fotografía artística con tonos fríos.','/uploads/fotos/foto34.jpg','2024-02-02 09:55:41'),(35,12,'Mano y luz','Juego conceptual entre luz y sombra.','/uploads/fotos/foto35.jpg','2024-02-04 08:21:12'),(36,12,'Figura abstracta','Composición artística minimalista.','/uploads/fotos/foto36.jpg','2024-02-06 19:03:27'),(37,13,'Costa desde el aire','Vista aérea de una playa.','/uploads/fotos/foto37.jpg','2024-02-01 18:11:09'),(38,13,'Bosque desde arriba','Toma aérea de un bosque frondoso.','/uploads/fotos/foto38.jpg','2024-02-03 14:22:55'),(39,13,'Ciudad a vista de dron','Panorámica urbana desde gran altura.','/uploads/fotos/foto39.jpg','2024-02-05 10:44:33'),(40,14,'Flor rosada','Detalle de una flor en primavera.','/uploads/fotos/foto40.jpg','2024-02-02 11:33:12'),(41,14,'Textura de madera','Primer plano de una superficie desgastada.','/uploads/fotos/foto41.jpg','2024-02-04 17:12:44'),(42,14,'Detalle antiguo','Elemento decorativo de un edificio histórico.','/uploads/fotos/foto42.jpg','2024-02-06 21:55:29'),(43,15,'Partido en acción','Momento clave de un partido de fútbol.','/uploads/fotos/foto43.jpg','2024-02-01 23:44:11'),(44,15,'Salto perfecto','Fotografía congelando un salto deportivo.','/uploads/fotos/foto44.jpg','2024-02-03 01:12:55'),(45,15,'Meta final','Corredor llegando a la meta.','/uploads/fotos/foto45.jpg','2024-02-05 22:33:18'),(46,1,'Callejón antiguo','Una calle estrecha con encanto histórico.','/uploads/fotos/foto46.jpg','2024-02-08 10:12:11'),(47,1,'Reflejos urbanos','Edificios reflejados en un charco tras la lluvia.','/uploads/fotos/foto47.jpg','2024-02-09 12:44:55'),(48,1,'Puerta roja','Una puerta antigua con un color vibrante.','/uploads/fotos/foto48.jpg','2024-02-10 09:21:33'),(49,2,'Cascada tranquila','Agua cayendo suavemente entre rocas.','/uploads/fotos/foto49.jpg','2024-02-08 14:12:33'),(50,2,'Camino nevado','Sendero cubierto de nieve fresca.','/uploads/fotos/foto50.jpg','2024-02-09 16:55:12'),(51,2,'Bosque iluminado','Rayos de sol atravesando los árboles.','/uploads/fotos/foto51.jpg','2024-02-10 13:27:49'),(52,3,'Retrato dramático','Iluminación dura para un efecto intenso.','/uploads/fotos/foto52.jpg','2024-02-08 15:10:05'),(53,3,'Sonrisa sincera','Retrato espontáneo en exteriores.','/uploads/fotos/foto53.jpg','2024-02-09 17:44:22'),(54,3,'Mirada lateral','Retrato artístico con fondo oscuro.','/uploads/fotos/foto54.jpg','2024-02-10 12:33:18'),(55,4,'Abeja en flor','Macro de una abeja recolectando polen.','/uploads/fotos/foto55.jpg','2024-02-08 09:55:41'),(56,4,'Textura vegetal','Detalle de una hoja con nervaduras marcadas.','/uploads/fotos/foto56.jpg','2024-02-09 08:21:12'),(57,4,'Ojo de reptil','Primer plano de un reptil exótico.','/uploads/fotos/foto57.jpg','2024-02-10 19:03:27'),(58,5,'Luz suave','Retrato con iluminación natural difusa.','/uploads/fotos/foto58.jpg','2024-02-08 18:11:09'),(59,5,'Contraluz cálido','Figura humana recortada por el sol.','/uploads/fotos/foto59.jpg','2024-02-09 14:22:55'),(60,5,'Ventana antigua','Luz entrando por una ventana desgastada.','/uploads/fotos/foto60.jpg','2024-02-10 10:44:33'),(61,6,'Mercado nocturno','Luces y colores de un mercado asiático.','/uploads/fotos/foto61.jpg','2024-02-08 11:33:12'),(62,6,'Templo iluminado','Arquitectura antigua bajo luces cálidas.','/uploads/fotos/foto62.jpg','2024-02-09 17:12:44'),(63,6,'Calle estrecha','Ambiente tradicional en un barrio antiguo.','/uploads/fotos/foto63.jpg','2024-02-10 21:55:29'),(64,7,'Cielo profundo','Captura de estrellas con larga exposición.','/uploads/fotos/foto64.jpg','2024-02-08 23:44:11'),(65,7,'Nebulosa','Fotografía astronómica de una nebulosa.','/uploads/fotos/foto65.jpg','2024-02-09 01:12:55'),(66,7,'Luna creciente','La luna en fase creciente con detalle.','/uploads/fotos/foto66.jpg','2024-02-10 22:33:18'),(67,8,'Retrato suave','Luz natural para un retrato delicado.','/uploads/fotos/foto67.jpg','2024-02-08 13:12:41'),(68,8,'Mirada intensa','Retrato con fondo oscuro y luz lateral.','/uploads/fotos/foto68.jpg','2024-02-09 15:44:12'),(69,8,'Expresión pensativa','Retrato emocional en tonos cálidos.','/uploads/fotos/foto69.jpg','2024-02-10 17:03:27'),(70,9,'Rascacielos','Edificio moderno bajo un cielo despejado.','/uploads/fotos/foto70.jpg','2024-02-08 10:22:11'),(71,9,'Puente moderno','Estructura arquitectónica iluminada.','/uploads/fotos/foto71.jpg','2024-02-09 20:14:55'),(72,9,'Escalera geométrica','Diseño arquitectónico minimalista.','/uploads/fotos/foto72.jpg','2024-02-10 09:44:21'),(73,10,'Minimalismo gris','Composición con tonos neutros.','/uploads/fotos/foto73.jpg','2024-02-08 12:12:33'),(74,10,'Objeto aislado','Un objeto solitario en un fondo blanco.','/uploads/fotos/foto74.jpg','2024-02-09 16:55:12'),(75,10,'Líneas cruzadas','Composición geométrica simple.','/uploads/fotos/foto75.jpg','2024-02-10 13:27:49'),(76,11,'Niña jugando','Momento espontáneo en un parque.','/uploads/fotos/foto76.jpg','2024-02-08 15:10:05'),(77,11,'Familia paseando','Escena natural en un día soleado.','/uploads/fotos/foto77.jpg','2024-02-09 17:44:22'),(78,11,'Gato curioso','Gato mirando a la cámara con atención.','/uploads/fotos/foto78.jpg','2024-02-10 12:33:18'),(79,12,'Concepto rojo','Fotografía artística con tonos cálidos.','/uploads/fotos/foto79.jpg','2024-02-08 09:55:41'),(80,12,'Mano y sombra','Juego conceptual entre luz y sombra.','/uploads/fotos/foto80.jpg','2024-02-09 08:21:12'),(81,12,'Figura geométrica','Composición artística abstracta.','/uploads/fotos/foto81.jpg','2024-02-10 19:03:27'),(82,13,'Acantilado aéreo','Vista aérea de un acantilado.','/uploads/fotos/foto82.jpg','2024-02-08 18:11:09'),(83,13,'Río serpenteante','Toma aérea de un río entre montañas.','/uploads/fotos/foto83.jpg','2024-02-09 14:22:55'),(84,13,'Ciudad iluminada','Panorámica nocturna desde un dron.','/uploads/fotos/foto84.jpg','2024-02-10 10:44:33'),(85,14,'Flor amarilla','Detalle de una flor en primavera.','/uploads/fotos/foto85.jpg','2024-02-08 11:33:12'),(86,14,'Textura de piedra','Primer plano de una superficie rocosa.','/uploads/fotos/foto86.jpg','2024-02-09 17:12:44'),(87,14,'Detalle antiguo II','Elemento decorativo de un edificio clásico.','/uploads/fotos/foto87.jpg','2024-02-10 21:55:29'),(88,15,'Gol decisivo','Momento clave de un partido.','/uploads/fotos/foto88.jpg','2024-02-08 23:44:11'),(89,15,'Salto acrobático','Fotografía congelando un salto.','/uploads/fotos/foto89.jpg','2024-02-09 01:12:55'),(90,15,'Celebración final','Corredor celebrando la victoria.','/uploads/fotos/foto90.jpg','2024-02-10 22:33:18'),(91,1,'Café matutino','Taza de café en una mesa de madera.','/uploads/fotos/foto91.jpg','2024-02-11 09:12:11'),(92,2,'Montaña lejana','Pico nevado visto desde un valle.','/uploads/fotos/foto92.jpg','2024-02-11 10:44:55'),(93,3,'Retrato suave II','Retrato con luz natural.','/uploads/fotos/foto93.jpg','2024-02-11 11:21:33'),(94,4,'Insecto verde','Macro de un insecto sobre una hoja.','/uploads/fotos/foto94.jpg','2024-02-11 12:12:33'),(95,5,'Luz cálida II','Retrato con tonos cálidos.','/uploads/fotos/foto95.jpg','2024-02-11 13:55:12'),(96,6,'Mercado colorido','Puesto lleno de frutas exóticas.','/uploads/fotos/foto96.jpg','2024-02-11 14:27:49'),(97,7,'Cielo profundo II','Fotografía astronómica detallada.','/uploads/fotos/foto97.jpg','2024-02-11 15:10:05'),(98,8,'Retrato artístico','Retrato con fondo texturizado.','/uploads/fotos/foto98.jpg','2024-02-11 16:44:22'),(99,9,'Edificio clásico','Arquitectura antigua restaurada.','/uploads/fotos/foto99.jpg','2024-02-11 17:33:18'),(100,10,'Minimalismo negro','Composición en tonos oscuros.','/uploads/fotos/foto100.jpg','2024-02-11 18:03:27'),(101,16,'sdasdasdasda','sdfasdasdasdasdasda','uploads/fotos/foto_16_1765904721.jpg','2025-12-16 18:05:21'),(102,17,'dssdf','sdffgtjh','uploads/fotos/foto_17_1765905239.jpg','2025-12-16 18:13:59'),(104,17,'LALALALA','fotoni','uploads/fotos/foto_17_1765907227.jpg','2025-12-16 18:47:07'),(105,17,'sdfsdqsdasad','sdasdasdasdasda','uploads/fotos/foto_17_1765907564.jpg','2025-12-16 18:52:44');
/*!40000 ALTER TABLE `fotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notificaciones` (
  `notificacion_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('like_foto','like_comentario','comentario','respuesta') NOT NULL,
  `foto_id` int(11) DEFAULT NULL,
  `comentario_id` int(11) DEFAULT NULL,
  `origen_usuario_id` int(11) NOT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`notificacion_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `foto_id` (`foto_id`),
  KEY `comentario_id` (`comentario_id`),
  KEY `origen_usuario_id` (`origen_usuario_id`),
  CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuarios_id`),
  CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`foto_id`) REFERENCES `fotos` (`fotos_id`),
  CONSTRAINT `notificaciones_ibfk_3` FOREIGN KEY (`comentario_id`) REFERENCES `comentarios` (`comentarios_id`),
  CONSTRAINT `notificaciones_ibfk_4` FOREIGN KEY (`origen_usuario_id`) REFERENCES `usuarios` (`usuarios_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (5,9,'comentario',99,6,17,0,'2025-12-16 19:53:45'),(6,17,'like_foto',102,NULL,16,0,'2025-12-16 19:55:35'),(7,17,'comentario',102,7,16,0,'2025-12-16 19:55:41'),(8,16,'like_foto',101,NULL,17,0,'2025-12-16 19:56:12'),(9,16,'comentario',101,8,17,0,'2025-12-16 19:56:17'),(11,17,'respuesta',101,10,16,0,'2025-12-16 19:58:15');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usuarios_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`usuarios_id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Carlos Méndez','carlos.mendez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar1.png','Aficionado a la fotografía urbana y al blanco y negro.','2024-01-05 10:23:11'),(2,'Laura Sánchez','laura.sanchez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar2.png','Me encanta capturar paisajes y momentos naturales.','2024-01-07 14:55:02'),(3,'Javier Torres','javier.torres@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar3.png','Fotógrafo freelance especializado en retratos.','2024-01-10 09:12:44'),(4,'Marina López','marina.lopez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar4.png','Amante de los animales y la fotografía macro.','2024-01-12 18:33:21'),(5,'Diego Fernández','diego.fernandez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar5.png','Buscando siempre la luz perfecta.','2024-01-15 11:47:09'),(6,'Sara Iglesias','sara.iglesias@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar6.png','Fotografía de viajes y culturas del mundo.','2024-01-18 16:22:55'),(7,'Pablo Núñez','pablo.nunez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar7.png','Me apasiona la fotografía nocturna.','2024-01-20 08:41:33'),(8,'Elena Castro','elena.castro@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar8.png','Capturando emociones a través de retratos.','2024-01-22 12:14:18'),(9,'Hugo Romero','hugo.romero@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar9.png','Explorador visual de ciudades y arquitectura.','2024-01-25 19:03:47'),(10,'Natalia Varela','natalia.varela@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar10.png','Apasionada por la fotografía minimalista.','2024-01-28 09:55:12'),(11,'Iván Pérez','ivan.perez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar11.png','Me gusta capturar momentos espontáneos.','2024-02-01 13:22:40'),(12,'Claudia Rey','claudia.rey@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar12.png','Fotografía artística y conceptual.','2024-02-03 17:44:29'),(13,'Andrés Silva','andres.silva@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar13.png','Fan de los drones y las tomas aéreas.','2024-02-05 10:11:56'),(14,'Patricia Gómez','patricia.gomez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar14.png','Me encanta capturar detalles que pasan desapercibidos.','2024-02-07 15:37:22'),(15,'Rubén Álvarez','ruben.alvarez@example.com','$10$w7easRp4xm5tppORwQDPOO93Y0eRwwwSXf4RQGURRPXsOWr09NpH.','formacombook/uploads/avatars/avatar15.png','Aficionado a la fotografía deportiva.','2024-02-10 18:49:05'),(16,'Pablo','patata@gm.com','$2y$10$PhqqSvxcQK0vqwE0hf5XiOi5p/Gw.U2oNwlglEUVAjjxYpGZUY9CS','uploads/avatars/avatar_16_1765904696.jpg','sdrgdgdd','2025-12-16 18:00:35'),(17,'paco','sad@ld.com','$2y$10$T/aXnq09ckr3lkMwySE.8OmM4hu6Gua5E9eraX3ISLk4cktC6F3v6','uploads/avatars/avatar_17_1765905255.jpg','dfgfgfgfgfgfgfgfgsasasa','2025-12-16 18:10:45');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votos`
--

DROP TABLE IF EXISTS `votos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votos` (
  `usuarios_id` int(11) NOT NULL,
  `fotos_id` int(11) NOT NULL,
  `fecha_voto` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`usuarios_id`,`fotos_id`),
  KEY `fk_usuarios_has_fotos_fotos1_idx` (`fotos_id`),
  KEY `fk_usuarios_has_fotos_usuarios1_idx` (`usuarios_id`),
  CONSTRAINT `fk_usuarios_has_fotos_fotos1` FOREIGN KEY (`fotos_id`) REFERENCES `fotos` (`fotos_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_has_fotos_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`usuarios_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votos`
--

LOCK TABLES `votos` WRITE;
/*!40000 ALTER TABLE `votos` DISABLE KEYS */;
INSERT INTO `votos` VALUES (1,4,'2024-02-12 13:12:33'),(1,7,'2024-02-12 16:10:05'),(1,19,'2024-02-13 13:12:55'),(1,24,'2025-12-16 17:56:39'),(1,34,'2024-02-14 12:55:41'),(1,49,'2024-02-15 12:22:11'),(1,64,'2024-02-16 12:33:12'),(1,79,'2024-02-17 12:10:05'),(1,94,'2024-02-18 12:12:41'),(1,99,'2025-12-16 18:00:06'),(2,1,'2024-02-12 10:12:11'),(2,7,'2024-02-12 17:44:22'),(2,22,'2024-02-13 15:12:41'),(2,37,'2024-02-14 15:11:09'),(2,49,'2024-02-15 13:14:55'),(2,67,'2024-02-16 15:44:11'),(2,79,'2024-02-17 13:44:22'),(2,94,'2024-02-18 13:44:12'),(3,1,'2024-02-12 11:44:55'),(3,4,'2024-02-12 14:55:12'),(3,19,'2024-02-13 14:33:18'),(3,34,'2024-02-14 13:21:12'),(3,49,'2024-02-15 14:44:21'),(3,64,'2024-02-16 13:12:44'),(3,82,'2024-02-17 15:55:41'),(3,94,'2024-02-18 14:03:27'),(4,1,'2024-02-12 12:21:33'),(4,7,'2024-02-12 18:33:18'),(4,22,'2024-02-13 16:44:12'),(4,37,'2024-02-14 16:22:55'),(4,52,'2024-02-15 15:12:33'),(4,67,'2024-02-16 16:12:55'),(4,79,'2024-02-17 14:33:18'),(4,97,'2024-02-18 15:22:11'),(5,4,'2024-02-12 15:27:49'),(5,25,'2024-02-13 18:22:11'),(5,34,'2024-02-14 14:03:27'),(5,52,'2024-02-15 16:55:12'),(5,64,'2024-02-16 14:55:29'),(5,82,'2024-02-17 16:21:12'),(5,97,'2024-02-18 16:14:55'),(6,10,'2024-02-12 19:55:41'),(6,22,'2024-02-13 17:03:27'),(6,37,'2024-02-14 17:44:33'),(6,52,'2024-02-15 17:27:49'),(6,67,'2024-02-16 17:33:18'),(6,82,'2024-02-17 17:03:27'),(6,97,'2024-02-18 17:44:21'),(7,10,'2024-02-12 20:21:12'),(7,25,'2024-02-13 19:14:55'),(7,40,'2024-02-14 18:33:12'),(7,55,'2024-02-15 18:10:05'),(7,70,'2024-02-16 18:12:41'),(7,85,'2024-02-17 18:11:09'),(7,100,'2024-02-18 18:12:33'),(8,10,'2024-02-12 21:03:27'),(8,25,'2024-02-13 20:44:21'),(8,40,'2024-02-14 19:12:44'),(8,55,'2024-02-15 19:44:22'),(8,70,'2024-02-16 19:44:12'),(8,85,'2024-02-17 19:22:55'),(8,100,'2024-02-18 19:55:12'),(9,13,'2024-02-12 22:11:09'),(9,28,'2024-02-13 21:12:33'),(9,40,'2024-02-14 20:55:29'),(9,55,'2024-02-15 20:33:18'),(9,70,'2024-02-16 20:03:27'),(9,85,'2024-02-17 20:44:33'),(9,100,'2024-02-18 20:27:49'),(10,13,'2024-02-12 22:55:55'),(10,43,'2024-02-14 21:44:11'),(10,58,'2024-02-15 21:55:41'),(10,73,'2024-02-16 21:22:11'),(10,88,'2024-02-17 21:33:12'),(11,13,'2024-02-12 23:44:33'),(11,28,'2024-02-13 22:55:12'),(11,43,'2024-02-14 22:12:55'),(11,58,'2024-02-15 22:21:12'),(11,73,'2024-02-16 22:14:55'),(11,88,'2024-02-17 22:12:44'),(12,16,'2024-02-13 09:33:12'),(12,28,'2024-02-13 23:27:49'),(12,43,'2024-02-14 23:33:18'),(12,58,'2024-02-15 23:03:27'),(12,73,'2024-02-16 23:44:21'),(12,88,'2024-02-17 23:55:29'),(13,16,'2024-02-13 10:12:44'),(13,31,'2024-02-14 09:10:05'),(13,46,'2024-02-15 09:12:41'),(13,61,'2024-02-16 09:11:09'),(13,76,'2024-02-17 09:12:33'),(13,91,'2024-02-18 09:44:11'),(14,16,'2024-02-13 11:55:29'),(14,31,'2024-02-14 10:44:22'),(14,46,'2024-02-15 10:44:12'),(14,61,'2024-02-16 10:22:55'),(14,76,'2024-02-17 10:55:12'),(14,91,'2024-02-18 10:12:55'),(15,19,'2024-02-13 12:44:11'),(15,31,'2024-02-14 11:33:18'),(15,46,'2024-02-15 11:03:27'),(15,61,'2024-02-16 11:44:33'),(15,76,'2024-02-17 11:27:49'),(15,91,'2024-02-18 11:33:18'),(16,102,'2025-12-16 19:55:35'),(17,101,'2025-12-16 19:56:12');
/*!40000 ALTER TABLE `votos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-17 15:45:26
