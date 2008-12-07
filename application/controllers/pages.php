<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Controller {
    public function _remap() {
    	$page = new Pages_Model();
    	$content = new View('pages/default');
    	$content->page = $page->get($this->uri->segment(2));
    	
    	if(is_null($content->page)) {
    		Kohana::show_404();
    	}
    	
    	$this->template->content = $content;
    }    
}