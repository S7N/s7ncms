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
class Page_Controller extends Website_Controller {

	public function index($id)
	{
		$page = ORM::factory('page', $id);

		if( ! $page->loaded)
    		Event::run('system.404');

		$view = is_null($page->view) ? 'default' : $page->view;

		$this->template->content = View::factory('page/'.$view)->set(array(
			'page' => $page
		))->render();

		$this->head->title->append($page->title);

		/*if ($page->level > 0 AND ($page->has_children() OR $page->level !== 1))
		{
			Sidebar::instance()->add
			(
				'Static',
				array
				(
					'title'   => 'Submenu',
					'content' => Menu::instance()->submenu($page)
				)
			);
		}*/

		Sidebar::instance()->add
		(
			'Static',
			array
			(
				'title'   => Kohana::config('s7n.default_sidebar_title'),
				'content' => Kohana::config('s7n.default_sidebar_content')
			)
		);
	}

}
