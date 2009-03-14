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
	
	static function load_themes()
	{
		$modules = Kohana::config("core.modules");
		array_unshift($modules, THEMEPATH);
		Kohana::config_set("core.modules", $modules);
		
		theme::$name = config::get('s7n.theme');
		
		if (strpos(Router::$current_uri, 'admin') === 0)
			theme::$name = 'admin';
	}
	
}