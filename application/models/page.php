<?php defined('SYSPATH') or die('No direct script access.');

class Page_Model extends ORM {

	protected $belongs_to = array('user');

	/**
	 * Allows Pages to be loaded by id or uri title.
	 */
	protected function where_key($id = NULL)
	{
		if(! ctype_digit($id))
		{
			return 'uri';
		}

		return parent::where_key($id);
	}

}