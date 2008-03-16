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

		$this->template->meta .= html::script('media/js/jquery.js', TRUE);
		$this->template->meta .= html::script('media/js/stuff.js', TRUE);
		
		$this->template->links = array();
		
        $this->template->title = '';
        $this->template->message = $this->session->get('info_message', NULL);
		$this->template->error = $this->session->get('error_message', NULL);
		$this->template->content = '';
	}

}
