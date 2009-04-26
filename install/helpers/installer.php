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
class installer {

	public static function check_system()
	{
		
	}

	public static function check_database($user, $password, $host, $database)
	{
		if ( ! $link = @mysql_connect($host, $username, $password)) {
			if (strpos(mysql_error(), 'Access denied') !== FALSE)
				throw new Exception('access');
				
			elseif (strpos(mysql_error(), 'server host') !== FALSE)
				throw new Exception('unknown_host');
				
			elseif (strpos(mysql_error(), 'connect to') !== FALSE)
				throw new Exception('connect_to_host');
				
			else
				throw new Exception('connect');
		}

		if ( ! $select = mysql_select_db($database, $link)) {
			throw new Exception('select');
		}

		return TRUE;
	}

}