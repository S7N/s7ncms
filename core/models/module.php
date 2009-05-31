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

class Module_Model extends ORM {

	public function installed()
	{
		return $this->find_all();
	}
	
	public function enabled()
	{
		return $this->where('enabled', TRUE)->find_all();
	}
	
}