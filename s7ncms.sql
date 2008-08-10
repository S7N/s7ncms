CREATE TABLE `blog_posts` (
	`id` bigint(20) unsigned NOT NULL auto_increment,
	`user_id` bigint(20) NOT NULL default '0',
	`date` datetime NOT NULL default '0000-00-00 00:00:00',
	`content` longtext NOT NULL,
	`title` varchar(200) NOT NULL,
	`excerpt` text,
	`status` varchar(20) NOT NULL default 'published',
	`comment_status` varchar(20) NOT NULL default 'open',
	`ping_status` varchar(20) NOT NULL default 'open',
	`password` varchar(20) default '',
	`uri` varchar(200) NOT NULL default '',
	`modified` datetime NOT NULL default '0000-00-00 00:00:00',
	`comment_count` bigint(20) NOT NULL default '0',
	`tags` text,
	PRIMARY KEY  (`id`),
	KEY `uri` (`uri`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `blog_comments` (
	`id` bigint(20) unsigned NOT NULL auto_increment,
	`blog_post_id` int(11) NOT NULL default '0',
	`author` varchar(200) NOT NULL,
	`email` varchar(100) default NULL,
	`url` varchar(200) default NULL,
	`ip` varchar(100) NOT NULL default '0.0.0.0',
	`date` datetime NOT NULL default '0000-00-00 00:00:00',
	`content` text,
	`approved` varchar(20) NOT NULL default '1',
	`agent` varchar(255) default NULL,
	`type` varchar(20) NOT NULL default 'comment',
	`user_id` bigint(20) NOT NULL default '0',
	PRIMARY KEY  (`id`),
	KEY `blog_posts_id` (`blog_post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `config`
-- 

CREATE TABLE `config` (
  `id` int(11) NOT NULL auto_increment,
  `context` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `config`
-- 

INSERT INTO `config` VALUES (1, 's7n', 'default_uri', 'home');
INSERT INTO `config` VALUES (2, 's7n', 'page_views', 'default, extended');
INSERT INTO `config` VALUES (3, 'blog', 'comment_status', 'open');
INSERT INTO `config` VALUES (4, 's7n', 'site_title', 'My Cool Website');
INSERT INTO `config` VALUES (5, 'blog', 'items_per_page', '5');
INSERT INTO `config` VALUES (6, 's7n','default_sidebar_title','About');
INSERT INTO `config` VALUES (7, 's7n','default_sidebar_content','Mit S7Ncms wird die Verwaltung Ihrer Internetpräsenz zum Kinderspiel. Bei S7Ncms handelt es sich um ein speziell für die Anforderungen professioneller Webseiten entwickeltes Content Management System.');


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `menu`
-- 

CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `l` int(11) default NULL,
  `r` int(11) default NULL,
  `title` varchar(200) default NULL,
  `uri` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `menu`
-- 

INSERT INTO `menu` VALUES (1, 1, 12, 'ROOT', NULL);
INSERT INTO `menu` VALUES (2, 2, 3, 'Home', 'home');
INSERT INTO `menu` VALUES (3, 6, 7, 'Products', 'products');
INSERT INTO `menu` VALUES (4, 4, 5, 'Blog', 'blog');
INSERT INTO `menu` VALUES (5, 8, 9, 'About Me', 'about-me');
INSERT INTO `menu` VALUES (6, 10, 11, 'Contact Me', 'contact-me');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `modules`
-- 

CREATE TABLE `modules` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `status` varchar(200) default 'on',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `modules`
-- 

INSERT INTO `modules` VALUES (1, 'blog', 'on');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `pages`
-- 

CREATE TABLE `pages` (
  `id` int(11) NOT NULL auto_increment,
  `keywords` varchar(200) default NULL,
  `user_id` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `title` varchar(200) NOT NULL,
  `excerpt` text,
  `content` longtext NOT NULL,
  `uri` varchar(200) NOT NULL,
  `tags` text,
  `view` varchar(200) default NULL,
  `modified` datetime default NULL,
  `password` varchar(200) default NULL,
  `status` varchar(200) default 'published',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `pages`
-- 

INSERT INTO `pages` VALUES (23, NULL, 1, '2008-04-11 23:13:30', 'Impressum', NULL, '<p><strong>Verantwortlich</strong>: niemand</p>', 'impressum', NULL, 'default', '2008-07-23 14:45:54', NULL, NULL);
INSERT INTO `pages` VALUES (24, NULL, 1, '2008-04-11 23:50:20', 'Home', NULL, '<p>Meine <strong>Heimat</strong>!</p>', 'home', NULL, 'default', '2008-04-12 01:44:08', NULL, NULL);
INSERT INTO `pages` VALUES (27, NULL, 1, '2008-04-12 01:32:07', 'Contact Me', NULL, '<p>Hallo, kontaktier mich bitte mal! :)</p>', 'contact-me', NULL, 'default', '2008-04-12 01:32:07', NULL, NULL);
INSERT INTO `pages` VALUES (30, NULL, 1, '2008-04-12 01:45:07', 'About me', NULL, '<p>Hi, thats me!</p>', 'about-me', NULL, 'default', '2008-04-12 01:45:07', NULL, 'published');
INSERT INTO `pages` VALUES (31, NULL, 1, '2008-04-12 01:45:42', 'Products', NULL, '<p>Prudukt 1</p>\n<p>Produkt 2</p>\n<p>Produkt 3</p>', 'products', NULL, 'default', '2008-04-12 01:45:42', NULL, 'published');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `roles`
-- 

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `roles`
-- 

INSERT INTO `roles` VALUES (1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO `roles` VALUES (2, 'admin', 'Administrative user, has access to everything.');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `roles_users`
-- 

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `users`
-- 

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `email` varchar(200) NOT NULL default '',
  `username` varchar(200) NOT NULL default '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL default '0',
  `homepage` varchar(200) default NULL,
  `first_name` varchar(200) default NULL,
  `last_name` varchar(200) default NULL,
  `registered_on` datetime default NULL,
  `last_login` int(20) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;