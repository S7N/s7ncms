<?php

final class Acl {
	
	protected $auth_instance;
	
	public static function current_page()
	{
		$instance = self::instance();
		if($instance->check_access() == FALSE)
		{
			echo "YOU NO NOT HAVE ACCESS! :-)";
		}
	}

	public static function instance()
	{
		static $instance;

		empty($instance) and $instance = new Acl();

		return $instance;
	}
	
	public function _contruct($auth = FALSE)
	{
		$auth_instance = $auth ? Auth::instance() : $auth;
	}
	
	public function check_access($item = FALSE)
	{
		//Get either the current or supplied item.
		$item = $item ? $item : Router::$page;	
		
		//Cross reference access with the current user
		if($auth_instance->get_user()->access >= $item->access) return true;
		else return false;	
	}
}