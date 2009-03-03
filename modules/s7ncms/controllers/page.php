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
class Page_Controller extends Website_Controller {

	public function index($id)
	{
		$page = ORM::factory('page', $id);

		if( ! $page->loaded)
    		Event::run('system.404');

		$view = is_null($page->view) ? 'default' : $page->view;

		$this->template->content = View::factory('page/'.$view, array('page' => $page));

		$this->head->title->append($page->title);

		Sidebar::instance()->add
		(
			'Static',
			array
			(
				'title'   => config::get('s7n.default_sidebar_title'),
				'content' => config::get('s7n.default_sidebar_content')
			)
		);
	}

}
