-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2012 at 02:16 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cabotcafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `year` int(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `PIN` int(255) NOT NULL,
  `sudo` int(255) NOT NULL COMMENT 'super admin status',
  `salt` varchar(255) NOT NULL,
  `sendto` varchar(255) NOT NULL DEFAULT '0',
  `emergency` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `username`, `password`, `email`, `year`, `tel`, `PIN`, `sudo`, `salt`, `sendto`, `emergency`) VALUES
(1, 'saagar', 'desh', 'saagar', '$2a$10$QMYjjhr7tNqRgJ7rImbJEO5QiCsKmBhUi20Cwcs8kBLoa2MMLN7Zu', 'some@thing.com', 2014, '555-5555', 8464, 1, 'QMYjjhr7tNqRgJ7rImbJER', '1', '1'),
(3, 'test12345', 'test12345', 'test12345', 'test12345', 'test12345', 0, '', 1543, 1, '', '0', '0'),
(5, 'carl', 'carl', 'carljackson', 'blahblah', 'carl', 2006, '', 1234, 0, '', '0', '0'),
(6, 'carl', 'jackson', 'cjackson', 'cjackson', 'cjackson', 2006, '', 6133, 0, '', '0', '0'),
(7, 'testqwer', 'testqwer', 'testqwer', 'testqwer', 'testqwer', 0, '', 1750, 1, '', '0', '0'),
(8, 'adsf1234', 'adsf1234', 'adsf1234', 'adsf1234', 'adsf1234', 0, '', 4312, 0, '', '0', '0'),
(9, 'qwer1234', 'qwer1234', 'qwer1234', 'qwer1234', 'qwer1234', 0, '', 4234, 1, '', '0', '0'),
(10, 'new', 'guy', 'newguy', 'newguy1234', 'new@guy', 2015, '', 5324, 0, '', '0', '0'),
(11, 'cake', 'bake', 'cake', '$2a$10$tM2YImBAbZVLS8QZuFzgoecbf7iHL0vskX/d0BVrK3tIzVRI0mH6u', 'bake@cake.nom', 1992, '123-1234', 2035, 0, 'tM2YImBAbZVLS8QZuFzgoq', '1', '0'),
(12, 'om', 'nom', 'nomnom', '$2a$10$rpFlyBF0M645zsjZQufG7uEsbgIoltwNvhYN7CFrmpAEWrAshmvda', 'some', 234523, '124', 6345, 0, 'rpFlyBF0M645zsjZQufG75', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `nightlyinventory`
--

CREATE TABLE IF NOT EXISTS `nightlyinventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `min_amt` varchar(255) NOT NULL,
  `max_amt` varchar(255) NOT NULL,
  `increment` varchar(255) NOT NULL,
  `measure_type` varchar(255) NOT NULL,
  `warning_limit` int(255) NOT NULL,
  `last_amt` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `nightlyinventory`
--

INSERT INTO `nightlyinventory` (`id`, `location`, `item_name`, `min_amt`, `max_amt`, `increment`, `measure_type`, `warning_limit`, `last_amt`) VALUES
(1, 'Front Fridge', 'Whole Milk', '0', '10', '1', 'cartons', 0, 0),
(2, 'Front Fridge', 'Skim Milk', '0', '10', '1', 'cartons', 0, 0),
(6, 'Back Fridge', 'Whole Milk', '0', '10', '1', 'cartons', 0, 0),
(5, 'Front Fridge', 'Cranberry Cocktail', '0', '10', '1', 'cartons', 0, 0),
(7, 'Back Fridge', 'Skim Milk', '0', '10', '1', 'cartons', 0, 0),
(3, 'Front Fridge', 'Soy Milk', '0', '10', '1', 'cartons', 0, 0),
(4, 'Front Fridge', 'Lemonade', '0', '10', '1', 'cartons', 0, 0),
(8, 'Back Fridge', 'Soy Milk', '0', '10', '1', 'cartons', 0, 0),
(9, 'Back Fridge', 'Lemonade', '0', '10', '1', 'cartons', 0, 0),
(10, 'Counter', 'Regular Beans', '0', '10', '1', 'bags', 0, 0),
(11, 'Counter', 'Decaf Beans', '0', '10', '1', 'bags', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `weeklyinventory`
--

CREATE TABLE IF NOT EXISTS `weeklyinventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `min_amt` varchar(255) NOT NULL,
  `max_amt` varchar(255) NOT NULL,
  `increment` varchar(255) NOT NULL,
  `measure_type` varchar(255) NOT NULL,
  `warning_limit` int(255) NOT NULL,
  `last_amt` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `weeklyinventory`
--

INSERT INTO `weeklyinventory` (`id`, `location`, `item_name`, `min_amt`, `max_amt`, `increment`, `measure_type`, `warning_limit`, `last_amt`) VALUES
(7, 'teas', 'red zen', '0', '10', '1', 'item', 0, 0),
(6, 'teas', 'crimson', '0', '10', '1', 'item', 0, 0),
(2, 'baked goods', 'chocolate chip cookies', '0', '10', '1', 'item', 0, 0),
(3, 'baked goods', 'coffee cake', '0', '10', '1', 'item', 0, 0),
(4, 'teas', 'teas', '0', '10', '1', 'item', 0, 0),
(12, 'syrups', 'caramel', '0', '10', '1', 'item', 0, 0),
(8, 'teas', 'china green', '0', '10', '1', 'item', 0, 0),
(9, 'teas', 'chamomile', '0', '10', '1', 'item', 0, 0),
(10, 'teas', 'english breakfast', '0', '10', '1', 'item', 0, 0),
(11, 'syrups', 'vanilla', '0', '10', '1', 'item', 0, 0),
(1, 'baked goods', 'mnm cookies', '0', '10', '1', 'item', 0, 0),
(13, 'syrups', 'hazelnut', '0', '10', '1', 'item', 0, 0),
(14, 'syrups', 'peppermint', '0', '10', '1', 'item', 0, 0),
(15, 'syrups', 'raspberry', '0', '10', '1', 'item', 0, 0),
(16, 'syrups', 'mango', '0', '10', '1', 'item', 0, 0),
(17, 'syrups', 'torani chocolate', '0', '10', '1', 'item', 0, 0),
(18, 'syrups', 'gingerbread', '0', '10', '1', 'item', 0, 0),
(19, 'syrups', 'pumpkin', '0', '10', '1', 'item', 0, 0),
(20, 'syrups', 'almond', '0', '10', '1', 'item', 0, 0),
(21, 'cleaning supplies', 'ph paper', '0', '10', '1', 'item', 0, 0),
(22, 'cleaning supplies', 'dish washing soap', '0', '10', '1', 'item', 0, 0),
(23, 'cleaning supplies', 'paper towels', '0', '10', '1', 'item', 0, 0),
(24, 'cleaning supplies', 'cleaning spray', '0', '10', '1', 'item', 0, 0),
(25, 'cleaning supplies', 'espresso cleaning powder', '0', '10', '1', 'item', 0, 0),
(26, 'paper', 'napkins', '0', '10', '1', 'item', 0, 0),
(27, 'paper', 'hot cups and lids', '0', '10', '1', 'item', 0, 0),
(28, 'paper', 'cold cups and lids', '0', '10', '1', 'item', 0, 0),
(29, 'paper', 'coffee sleeves', '0', '10', '1', 'item', 0, 0),
(30, 'paper', 'large wax paper', '0', '10', '1', 'item', 0, 0),
(31, 'paper', 'small wax paper', '0', '10', '1', 'item', 0, 0),
(32, 'powders', 'powders', '0', '10', '1', 'item', 0, 0),
(33, 'powders', 'chai', '0', '10', '1', 'item', 0, 0),
(34, 'powders', 'white chocolate mocha', '0', '10', '1', 'item', 0, 0),
(35, 'powders', 'dark chocolate mocha', '0', '10', '1', 'item', 0, 0),
(36, 'powders', 'cider spices', '0', '10', '1', 'item', 0, 0),
(37, 'powders', 'Cranberry Cocktail', '0', '10', '1', 'item', 0, 0),
(38, 'Cafe Items', 'white chocolate mocha', '0', '10', '1', 'item', 0, 0),
(39, 'Cafe Items', 'dark chocolate mocha', '0', '10', '1', 'item', 0, 0),
(40, 'Cafe Items', 'cider spices', '0', '10', '1', 'item', 0, 0),
(41, 'Cafe Items', 'Cranberry Cocktail', '0', '10', '1', 'item', 0, 0),
(5, 'teas', 'earl grey', '0', '10', '1', 'item', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
