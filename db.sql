/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.27 : Database - mediagallery
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mediagallery` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `mediagallery`;

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `media_GUID` varchar(50) NOT NULL,
  `media_name` varchar(255) NOT NULL,
  `media_name_original` varchar(255) NOT NULL,
  `media_type` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`media_id`),
  UNIQUE KEY `Unique` (`media_GUID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `media` */

insert  into `media`(`media_id`,`media_GUID`,`media_name`,`media_name_original`,`media_type`,`created_date`) values (1,'75591446836748','7591446836747.jpg','beautiful nature','image/jpeg','2015-11-06'),(2,'84941446836752','9341446836751.jpg','beautiful white flower in garden','image/jpeg','2015-11-06'),(3,'85911446837713','5131446837712.jpg','Rangoli','image/jpeg','2015-11-06'),(4,'12941446838550','J1yoQAdHuu0','Marco Caterpillars','YouTube','2015-11-06');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
