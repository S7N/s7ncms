<?php
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2008, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2008
 * @version $Id$
 */
class hook_routes {

	public function __construct()
	{
		Event::add_before('system.routing', array('Router', 'setup'), array($this, 'new_route'));
	}

	public function new_route()
	{
		$uri = explode('/', Router::$current_uri);

		if($uri[0] === 'admin')
		{
			return TRUE;
		}

		$tree = Database::instance()
			->select('id, uri, level, module')
			->orderby('lft', 'ASC')
			->get('pages');

		// load first page if uri is empty
		// TODO what if the first page is a module or a redirect?
		if(empty(Router::$current_uri))
		{
			Router::$current_uri = 'page/index/'.$tree->current()->id;
			return TRUE;
		}

		foreach ($tree as $row)
		{
			if ($row->level == 0) continue;

			$pages[$row->level][] = array(
				'id' => $row->id,
				'uri' => $row->uri,
				'module' => $row->module
			);
		}

		// the page does not exist if we have more uri segments than levels
		// TODO implement modules and other controllers here
		/*if (count($uri) > count($pages))
		{
			//Event::run('system.404');
		}*/

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
			{
				$routed_arguments[] = $uri[$level-1];
			}

			foreach($pages[$level] as $page)
			{
				if($page['uri'] == $uri[$level-1])
				{
					$found = TRUE;

					$id = $page['id'];

					$routed_uri[] = $page['uri'];

					// check, if we have to load a controller
					if ( ! empty($page['module']))
					{
						$load_module = $page['module'];
					}

					continue 2;
				}
			}

		}

		Router::$current_id = $id;

		if ($load_module !== FALSE)
		{
			Router::$routed_uri = implode('/', $routed_uri);

			Kohana::config_set('routes.'.implode('/', $routed_uri).'(/.*)?', $load_module.'/'.implode('/', $routed_arguments));
		}
		else
		{
			if ( ! $found OR ! empty($routed_arguments))
			{
				Event::run('system.404');
			}

			Router::$current_uri = 'page/index/'.$id;
		}
	}

}

new hook_routes;