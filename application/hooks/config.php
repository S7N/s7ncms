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
class hook_config {

	public function __construct()
	{
		Event::add('system.ready', array($this, 'new_config'));
	}

	public function new_config()
	{
		$query = Database::instance()->select('context, key, value')
			->from('config')
			->get();

		$result = $query->result();

		foreach ($result as $item)
		Kohana::config_set($item->context.'.'.$item->key, $item->value);
	}

}

new hook_config;
