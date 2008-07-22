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
class hook_modules {

	public function __construct()
	{
		// fetch Modules from config
		$modules = Kohana::config('core.modules');

		// attach modules from Database
		$query = Database::instance()->select('name')->where('status', 'on')->get('modules');

		if(count($query) > 0)
		{
			$new_modules = array();
			
			$result = $query->result();
			foreach ($result as $item)
			{
				$new_modules[] = MODPATH.$item->name;
			}

			Kohana::config_set('core.modules', array_merge($new_modules,$modules));
		}
	}

}

new hook_modules;