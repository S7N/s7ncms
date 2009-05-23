<?php defined("SYSPATH") or die("No direct script access.") ?>
SET NAMES 'utf8';

CREATE TABLE `<?php echo $table_prefix ?>config` (
  `id` int(11) NOT NULL auto_increment,
  `context` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `value` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `<?php echo $table_prefix ?>config` VALUES (1, 's7n', 'page_views', 'default, extended');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (2, 's7n', 'site_title', 'My Website');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (3, 's7n','default_sidebar_title','About');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (4, 's7n','default_sidebar_content','Mit S7Ncms wird die Verwaltung Ihrer Internetpräsenz zum Kinderspiel. Bei S7Ncms handelt es sich um ein speziell für die Anforderungen professioneller Webseiten entwickeltes Content Management System.');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (5, 's7n','theme','default');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (6, 'blog', 'enable_captcha', 'yes');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (7, 'blog', 'enable_tagcloud', 'yes');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (8, 'blog', 'comment_status', 'open');
INSERT INTO `<?php echo $table_prefix ?>config` VALUES (9, 'blog', 'items_per_page', '5');

CREATE TABLE `<?php echo $table_prefix ?>modules` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `version` int(10) default 0,
  `status` varchar(200) default 'on',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `<?php echo $table_prefix ?>modules` VALUES (1, 'blog', 1, 'on');

CREATE TABLE `<?php echo $table_prefix ?>pages` (
  `id` int(11) NOT NULL auto_increment,
  `level` int(11) NOT NULL,
  `lft` int(11) default NULL,
  `rgt` int(11) default NULL,
  `scope` int(11) default 1,
  `title` varchar(200) default NULL,
  `type` varchar(200) default NULL,
  `target` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `<?php echo $table_prefix ?>pages` (`id`,`level`,`lft`,`rgt`,`title`,`type`,`target`,`scope`)
VALUES
	(6,1,10,11,'Über S7Ncms / About S7Ncms',NULL,NULL,1),
	(5,1,8,9,'Blog / Blog','module','blog',1),
	(4,2,5,6,'Amet / Amet',NULL,NULL,1),
	(3,2,3,4,'Dolor Sit / Dolor Sit',NULL,NULL,1),
	(2,1,2,7,'Lorem Ipsum / Lorem Ipsum',NULL,NULL,1),
	(1,0,1,12,'Startseite / Home Page',NULL,NULL,1);

CREATE TABLE `<?php echo $table_prefix ?>page_contents` (
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

INSERT INTO `<?php echo $table_prefix ?>page_contents` (`id`,`page_id`,`language`,`keywords`,`user_id`,`date`,`title`,`excerpt`,`content`,`uri`,`tags`,`view`,`modified`,`password`,`status`,`type`,`target`)
VALUES
	(1,1,'de',NULL,0,'2009-05-19 23:05:20','Startseite',NULL,'<p>Das ist die Startseite von S7Ncms.</p>','startseite',NULL,NULL,'2009-05-19 23:05:20',NULL,'published',NULL,NULL),
	(2,1,'en',NULL,0,'2009-05-19 23:05:20','Home Page',NULL,'<p>This is the home page of S7Ncms.</p>','home-page',NULL,NULL,'2009-05-19 23:05:20',NULL,'published',NULL,NULL),
	(3,2,'de',NULL,0,'2009-05-19 23:06:17','Lorem Ipsum',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','lorem-ipsum',NULL,NULL,'2009-05-19 23:06:17',NULL,'published',NULL,NULL),
	(4,2,'en',NULL,0,'2009-05-19 23:06:17','Lorem Ipsum',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','lorem-ipsum',NULL,NULL,'2009-05-19 23:06:17',NULL,'published',NULL,NULL),
	(5,3,'de',NULL,0,'2009-05-19 23:15:31','Dolor Sit',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','dolor-sit',NULL,NULL,'2009-05-19 23:15:31',NULL,'published',NULL,NULL),
	(6,3,'en',NULL,0,'2009-05-19 23:15:31','Dolor Sit',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','dolor-sit',NULL,NULL,'2009-05-19 23:15:31',NULL,'published',NULL,NULL),
	(7,4,'de',NULL,0,'2009-05-19 23:16:03','Amet',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','amet',NULL,NULL,'2009-05-19 23:16:03',NULL,'published',NULL,NULL),
	(8,4,'en',NULL,0,'2009-05-19 23:16:03','Amet',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','amet',NULL,NULL,'2009-05-19 23:16:03',NULL,'published',NULL,NULL),
	(9,5,'de',NULL,0,'2009-05-19 23:13:56','Blog',NULL,'','blog',NULL,NULL,'2009-05-19 23:14:12',NULL,'published',NULL,NULL),
	(10,5,'en',NULL,0,'2009-05-19 23:13:56','Blog',NULL,'','blog',NULL,NULL,'2009-05-19 23:14:12',NULL,'published',NULL,NULL),
	(11,6,'de',NULL,0,'2009-05-19 23:19:21','Über S7Ncms',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','uber-s7ncms',NULL,NULL,'2009-05-19 23:19:21',NULL,'published',NULL,NULL),
	(12,6,'en',NULL,0,'2009-05-19 23:19:21','About S7Ncms',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','about-s7ncms',NULL,NULL,'2009-05-19 23:19:21',NULL,'published',NULL,NULL);

CREATE TABLE `<?php echo $table_prefix ?>roles` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `<?php echo $table_prefix ?>roles` VALUES (1, 'login', 'Login privileges, granted after account confirmation');
INSERT INTO `<?php echo $table_prefix ?>roles` VALUES (2, 'admin', 'Administrative user, has access to everything.');

CREATE TABLE `<?php echo $table_prefix ?>roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `<?php echo $table_prefix ?>roles_users` (`user_id`, `role_id`) VALUES (1, 1), (1, 2);

CREATE TABLE `<?php echo $table_prefix ?>users` (
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

INSERT INTO `<?php echo $table_prefix ?>users` (`id`, `email`, `username`, `password`, `logins`, `homepage`, `first_name`, `last_name`, `registered_on`, `last_login`) VALUES
(1, 'admin@example.com', 'admin', '<?php echo $password_hash ?>', 0, NULL, 'Administrator', NULL, NULL, NULL);


CREATE TABLE `<?php echo $table_prefix ?>blog_posts` (
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

INSERT INTO `<?php echo $table_prefix ?>blog_posts` (`id`,`user_id`,`date`,`content`,`title`,`excerpt`,`status`,`comment_status`,`ping_status`,`password`,`uri`,`modified`,`comment_count`,`tags`)
VALUES
	(1,1,'2009-05-19 23:00:00','<p>This is my <strong>first</strong> blog post.</p>\n<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','First Blog Post',NULL,'published','open','open','','first-blog-post','2009-05-19 23:00:00',1,'Lorem Ipsum, Test'),
	(2,1,'2009-05-19 23:00:0','<p>This is my <strong>second</strong> blog post.</p>\n<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>','Second Blog Post',NULL,'published','open','open','','second-blog-post','2009-05-19 23:00:00',0,'Dolor Sit, Test');

CREATE TABLE `<?php echo $table_prefix ?>blog_comments` (
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

INSERT INTO `<?php echo $table_prefix ?>blog_comments` (`id`,`blog_post_id`,`author`,`email`,`url`,`ip`,`date`,`content`,`approved`,`agent`,`type`,`user_id`)
VALUES
	(1,1,'Edy','edy@edy-b.de','http://www.edy-b.de/','127.0.0.1','2009-05-19 23:00:00','Nice CMS!','1','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.0.6) Gecko/2009020614 Firefox/3.0.6 BeatnikPad FirePHP/0.2.4','comment',0);
