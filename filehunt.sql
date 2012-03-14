-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Vært: localhost
-- Genereringstid: 08. 03 2012 kl. 18:00:46
-- Serverversion: 5.5.16
-- PHP-version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filehunt`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `abuse`
--

CREATE TABLE IF NOT EXISTS `abuse` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `fileID` int(11) NOT NULL,
  `report_by` int(11) NOT NULL,
  `date_reported` bigint(20) NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `fileID` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `date_commented` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `downloaded_by` varchar(11) NOT NULL,
  `fileID` int(11) NOT NULL,
  `downloaded_date` text NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `file` text NOT NULL,
  `mimetype` text NOT NULL,
  `data` longblob NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_date` bigint(20) NOT NULL,
  `size` int(11) NOT NULL,
  `times_downloaded` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `subs`
--

CREATE TABLE IF NOT EXISTS `subs` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber` int(11) NOT NULL,
  `subscribed` int(11) NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `security_code` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `last_sub_check` bigint(20) NOT NULL,
  PRIMARY KEY (`rowID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`rowID`, `username`, `password`, `email`, `security_code`, `admin`, `last_sub_check`) VALUES
(1, 'theadamlt', 'bdef23997404ae3a0a653cf369610e85', 'lilienfeldt.adam@gmail.com', 1543869803, 1, 1343982360),
(2, 'ChristianWismann', 'a407a87802cb98535d3ef3ca8d62c634', 'wismann.christian@gmail.com', 1404729028, 1, 1333473540),
(3, 'sebastianBeen', 'c23aae0f542e158d40a232617598a6f4', 'donau12@gmail.com', 2147483647, 1, 1336025220),
(4, 'steen', '49f4d35ca2e5e3ce0a609bad406f0800', 'steen_lt@hotmail.com', 2147483647, 0, 1333473540),
(10, 'elskeradam', '3baba1e741928d8c074d99d557763e8a', 'elskeradamfuckingmeget@hotmail.com', 1202420723, 0, 1333473540),
(11, 'Engberg', '730266e4fe1c85826181d57ace069838', 'rasmus.engberg@live.dk', 41949040, 0, 1333473540),
(12, 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test.com', 14883492, 0, 1343991540);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
