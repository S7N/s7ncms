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
 * @version $Id: MY_html.php 274 2009-03-04 13:26:24Z eduardbaun $
 */
class html extends html_Core {

	public static function anchor_lang($lang, $uri, $title = NULL, $attributes = NULL, $protocol = NULL)
	{
		if ($uri === '')
		{
			$site_url = url::base(FALSE);
		}
		elseif (strpos($uri, '://') === FALSE AND strpos($uri, '#') !== 0)
		{
			$site_url = url::site_lang($lang, $uri, $protocol);
		}
		else
		{
			if (html::$windowed_urls === TRUE AND empty($attributes['target']))
			{
				$attributes['target'] = '_blank';
			}

			$site_url = $uri;
		}

		return
		// Parsed URL
		'<a href="'.html::specialchars($site_url, FALSE).'"'
		// Attributes empty? Use an empty string
		.(is_array($attributes) ? html::attributes($attributes) : '').'>'
		// Title empty? Use the parsed URL
		.(($title === NULL) ? $site_url : $title).'</a>';
	}
}