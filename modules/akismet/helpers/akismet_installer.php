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
class akismet_installer {

	public static function install()
	{
		$version = (int) module::version('akismet');

		// module is not installed yet
		if ($version === 0)
		{
			config::set('akismet.api_key', NULL);

			module::version('akismet', 1);
		}
	}

	public static function uninstall()
	{
		module::delete("akismet");

	    Database::instance()->delete('config', array('context' => 'akismet'));
	}

}