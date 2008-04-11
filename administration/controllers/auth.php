<?php defined('SYSPATH') or die('No direct script access.');

class Auth_Controller extends Controller {

	public function __construct()
	{
		parent::__construct();

		// Load some libraries
		foreach(array('auth', 'session') as $lib)
		{
			$class = ucfirst($lib);
			$this->$lib = new $class();
		}
	}
	
	function index()
	{
		url::redirect('auth/login');
	}

	public function login()
	{
		if ($this->auth->logged_in())
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

	}

	public function logout()
	{
		// Load auth and log out
		$this->auth->logout(TRUE);

		// Redirect back to the login page
		url::redirect('auth/login');
	}

}