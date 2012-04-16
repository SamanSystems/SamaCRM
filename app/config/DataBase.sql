-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2012 at 11:42 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hh`
--

-- --------------------------------------------------------

--
-- Table structure for table `apis`
--

CREATE TABLE IF NOT EXISTS `apis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `component_name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `settings` varchar(2000) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bulks`
--

CREATE TABLE IF NOT EXISTS `bulks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mod` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `subject` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `date` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cardcharges`
--

CREATE TABLE IF NOT EXISTS `cardcharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `security_code` varchar(5) COLLATE utf8_persian_ci NOT NULL,
  `start_date` int(11) NOT NULL,
  `credit` int(11) NOT NULL,
  `submit_date` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `admin_check` int(1) NOT NULL COMMENT '0 not checked, 1 verified, 2 faild',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newscategory_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newscategories`
--

CREATE TABLE IF NOT EXISTS `newscategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `newscategories`
--

INSERT INTO `newscategories` (`id`, `name`) VALUES
(1, 'ثبت دامين'),
(2, 'سرورهای لينوکس'),
(3, 'گروه عصرنت');

-- --------------------------------------------------------

--
-- Table structure for table `onlinetrans`
--

CREATE TABLE IF NOT EXISTS `onlinetrans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `au` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `amount` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `top_order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `desc` text COLLATE utf8_persian_ci NOT NULL,
  `date` int(11) NOT NULL,
  `next_pay` int(11) NOT NULL,
  `monthly` tinyint(4) DEFAULT '0',
  `confirmed` tinyint(4) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `privet_note` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `public_note` varchar(250) COLLATE utf8_persian_ci NOT NULL,
  `api_data` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `cat` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `desc` text COLLATE utf8_persian_ci NOT NULL,
  `list` tinyint(4) NOT NULL DEFAULT '0',
  `merchant` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `settings` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `pin` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productproperties`
--

CREATE TABLE IF NOT EXISTS `productproperties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `property_id` int(11) NOT NULL,
  `product_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` tinyint(4) NOT NULL,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `plan_name` varchar(25) COLLATE utf8_persian_ci NOT NULL,
  `cost` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `relative_services` varchar(70) COLLATE utf8_persian_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `desc` text COLLATE utf8_persian_ci NOT NULL,
  `monthly` tinyint(4) NOT NULL,
  `need_domain` tinyint(1) NOT NULL,
  `api_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_persian_ci NOT NULL,
  `address` text COLLATE utf8_persian_ci NOT NULL,
  `phonenum` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `desc` text COLLATE utf8_persian_ci NOT NULL,
  `mail_address` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `mail_title` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `send_email` tinyint(1) NOT NULL,
  `noreply_mail_address` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `billing_mail_address` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `website` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `top_user_percent` int(2) NOT NULL,
  `license_key` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `admin_cellnum` varchar(16) COLLATE utf8_persian_ci NOT NULL,
  `send_sms` tinyint(1) NOT NULL,
  `send_sms_option` tinyint(1) NOT NULL,
  `gateway_number` varchar(16) COLLATE utf8_persian_ci NOT NULL,
  `gateway_pass` varchar(32) COLLATE utf8_persian_ci NOT NULL,
  `security_key` varchar(16) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `address`, `phonenum`, `desc`, `mail_address`, `mail_title`, `send_email`, `noreply_mail_address`, `billing_mail_address`, `website`, `top_user_percent`, `license_key`, `admin_cellnum`, `send_sms`, `send_sms_option`, `gateway_number`, `gateway_pass`, `security_key`) VALUES
(4, 'demo', 'address', '1111111', '', 'no-reply@domain.com', 'demo', 1, 'no-reply@asrenet.com', 'no-reply@asrenet.com', 'http://www.domain.com', 0, '', '09111111111', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `signatures`
--

CREATE TABLE IF NOT EXISTS `signatures` (
  `user_id` int(11) NOT NULL,
  `text` text COLLATE utf8_persian_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE IF NOT EXISTS `slideshows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `pic_address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `link_address` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketdepartments`
--

CREATE TABLE IF NOT EXISTS `ticketdepartments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `department_order` int(11) NOT NULL DEFAULT '0',
  `guest_access` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ticketdepartments`
--

INSERT INTO `ticketdepartments` (`id`, `name`, `department_order`, `guest_access`) VALUES
(1, 'پشتيبانی هاستينگ', 1, 0),
(4, 'پشتيبانی دامين', 2, 0),
(2, 'فروش', 4, 1),
(6, 'مالی', 5, 0),
(5, 'امور نمايندگی', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticketreplies`
--

CREATE TABLE IF NOT EXISTS `ticketreplies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `date` int(11) NOT NULL,
  `attached_file` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `note` tinyint(1) NOT NULL COMMENT '0 publish, 1 note',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '0 system, -1 guest',
  `flag_user_id` int(11) NOT NULL DEFAULT '0' COMMENT 'flag for this user id',
  `ticketdepartment_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `date` int(11) NOT NULL,
  `user_unread` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 read, 1 unread',
  `priority` int(1) NOT NULL COMMENT '0 low, 1 medium, 2 high',
  `status` tinyint(3) NOT NULL COMMENT '0 open, 1 answered, 2 customer reply, 3 on hold, 4 in progress, 5 closed, 6 by system',
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT '0',
  `payment_id` tinyint(4) DEFAULT '0',
  `amount` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `confirmed` tinyint(4) NOT NULL,
  `desc` varchar(255) COLLATE utf8_persian_ci DEFAULT ' ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(35) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `cellnum` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `phonenum` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `pbox` varchar(10) COLLATE utf8_persian_ci NOT NULL,
  `company` varchar(35) COLLATE utf8_persian_ci NOT NULL,
  `address` text COLLATE utf8_persian_ci NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `referrer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `cellnum`, `phonenum`, `pbox`, `company`, `address`, `role`, `referrer_id`) VALUES
(1, 'you@domain.com', 'cd249a8d7a53fe3b6a70ab30936d083f29d60f99', 'modir', '', '0919000000', '', '', '', 4, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
