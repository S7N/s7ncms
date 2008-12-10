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
class module_Core {

	public static function installed($name = NULL)
	{
		if ($name !== NULL)
			return ORM::factory('module', $name)->loaded;
		else
			return ORM::factory('module')->find_all();
	}

	public static function active($name = NULL)
	{
		if ($name !== NULL)
		{
			$module = ORM::factory('module', $name);
			return $module->status === 'on';
		}
		else
		{
			return ORM::factory('module')->where('status', 'on')->find_all();
		}
	}

	public static function change_status($module, $status)
	{
		$module = ORM::factory('module', $module);
		if ($module->loaded)
		{
			$module->status = $status === 'on' ? 'on' : 'off';
			$module->save();
		}

		return TRUE;
	}

	public static function available() {
		$modules = array();

		foreach (glob(MODPATH . "*/helpers/*_installer.php") as $file)
			$modules[basename(dirname(dirname($file)))] = 0;

		foreach (self::installed() as $module)
			$modules[$module->name] = $module->version;

		ksort($modules);
		return $modules;
	}

	public static function delete($name)
	{
		ORM::factory('module', $name)->delete();
	}

	public static function version($name, $version_id = FALSE)
	{
		$module = ORM::factory('module', $name);

		if ($version_id !== FALSE)
		{
			if ( ! $module->loaded)
			{
				$module->name = $name;
				$module->status = 'on';
			}

			$module->version = $version_id;
			$module->save();
		}

		return (int) $module->version;
	}

	public static function load_modules()
	{
		$new_modules = array();
		foreach (self::active() as $module)
			$new_modules[] = MODPATH . $module->name;

		Kohana::config_set('core.modules', array_merge($new_modules, Kohana::config('core.modules')));
	}
}