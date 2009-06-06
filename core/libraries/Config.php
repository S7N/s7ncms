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

class Config_Core {

	protected $config = NULL;

	public function __construct($module_id)
	{
		// parse configuration
		// take care of the language value
	}

	public function __get($key)
	{
		if (array_key_exists($key, $this->config))
			return $this->config[$key];

		return FALSE;
	}

	public function __set($key, $value)
	{
		// how do we set i18n values here?
		// need another method
	}

}