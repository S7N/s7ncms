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

class Menu_Core {

	public static $page = NULL;
	public static $page_id = NULL;

	public static function home_page_id()
	{
		$root = ORM::factory('menu')->root(0);

		if ( ! $root->loaded)
			return NULL;

		return $root->page_id;
	}

}