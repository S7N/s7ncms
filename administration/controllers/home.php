<?php defined('SYSPATH') or die('No direct script access.');

class Dashboard_Controller extends Admin_Controller {

	public function index()
	{
        $this->template->title = 'Dashboard';
		$this->template->content = new View('dashboard/home');
    }

}