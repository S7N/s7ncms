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

class Page_Model extends ORM {

	protected $has_many = array('contents' => 'content_types');
	protected $belongs_to = array('author' => 'user');
	
	public function content()
	{
		$this->where(array('language_id' => language::$id));
		
		return $this->contents->current();
	}
	
}