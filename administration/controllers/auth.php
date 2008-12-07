<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Controller extends Controller {

	protected $inputs = array (
		'username' => array (
			'label' => 'Username',
			'rules' => 'required[3,32]'
		),
		'password' => array (
			'label' => 'Password',
			'type'  => 'password',
			'rules' => 'required[4,40]'
		),
		'submit' => array (
			'type' => 'submit',
			'value' => ' Login '
		)
	);

	public function __construct()
	{
		parent::__construct();
		$this->auto_render = false;
	}

	function index() {
		url::redirect('auth/login');
	}

	function login()
	{
		// Get inputs
		$inputs = $this->inputs;

		$message = '';
		$form = null;
		if ( ! $this->session->get('user_id'))
		{
			// Create the login form
			$form = $this->load->model('form', TRUE)
				->action('auth/login')
				->inputs($inputs);

			if ($form->validate())
			{
				// Load the user
				$user = new User_Model($form->data('username'));
				
				// Attempt a login
				$auth = new Auth();
				if ($auth->login($user, $form->data('password')))
				{
					$message .= "<h4>Login Success!</h4>";
					$message .= "<p>Your roles are:</p>";
					$message .= Kohana::debug($this->session->get('roles'));
					
					$url = $this->session->get_once('redirect_me_to');
					url::redirect(empty($url) ? '' : $url);
				}
				else
				{
					$message .= "<h4>Login Failed!</h4>";
				}
			}
		} else {
			$message .= 'You are already logged in as '. $this->session->get('username');
		}

		$login = new View('login');
	 	
	 	if(!is_null($form)) {
	 		$login->form = $form->build();
	 	} else {
	 		$login->form = '';
	 	}
	 	$login->message = $message;
	 	echo $login;
	
	}

	function logout()
	{
		// Load auth and log out
		$auth = new Auth();
		$auth->logout(TRUE);

		// Redirect back to the login page
		url::redirect('auth/login');
	}

} // End Auth_Controller