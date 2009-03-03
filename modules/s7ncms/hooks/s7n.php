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

Event::add("system.ready", 'module::load_modules');
Event::add('system.ready', 'config::load');

Event::add_before('system.routing', array('Router', 'setup'), array('language_hook', 'setup'));
Event::add_before('system.routing', array('Router', 'setup'), array('route_hook', 'new_route'));

class language_hook {

	public static $available_languages = array();
	public static $browser_language = NULL;

	public static function setup()
	{
		self::$available_languages = Kohana::config('locale.languages');

		if (Router::$language === NULL)
		{
			$redirect = NULL;
			if (empty(Router::$current_uri))
			{
				if (($lang = self::browser_language()) !== '')
				{
					$redirect = $lang;
				}
				else
				{
					reset(self::$available_languages);
					$redirect = key(self::$available_languages);
				}
			}
			else
			{
				if (($lang = self::browser_language()) !== '')
				{
					$redirect = $lang.'/'.Router::$current_uri;
				}
				else
				{
					reset(self::$available_languages);
					$redirect = key(self::$available_languages).'/'.Router::$current_uri;
				}
			}

			url::redirect($redirect);
		}

		/*if (empty(Router::$current_uri))
			Router::$current_uri = Kohana::config('routes._default');*/

		Kohana::config_set('locale.language', self::$available_languages[Router::$language]);
	}

	public static function browser_language()
	{
		if (self::$browser_language === NULL)
		{
			self::$browser_language = '';
			$browser_languages = Kohana::user_agent('languages');

			foreach($browser_languages as $language)
			{
				if (strlen($language) == 2 AND array_key_exists($language, self::$available_languages))
				{
					self::$browser_language = strtolower($language);
					break;
				}
			}
		}

		return self::$browser_language;
	}

}

class route_hook {

	public static function new_route()
	{
		$uri = explode('/', Router::$current_uri);

		if ($uri[0] === 'admin')
			return;

		$tree = ORM::factory('page')->find_all();

		// stop of we dont have pages
		if (count($tree) == 0)
			return;

		// load first page if uri is empty
		if(empty(Router::$current_uri))
		{
			$page = $tree->current();

			// redirect the home page
			if ( $page->type == 'redirect' AND ! empty($page->target))
			{
				$redirect = ORM::factory('page', $page->target);
				if ($redirect->loaded)
					url::redirect($redirect->uri());
			}


			Router::$current_id = (int) $page->id;
			Router::$current_uri = 'page/index/'.$page->id;

			return;
		}

		$pages = array();
		foreach ($tree as $row)
		{
			if ($row->level == 0) continue;

			$pages[$row->level][] = array(
				'id' => $row->id,
				'uri' => $row->uri,
				'type' => $row->type,
				'target' => $row->target
			);
		}

		$id = NULL;
		$routed_uri = array();
		$routed_arguments = array();
		$load_module = FALSE;
		$found = FALSE;

		$uri_size = count($uri);
		$pages_size = count($pages);
		for ($level = 1; $level <= $uri_size; $level++)
		{
			if ($level > $pages_size)
			{
				$routed_arguments[] = $uri[$level-1];
				continue;
			}

			if ($load_module !== FALSE)
				$routed_arguments[] = $uri[$level-1];

			foreach($pages[$level] as $page)
			{
				if($page['uri'] == $uri[$level-1])
				{
					$found = TRUE;

					$id = $page['id'];

					$routed_uri[] = $page['uri'];

					// check, if we have to load a controller
					if ( ! empty($page['target']))
					{
						$load_module = $page['target'];
					}

					continue 2;
				}
			}
		}

		Router::$current_id = (int) $id;

		if ($found)
		{
			// do not load a page if controller with the same name exists
			if (Kohana::find_file('controllers', $uri[0]))
			{
				Router::$routed_uri = $uri[0];
				return;
			}

			if ($load_module)
			{
				Router::$routed_uri = implode('/', $routed_uri);

				Kohana::config_set('routes.'.implode('/', $routed_uri).'(/.*)?', $load_module.'/'.implode('/', $routed_arguments));
				return;
			}

			Router::$current_uri = 'page/index/'.$id;
		}
	}

}