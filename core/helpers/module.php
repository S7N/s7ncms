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

class module_Core {
	
	public static function load_core_modules()
	{
		$modules = (array) glob(COREPATH . 'modules/*');
		
		if ( ! empty($modules))
			foreach ($modules as $module)
				self::load_module(basename($module), TRUE);
	}
	
	public static function load_module($name, $core = FALSE)
	{
		$modules = Kohana::config('core.modules');

		$module_dir = $core ? COREPATH . 'modules/' . $name : MODPATH . $name;

		$modules[] = $module_dir;

		Kohana::config_set('core.modules', $modules);

		$hooks = (array) glob($module_dir . '/hooks/*.php');

		if ( ! empty($hooks))
			foreach ($hooks as $hook)
				include $hook;
	}

}