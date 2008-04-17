# CocoaMySQL dump
# Version 0.7b5
# http://cocoamysql.sourceforge.net
#
# Host: localhost (MySQL 5.0.51a)
# Database: s7ncms
# Generation Time: 2008-04-12 02:15:29 +0200
# ************************************************************

# Dump of table config
# ------------------------------------------------------------

CREATE TABLE `config` (
  `id` int(11) NOT NULL auto_increment,
  `context` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `config` (`id`,`context`,`key`,`value`) VALUES ('1','s7n','default_uri','home');
INSERT INTO `config` (`id`,`context`,`key`,`value`) VALUES ('2','s7n','page_views','default, extended');


# Dump of table pages
# ------------------------------------------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;


# Dump of table roles
# ------------------------------------------------------------

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


# Dump of table users
# ------------------------------------------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


# Dump of table users_roles
# ------------------------------------------------------------

CREATE TABLE `users_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table menu
# ------------------------------------------------------------

CREATE TABLE `menu` (
  `id` int(11) NOT NULL auto_increment,
  `l` int(11) default NULL,
  `r` int(11) default NULL,
  `title` varchar(200) default NULL,
  `uri` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('1','1','12','ROOT',NULL);
INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('2','2','3','Home','home');
INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('3','4','5','Products','products');
INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('4','6','7','Blog','blog');
INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('5','8','9','About Me','about-me');
INSERT INTO `menu` (`id`,`l`,`r`,`title`,`uri`) VALUES ('6','10','11','Contact Me','contact-me');