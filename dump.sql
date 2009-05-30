SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

-- -----------------------------------------------------
-- Table `languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `languages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(6) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `default` BOOLEAN NOT NULL ,
  `sample` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `nations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `nations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(6) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `timezone` TIMESTAMP NOT NULL ,
  `language_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_nations_languages` (`language_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NOT NULL ,
  `last_login` DATETIME NOT NULL ,
  `created` DATETIME NOT NULL ,
  `auth_code` VARCHAR(45) NULL ,
  `nation_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_users_nations` (`nation_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `pages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `pages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `author_id` INT UNSIGNED NOT NULL ,
  `access` INT NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_edited` DATETIME NULL ,
  `show_info` BOOLEAN NOT NULL ,
  `type` ENUM('page','redirect','module') NOT NULL ,
  `target` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pages_users` (`author_id` ASC))
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `modules`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `modules` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  `class` VARCHAR(45) NOT NULL ,
  `enabled` BOOLEAN NOT NULL ,
  `access` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roles` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `access` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `users_roles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users_roles` (
  `user_id` INT UNSIGNED NOT NULL ,
  `role_id` INT UNSIGNED NOT NULL ,
  INDEX `fk_users_roles_users` (`user_id` ASC) ,
  INDEX `fk_users_roles_roles` (`role_id` ASC) ,
  PRIMARY KEY (`user_id`, `role_id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `menus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `menus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `pages_id` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `parent_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_menus_menus` (`parent_id` ASC) ,
  INDEX `fk_menus_pages` (`pages_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `blocks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blocks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `access` INT NOT NULL ,
  `enabled` BOOLEAN NOT NULL ,
  `weight` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `content_type`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `content_types` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `page_id` INT UNSIGNED NULL ,
  `block_id` INT UNSIGNED NULL ,
  `content_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_content_join_pages` (`page_id` ASC) ,
  INDEX `fk_content_join_blocks` (`block_id` ASC) ,
  INDEX `fk_content_join_contentts` (`block_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `revisions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `revisions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` INT UNSIGNED NOT NULL ,
  `date` DATETIME NOT NULL ,
  `active` BOOLEAN NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_revisions_users` (`user_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `contents` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `language_id` INT UNSIGNED NOT NULL ,
  `revision_id` INT UNSIGNED NOT NULL ,
  `data` TEXT NOT NULL ,
  `active` BOOLEAN NOT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `sub_title` VARCHAR(255) NULL ,
  `menu_title` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_content_languages` (`language_id` ASC) ,
  INDEX `fk_content_revisions` (`revision_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `configs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `configs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `key` TEXT NOT NULL ,
  `modules_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_config_modules` (`modules_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `page_blocks`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `page_blocks` (
  `page_id` INT UNSIGNED NOT NULL ,
  `block_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`page_id`, `block_id`) ,
  INDEX `fk_page_blocks_pages` (`page_id` ASC) ,
  INDEX `fk_page_blocks_blocks` (`block_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `keywords`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `keywords` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content_id` INT UNSIGNED NULL ,
  `value` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_keywords_content` (`content_id` ASC) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


-- -----------------------------------------------------
-- Table `config_languages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `config_languages` (
  `language_id` INT UNSIGNED NOT NULL ,
  `config_id` INT UNSIGNED NOT NULL ,
  `value` TEXT NOT NULL ,
  INDEX `fk_config_languages_languages` (`language_id` ASC) ,
  INDEX `fk_config_languages_config` (`config_id` ASC) ,
  PRIMARY KEY (`language_id`, `config_id`) )
ENGINE = MyISAM DEFAULT CHARACTER SET utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;