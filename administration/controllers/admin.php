<?php defined('SYSPATH') or die('No direct script access.');

class Admin_Controller extends Template_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->session = new Session;

		if ( ! Auth::factory()->logged_in('admin'))
		{
        	$this->session->set('redirect_me_to', url::current());
        	url::redirect('auth/login');
        }
		
		// Javascripts
		$this->template->meta .= html::script('media/js/jquery.js', TRUE);
		$this->template->meta .= html::script('media/js/ui.tabs.js', TRUE);
		$this->template->meta .= html::script('media/js/stuff.js', TRUE);
		
		// Stylesheets
		$this->template->meta .= html::stylesheet('media/css/ui.tabs.css', 'screen', TRUE);
			
		$this->template->tasks = array();
		
        $this->template->title = '';
        $this->template->message = $this->session->get('info_message', NULL);
		$this->template->error = $this->session->get('error_message', NULL);
		$this->template->content = '';
	}

}
