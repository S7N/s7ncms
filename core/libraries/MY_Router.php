<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */
class Router extends Router_Core {

	public static $language = NULL;
	public static $current_id;
	public static $page = NULL;
	public static $current_arguments = NULL;

	public static function find_uri()
	{
		parent::find_uri();

		if ((strpos(Router::$current_uri, 'admin')) === 0)
			return;

		if (preg_match('~^[a-z]{2}(?=/|$)~i', Router::$current_uri, $matches) AND isset($matches[0]))
		{
			$lang = strtolower($matches[0]);
			if (ORM::factory('language')->tag_exists($lang))
			{
				Router::$language = $lang;
				Router::$current_uri = trim(substr(Router::$current_uri, 2), '/');
			}
		}
	}
	
	public static function new_route()
	{
		if ((strpos(Router::$current_uri, 'admin')) === 0)
			return;

		$page = menus::find_page(Router::$current_uri);

		if ($page === FALSE)
			return;

		if ($page->type === 'module')
		{
			Kohana::config_set('routes.'.implode('/', menus::$uri).'(/.*)?', trim($page->target.'/'.implode('/', menus::$arguments), '/'));
		}
		elseif ($page->type === 'redirect')
		{
			url::redirect($page->target);
		}
		else
		{
			Router::$current_uri = 'page/index/'.$page->id;
		}
	}

}