-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 07 月 16 日 12:48
-- 服务器版本: 5.5.31-0ubuntu0.12.04.2
-- PHP 版本: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `tiankong_mfk`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

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
(29, '校园公区环境'),
(30, '六舍'),
(31, '七舍'),
(32, '八舍'),
(33, '九舍'),
(35, 'test');

-- --------------------------------------------------------

--
-- 表的结构 `depart`
--

CREATE TABLE IF NOT EXISTS `depart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sendToCenter` tinyint(4) DEFAULT '0',
  `center` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_depart_user1_idx` (`center`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `depart`
--

INSERT INTO `depart` (`id`, `name`, `sendToCenter`, `center`) VALUES
(1, '学生宿舍', 0, 7),
(2, '学院及直属单位', 0, 7),
(3, '公用楼', 0, 7),
(4, '校园公区环境', 0, NULL);

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
(29, 4),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(35, 1);

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
  `phone` varchar(11) DEFAULT NULL COMMENT 'if send to user, get phone from problem.\\nif sent to admin or fixcenter ,get phone from user.',
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
  `starContent` longtext,
  `star` int(11) DEFAULT NULL COMMENT '问题评价等级',
  `state` int(11) NOT NULL COMMENT '1 ask -> wait to  check\n2 ac  -> wait to accept\n3 fix  -> fixxing\n4 finish ->wait to evaluate\n5  evaluate -> over\n6 not pass the check',
  `chargeContent` longtext COMMENT '问题原因',
  `result` longtext COMMENT '问题解决原因',
  `totalCharge` varchar(255) DEFAULT NULL,
  `total_time` varchar(255) DEFAULT NULL,
  `realName` varchar(45) NOT NULL DEFAULT 'test',
  `fixProple` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pro_user_idx` (`user_id`),
  KEY `fk_problem_depart1_idx` (`depart_id`),
  KEY `fk_problem_block1_idx` (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `problem`
--

INSERT INTO `problem` (`id`, `user_id`, `title`, `content`, `phone`, `block_id`, `depart_id`, `starContent`, `star`, `state`, `chargeContent`, `result`, `totalCharge`, `total_time`, `realName`, `fixProple`) VALUES
(1, 2, 'test01', 'test01', '13944097701', 25, 3, NULL, NULL, 6, NULL, NULL, NULL, NULL, 'test', NULL),
(2, 2, 'test02', 'test02', '13944097701', 26, 3, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'test', NULL),
(3, 2, '第一卷 魔鬼训练营 第二章 失败者的惩罚', '1. 熟悉 ubuntu 系统。\n\n一般用 Ubuntu 的用户是刚从 windows 下过来的，用着可能各种不爽，但是请不要着急，慢慢会感觉爽的。\n\n2. 选择一个好的源，更新系统。\n\n你可能不知到什么是源，不过没关系。\n请更新源。不会的可以 google.\n\n3.视频软件\n	mplayer\n	\n4.音乐播放器\n	audacious\n\n5.BT下载\n	deluge\n	', '13944097701', 21, 1, NULL, NULL, 6, NULL, NULL, NULL, NULL, 'test', NULL),
(4, 6, '管理员也要提问题', '管理员也要提问题', '13944097701', 20, 1, '服务态度很好', 5, 5, '无', '修好', '0', '182558', 'test', '袁小康'),
(5, 7, 'xss&aelig;&sup3;&uml;&aring;', '&lt;script&gt;alert(&quot;hello&quot;);&lt;script&gt;', '13944097701', 25, 3, NULL, NULL, 6, NULL, NULL, NULL, NULL, 'test', NULL),
(6, 7, '111', '&lt;script&gt;alert(&quot;hello&quot;);&lt;script&gt;\n&aelig;', '13944097701', 20, 1, NULL, NULL, 6, NULL, NULL, NULL, NULL, 'test', NULL),
(7, 7, 'htmlentities&aring;', '&lt;script&gt;alert("hello");&lt;script&gt;  htmlentities&aring;', '13944097701', 23, 1, NULL, NULL, 6, NULL, NULL, NULL, NULL, 'test', NULL),
(8, 7, 'htmlspecialchars测试一下', 'htmlspecialchars测试一下 &lt;script&gt;alert(&quot;hello&quot;);&lt;script&gt;', '13944097701', 24, 1, NULL, NULL, 4, '无', '修好', '0', '2733', 'test', 'sa'),
(9, 7, '真实姓名测试', '$name', '13944097701', 20, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, '袁小康', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `problem_time`
--

CREATE TABLE IF NOT EXISTS `problem_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_problem_time_problem1_idx` (`pro_id`),
  KEY `fk_problem_time_user1_idx` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `problem_time`
--

INSERT INTO `problem_time` (`id`, `pro_id`, `user_id`, `time`, `state`) VALUES
(1, 1, 2, 1371563340, 1),
(2, 2, 2, 1371563356, 1),
(3, 3, 2, 1373717191, 1),
(4, 4, 6, 1373766565, 1),
(5, 4, 6, 1373882427, 2),
(6, 2, 6, 1373883119, 2),
(7, 3, 6, 1373884679, 6),
(8, 4, 7, 1373936836, 3),
(10, 6, 7, 1373941296, 1),
(12, 8, 7, 1373941674, 1),
(13, 8, 6, 1373941710, 2),
(14, 6, 6, 1373941721, 6),
(15, 5, 6, 1373941728, 6),
(16, 7, 6, 1373941734, 6),
(17, 1, 6, 1373941743, 6),
(18, 9, 7, 1373942589, 1),
(19, 8, 7, 1373942690, 3),
(20, 8, 7, 1373944407, 4),
(21, 4, 7, 1373949123, 4),
(22, 4, 6, 1373949646, 5);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `lev` int(11) NOT NULL COMMENT ' 1 user\\n 2 fixCenter\\n 3 admin\\n',
  `phone` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `email`, `lev`, `phone`) VALUES
(2, 'i@tiankonguse.com', 1, NULL),
(3, '514357238@qq.com', 1, NULL),
(4, 'gaoj169@nenu.edu.cn', 1, NULL),
(5, '804345178@qq.com', 1, NULL),
(6, 'admin@tiankonguse.com', 3, '13944097701'),
(7, 'fix@tiankonguse.com', 2, '13944097701'),
(9, 'test@tiankonguse.com', 1, NULL),
(10, 'test1@tiankonguse.com', 1, NULL),
(11, 'fixed@tiankonguse.com', 1, '13944097701');

--
-- 限制导出的表
--

--
-- 限制表 `depart`
--
ALTER TABLE `depart`
  ADD CONSTRAINT `fk_depart_user1` FOREIGN KEY (`center`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_map_pro_bill_Bill1` FOREIGN KEY (`bill_id`) REFERENCES `bill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_map_pro_bill_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_problem_block1` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problem_depart1` FOREIGN KEY (`depart_id`) REFERENCES `depart` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pro_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- 限制表 `problem_time`
--
ALTER TABLE `problem_time`
  ADD CONSTRAINT `fk_problem_time_problem1` FOREIGN KEY (`pro_id`) REFERENCES `problem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problem_time_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
