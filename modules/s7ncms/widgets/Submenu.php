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
class Submenu_Widget extends Widget {

	public function render()
	{
		$menu = Menu::instance()->submenu(ORM::factory('page', Router::$current_id));
		if (is_null($menu))
			return '';

		return View::factory('widgets/submenu')->set(array(
			'menu' => $menu
		))->render();
	}

}