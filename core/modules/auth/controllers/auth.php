<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auth_Controller extends Controller {
	
	public function index($id)
	{
		$view = View::factory('page')
			->bind('page', $page)
			->bind('content', $content);
		
		$page = ORM::factory('page', (int) $id);
    	$content = $page->content();
		
    	echo $view;
	}
	
	public function login()
	{
			
	}
}