-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 31. Mai 2009 um 01:28
-- Server Version: 5.0.41
-- PHP-Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Datenbank: `s7ncms08`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `blocks`
-- 

DROP TABLE IF EXISTS `blocks`;
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `blocks`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `configs`
-- 

DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `key` text NOT NULL,
  `modules_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `configs`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `config_languages`
-- 

DROP TABLE IF EXISTS `config_languages`;
CREATE TABLE IF NOT EXISTS `config_languages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language_id` int(10) unsigned NOT NULL,
  `config_id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `config_languages`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `contents`
-- 

DROP TABLE IF EXISTS `contents`;
CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `content_type_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(45) NOT NULL,
  `sub_title` varchar(255) default NULL,
  `menu_title` varchar(45) default NULL,
  `uri` varchar(45) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Daten für Tabelle `contents`
-- 

INSERT INTO `contents` VALUES (1, 1, 1, 0, 'Hallo, das ist meiner erste Seite.', 1, 'Meine erste Seite', NULL, 'Erste Seite', 'erste-seite');
INSERT INTO `contents` VALUES (2, 2, 2, 0, 'Hello, this is my first page.', 1, 'My first Page', NULL, 'First Page', 'first-page');
INSERT INTO `contents` VALUES (3, 1, 0, 0, 'das ist der inhalt', 0, 'Andere Seite', 'Andere Seite', 'Andere Seite', 'andere-seite');
INSERT INTO `contents` VALUES (4, 2, 0, 0, 'this is the content', 0, '', 'Another Page', 'Another Page', 'another-page');
INSERT INTO `contents` VALUES (5, 1, 0, 0, 'das ist über S7Ncms', 0, 'Über S7Ncms', NULL, 'Über', 'uber');
INSERT INTO `contents` VALUES (6, 2, 0, 0, 'this is about S7Ncms', 0, 'About S7Ncms', NULL, 'About', 'about');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `content_types`
-- 

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(10) unsigned default NULL,
  `block_id` int(10) unsigned default NULL,
  `content_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- 
-- Daten für Tabelle `content_types`
-- 

INSERT INTO `content_types` VALUES (1, 1, NULL, 1);
INSERT INTO `content_types` VALUES (2, 1, NULL, 2);
INSERT INTO `content_types` VALUES (3, 2, NULL, 3);
INSERT INTO `content_types` VALUES (4, 2, NULL, 4);
INSERT INTO `content_types` VALUES (5, 3, NULL, 5);
INSERT INTO `content_types` VALUES (6, 3, NULL, 6);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `keywords`
-- 

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned default NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Daten für Tabelle `keywords`
-- 

INSERT INTO `keywords` VALUES (1, 1, 'keyword1');
INSERT INTO `keywords` VALUES (2, 1, 'keyword2');
INSERT INTO `keywords` VALUES (3, 2, 'keyword3');
INSERT INTO `keywords` VALUES (4, 2, 'keyword4');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `languages`
-- 

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `name` varchar(45) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `sample` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `languages`
-- 

INSERT INTO `languages` VALUES (1, 'de', 'Deutsch (Deutschland)', 1, '');
INSERT INTO `languages` VALUES (2, 'en', 'English (UK)', 0, '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menus`
-- 

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(10) unsigned NOT NULL,
  `lvl` int(10) unsigned default NULL,
  `lft` int(10) unsigned default NULL,
  `rgt` int(10) unsigned default NULL,
  `scope` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `menus`
-- 

INSERT INTO `menus` VALUES (1, 1, 0, 1, 6, 0);
INSERT INTO `menus` VALUES (2, 2, 1, 2, 3, 0);
INSERT INTO `menus` VALUES (3, 3, 1, 4, 5, 0);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `modules`
-- 

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `class` varchar(45) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `modules`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `nations`
-- 

DROP TABLE IF EXISTS `nations`;
CREATE TABLE IF NOT EXISTS `nations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `name` varchar(45) NOT NULL,
  `timezone` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `language_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Daten für Tabelle `nations`
-- 

INSERT INTO `nations` VALUES (1, 'de_DE', 'Germany', '2009-05-31 00:20:16', 1);
INSERT INTO `nations` VALUES (2, 'en_GB', 'Great Britain', '2009-05-31 00:20:16', 2);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `pages`
-- 

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `author_id` int(10) unsigned NOT NULL,
  `access` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_edited` datetime default NULL,
  `show_info` tinyint(1) NOT NULL,
  `type` enum('page','redirect','module') NOT NULL,
  `target` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Daten für Tabelle `pages`
-- 

INSERT INTO `pages` VALUES (1, 1, 0, '2009-05-30 00:00:01', NULL, 0, 'page', '');
INSERT INTO `pages` VALUES (2, 1, 0, '0000-00-00 00:00:00', NULL, 0, 'page', '');
INSERT INTO `pages` VALUES (3, 1, 0, '0000-00-00 00:00:00', NULL, 0, 'page', '');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `page_blocks`
-- 

DROP TABLE IF EXISTS `page_blocks`;
CREATE TABLE IF NOT EXISTS `page_blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(10) unsigned NOT NULL,
  `block_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `page_blocks`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `revisions`
-- 

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE IF NOT EXISTS `revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `comments` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `revisions`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `roles`
-- 

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Daten für Tabelle `roles`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `last_login` datetime NOT NULL,
  `created` datetime NOT NULL,
  `auth_code` varchar(45) default NULL,
  `nation_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Daten für Tabelle `users`
-- 

INSERT INTO `users` VALUES (1, 'Edy', '', 'edy@edy-b.de', 'Eduard', 'B', '0000-00-00 00:00:00', '2009-05-30 23:36:25', NULL, 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `users_roles`
-- 

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `users_roles`
-- 

