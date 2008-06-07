<?php defined('SYSPATH') or die('No direct script access.');
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

	public function _remap()
	{
		$page = ORM::factory('page')->find($this->uri->segment(2));

		if(is_null($page))
    		Event::run('system.404');

		$view = is_null($page->view) ? 'default' : $page->view;

		$this->template->content = new View('page/'.$view);
		$this->template->content->page = $page;
		$this->head['title']->append($page->title);
	}

}
