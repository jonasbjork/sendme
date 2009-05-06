-- MySQL dump 10.11
--
-- Host: localhost    Database: sendme
-- ------------------------------------------------------
-- Server version	5.0.68

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
-- Table structure for table `kommentar`
--

DROP TABLE IF EXISTS `kommentar`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `kommentar` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uppgift_id` int(10) unsigned NOT NULL default '0',
  `kommentar` text NOT NULL,
  `tid` int(11) NOT NULL default '0',
  `kommentar_av` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=158 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `kurs`
--

DROP TABLE IF EXISTS `kurs`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `kurs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `namn` varchar(255) NOT NULL default '',
  `skapad_av` int(10) unsigned NOT NULL default '0',
  `skapad_datum` int(11) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `kurs_user`
--

DROP TABLE IF EXISTS `kurs_user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `kurs_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `kurs_id` int(10) unsigned NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `logger`
--

DROP TABLE IF EXISTS `logger`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `logger` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `ip_addr` varchar(15) NOT NULL default '',
  `datum` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13696 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_amnesomrade`
--

DROP TABLE IF EXISTS `mittval_amnesomrade`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_amnesomrade` (
  `id` int(11) NOT NULL auto_increment,
  `amne` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_enhet`
--

DROP TABLE IF EXISTS `mittval_enhet`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_enhet` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `enhetnamn` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_indval`
--

DROP TABLE IF EXISTS `mittval_indval`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_indval` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kursnamn` varchar(200) NOT NULL default '',
  `kursbesk` text NOT NULL,
  `kursinfo` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_inriktning`
--

DROP TABLE IF EXISTS `mittval_inriktning`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_inriktning` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `enhet_id` int(10) unsigned NOT NULL default '0',
  `program_id` int(10) unsigned NOT NULL default '0',
  `inriktning` varchar(255) character set utf8 collate utf8_swedish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_inriktning_kurs`
--

DROP TABLE IF EXISTS `mittval_inriktning_kurs`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_inriktning_kurs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `inriktning_id` int(10) unsigned NOT NULL default '0',
  `kurs_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `inriktning_id` (`inriktning_id`),
  KEY `kurs_id` (`kurs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6329 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_klar`
--

DROP TABLE IF EXISTS `mittval_klar`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_klar` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `persnr` varchar(100) collate utf8_swedish_ci NOT NULL default '',
  `klass` varchar(100) collate utf8_swedish_ci NOT NULL default '',
  `fnamn` varchar(200) collate utf8_swedish_ci NOT NULL default '',
  `enamn` varchar(200) collate utf8_swedish_ci NOT NULL default '',
  `modersmal` varchar(200) collate utf8_swedish_ci NOT NULL default '',
  `val10` int(11) NOT NULL default '0',
  `val11` int(11) NOT NULL default '0',
  `val12` int(11) NOT NULL default '0',
  `val13` int(11) NOT NULL default '0',
  `val20` int(11) NOT NULL default '0',
  `val21` int(11) NOT NULL default '0',
  `val22` int(11) NOT NULL default '0',
  `val23` int(11) NOT NULL default '0',
  `val30` int(11) NOT NULL default '0',
  `val31` int(11) NOT NULL default '0',
  `val32` int(11) NOT NULL default '0',
  `val33` int(11) NOT NULL default '0',
  `lagrad` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=735 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_kurser`
--

DROP TABLE IF EXISTS `mittval_kurser`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_kurser` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kursnamn` varchar(255) NOT NULL default '',
  `kurskod` varchar(100) NOT NULL default '',
  `poang` int(11) NOT NULL default '0',
  `kursinfo_url` varchar(255) NOT NULL default '',
  `omrade_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_kurser_note`
--

DROP TABLE IF EXISTS `mittval_kurser_note`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_kurser_note` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kurs_id` int(10) unsigned NOT NULL default '0',
  `besk` text NOT NULL,
  `forkunskap` text NOT NULL,
  `noteringar` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `kurs_id` (`kurs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_kurser_tid`
--

DROP TABLE IF EXISTS `mittval_kurser_tid`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_kurser_tid` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kurs_id` int(10) unsigned NOT NULL default '0',
  `tid` enum('höst','vår','helår') NOT NULL default 'höst',
  `ak` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `kurs_id` (`kurs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_profile`
--

DROP TABLE IF EXISTS `mittval_profile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_profile` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `enhet_id` int(10) unsigned NOT NULL default '0',
  `program_id` int(10) unsigned NOT NULL default '0',
  `inriktning_id` int(11) NOT NULL default '0',
  `klass` varchar(200) collate utf8_swedish_ci NOT NULL default '',
  `arskurs` int(10) unsigned NOT NULL default '0',
  `logged_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1064 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mittval_program`
--

DROP TABLE IF EXISTS `mittval_program`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `mittval_program` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `programnamn` varchar(255) character set utf8 collate utf8_swedish_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `single_pass`
--

DROP TABLE IF EXISTS `single_pass`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `single_pass` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `pass` varchar(40) NOT NULL default '',
  `pass_type` varchar(40) NOT NULL default '',
  `pass_created` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `uppgifter`
--

DROP TABLE IF EXISTS `uppgifter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `uppgifter` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `name_orig` varchar(255) NOT NULL default '',
  `name_store` varchar(255) NOT NULL default '',
  `file_type` varchar(200) NOT NULL default '',
  `file_size` int(11) NOT NULL default '0',
  `inlamnad` int(11) NOT NULL default '0',
  `rattad` tinyint(4) NOT NULL default '0',
  `rattad_av` int(11) NOT NULL default '0',
  `kurs_id` int(11) NOT NULL default '0',
  `ip_addr` varchar(15) NOT NULL default '',
  `betyg` int(11) NOT NULL default '0',
  `checksum` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fNamn` varchar(100) NOT NULL default '',
  `eNamn` varchar(100) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `epost` varchar(100) NOT NULL default '',
  `skapad` int(11) NOT NULL default '0',
  `larare` tinyint(4) NOT NULL default '0',
  `ip_addr` varchar(15) NOT NULL default '',
  `active` tinyint(4) NOT NULL default '0',
  `one_time_pass` varchar(40) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1727 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users_profile`
--

DROP TABLE IF EXISTS `users_profile`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `users_profile` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL default '0',
  `fnamn` varchar(255) collate utf8_swedish_ci NOT NULL default '',
  `enamn` varchar(255) collate utf8_swedish_ci NOT NULL default '',
  `adress` varchar(255) collate utf8_swedish_ci NOT NULL default '',
  `pnr` int(11) NOT NULL default '0',
  `ort` varchar(255) collate utf8_swedish_ci NOT NULL default '',
  `persnr` varchar(12) collate utf8_swedish_ci NOT NULL default '',
  `telenr` varchar(20) collate utf8_swedish_ci NOT NULL default '',
  `mobilnr` varchar(20) collate utf8_swedish_ci NOT NULL default '',
  `logged_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1094 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;
SET character_set_client = @saved_cs_client;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-05-06  9:04:05
