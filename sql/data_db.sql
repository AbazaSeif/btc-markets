-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 27, 2016 at 03:37 PM
-- Server version: 5.6.30-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

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
-- Table structure for table `marketdata`
--

CREATE TABLE IF NOT EXISTS `marketdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `price_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `best_bid` double DEFAULT NULL,
  `best_ask` double DEFAULT NULL,
  `last_price` double DEFAULT NULL,
  `instrument` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `volume` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `markethistory`
--

CREATE TABLE IF NOT EXISTS `markethistory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crypto_unit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transid` int(11) unsigned DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `price_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1;
