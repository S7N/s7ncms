CREATE TABLE `{table_prefix}blogposts` (
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

CREATE TABLE `{table_prefix}comments` (
	`id` bigint(20) unsigned NOT NULL auto_increment,
	`blogpost_id` int(11) NOT NULL default '0',
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
	KEY `blogposts_id` (`blogpost_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;