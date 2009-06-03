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

class Menu_Model extends ORM_MPTT {

	protected $belongs_to = array('page');

	public function title()
	{
		return ORM::factory('page', $this->page_id)->content()->menu_title;
	}

}