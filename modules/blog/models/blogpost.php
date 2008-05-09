<?php defined('SYSPATH') or die('No direct script access.');

class Blogpost_Model extends ORM {
	
	protected $has_many = array('comments');
	protected $belongs_to = array('user');
	
	/**
	 * Allows Blogposts to be loaded by id or uri title.
	 */
	protected function where_key($id = NULL)
	{
		if(! ctype_digit($id))
		{
			return 'uri';
		}
		
		return parent::where_key($id);
	}
	
	/**
	 * increment the comment counter on each new comment
	 */
	public function add_comment($object)
	{
		$this->comment_count += 1;
		
		/*
		 * set the user_id if the poster is logged in
		 */
		if(isset($_SESSION['auth_user']))
			$object->user_id = $_SESSION['auth_user']->id;

		// we have to call __call because add_ is a magic method
		parent::__call('add_comment', array($object));
		
		// save comment count update
		$this->save();
	}
	
	public function count_posts()
	{
		return count(Database::instance()->select('id')->get('blogposts'));
	}
	
}
