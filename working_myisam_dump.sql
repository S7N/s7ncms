DROP TABLE IF EXISTS `blocks`;
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `key` text NOT NULL,
  `modules_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_config_modules` (`modules_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `config_languages`;
CREATE TABLE IF NOT EXISTS `config_languages` (
  `language_id` int(10) unsigned NOT NULL,
  `config_id` int(10) unsigned NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`language_id`,`config_id`),
  KEY `fk_config_languages_languages` (`language_id`),
  KEY `fk_config_languages_config` (`config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `contents`;
CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(45) NOT NULL,
  `sub_title` varchar(255) default NULL,
  `menu_title` varchar(45) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_content_languages` (`language_id`),
  KEY `fk_content_revisions` (`revision_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `contents` VALUES (1, 1, 1, 'Hallo, das ist meiner erste Seite.', 1, 'Meine erste Seite', NULL, 'Erste Seite');
INSERT INTO `contents` VALUES (2, 2, 2, 'Hello, this is my first page.', 1, 'My first Page', NULL, 'First Page');

DROP TABLE IF EXISTS `content_types`;
CREATE TABLE IF NOT EXISTS `content_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `page_id` int(10) unsigned default NULL,
  `block_id` int(10) unsigned default NULL,
  `content_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_content_join_pages` (`page_id`),
  KEY `fk_content_join_blocks` (`block_id`),
  KEY `fk_content_join_contentts` (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `content_types` VALUES (1, 1, NULL, 1);
INSERT INTO `content_types` VALUES (2, 1, NULL, 2);

DROP TABLE IF EXISTS `keywords`;
CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_id` int(10) unsigned default NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_keywords_content` (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

INSERT INTO `keywords` VALUES (1, 1, 'keyword1');
INSERT INTO `keywords` VALUES (2, 1, 'keyword2');
INSERT INTO `keywords` VALUES (3, 2, 'keyword3');
INSERT INTO `keywords` VALUES (4, 2, 'keyword4');

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `name` varchar(45) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `sample` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `languages` VALUES (1, 'de', 'Deutsch', 1, '');
INSERT INTO `languages` VALUES (2, 'en', 'English', 0, '');

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pages_id` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `parent_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_menus_menus` (`parent_id`),
  KEY `fk_menus_pages` (`pages_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `class` varchar(45) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `access` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `nations`;
CREATE TABLE IF NOT EXISTS `nations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(6) NOT NULL,
  `name` varchar(45) NOT NULL,
  `timezone` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `language_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_nations_languages` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY  (`id`),
  KEY `fk_pages_users` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `pages` VALUES (1, 1, 0, '2009-05-30 00:00:01', NULL, 0, 'page', '');

DROP TABLE IF EXISTS `page_blocks`;
CREATE TABLE IF NOT EXISTS `page_blocks` (
  `page_id` int(10) unsigned NOT NULL,
  `block_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`page_id`,`block_id`),
  KEY `fk_page_blocks_pages` (`page_id`),
  KEY `fk_page_blocks_blocks` (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE IF NOT EXISTS `revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `comments` text,
  PRIMARY KEY  (`id`),
  KEY `fk_revisions_users` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY  (`id`),
  KEY `fk_users_nations` (`nation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `users` VALUES (1, 'Edy', '', 'edy@edy-b.de', 'Eduard', 'B', '0000-00-00 00:00:00', '2009-05-30 23:36:25', NULL, 1);

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`),
  KEY `fk_users_roles_users` (`user_id`),
  KEY `fk_users_roles_roles` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
