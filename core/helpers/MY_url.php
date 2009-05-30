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
		
		$uri = explode('/', Router::$current_uri);
	
		// load the menu tree
		$tree = ORM::factory('menu')->find_all();
		
		// TODO show custom error. if the menu is empty then there is nothing to show
		// do nothing if the menu tree is empty
		if (count($tree) == 0)
			return;
			
		// load home page if uri is empty
		if(empty(Router::$current_uri))
		{
			$page = $tree->current()->page;
			
			// redirect the home page
			/*if ( $page->type == 'redirect' AND ! empty($page->target))
			{
				$redirect = ORM::factory('page', $page->target);
				if ($redirect->loaded)
					url::redirect($redirect->uri());
			}*/


			Router::$current_id = (int) $page->id;
			Router::$current_uri = 'page/index/'.$page->id;

			return;
		}
		
		$menu_items = array();
		foreach ($tree as $row)
		{
			if ($row->lvl == 0) continue;

			$menu_items[$row->lvl][] = array(
				'id' => $row->page_id,
				'uri' => $row->page->content()->uri,
				'type' => $row->page->type,
				'target' => $row->page->target
			);
		}

		$id = NULL;
		$routed_uri = array();
		$routed_arguments = array();
		$load_module = FALSE;
		$found = FALSE;

		$uri_size = count($uri);
		$menu_size = count($menu_items);
		for ($level = 1; $level <= $uri_size; $level++)
		{
			if ($level > $menu_size)
			{
				$routed_arguments[] = $uri[$level-1];
				continue;
			}

			if ($load_module !== FALSE)
				$routed_arguments[] = $uri[$level-1];

			foreach($menu_items[$level] as $item)
			{
				if($item['uri'] == $uri[$level-1] OR $item['target'] == $uri[$level-1])
				{
					$found = TRUE;

					$id = $item['id'];

					$routed_uri[] = $item['uri'];

					// check, if we have to load a controller
					if ( ! empty($item['target']))
					{
						$load_module = $item['target'];
					}

					continue 2;
				}
			}
		}
		
		Router::$current_id = (int) $id;
		Router::$current_arguments = implode('/', $routed_arguments);
		
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