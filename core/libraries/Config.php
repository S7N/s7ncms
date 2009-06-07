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

	public function __construct($module_id = NULL)
	{
		// parse configuration
		$keys = ORM::factory('config')->where(array('module_id' => $module_id))->find_all();

		foreach ($keys as $key)
		{
			$values = $key->values()->find_all();

			if (count($values) === 1)
			{
				$this->config[$key->key] = $values->current()->value;
			}
			else
			{
				foreach ($values as $value)
				{
					$this->config[$key->key][$value->language_id] = $value->value;
				}
			}
		}
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