<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */
class Auth_Controller extends Controller {

	public function index()
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
		
		$form = Formo::factory()
			->add('text', 'username', array('label' => __('Username')))
			->add('text', 'password', array('label' => __('Password')))
			->add('submit', 'submit', array('label' => __('Login')))
			
			->add_rule('username', 'required', __('You must enter a username'))
			->add_rule('password', 'required', __('You must enter a password'));
			
		if ($form->validate())
		{
			// Load the user
			$user = ORM::factory('user', $form->username->value);

			// Attempt a login
			if ($user->loaded AND Auth::instance()->login($user, $form->password->value))
			{
				$url = Session::instance()->get_once('redirect_me_to');
				url::redirect(empty($url) ? 'admin' : $url);
			}
			
			$error = __('Invalid username or password');
		}
		
		$view = View::factory('login', $form->get(TRUE))->bind('error', $error);
		
		echo $view;
	}

	public function logout()
	{
		// Load auth and log out
		Auth::instance()->logout(TRUE);

		// Redirect back to the login page
		url::redirect('admin/auth/login');
	}

}