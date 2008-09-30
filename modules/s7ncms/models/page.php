<?php
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
class Page_Model extends ORM_MPTT {
	
	protected $children = 'pages';

	protected $belongs_to = array('user');

	/**
	 * Allows Pages to be loaded by id or uri title.
	 */
	public function unique_key($id = NULL)
	{
		if( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
		{
			return 'uri';
		}

		return parent::unique_key($id);
	}
	
	public function get_url()
    {
        return $this->uri;
    }

}