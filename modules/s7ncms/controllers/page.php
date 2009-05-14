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

    	$page_content = ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => Router::$language))->find();

    	Event::run('s7n.display_content', $page_content);
    	
		$this->template->content = View::factory('page/default', array('page' => $page_content));

		$this->head->title->append($page->title);
	}

}
