CREATE TABLE `config` (
  `id` int(11) NOT NULL auto_increment,
  `context` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `config` VALUES (1, 's7n', 'page_views', 'default, extended');
INSERT INTO `config` VALUES (2, 's7n', 'site_title', 'My Website');
INSERT INTO `config` VALUES (3, 's7n','default_sidebar_title','About');
INSERT INTO `config` VALUES (4, 's7n','default_sidebar_content','Mit S7Ncms wird die Verwaltung Ihrer Internetpräsenz zum Kinderspiel. Bei S7Ncms handelt es sich um ein speziell für die Anforderungen professioneller Webseiten entwickeltes Content Management System.');
INSERT INTO `config` VALUES (5, 's7n','theme','default');
INSERT INTO `config` VALUES (6, 'blog', 'comment_status', 'open');
INSERT INTO `config` VALUES (7, 'blog', 'items_per_page', '5');

CREATE TABLE `modules` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `version` int(10) default 0,
  `status` varchar(200) default 'off',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `modules` VALUES (1, 'blog', 1, 'on');

CREATE TABLE `pages` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `level` int(11) NOT NULL,
  `lft` int(11) default NULL,
  `rgt` int(11) default NULL,
  `title` varchar(200) default NULL,
  `type` varchar(200) default NULL,
  `target` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pages` (`id`,`parent_id`,`level`,`lft`,`rgt`,`title`,`type`,`target`)
VALUES
	(1,0,0,1,8,'Startseite / Home',NULL,NULL),
	(2,1,1,2,5,'Produkte / Products',NULL,NULL),
	(3,2,2,3,4,'S7Ncms / S7Ncms',NULL,NULL),
	(4,1,1,6,7,'Tagebuch / Diary','module','blog');

CREATE TABLE `page_contents` (
  `id` int(11) NOT NULL auto_increment,
  `page_id` int(11) NOT NULL,
  `language` varchar(250) default NULL,
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
  `type` varchar(250) default NULL,
  `target` varchar(250) default NULL,
  PRIMARY KEY  (`id`),
  KEY `uri` (`uri`),
  KEY `language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `page_contents` (`id`,`page_id`,`language`,`keywords`,`user_id`,`date`,`title`,`excerpt`,`content`,`uri`,`tags`,`view`,`modified`,`password`,`status`,`type`,`target`)
VALUES
	(1,1,'de',NULL,0,'2009-03-04 00:12:50','Startseite',NULL,'<p>Willkommen</p>','startseite',NULL,NULL,'2009-03-04 00:12:50',NULL,'published',NULL,NULL),
	(2,1,'en',NULL,0,'2009-03-04 00:12:50','Home',NULL,'<p>Welcome</p>','home',NULL,NULL,'2009-03-04 00:12:50',NULL,'published',NULL,NULL),
	(3,2,'de',NULL,0,'2009-03-04 00:13:33','Produkte',NULL,'<p>Produkte</p>','produkte',NULL,NULL,'2009-03-04 00:13:33',NULL,'published',NULL,NULL),
	(4,2,'en',NULL,0,'2009-03-04 00:13:33','Products',NULL,'<p>Products</p>','products',NULL,NULL,'2009-03-04 00:13:33',NULL,'published',NULL,NULL),
	(5,3,'de',NULL,0,'2009-03-04 00:14:28','S7Ncms',NULL,'<p>Das ist S7Ncms</p>','s7ncms',NULL,NULL,'2009-03-04 00:14:28',NULL,'published',NULL,NULL),
	(6,3,'en',NULL,0,'2009-03-04 00:14:28','S7Ncms',NULL,'<p>This is S7Ncms</p>','s7ncms',NULL,NULL,'2009-03-04 00:14:28',NULL,'published',NULL,NULL),
	(7,4,'de',NULL,0,'2009-03-04 00:15:04','Tagebuch',NULL,'<p>---</p>','tagebuch',NULL,NULL,'2009-03-04 00:15:18',NULL,'published',NULL,NULL),
	(8,4,'en',NULL,0,'2009-03-04 00:15:04','Diary',NULL,'<p>---</p>','diary',NULL,NULL,'2009-03-04 00:15:18',NULL,'published',NULL,NULL);

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `roles` VALUES (1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO `roles` VALUES (2, 'admin', 'Administrative user, has access to everything.');

CREATE TABLE `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;