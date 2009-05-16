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
class url extends url_Core {

	public static function site($uri = '', $protocol = FALSE)
	{
		return self::site_lang(Router::$language, $uri, $protocol);
	}

	public static function site_lang($lang, $uri = '', $protocol = FALSE)
	{
		return parent::site($lang.'/'.$uri, $protocol);
	}

	public static function current_lang($lang, $qs = FALSE)
	{
		return ($qs === TRUE) ? $lang.'/'.Router::$complete_uri : $lang.'/'.Router::$current_uri;
	}
	
	public static function current_site($uri = '')
	{
		$current = preg_replace('#/'.Router::$current_arguments.'$#', '', self::current());
		return empty($uri) ? $current : $current.'/'.$uri;
	}
	
	public static function new_route()
	{
		if ((strpos(Router::$current_uri, 'admin')) === 0)
			return;
		
		$cache_name = 'route_'.str_replace('/', '_', Router::$current_uri);
		
		if (($cache = Cache::instance()->get($cache_name)) === NULL)
		{
			$uri = explode('/', Router::$current_uri);
	
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
					if($page['uri'] == $uri[$level-1] OR $page['target'] == $uri[$level-1])
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
			Router::$current_arguments = implode('/', $routed_arguments);
			
			$cache = array(
				'current_id' => Router::$current_id,
				'current_arguments' => Router::$current_arguments,
				'found' => $found,
				'load_module' => $load_module,
				'routed_uri' => $routed_uri
			);
			
			// set cache
			Cache::instance()->set($cache_name, $cache, array('route'));
		}
		else
		{
			Router::$current_id = $cache['current_id'];
			Router::$current_arguments = $cache['current_arguments'];
			$found = $cache['found'];
			$load_module = $cache['load_module'];
			$routed_uri = $cache['routed_uri'];
		}
		
		
		

		if ($found)
		{
			if ($load_module)
			{
				Kohana::config_set('routes.'.implode('/', $routed_uri).'(/.*)?', $load_module.'/'.Router::$current_arguments);
				return;
			}

			Router::$current_uri = 'page/index/'.Router::$current_id;
		}
	}
}