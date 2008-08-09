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
			$form = new Forge('admin/auth/logout', 'Log Out');

			$form->submit('Logout Now');
		}
		else
		{
			$form = new Forge(NULL);

			$form->input('username')->label(TRUE)->rules('required|length[3,32]');
			$form->password('password')->label(TRUE)->rules('required|length[4,40]');
			$form->submit('Login');

			if ($form->validate())
			{
				// Load the user
				$user = ORM::factory('user', $form->username->value);

				// Attempt a login
				if (Auth::instance()->login($user, $form->password->value))
				{
					$url = Session::instance()->get_once('redirect_me_to');
					url::redirect(empty($url) ? 'admin' : $url);
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
		Auth::instance()->logout(TRUE);

		// Redirect back to the login page
		url::redirect('admin/auth/login');
	}

}