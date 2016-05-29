-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2016 at 03:28 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `btc_markets`
--

-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE IF NOT EXISTS `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `country` varchar(200) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `exchanges`
--

INSERT INTO `exchanges` (`id`, `name`, `country`, `active`) VALUES
(1, 'btcmarkets', 'Australia', 1),
(2, 'bitfinex', 'Hong Kong', 1);

-- --------------------------------------------------------

--
-- Table structure for table `marketdata`
--

CREATE TABLE IF NOT EXISTS `marketdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `exchange` int(11) NOT NULL,
  `price_unit` varchar(10) NOT NULL,
  `best_bid` double DEFAULT NULL,
  `best_ask` double DEFAULT NULL,
  `last_price` double DEFAULT NULL,
  `instrument` varchar(191) DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_marketdata_exchanges_idx` (`exchange`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `markethistory`
--

CREATE TABLE IF NOT EXISTS `markethistory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crypto_unit` varchar(20) NOT NULL,
  `transid` int(11) unsigned DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `price_unit` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marketdata`
--
ALTER TABLE `marketdata`
  ADD CONSTRAINT `fk_marketdata_exchanges` FOREIGN KEY (`exchange`) REFERENCES `exchanges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
