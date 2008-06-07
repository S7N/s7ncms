<?php defined('SYSPATH') or die('No direct script access.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2008, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2008
 * @version $Id$
 */
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
