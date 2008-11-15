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

INSERT INTO `config` VALUES (2, 's7n', 'page_views', 'default, extended');
INSERT INTO `config` VALUES (3, 'blog', 'comment_status', 'open');
INSERT INTO `config` VALUES (4, 's7n', 'site_title', 'My Website');
INSERT INTO `config` VALUES (5, 'blog', 'items_per_page', '5');
INSERT INTO `config` VALUES (6, 's7n','default_sidebar_title','About');
INSERT INTO `config` VALUES (7, 's7n','default_sidebar_content','Mit S7Ncms wird die Verwaltung Ihrer Internetpräsenz zum Kinderspiel. Bei S7Ncms handelt es sich um ein speziell für die Anforderungen professioneller Webseiten entwickeltes Content Management System.');

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
  `excerpt` text default NULL,
  `content` longtext default NULL,
  `uri` varchar(200) NOT NULL,
  `tags` text default NULL,
  `view` varchar(200) default NULL,
  `modified` datetime default NULL,
  `password` varchar(200) default NULL,
  `status` varchar(200) default 'published',
  `parent_id` int(11) default NULL,
  `level` int(11) NOT NULL,
  `lft` int(11) default NULL,
  `rgt` int(11) default NULL,
  `type` varchar(250) default NULL,
  `target` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- 
-- Daten für Tabelle `pages`
-- 

INSERT INTO `pages` VALUES (1, NULL, 1, '2008-08-08 08:08:08', 'Home', NULL, '<h1>Willkommen!<br /></h1>\n<p>Mit <strong>S7Ncms</strong> wird die Verwaltung Ihrer Internetpräsenz zum Kinderspiel. Bei <strong>S7Ncms</strong> handelt es sich um ein speziell für die Anforderungen professioneller Webseiten                     entwickeltes Content Management System.</p>\n<p><strong>S7Ncms</strong> bietet dem Benutzer eine einfach zu verstehende Verwaltungsplattform, die durch hohe Benutzerfreundlich- und                     Übersichtlichkeit glänzt. Das Ziel von <strong>S7Ncms</strong> ist es jedem Benutzer - auch ohne vorhandene Programmierkenntnisse - den Einstieg in die Erstellung einer eigenen Homepage zu ermöglichen.</p>\n<p>Durch <strong>S7Ncms</strong> wird es Ihnen möglich sein, auf einfachste Art und Weise, von überall auf der Welt,                     Ihre Internetpräsenz zu steuern und zu verwalten. Aktuelle Neuigkeiten auf der Website                     zu veröffentlichen oder die letzten Ereignisse zu verewigen ist jetzt genauso so kinderleicht,                     wie E-Mails schreiben.</p>\n<p>Die Installation des Systems erfolgt in drei Schritten und kann ohne große Vorkenntnisse vorgenommen                     werden.</p>\n<p>Weiterhin ist es möglich, <strong>S7Ncms</strong> modular zu erweitern, um auch fortgeschrittenen Benutzern                     alle benötigten Features zur Verfügung zu stellen.</p>\n<p>Entscheiden Sie sich noch heute für <strong>S7Ncms</strong> und erhalten Sie ein einzigartiges OpenSource-Produkt, welches die Möglichkeiten von PHP 5 und MySQL nutzt und Ihnen damit eine schnelle,                     einfache und zukunftssichere Verwaltung Ihrer Webseite garantiert.</p>', 'home', NULL, 'extended', '2008-08-10 20:16:53', NULL, 'published', 0, 0, 1, 12, NULL);
INSERT INTO `pages` VALUES (2, NULL, 1, '2008-08-08 08:08:08', 'Products', NULL, '<p>Prudukt 1</p>\n<p>Produkt 2</p>\n<p>Produkt 3</p>', 'products', NULL, 'default', '2008-04-12 01:45:42', NULL, 'published', 1, 1, 2, 3, NULL);
INSERT INTO `pages` VALUES (3, NULL, 1, '2008-08-08 08:08:08', 'About me', NULL, '<p>Hi, thats me!</p>', 'about-me', NULL, 'default', '2008-04-12 01:45:07', NULL, 'published', 1, 1, 4, 9, NULL);
INSERT INTO `pages` VALUES (4, NULL, 1, '2008-08-08 08:08:08', 'Contact Me', NULL, '<p>Hallo, kontaktier mich bitte mal! :)</p>', 'contact-me', NULL, 'default', '2008-04-12 01:32:07', NULL, 'published', 3, 2, 5, 6, NULL);
INSERT INTO `pages` VALUES (5, NULL, 1, '2008-08-08 08:08:08', 'Impressum', NULL, '<p><strong>Verantwortlich</strong>: niemand</p>', 'impressum', NULL, 'default', '2008-10-02 21:50:41', NULL, 'published', 3, 2, 7, 8, NULL);
INSERT INTO `pages` VALUES (6, NULL, 1, '2008-08-08 08:08:08', 'Blog', NULL, NULL, 'blog', NULL, 'default', '2008-10-01 17:40:02', NULL, 'published', 1, 1, 10, 11, 'blog');

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