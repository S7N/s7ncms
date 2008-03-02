<?php defined('SYSPATH') or die('No direct script access.');

class Admin_Controller extends Template_Controller {
	public function __construct()
	{
		parent::__construct();
		
		$this->session = new Session;
		
		if (!Auth::factory()->logged_in('admin')) {
        	$this->session->set('redirect_me_to', url::current());
        	url::redirect('auth/login');
        }
		
		$this->template->title = '';
        $this->template->meta = '';
        $this->template->content = '';
	}
}
