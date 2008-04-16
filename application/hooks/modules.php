<?php defined('SYSPATH') or die('No direct script access.');

class LoadModules {

    public function __construct()
	{
        // fetch Modules from config
		$modules = Config::item('core.modules');
		
		// attach modules from Database
		$query = Database::instance()->select('name')->where('status', 'on')->get('modules');
		
		if(count($query) > 0)
		{
			$result = $query->result();
			foreach ($result as $item)
			{
				$modules[] = MODPATH.$item->name;
			}
		
			Config::set('core.modules', $modules);
		}
    }
    
}

new LoadModules;