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
class theme_Core {
	
	public static $name = 'default';
	
	public static function load()
	{
		$modules = Kohana::config("core.modules");
		$modules[] = THEMESPATH;
		
		Kohana::config_set("core.modules", $modules);
		
		// TODO
		//theme::$name = config::get('s7n.theme');
		
		if (strpos(Router::$current_uri, 'admin') === 0)
			theme::$name = 'admin';
	}
	
	public static function url($path = '')
	{
		return 'themes/' . theme::$name . '/' . $path;
	}
}