<?php

class Acl extends Auth
{
	public static function check_access()
	{
		if($inst = parent::instance()->logged_in())
		{
			if(!self::check())
			{
				//401 ERROR
			}
		}
		else
		{
			//TODO: Change 1 for default anonomous user
			if(!self::check(1))
			{
				//401 ERROR	
			}
		}
	}
	
	private static function check($access = FALSE)
	{
		return $access ? $access : parent::instance()->get_user()->access >= Menu::$page->access ? TRUE : FALSE ;
	}
}