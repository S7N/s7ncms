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

		if (Kohana::find_file('views/'.$theme.'/html', $name))
			parent::set_filename($theme.'/html/'.$name, $type);
		elseif (Kohana::find_file('views/default/html', $name))
			parent::set_filename('default/html/'.$name, $type);
		else
			parent::set_filename($name, $type);

		return $this;
	}

}