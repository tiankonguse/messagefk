SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER SCHEMA `tiankong_mfk`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci ;

USE `tiankong_mfk`;

ALTER TABLE `tiankong_mfk`.`bill` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`block` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`depart` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`map_block_depart` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`map_pro_bill` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`problem` COLLATE = utf8_general_ci , DROP COLUMN `reason` , ADD COLUMN `reason` LONGTEXT NULL DEFAULT NULL COMMENT '问题原因'  AFTER `state` , CHANGE COLUMN `twentyFourHour` `twentyFourHour` INT(11) NOT NULL DEFAULT false COMMENT '是否进行过24小时提醒，提醒一次后不再提醒'  ;

ALTER TABLE `tiankong_mfk`.`problem_time` COLLATE = utf8_general_ci ;

ALTER TABLE `tiankong_mfk`.`user` COLLATE = utf8_general_ci ;

CREATE  TABLE IF NOT EXISTS `tiankong_mfk`.`smg_catch` (
  `id` INT(11) NOT NULL ,
  `phone` VARCHAR(11) NOT NULL ,
  `content` VARCHAR(512) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `tiankong_mfk`.`message_log` ;

DROP TABLE IF EXISTS `tiankong_mfk`.`login_log` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
