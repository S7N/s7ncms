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

	protected $sorting = array('lft' => 'ASC');

	/**
	 * Allows Pages to be loaded by id or uri title.
	 */
	public function unique_key($id = NULL)
	{
		if( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
			return 'uri';

		return parent::unique_key($id);
	}

	public function url()
    {
        return $this->uri;
    }

    public function paths()
    {
		$pages = $this->find_all();

		$paths = array('' => 'Do not Redirect');
		foreach ($pages as $page)
		{
			$titles = array();
			$uris = array();

			$path = $page->path();
			foreach ($path as $page)
			{
				if ($page->level == 0 OR $page->uri == $this->uri)
				{
					continue;
				}
				$titles[] = $page->title;
				$uris[] = $page->uri;
			}

			if ( ! empty($titles))
				$paths[implode('/', $uris)] = implode(' &rarr; ', $titles);
		}

		return $paths;
    }

}