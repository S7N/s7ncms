<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auth_Controller extends Frontend_Controller {
		
	public function register()
	{
    	$this->title = "Register to s7n!";
		 
		$form = Formo::factory()
			->plugin('orm', 'mval')
			->orm('user')
			->add('password_conf')
			->add('submit', 'Register');
			
		$this->content = $form;
		
		if ($form->validate())
		{
		  $form->save();
		}
	}
	
	public function login() {}
}