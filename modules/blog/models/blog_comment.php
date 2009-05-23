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
class Blog_comment_Model extends ORM {

	protected $belongs_to = array('blog_post', 'user');

	protected $sorting = array('id' => 'ASC');
	
	public function delete($id = NULL)
	{
		$post = ORM::factory('blog_post', (int) $this->blog_post_id);
		$post->comment_count -= 1;
		$post->save();
		
		parent::delete($id);
	}

}