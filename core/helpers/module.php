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
		$core_modules = (array) glob(DOCROOT . 'core/modules/*');
		
		if ( ! empty($core_modules))
		{
			$modules = Kohana::config('core.modules');

			foreach ($core_modules as $core_module)
				$modules[] = $core_module;

			Kohana::config_set('core.modules', $modules);
		}
	}
}