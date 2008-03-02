<?php defined('SYSPATH') or die('No direct script access.');

class Home_Controller extends Admin_Controller {

	public function index()
	{
        $this->template->title = 'Home';
        $this->template->content = new View('home/home');
    }

}