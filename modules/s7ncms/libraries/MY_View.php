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
class View extends View_Core {

	public function set_filename($name, $type = NULL)
	{
		$theme = Kohana::config('s7n.theme');

		if (Kohana::config('s7n.use_admin_theme'))
			$theme = 'admin';

		if ($path = Kohana::find_file('themes/'.$theme.'/views', $name) OR
			$path = Kohana::find_file($theme.'/views', $name) OR
			$path = Kohana::find_file('default/views', $name))
		{
			$this->kohana_filename = $path;
			$this->kohana_filetype = EXT;
		}
		else
		{
			parent::set_filename($name, $type);
		}

		return $this;
	}

}