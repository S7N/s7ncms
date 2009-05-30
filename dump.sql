SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `mydb`.`languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`languages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(6) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `default` BOOLEAN NOT NULL ,
  `sample` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`nations` (
  `id` INT UNSIGNED NOT NULL ,
  `tag` VARCHAR(6) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `timezone` TIMESTAMP NOT NULL ,
  `language_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_nations_languages` (`language_id` ASC) ,
  CONSTRAINT `fk_nations_languages`
    FOREIGN KEY (`language_id` )
    REFERENCES `mydb`.`languages` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NOT NULL ,
  `last_login` DATETIME NOT NULL ,
  `created` DATETIME NOT NULL ,
  `auth_code` VARCHAR(45) NULL ,
  `nation_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_users_nations` (`nation_id` ASC) ,
  CONSTRAINT `fk_users_nations`
    FOREIGN KEY (`nation_id` )
    REFERENCES `mydb`.`nations` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`pages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `author_id` INT UNSIGNED NOT NULL ,
  `access` INT NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_edited` DATETIME NULL ,
  `show_info` BOOLEAN NOT NULL ,
  `type` ENUM('page','redirect','module') NOT NULL ,
  `target` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pages_users` (`author_id` ASC) ,
  CONSTRAINT `fk_pages_users`
    FOREIGN KEY (`author_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`modules`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`modules` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  `class` VARCHAR(45) NOT NULL ,
  `enabled` BOOLEAN NOT NULL ,
  `access` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `access` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`users_roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`users_roles` (
  `user_id` INT UNSIGNED NOT NULL ,
  `role_id` INT UNSIGNED NOT NULL ,
  INDEX `fk_users_roles_users` (`user_id` ASC) ,
  INDEX `fk_users_roles_roles` (`role_id` ASC) ,
  PRIMARY KEY (`user_id`, `role_id`) ,
  CONSTRAINT `fk_users_roles_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_roles_roles`
    FOREIGN KEY (`role_id` )
    REFERENCES `mydb`.`roles` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`menus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`menus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pages_id` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `parent_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_menus_menus` (`parent_id` ASC) ,
  INDEX `fk_menus_pages` (`pages_id` ASC) ,
  CONSTRAINT `fk_menus_menus`
    FOREIGN KEY (`parent_id` )
    REFERENCES `mydb`.`menus` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_menus_pages`
    FOREIGN KEY (`pages_id` )
    REFERENCES `mydb`.`pages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`blocks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`blocks` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `access` INT NOT NULL ,
  `enabled` BOOLEAN NOT NULL ,
  `weight` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`content_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`content_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `page_id` INT UNSIGNED NULL ,
  `block_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_content_join_pages` (`page_id` ASC) ,
  INDEX `fk_content_join_blocks` (`block_id` ASC) ,
  CONSTRAINT `fk_content_join_pages`
    FOREIGN KEY (`page_id` )
    REFERENCES `mydb`.`pages` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_content_join_blocks`
    FOREIGN KEY (`block_id` )
    REFERENCES `mydb`.`blocks` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`revisions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`revisions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT UNSIGNED NOT NULL ,
  `date` DATETIME NOT NULL ,
  `active` BOOLEAN NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_revisions_users` (`user_id` ASC) ,
  CONSTRAINT `fk_revisions_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `mydb`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`content` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `language_id` INT UNSIGNED NOT NULL ,
  `content_type_id` INT UNSIGNED NOT NULL ,
  `revision_id` INT UNSIGNED NOT NULL ,
  `data` TEXT NOT NULL ,
  `active` BOOLEAN NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `sub_title` VARCHAR(255) NULL ,
  `menu_title` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_content_languages` (`language_id` ASC) ,
  INDEX `fk_content_content_type` (`content_type_id` ASC) ,
  INDEX `fk_content_revisions` (`revision_id` ASC) ,
  CONSTRAINT `fk_content_languages`
    FOREIGN KEY (`language_id` )
    REFERENCES `mydb`.`languages` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_content_content_type`
    FOREIGN KEY (`content_type_id` )
    REFERENCES `mydb`.`content_type` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_content_revisions`
    FOREIGN KEY (`revision_id` )
    REFERENCES `mydb`.`revisions` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`configs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`configs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `key` TEXT NOT NULL ,
  `modules_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_config_modules` (`modules_id` ASC) ,
  CONSTRAINT `fk_config_modules`
    FOREIGN KEY (`modules_id` )
    REFERENCES `mydb`.`modules` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`page_blocks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`page_blocks` (
  `page_id` INT UNSIGNED NOT NULL ,
  `block_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`page_id`, `block_id`) ,
  INDEX `fk_page_blocks_pages` (`page_id` ASC) ,
  INDEX `fk_page_blocks_blocks` (`block_id` ASC) ,
  CONSTRAINT `fk_page_blocks_pages`
    FOREIGN KEY (`page_id` )
    REFERENCES `mydb`.`pages` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_page_blocks_blocks`
    FOREIGN KEY (`block_id` )
    REFERENCES `mydb`.`blocks` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`keywords`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`keywords` (
  `id` INT NOT NULL ,
  `content_id` INT UNSIGNED NULL ,
  `value` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_keywords_content` (`content_id` ASC) ,
  CONSTRAINT `fk_keywords_content`
    FOREIGN KEY (`content_id` )
    REFERENCES `mydb`.`content` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`config_languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`config_languages` (
  `language_id` INT UNSIGNED NOT NULL ,
  `config_id` INT UNSIGNED NOT NULL ,
  `value` TEXT NOT NULL ,
  INDEX `fk_config_languages_languages` (`language_id` ASC) ,
  INDEX `fk_config_languages_config` (`config_id` ASC) ,
  PRIMARY KEY (`language_id`, `config_id`) ,
  CONSTRAINT `fk_config_languages_languages`
    FOREIGN KEY (`language_id` )
    REFERENCES `mydb`.`languages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_config_languages_config`
    FOREIGN KEY (`config_id` )
    REFERENCES `mydb`.`configs` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
