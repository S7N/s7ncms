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
class google_analytics_installer {

	public static function install()
	{
		$version = (int) module::version('google_analytics');

		// blog module is not installed yet
		if ($version === 0)
		{
			config::set('google_analytics.id', 0);

			module::version('google_analytics', 1);
		}
	}

	public static function uninstall()
	{
		module::delete("google_analytics");

	    Database::instance()->delete('config', array('context' => 'google_analytics'));
	}

}