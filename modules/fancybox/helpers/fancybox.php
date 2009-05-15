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
class fancybox_Core {
	
	public static function head()
	{
		echo View::factory('fancybox/head');
	}
	
	public static function replace_content()
	{
		$pattern = array(
			'/<a(.*?)href="(\S*?)(\.(gif|jpe?g|png))"([^\>]*?)><img/i',
			'/<a(.*?)href="(\S*?)(\.(gif|jpe?g|png))"(.*?)((rel="lightbox(.*?)"(\s*))+)([^\>]*?)><img/i');
		$replacement = array(
			"<a$1href=\"$2$3\" rel=\"lightbox[".Event::$data->id."]\"$5><img",
			"<a$1href=\"$2$3\"$5$7$10><img");
		
		Event::$data->content = preg_replace($pattern, $replacement, Event::$data->content);
	}
	
}