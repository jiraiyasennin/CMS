-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cms
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulos`
--
#Script para crear la base de datos y la tabla categorías

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(120) NOT NULL,
  `creador` varchar(120) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (5,'hardware','dostow','2018-06-29 16:08:21','2018-06-29 16:08:21'),(7,'gestion','dostow','2018-06-29 17:14:07','2018-06-29 17:14:07'),(8,'redes','dostow','2018-06-29 17:44:06','2018-06-29 17:44:06'),(9,'seguridad','dostow','2018-06-29 17:47:17','2018-06-29 17:47:17'),(10,'encriptado','dostow','2018-06-29 17:49:07','2018-06-29 17:49:07'),(11,'servidores','dostow','2018-06-29 17:49:59','2018-06-29 17:49:59'),(12,'errores','dostow','2018-06-29 18:02:36','2018-06-29 18:02:36'),(13,'usuarios','dostow','2018-07-13 17:23:28','2018-07-13 17:23:28'),(14,'devops','dostow','2018-08-06 11:12:45','2018-08-06 11:12:45'),(15,'software','dostow','2018-08-08 13:57:54','2018-08-08 13:57:54');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `id` int(40) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(120) NOT NULL,
  `creador` varchar(120) NOT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `contenido` varchar(12000) NOT NULL,
  `categoria` int(40) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulos`
--

LOCK TABLES `articulos` WRITE;
/*!40000 ALTER TABLE `articulos` DISABLE KEYS */;
INSERT INTO `articulos` VALUES (25,'PHP','dostow','The Best Software For PHP Coding.jpg','PHP, acrónimo recursivo en inglés de PHP Hypertext Preprocessor (preprocesador de hipertexto), es un lenguaje de programación de propósito general de código del lado del servidor originalmente diseñado para el desarrollo web de contenido dinámico. Fue uno de los primeros lenguajes de programación del lado del servidor que se podían incorporar directamente en un documento HTML en lugar de llamar a un archivo externo que procese los datos. El código es interpretado por un servidor web con un módulo de procesador de PHP que genera el HTML resultante.\r\n\r\nPHP ha evolucionado por lo que ahora incluye también una interfaz de línea de comandos que puede ser usada en aplicaciones gráficas independientes. Puede ser usado en la mayoría de los servidores web al igual que en muchos sistemas operativos y plataformas sin ningún costo.\r\n\r\nFue creado originalmente por Rasmus Lerdorf en el año 1995. Actualmente el lenguaje sigue siendo desarrollado con nuevas funciones por el grupo PHP.2​ Este lenguaje forma parte del software libre publicado bajo la licencia PHPv3_01, es una licencia Open Source validada por Open Source Initiative. La licencia de PHP es del estilo de licencias BSD, esta licencia no tiene restricciones de copyleft\" asociadas con GPL. ',15,'2018-08-08 14:10:50','2018-08-08 14:10:50'),(26,'Microprocesadores','dostow','AMD_X2_3600.jpg','El microprocesador (o simplemente procesador) es el circuito integrado central más complejo de un sistema informático; a modo de ilustración, se le suele llamar por analogía el «cerebro» de un ordenador.\r\n\r\nEs el encargado de ejecutar los programas, desde el sistema operativo hasta las aplicaciones de usuario; sólo ejecuta instrucciones programadas en lenguaje de bajo nivel, realizando operaciones aritméticas y lógicas simples, tales como sumar, restar, multiplicar, dividir, las lógicas binarias y accesos a memoria.\r\n\r\nPuede contener una o más unidades centrales de procesamiento (CPU) constituidas, esencialmente, por registros, una unidad de control, una unidad aritmético lógica (ALU) y una unidad de cálculo en coma flotante (conocida antiguamente como «coprocesador matemático»).\r\n\r\nEl microprocesador está conectado generalmente mediante un zócalo específico de la placa base de la computadora; normalmente para su correcto y estable funcionamiento, se le incorpora un sistema de refrigeración que consta de un disipador de calor fabricado en algún material de alta conductividad térmica, como cobre o aluminio, y de uno o más ventiladores que eliminan el exceso del calor absorbido por el disipador. Entre el disipador y la cápsula del microprocesador usualmente se coloca pasta térmica para mejorar la conductividad del calor. Existen otros métodos más eficaces, como la refrigeración líquida o el uso de células peltier para refrigeración extrema, aunque estas técnicas se utilizan casi exclusivamente para aplicaciones especiales, tales como en las prácticas de overclocking.\r\n\r\nLa medición del rendimiento de un microprocesador es una tarea compleja, dado que existen diferentes tipos de \"cargas\" que pueden ser procesadas con diferente efectividad por procesadores de la misma gama. Una métrica del rendimiento es la frecuencia de reloj que permite comparar procesadores con núcleos de la misma familia, siendo este un indicador muy limitado dada la gran variedad de diseños con los cuales se comercializan los procesadores de una misma marca y referencia. Un sistema informático de alto rendimiento puede estar equipado con varios microprocesadores trabajando en paralelo, y un microprocesador puede, a su vez, estar constituido por varios núcleos físicos o lógicos. Un núcleo físico se refiere a una porción interna del microprocesador casi-independiente que realiza todas las actividades de una CPU solitaria, un núcleo lógico es la simulación de un núcleo físico a fin de repartir de manera más eficiente el procesamiento. Existe una tendencia de integrar el mayor número de elementos dentro del propio procesador, aumentando así la eficiencia energética y la miniaturización. Entre los elementos integrados están las unidades de punto flotante, controladores de la memoria RAM, controladores de buses y procesadores dedicados de vídeo. ',5,'2018-08-08 14:44:02','2018-08-08 14:44:02'),(27,'Cifrado','dostow','Cifrado.jpeg','En criptografía, el cifrado es un procedimiento que utiliza un algoritmo de cifrado con cierta clave (clave de cifrado) para transformar un mensaje, sin atender a su estructura lingüística o significado, de tal forma que sea incomprensible o, al menos, difícil de comprender a toda persona que no tenga la clave secreta (clave de descifrado) del algoritmo. Las claves de cifrado y de descifrado pueden ser iguales (criptografía simétrica), distintas (criptografía asimétrica) o de ambos tipos (criptografía híbrida).\r\n\r\nEl juego de caracteres (alfabeto) usado en el mensaje sin cifrar puede no ser el mismo que el juego de caracteres que se usa en el mensaje cifrado.\r\n\r\nA veces el texto cifrado se escribe en bloques de igual longitud. A estos bloques se les denomina grupos. Estos grupos proporcionaban una forma de verificación adicional, ya que el texto cifrado obtenido debía tener un número entero de grupos. Si al cifrar el texto plano no se tiene ese número entero de grupos, entonces se suele rellenar al final con ceros o con caracteres sin sentido.\r\n\r\nAunque el cifrado pueda volver secreto el contenido de un documento, es necesario complementarlo con otras técnicas criptográficas para poder comunicarse de manera segura. Puede ser necesario garantizar la integridad la autenticación de las partes, etcétera. ',10,'2018-08-08 16:13:58','2018-08-08 16:13:58');
/*!40000 ALTER TABLE `articulos` ENABLE KEYS */;
UNLOCK TABLES;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-11  9:30:56
