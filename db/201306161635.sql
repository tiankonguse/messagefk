-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 16 日 16:35
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

CREATE TABLE IF NOT EXISTS `block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `block`
--

INSERT INTO `block` (`id`, `name`) VALUES
(5, '教育学部'),
(6, '马列学部'),
(7, '化学学院'),
(8, '物理学院'),
(9, '城市与环境科学学院'),
(10, '外国语学院'),
(11, '音乐学院'),
(12, '国际关系学院'),
(13, '体育学院'),
(14, '历史文化学院'),
(15, '文学院'),
(16, '图书馆'),
(17, '田径馆'),
(18, '校医院'),
(19, '幼儿园'),
(20, '一舍A/B'),
(21, '二舍'),
(22, '三舍A/B '),
(23, '四舍'),
(24, '五舍'),
(25, '综合办公楼'),
(26, '逸夫教学楼'),
(27, '逸夫科技馆'),
(28, '综合教学楼'),
(29, '校园公区环境');

-- --------------------------------------------------------

--
-- 表的结构 `depart`
--

CREATE TABLE IF NOT EXISTS `depart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

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
-- 表的结构 `login_log`
--

CREATE TABLE IF NOT EXISTS `login_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_login_log_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `map_block_depart`
--

CREATE TABLE IF NOT EXISTS `map_block_depart` (
  `block_id` int(11) NOT NULL,
  `depart_id` int(11) NOT NULL,
  PRIMARY KEY (`block_id`,`depart_id`),
  KEY `fk_map_block_depart_block1_idx` (`block_id`),
  KEY `fk_map_block_depart_depart1_idx` (`depart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `map_block_depart`
--

INSERT INTO `map_block_depart` (`block_id`, `depart_id`) VALUES
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 4);

-- --------------------------------------------------------

--
-- 表的结构 `map_pro_bill`
--

CREATE TABLE IF NOT EXISTS `map_pro_bill` (
  `pro_id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  PRIMARY KEY (`pro_id`,`bill_id`),
  KEY `fk_map_pro_bill_problem1_idx` (`pro_id`),
  KEY `fk_map_pro_bill_Bill1_idx` (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `message_log`
--

CREATE TABLE IF NOT EXISTS `message_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `conetnt` varchar(45) NOT NULL,
  `time` bigint(20) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message_problem1_idx` (`pro_id`),
  KEY `fk_message_user1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `problem`
--

CREATE TABLE IF NOT EXISTS `problem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `phone` varchar(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `depart_id` int(11) NOT NULL,
  `fb_content` longtext,
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
-- 表的结构 `pro_time`
--

CREATE TABLE IF NOT EXISTS `pro_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `lev` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pro_time_problem1_idx` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `lev` int(11) NOT NULL COMMENT '0 normal\\n1 fixCenter\\n2 roomCenter\\n3 admin\\n',
  `phone` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `lev`, `phone`) VALUES
(2, 'i@tiankonguse.com', 0, NULL);

--
-- 限制导出的表
--

--
-- 限制表 `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `fk_login_log_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_map_pro_bill_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_map_pro_bill_Bill1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `message_log`
--
ALTER TABLE `message_log`
  ADD CONSTRAINT `fk_message_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `problem`
--
ALTER TABLE `problem`
  ADD CONSTRAINT `fk_pro_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problem_depart1` FOREIGN KEY (`depart_id`) REFERENCES `depart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problem_block1` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `pro_time`
--
ALTER TABLE `pro_time`
  ADD CONSTRAINT `fk_pro_time_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
