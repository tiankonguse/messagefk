SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `messagefk`.`user` CHANGE COLUMN `lev` `lev` INT(11) NOT NULL COMMENT '0 normal\\n1 fixCenter\\n2 roomCenter\\n3 admin\\n'  ;

CREATE  TABLE IF NOT EXISTS `messagefk`.`problem` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  `content` LONGTEXT NOT NULL ,
  `phone` VARCHAR(11) NOT NULL ,
  `block_id` INT(11) NOT NULL ,
  `depart_id` INT(11) NOT NULL ,
  `fb_content` LONGTEXT NULL DEFAULT NULL ,
  `star` INT(11) NULL DEFAULT NULL COMMENT '问题评价等级' ,
  `state` INT(11) NULL DEFAULT NULL COMMENT '\\n0 ask\\n1 send\\n2 ac\\n3 finish\\n4  evaluate\\n' ,
  `reason` LONGTEXT NULL DEFAULT NULL COMMENT '问题原因' ,
  `result` LONGTEXT NULL DEFAULT NULL COMMENT '问题解决原因' ,
  `total_bill` VARCHAR(255) NULL DEFAULT NULL ,
  `total_time` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pro_user_idx` (`user_id` ASC) ,
  INDEX `fk_problem_depart1_idx` (`depart_id` ASC) ,
  INDEX `fk_problem_block1_idx` (`block_id` ASC) ,
  CONSTRAINT `fk_pro_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `messagefk`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_problem_depart1`
    FOREIGN KEY (`depart_id` )
    REFERENCES `messagefk`.`depart` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_problem_block1`
    FOREIGN KEY (`block_id` )
    REFERENCES `messagefk`.`block` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `messagefk`.`map_block_depart` 
ADD INDEX `fk_map_block_depart_block1_idx` (`block_id` ASC) 
, ADD INDEX `fk_map_block_depart_depart1_idx` (`depart_id` ASC) 
, DROP INDEX `fk_map_block_depart_depart1_idx` 
, DROP INDEX `fk_map_block_depart_block1_idx` ;

ALTER TABLE `messagefk`.`map_pro_bill` 
ADD INDEX `fk_map_pro_bill_problem1_idx` (`pro_id` ASC) 
, ADD INDEX `fk_map_pro_bill_Bill1_idx` (`bill_id` ASC) 
, DROP INDEX `fk_map_pro_bill_Bill1_idx` 
, DROP INDEX `fk_map_pro_bill_problem1_idx` ;

CREATE  TABLE IF NOT EXISTS `messagefk`.`message_log` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pro_id` INT(11) NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  `conetnt` VARCHAR(45) NOT NULL ,
  `time` BIGINT(20) NULL DEFAULT NULL ,
  `phone` VARCHAR(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_message_problem1_idx` (`pro_id` ASC) ,
  INDEX `fk_message_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_message_problem1`
    FOREIGN KEY (`pro_id` )
    REFERENCES `messagefk`.`problem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `messagefk`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `messagefk`.`pro_time` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `pro_id` INT(11) NULL DEFAULT NULL ,
  `time` BIGINT(20) NULL DEFAULT NULL ,
  `lev` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pro_time_problem1_idx` (`pro_id` ASC) ,
  CONSTRAINT `fk_pro_time_problem1`
    FOREIGN KEY (`pro_id` )
    REFERENCES `messagefk`.`problem` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE IF NOT EXISTS `messagefk`.`login_log` (
  `id` INT(11) NOT NULL ,
  `user_id` INT(11) NULL DEFAULT NULL ,
  `time` BIGINT(20) NULL DEFAULT NULL ,
  `ip` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_login_log_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_login_log_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `messagefk`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `messagefk`.`problem` ;

DROP TABLE IF EXISTS `messagefk`.`no_finish` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
