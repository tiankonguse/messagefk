-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 05 月 09 日 22:29
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `messagefk`
--

-- --------------------------------------------------------

--
-- 表的结构 `bill`
--

DROP TABLE IF EXISTS `bill`;
CREATE TABLE IF NOT EXISTS `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `cost` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `block`
--

DROP TABLE IF EXISTS `block`;
CREATE TABLE IF NOT EXISTS `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `depart`
--

DROP TABLE IF EXISTS `depart`;
CREATE TABLE IF NOT EXISTS `depart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `depart`
--

INSERT INTO `depart` (`id`, `name`) VALUES
(1, '学生宿舍'),
(2, '学院及直属单位'),
(3, '公用楼'),
(4, '校园公区环境');

-- --------------------------------------------------------

--
-- 表的结构 `map_block_depart`
--

DROP TABLE IF EXISTS `map_block_depart`;
CREATE TABLE IF NOT EXISTS `map_block_depart` (
  `block_id` int(11) NOT NULL,
  `depart_id` int(11) NOT NULL,
  PRIMARY KEY (`block_id`,`depart_id`),
  KEY `fk_map_block_depart_block1_idx` (`block_id`),
  KEY `fk_map_block_depart_depart1_idx` (`depart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `map_pro_bill`
--

DROP TABLE IF EXISTS `map_pro_bill`;
CREATE TABLE IF NOT EXISTS `map_pro_bill` (
  `pro_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  PRIMARY KEY (`pro_id`,`bill_id`),
  KEY `fk_map_pro_bill_problem1_idx` (`pro_id`),
  KEY `fk_map_pro_bill_Bill1_idx` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `conetnt` varchar(45) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_problem1_idx` (`pro_id`),
  KEY `fk_message_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `no_finish`
--

DROP TABLE IF EXISTS `no_finish`;
CREATE TABLE IF NOT EXISTS `no_finish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) DEFAULT NULL,
  `send_message_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_no_finish_problem1_idx` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

DROP TABLE IF EXISTS `problem`;
CREATE TABLE IF NOT EXISTS `problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `block_id` int(11) NOT NULL,
  `depart_id` int(11) NOT NULL,
  `ask_time` varchar(255) NOT NULL,
  `send_time` varchar(255) DEFAULT NULL,
  `accept_time` varchar(255) DEFAULT NULL,
  `finish_time` varchar(255) DEFAULT NULL,
  `fb_content` longtext,
  `fb_time` varchar(255) DEFAULT NULL,
  `star` int(11) DEFAULT NULL COMMENT '问题评价等级',
  `state` int(11) DEFAULT NULL COMMENT '\\n0 ask\\n1 send\\n2 ac\\n3 finish\\n4  evaluate\\n',
  `reason` longtext COMMENT '问题原因',
  `result` longtext COMMENT '问题解决原因',
  `total_bill` varchar(255) DEFAULT NULL,
  `total_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pro_user_idx` (`user_id`),
  KEY `fk_problem_depart1_idx` (`depart_id`),
  KEY `fk_problem_block1_idx` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `lev` int(11) NOT NULL COMMENT '0 normal\\n1 fixCenter\\n2 roomCenter\\n3 admin\\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `lev`) VALUES
(2, 'i@tiankonguse.com', 'i@tiankonguse.com', NULL, 0);

--
-- 限制导出的表
--

--
-- 限制表 `map_block_depart`
--
ALTER TABLE `map_block_depart`
  ADD CONSTRAINT `fk_map_block_depart_block1` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_map_block_depart_depart1` FOREIGN KEY (`depart_id`) REFERENCES `depart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `map_pro_bill`
--
ALTER TABLE `map_pro_bill`
  ADD CONSTRAINT `fk_map_pro_bill_Bill1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_map_pro_bill_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `no_finish`
--
ALTER TABLE `no_finish`
  ADD CONSTRAINT `fk_no_finish_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `problem`
--
ALTER TABLE `problem`
  ADD CONSTRAINT `fk_problem_block1` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problem_depart1` FOREIGN KEY (`depart_id`) REFERENCES `depart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
