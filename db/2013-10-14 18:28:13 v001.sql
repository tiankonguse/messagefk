SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

ALTER TABLE `tiankong_mfk`.`problem` DROP COLUMN `reason` , ADD COLUMN `reason` LONGTEXT NULL DEFAULT NULL COMMENT '问题原因'  AFTER `state` , CHANGE COLUMN `twentyFourHour` `twentyFourHour` INT(11) NOT NULL DEFAULT false COMMENT '是否进行过24小时提醒，提醒一次后不再提醒'  ;

ALTER TABLE `tiankong_mfk`.`smg_catch` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;