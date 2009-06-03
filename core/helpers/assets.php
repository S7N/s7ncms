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
class assets_Core {

	protected static $scripts = array();
	protected static $stylesheets = array();

	public static function script($name, $script, $index = FALSE)
	{
		self::$scripts[$name] = html::script($script, $index);
	}

	public static function stylesheet($style, $media = FALSE, $index = FALSE)
	{
		self::$stylesheets[] = html::stylesheet($style, $media, $index);
	}

	public static function render($return = TRUE)
	{
		$output = implode('', self::$scripts);
		$output .= implode('', self::$stylesheets);

		if ($return)
			return $output;

		echo $output;
	}

}