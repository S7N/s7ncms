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
class menus_Core {

	public static function modules()
	{
		$query = Database::instance()->where('status', 'on')->get('modules');

		if (count($query) === 0)
			return '';

		$menu = '';
		foreach ($query->result() as $result)
		{
			if( ! is_file(MODPATH.$result->name.'/module.xml'))
				continue;

			$xml = simplexml_load_file(MODPATH.$result->name.'/module.xml');
			$title = (string) $xml->admin_menu_title;

			if(empty($title))
				continue;

			$menu .= '<li>'.html::anchor('admin/'. (string) $xml->uri, $title).'</li>';

		}

		return $menu;
	}

}