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

		if ($uri[0] === 'admin')
			return;

		$tree = Database::instance()
			->select('id, uri, level, type, target')
			->orderby('lft', 'ASC')
			->get('pages');

		// load first page if uri is empty
		if(empty(Router::$current_uri))
		{
			$page = $tree->current();

			// redirect
			if ( ! empty($page->target) AND $page->type == 'redirect')
				url::redirect($page->target);

			Router::$current_id = $page->id;
			Router::$current_uri = 'page/index/'.$page->id;

			return;
		}

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

		Router::$current_id = $id;

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

new hook_routes;