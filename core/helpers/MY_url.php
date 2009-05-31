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
class url extends url_Core {

	public static function site($uri = '', $protocol = FALSE)
	{
		return self::site_lang(Router::$language, $uri, $protocol);
	}

	public static function site_lang($lang, $uri = '', $protocol = FALSE)
	{
		return parent::site($lang.'/'.$uri, $protocol);
	}

	public static function current_lang($lang, $qs = FALSE)
	{
		return ($qs === TRUE) ? $lang.'/'.Router::$complete_uri : $lang.'/'.Router::$current_uri;
	}
	
	public static function current_site($uri = '')
	{
		$current = preg_replace('#/'.menu::$arguments.'$#', '', self::current());
		return empty($uri) ? $current : $current.'/'.$uri;
	}

}