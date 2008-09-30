<?php
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2008, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2008
 * @version $Id$
 */
class Auth_Controller extends Controller {

	function index()
	{
		url::redirect('admin/auth/login');
	}

	public function login()
	{
		if (Auth::instance()->logged_in())
		{
			if (Auth::instance()->logged_in('admin'))
				url::redirect('admin');
			else
				url::redirect();
		}
		
		$fields = array
		(
			'username' => '',
			'password' => ''
		);
		
		$errors = $fields;
		
		if ($_POST)
		{
			$_POST = new Validation($_POST);
			
			$_POST
				->add_rules('username', 'required')
				->add_rules('password', 'required');
			
			if ($_POST->validate())
			{
				// Load the user
				$user = ORM::factory('user', $_POST['username']);
				
				// Attempt a login
				if (Auth::instance()->login($user, $_POST['password']))
				{
					$url = Session::instance()->get_once('redirect_me_to');
					url::redirect(empty($url) ? 'admin' : $url);
				}
				else
				{
					$_POST->add_error('password', 'default');
					$fields = arr::overwrite($_POST->safe_array('username'));
					$errors = arr::overwrite($_POST->errors('login_error_messages'));
				}
			}
			else
			{
				$fields = arr::overwrite($_POST->safe_array('username'));
				$errors = arr::overwrite($_POST->errors('login_error_messages'));
			}
		}

		// Display the form
		$login = new View('login');
		$login->fields = $fields;
		$login->errors = $errors;
		echo $login;
	}

	public function logout()
	{
		// Load auth and log out
		Auth::instance()->logout(TRUE);

		// Redirect back to the login page
		url::redirect('admin/auth/login');
	}

}