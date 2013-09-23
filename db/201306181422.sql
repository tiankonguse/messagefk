SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `messagefk`.`user` CHANGE COLUMN `lev` `lev` INT(11) NOT NULL COMMENT '0 normal\\n1 fixCenter\\n2 roomCenter\\n3 admin\\n'  ;

ALTER TABLE `messagefk`.`problem` CHANGE COLUMN `total_time` `total_time` VARCHAR(255) NULL DEFAULT NULL  AFTER `startime` , CHANGE COLUMN `total_bill` `total_bill` VARCHAR(255) NULL DEFAULT NULL  AFTER `total_time` , CHANGE COLUMN `star` `star` INT(11) NULL DEFAULT NULL COMMENT '问题评价等级'  AFTER `result` , CHANGE COLUMN `fb_content` `fb_content` LONGTEXT NULL DEFAULT NULL  AFTER `star` , CHANGE COLUMN `state` `state` INT(11) NOT NULL COMMENT '\\n0 ask\\n1 send\\n2 ac\\n3 finish\\n4  evaluate\\n'  , ADD COLUMN `asktime` BIGINT(20) NOT NULL  AFTER `state` , ADD COLUMN `accepttime` BIGINT(20) NULL DEFAULT NULL  AFTER `asktime` , ADD COLUMN `fixtime` BIGINT(20) NULL DEFAULT NULL  AFTER `accepttime` , ADD COLUMN `finishtime` BIGINT(20) NULL DEFAULT NULL  AFTER `fixtime` , ADD COLUMN `startime` BIGINT(20) NULL DEFAULT NULL  AFTER `finishtime` , DROP FOREIGN KEY `fk_pro_user` , DROP FOREIGN KEY `fk_problem_depart1` ;

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

DROP TABLE IF EXISTS `messagefk`.`pro_time` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
