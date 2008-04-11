<?php defined('SYSPATH') or die('No direct script access.');

class Page_Controller extends Template_Controller {
	
	public function _remap()
	{
		$page = ORM::factory('page')->find($this->uri->segment(2));
		
		if(is_null($page))
    		Event::run('system.404');
		
		$view = is_null($page->view) ? 'default' : $page->view;
		
		$this->template->content = new View('page/'.$view);
		$this->template->content->page = $page;
	}
}
