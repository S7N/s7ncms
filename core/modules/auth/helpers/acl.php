<?php

class Acl extends Acl_Core
{
	public static function current_page()
	{
		$instance = self::instance();
		if($instance->check_access() == FALSE)
		{
			echo "YOU NO NOT HAVE ACCESS! :-)";
		}
	}
}