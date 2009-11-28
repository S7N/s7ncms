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
class User_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->template->tasks = array(
			array('admin/user/create', __('New User'))
		);

		$this->head->title->append(__('User'));
		$this->template->title = html::anchor('admin/user', __('User')).' | ';
	}

	public function index()
	{
		$this->template->content = View::factory('user/index', array('users' => ORM::factory('user')->find_all()));

		$this->head->title->append(__('All Users'));
		$this->template->title .= __('All Users');
	}

	public function create()
	{
		$this->head->title->append(__('New User'));
		$this->template->title .= __('New User');

		$form = Formo::factory()
			->plugin('csrf')
			->add('text', 'username', array('label' => __('Username')))
			->add('text', 'email', array('label' => __('Email')))
			->add('password', 'password', array('label' => __('Password')))
			->add('password', 'password_confirm', array('label' => __('Confirm password')))
			->add('submit', 'submit', array('label' => __('Save')))

			// TODO check if username or email exists
			->add_rule('username', 'required', __('You must enter a username'))
			->add_rule('email', 'required', __('You must enter an email'))
			->add_rule('email', 'valid::email', __('Email address is not valid'))
			->add_rule('password', 'required', __('You must enter a password'))
			->add_rule('password', 'matches[password_confirm]', __('The passwords doesn\'t match'))
			->add_rule('password_confirm', 'required', __('You must confirm the password'));

		if ($form->validate())
		{
			$user = ORM::factory('user');
			$user->username = $form->username->value;
			$user->email = $form->email->value;
			$user->password = $form->password->value;
			$user->registered_on = date("Y-m-d H:i:s", time());
			$user->add(ORM::factory('role', 'login'));
			$user->add(ORM::factory('role', 'admin'));
			$user->save();

			message::info(__('User created successfully'), 'admin/user');
		}

		$this->template->content = View::factory('user/create', $form->get(TRUE));
	}

	public function edit($id)
	{
		$this->head->title->append(__('New User'));
		$this->template->title .= __('New User');

		$user = ORM::factory('user', (int) $id);

		if ( ! $user->loaded)
			Event::run('system.404');

		$form = Formo::factory()
			->plugin('csrf')
			->add('text', 'username', array('label' => __('Username'), 'value' => $user->username))
			->add('text', 'email', array('label' => __('Email'), 'value' => $user->email))
			->add('password', 'password', array('label' => __('Password')))
			->add('password', 'password_confirm', array('label' => __('Confirm password')))
			->add('submit', 'submit', array('label' => __('Save')))

			// TODO check if email has changed and check if it already exists
			->add_rule('email', 'required', __('You must enter an email'))
			->add_rule('email', 'valid::email', __('Email address is not valid'))
			->add_rule('password', 'matches[password_confirm]', __('The passwords doesn\'t match'));

		if ($form->validate())
		{
			$user->username = $form->username->value;
			$user->email = $form->email->value;
			if ( ! empty($form->password->value))
				$user->password = $form->password->value;
			$user->save();

			message::info(__('User edited successfully'), 'admin/user');
		}

		$this->template->content = View::factory('user/edit', $form->get(TRUE));
	}

	public function delete($id)
	{
		$user = ORM::factory('user', (int) $id);

		if ( ! $user->loaded)
			message::error(__('Invalid ID'), 'admin/user');

		if ($user->id === Auth::instance()->get_user()->id)
			message::error(__('You can\'t delete yourself'), 'admin/user');

		$user->remove(ORM::factory('role', 'login'));
		$user->remove(ORM::factory('role', 'admin'));
		$user->delete();

		message::info(__('User deleted successfully'), 'admin/user');
	}

}
