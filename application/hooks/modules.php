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

new hook_modules;