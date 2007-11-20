<?php defined('SYSPATH') or die('No direct script access.');

class User_Model extends ORM {

	protected $_relationships = array
	(
		'belongs_to' => array('group')
		// 'has_many' => array('groups')
	);

}