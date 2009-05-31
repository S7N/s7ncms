<?php

class loader_Core
{
	public static function load_core()
	{
		if($handle = opendir(COREPATH . 'modules/')) 
		{ 
			while($file = readdir($handle))
			{
				$file != '.' && $file != '..' && $file != '.svn' ? self::load_module($file, TRUE) : '' ;
			}
			closedir($handle);
		}
		
		//print_r(self::$debug_loaded_files);
	}
	
	public static function load_module($name, $core = FALSE)
	{
		$modules = Kohana::config('core.modules');
		$hooks = array();
		
		array_unshift($modules, $mod_dir = $core ? 
				COREPATH . 'modules/' . $name . '/': 
				MODPATH				  . $name . '/');
		
		
		$files = (array) glob($mod_dir . 'hooks/*.php');
			
		if ( ! empty($files))
			$hooks = array_merge($hooks, $files);
		
		foreach ($hooks as $hook)
		{
			include $hook;
		}
	
		Kohana::config_set('core.modules', $modules);
	}
}