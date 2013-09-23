SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `messagefk`.`user` CHANGE COLUMN `lev` `lev` INT(11) NOT NULL COMMENT ' 1 user\\n 2 fixCenter\\n 3 admin\\n'  ;

ALTER TABLE `messagefk`.`problem` DROP COLUMN `startime` , DROP COLUMN `finishtime` , DROP COLUMN `fixtime` , DROP COLUMN `accepttime` , DROP COLUMN `asktime` , CHANGE COLUMN `state` `state` INT(11) NOT NULL COMMENT '\\n1 ask -> wait to  pass\\n2 ac  -> wait to fix\\n3 fix  -> fixxing\\n4 finish ->wait to evaluate\\n5  evaluate -> over\\n'  , DROP FOREIGN KEY `fk_pro_user` , DROP FOREIGN KEY `fk_problem_depart1` ;

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

ALTER TABLE `messagefk`.`depart` 
ADD INDEX `fk_depart_user1_idx` (`center` ASC) 
, DROP INDEX `fk_depart_user1_idx` ;

ALTER TABLE `messagefk`.`message_log` CHANGE COLUMN `phone` `phone` VARCHAR(11) NULL DEFAULT NULL COMMENT 'if send to user, get phone from problem.\\nif sent to admin or fixcenter ,get phone from user.'  ;

CREATE  TABLE IF NOT EXISTS `messagefk`.`problem_time` (
  `id` INT(11) NOT NULL ,
  `pro_id` INT(11) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  `time` BIGINT(20) NOT NULL ,
  `state` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_problem_time_problem1_idx` (`pro_id` ASC) ,
  INDEX `fk_problem_time_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_problem_time_problem1`
    FOREIGN KEY (`pro_id` )
    REFERENCES `messagefk`.`problem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_problem_time_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `messagefk`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
