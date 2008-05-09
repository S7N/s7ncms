<?php defined('SYSPATH') or die('No direct script access.');

class Dashboard_Controller extends Administration_Controller {

	public function index()
	{
        $this->head['title']->append('Dashboard');
        
		$this->template->title = 'Dashboard';
        $this->template->content = new View('dashboard/index');
    }

}