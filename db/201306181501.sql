SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `messagefk`.`user` CHANGE COLUMN `lev` `lev` INT(11) NOT NULL COMMENT ' 1 user\\n 2 fixCenter\\n 3 admin\\n'  ;

ALTER TABLE `messagefk`.`problem` CHANGE COLUMN `state` `state` INT(11) NOT NULL COMMENT '\\n1 ask -> wait to  pass\\n2 ac  -> wait to fix\\n3 fix  -> fixxing\\n4 finish ->wait to evaluate\\n5  evaluate -> over\\n'  ;

ALTER TABLE `messagefk`.`depart` ADD COLUMN `center` INT(11) NULL DEFAULT NULL  AFTER `sendToCenter` , 
  ADD CONSTRAINT `fk_depart_user1`
  FOREIGN KEY (`center` )
  REFERENCES `messagefk`.`user` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_depart_user1_idx` (`center` ASC) ;

ALTER TABLE `messagefk`.`message_log` CHANGE COLUMN `phone` `phone` VARCHAR(11) NULL DEFAULT NULL COMMENT 'if send to user, get phone from problem.\\nif sent to admin or fixcenter ,get phone from user.'  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
