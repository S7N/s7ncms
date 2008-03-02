<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->auto_render = false;
		
		// Load some libraries
		foreach(array('auth', 'session') as $lib)
		{
			$class = ucfirst($lib);
			$this->$lib = new $class();
		}
	}
	
	function index() {
		url::redirect('auth/login');
	}

	public function login()
	{
		if (Auth::factory()->logged_in())
		{
			$form = new Forge('auth/logout', 'Log Out');

			$form->submit('Logout Now');
		}
		else
		{
			$form = new Forge;

			$form->input('username')->label(TRUE)->rules('required|length[3,32]');
			$form->password('password')->label(TRUE)->rules('required|length[4,40]');
			$form->submit('Login');

			if ($form->validate())
			{
				// Load the user
				$user = ORM::factory('user', $form->username->value);

				// Attempt a login
				if ($this->auth->login($user, $form->password->value))
				{
					$url = $this->session->get_once('redirect_me_to');
					url::redirect(empty($url) ? '' : $url);
				}
				else
				{
					$form->password->add_error('login_failed', 'Invalid username or password.');
				}
			}
		}

		// Display the form
		$login = new View('login');
		
		$login->form = $form;
		
		echo $login;
		//echo $form->render('login', TRUE);
	}

	public function logout()
	{
		// Load auth and log out
		$this->auth->logout(TRUE);

		// Redirect back to the login page
		url::redirect('auth/login');
	}
/*	protected $inputs = array (
		'username' => array (
			'label' => 'Username',
			'rules' => 'required[3,32]'
		),
		'password' => array (
			'label' => 'Password',
			'type'  => 'password',
			'rules' => 'required[3,40]'
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
			$form = new Form_model;
			$form->action('auth/login')
				->inputs($inputs);

			if ($form->validate())
			{
				// Load the user
				$user = new User_Model($form->data('username'));
				
				// Attempt a login
				$auth = new Auth();
				if ($auth->login($user, $form->data('password')))
				{
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
	}*/

} // End Auth_Controller