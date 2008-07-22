<?php defined('SYSPATH') or die('No direct script access.');
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
		if(empty(Router::$current_uri))
			return TRUE;

		$segments = explode('/', Router::$current_uri);

		/**
		 * Don't rewrite the route if we have other than one segments
		 */
		if (count($segments) != 1)
			return TRUE;

		/**
		 * Don't rewrite the route if the first segment is 'admin'
		 */
		if ($segments[0] === 'admin')
			return TRUE;

		$query = Database::instance()->select('id')->limit(1)->getwhere('pages', array('uri =' => $segments[0]));

		/**
		 * how many pages were found?
		 */
		if (count($query) != 1)
			return true;

		Router::$current_uri = 'page/'.$segments[0];
	}

}

new hook_routes;