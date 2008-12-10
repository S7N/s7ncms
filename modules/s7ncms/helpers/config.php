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
class config_Core {

	public static function set($key, $value)
	{
		$keys = explode('.', $key);

		if (count($keys) === 2)
		{
			$db = Database::instance();

			$count = $db
				->where(array('context' => $keys[0], 'key' => $keys[1]))
				->count_records('config');

			if ($count == 1)
			{
				$db->update(
					'config',
					array('value' => $value),
					array('context' => $keys[0], 'key' => $keys[1])
				);
			}
			else
			{
				$db->insert(
					'config',
					array('context' => $keys[0], 'key' => $keys[1], 'value' => $value)
				);
			}
		}
	}

	public static function get($key)
	{
		return Kohana::config($key);
	}

}