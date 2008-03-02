<?php defined('SYSPATH') or die('No direct script access.');

class Defaultpage_Controller extends Controller {
	
    public function index()
	{
    	$redirect = config::item('s7n.default_uri');
    	
        if(is_null($redirect))
        	Kohana::show_error('No start page defined', "The system couldn't find a start page to display.");
        
    	url::redirect($redirect);
    }
	
}