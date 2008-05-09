<?php defined('SYSPATH') or die('No direct script access.');

class Comment_Model extends ORM {
	protected $belongs_to = array('blogpost', 'user');
	
	public function __set($key, $value)
	{
		/*
		 * We need to convert these keys with htmlspecialchars
		 */
		$keys = array('author', 'content', 'agent', 'url');		
		in_array($key, $keys) AND $value = html::specialchars($value, TRUE);
		
		parent::__set($key, $value);
	}
}
