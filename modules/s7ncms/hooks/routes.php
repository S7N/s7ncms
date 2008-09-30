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
		$tree = Database::instance()
		->select('id, uri, level')
		->orderby('lft', 'ASC')
		->get('pages');

		if(empty(Router::$current_uri))
		{
			Router::$current_uri = 'page/index/'.$tree->current()->id;
			return TRUE;
		}

		$uri = explode('/', Router::$current_uri);

		if($uri[0] === 'admin')
		{
			return TRUE;
		}

		foreach ($tree as $row)
		{
			if ($row->level == 0) continue;
				
			$pages[$row->level][] = array(
				'id' => $row->id,
				'uri' => $row->uri
			);
		}

		// the page does not exist if we have more uri segments than levels
		// TODO implement modules and other controllers here
		if (count($uri) > count($pages))
		{
			Event::run('system.404');
		}


		$id = NULL;
		for ($level = 1; $level <= count($uri); $level++)
		{
			$found = FALSE;
			foreach($pages[$level] as $page)
			{
				if($page['uri'] == $uri[$level-1])
				{
					$id = $page['id'];
					$found = TRUE;
					continue 2;
				}
			}
				
			if ( ! $found)
			{
				Event::run('system.404');
			}
		}

		Router::$current_uri = 'page/index/'.$id;
	}

}

new hook_routes;