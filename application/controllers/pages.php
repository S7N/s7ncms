<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Controller {
    public function _remap() {
    	$page = new Pages_Model();
		$data = $page->get($this->uri->segment(2));
		
		$view = 'default';
		if( is_string($data->view) ) {
			$view = $data->view;
		}
		
		$content = new View('pages/'.$view);
    	$content->page = $data;
    	
    	if(is_null($content->page)) {
    		Kohana::show_404();
    	}
    	
    	$this->template->content = $content;
    }    
}