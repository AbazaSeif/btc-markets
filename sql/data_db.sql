SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crypto_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `marketdata`
--

CREATE TABLE IF NOT EXISTS `marketdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `best_bid` decimal(10,2) DEFAULT NULL,
  `best_ask` decimal(10,2) DEFAULT NULL,
  `last_price` decimal(10,2) DEFAULT NULL,
  `instrument` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  `volume` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `markethistory`
--

CREATE TABLE IF NOT EXISTS `markethistory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transid` int(11) unsigned DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `timestamp` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
