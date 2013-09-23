SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `messagefk`.`user` CHANGE COLUMN `lev` `lev` INT(11) NOT NULL COMMENT ' 1 user\\n 2 fixCenter\\n 3 admin\\n'  , CHANGE COLUMN `phone` `phone` VARCHAR(11) NULL DEFAULT NULL COMMENT 'admin and fixcenter use'  ;

ALTER TABLE `messagefk`.`problem` CHANGE COLUMN `total_time` `total_time` VARCHAR(255) NULL DEFAULT NULL  AFTER `startime` , CHANGE COLUMN `total_bill` `total_bill` VARCHAR(255) NULL DEFAULT NULL  AFTER `total_time` , CHANGE COLUMN `reason` `reason` LONGTEXT NULL DEFAULT NULL COMMENT '问题原因'  AFTER `total_bill` , CHANGE COLUMN `result` `result` LONGTEXT NULL DEFAULT NULL COMMENT '问题解决原因'  AFTER `reason` , CHANGE COLUMN `star` `star` INT(11) NULL DEFAULT NULL COMMENT '问题评价等级'  AFTER `result` , CHANGE COLUMN `fb_content` `fb_content` LONGTEXT NULL DEFAULT NULL  AFTER `star` , CHANGE COLUMN `state` `state` INT(11) NOT NULL COMMENT '\\n1 ask -> wait to  pass\\n2 ac  -> wait to fix\\n3 fix  -> fixxing\\n4 finish ->wait to evaluate\\n5  evaluate -> over\\n'  , ADD COLUMN `test` BIGINT(20) NULL DEFAULT NULL  AFTER `fb_content` , DROP FOREIGN KEY `fk_pro_user` , DROP FOREIGN KEY `fk_problem_depart1` ;

ALTER TABLE `messagefk`.`problem` 
  ADD CONSTRAINT `fk_pro_user`
  FOREIGN KEY (`user_id` )
  REFERENCES `messagefk`.`user` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `fk_problem_depart1`
  FOREIGN KEY (`depart_id` )
  REFERENCES `messagefk`.`depart` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `messagefk`.`depart` ADD COLUMN `sendToCenter` TINYINT(4) NULL DEFAULT 0  AFTER `name` ;

ALTER TABLE `messagefk`.`message_log` CHANGE COLUMN `phone` `phone` VARCHAR(11) NULL DEFAULT NULL COMMENT 'if send to user, get phone from problem.\\nif sent to admin or fixcenter ,get phone from user.'  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
