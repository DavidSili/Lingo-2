-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2016 at 05:24 AM
-- Server version: 5.5.42-MariaDB-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lingo2`
--

-- --------------------------------------------------------

--
-- Table structure for table `dek_alb`
--

CREATE TABLE IF NOT EXISTS `dek_alb` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `odgovori` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dek_deu`
--

CREATE TABLE IF NOT EXISTS `dek_deu` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `odgovori` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dek_eng`
--

CREATE TABLE IF NOT EXISTS `dek_eng` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `odgovori` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dek_hun`
--

CREATE TABLE IF NOT EXISTS `dek_hun` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `odgovori` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dek_nzg`
--

CREATE TABLE IF NOT EXISTS `dek_nzg` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `odgovori` varchar(5000) CHARACTER SET utf8 NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `dek_rom`
--

CREATE TABLE IF NOT EXISTS `dek_rom` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `dizajn` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `odgovori` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `grupe`
--

CREATE TABLE IF NOT EXISTS `grupe` (
  `ID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(50) COLLATE utf32_slovenian_ci NOT NULL,
  `recnik` varchar(10) COLLATE utf32_slovenian_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 COLLATE=utf32_slovenian_ci COMMENT='grupe reči' AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `jezici`
--

CREATE TABLE IF NOT EXISTS `jezici` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ime` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `tabela` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `slikaa` varchar(300) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `slikab` varchar(300) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `prideva` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `pridevb` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `genitiva` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `genitivb` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `napredak`
--

CREATE TABLE IF NOT EXISTS `napredak` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `novosti`
--

CREATE TABLE IF NOT EXISTS `novosti` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naslov` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `tekst` text COLLATE utf8_slovenian_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `quote` varchar(3000) DEFAULT NULL,
  `autor` varchar(100) DEFAULT NULL,
  `uneo` varchar(100) NOT NULL,
  `izmenio` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `recnici`
--

CREATE TABLE IF NOT EXISTS `recnici` (
  `ID` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `tabela` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `naziv` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbalb`
--

CREATE TABLE IF NOT EXISTS `rec_srbalb` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8 NOT NULL,
  `coma` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 NOT NULL,
  `synb` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci COMMENT='Srpski - Nemački' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbdeu`
--

CREATE TABLE IF NOT EXISTS `rec_srbdeu` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8 NOT NULL,
  `coma` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 NOT NULL,
  `synb` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci COMMENT='Srpski - Nemački' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbeng`
--

CREATE TABLE IF NOT EXISTS `rec_srbeng` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8 NOT NULL,
  `coma` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `synb` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci COMMENT='Srpski - Nemački' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbhun`
--

CREATE TABLE IF NOT EXISTS `rec_srbhun` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `coma` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `synb` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `grupa` varchar(1000) COLLATE utf8_slovenian_ci DEFAULT NULL COMMENT 'grupe reči',
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci COMMENT='Srpski - Mađarski' AUTO_INCREMENT=1185 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbnzg`
--

CREATE TABLE IF NOT EXISTS `rec_srbnzg` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) NOT NULL,
  `coma` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `synb` varchar(300) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) NOT NULL,
  `izmenio` text,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Srpski - Novozavetni Grčki' AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- Table structure for table `rec_srbrom`
--

CREATE TABLE IF NOT EXISTS `rec_srbrom` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aa` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8 COLLATE utf8_romanian_ci NOT NULL,
  `coma` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `comb` varchar(100) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `syna` varchar(300) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `synb` varchar(300) COLLATE utf8_slovenian_ci NOT NULL,
  `uneo` varchar(100) COLLATE utf8_slovenian_ci NOT NULL,
  `izmenio` text COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci COMMENT='Srpski - Rumunski' AUTO_INCREMENT=335 ;

-- --------------------------------------------------------

--
-- Table structure for table `statistike`
--

CREATE TABLE IF NOT EXISTS `statistike` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(3) unsigned NOT NULL,
  `jezici` int(3) unsigned NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `abu` int(3) unsigned DEFAULT NULL,
  `abt` int(3) unsigned DEFAULT NULL,
  `bau` int(3) unsigned DEFAULT NULL,
  `bat` int(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_dek`
--

CREATE TABLE IF NOT EXISTS `test_dek` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recnik` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `user` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `iddek` int(10) NOT NULL,
  `ukupno` int(10) NOT NULL,
  `procenat` decimal(5,4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_reci`
--

CREATE TABLE IF NOT EXISTS `test_reci` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `recnik` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `smer` varchar(1) COLLATE utf8_slovenian_ci NOT NULL,
  `idreci` int(10) NOT NULL,
  `ukupno` int(10) NOT NULL,
  `procenat` decimal(5,4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=1746 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_reci_m`
--

CREATE TABLE IF NOT EXISTS `test_reci_m` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `recnik` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `smer` varchar(1) COLLATE utf8_slovenian_ci NOT NULL,
  `idreci` int(10) NOT NULL,
  `ukupno` int(10) NOT NULL,
  `procenat` decimal(5,4) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=841 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_rezultati`
--

CREATE TABLE IF NOT EXISTS `test_rezultati` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `recnik` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `smer` varchar(1) COLLATE utf8_slovenian_ci NOT NULL,
  `vrsta` varchar(3) COLLATE utf8_slovenian_ci NOT NULL,
  `ukupno` int(3) unsigned NOT NULL,
  `tacnih` int(3) unsigned NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=652 ;

-- --------------------------------------------------------

--
-- Table structure for table `test_statistike`
--

CREATE TABLE IF NOT EXISTS `test_statistike` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `vrsta` varchar(10) COLLATE utf8_slovenian_ci NOT NULL,
  `recnik` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `smer` varchar(1) COLLATE utf8_slovenian_ci NOT NULL,
  `stat` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `laststat` varchar(5000) COLLATE utf8_slovenian_ci NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_slovenian_ci NOT NULL,
  `salt` varchar(11) COLLATE utf8_slovenian_ci NOT NULL,
  `confcode` varchar(65) COLLATE utf8_slovenian_ci NOT NULL,
  `confcode2` varchar(64) COLLATE utf8_slovenian_ci NOT NULL,
  `forgot` varchar(64) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `level` int(1) DEFAULT '0',
  `settings` varchar(3000) COLLATE utf8_slovenian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_slovenian_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  `country` varchar(30) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=12 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
