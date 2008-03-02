<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Template_Controller {
	
    public function _remap()
	{
    	$page = new Pages_Model();
		$data = $page->get($this->uri->segment(2));
		
		if(is_null($data))
    		Kohana::show_404();
		
		$view = 'default';
		is_string($data->view) AND $view = $data->view;
		
		$content = new View('pages/'.$view);
    	$content->page = $data;
    	
    	$this->template->content = $content;
    }

}