/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.24-MariaDB : Database - proyectosgt
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`proyectosgt` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `proyectosgt`;

/*Table structure for table `actividades` */

DROP TABLE IF EXISTS `actividades`;

CREATE TABLE `actividades` (
  `idactividad` int(10) NOT NULL AUTO_INCREMENT,
  `idproyecto` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `estatus` varchar(20) NOT NULL,
  `archivo` varchar(200) NOT NULL,
  PRIMARY KEY (`idactividad`),
  KEY `idproyecto` (`idproyecto`),
  CONSTRAINT `proyectofk` FOREIGN KEY (`idproyecto`) REFERENCES `proyectos` (`idproyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `actividades` */

/*Table structure for table `alumnos` */

DROP TABLE IF EXISTS `alumnos`;

CREATE TABLE `alumnos` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `apellidos` varchar(25) NOT NULL,
  `edad` int(2) NOT NULL,
  `sexo` char(1) NOT NULL,
  `carrera` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `es_admin` int(1) NOT NULL,
  PRIMARY KEY (`idalumno`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Data for the table `alumnos` */

insert  into `alumnos`(`idalumno`,`nombre`,`apellidos`,`edad`,`sexo`,`carrera`,`email`,`password`,`es_admin`) values (1,'Daniel Alberto','Panti Gonzales',30,'H','Ingenieria en Sistemas Computacionales','daniel.pg@hopelchen.tecnm.mx','0be61ea7ab321ebffc699a3dab493c9c',1),(6,'Julio Eduardo','Pérez Ake ',24,'H','Ingeniería en Sistemas Computacionales','eduarsim07@gmail.com','ecb021046580eb881b207d3d514531c0',0);

/*Table structure for table `proyectos` */

DROP TABLE IF EXISTS `proyectos`;

CREATE TABLE `proyectos` (
  `idproyecto` int(11) NOT NULL AUTO_INCREMENT,
  `idalumno` int(11) NOT NULL,
  `nombre_proyecto` varchar(50) NOT NULL,
  `concepto_negocio` varchar(1000) NOT NULL,
  `metas` varchar(1000) NOT NULL,
  `valores` varchar(1000) NOT NULL,
  `retos` varchar(1000) NOT NULL,
  `dolores` varchar(1000) NOT NULL,
  `comunidad` varchar(500) NOT NULL,
  `colaboradores` varchar(500) NOT NULL,
  PRIMARY KEY (`idproyecto`),
  KEY `idalumno` (`idalumno`),
  CONSTRAINT `alumnosfk` FOREIGN KEY (`idalumno`) REFERENCES `alumnos` (`idalumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `proyectos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
