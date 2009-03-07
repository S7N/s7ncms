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
class message_Core {

	public static function info($message = NULL, $uri = NULL)
	{
		if ($message !== NULL AND $uri !== NULL)
		{
			Session::instance()->set_flash('info_message', $message);
			url::redirect($uri);
		}
		
		return Session::instance()->get('info_message', FALSE);
	}
	
	public static function error($message = NULL, $uri = NULL)
	{
		if ($message !== NULL AND $uri !== NULL)
		{
			Session::instance()->set_flash('error_message', $message);
			url::redirect($uri);
		}
		
		return Session::instance()->get('error_message', FALSE);
	}
	
}