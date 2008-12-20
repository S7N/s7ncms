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
 * @version $Id:Tagcloud.php 151 2008-07-24 16:06:21Z eduardbaun $
 */
class Tagcloud_Widget extends Widget {

	public function initialize($config = array())
	{
		$this->config = (array) $config + Kohana::config('tagcloud');
	}

	public function render()
	{
		return View::factory('widgets/tagcloud')->set(array(
			'tags' => new Tagcloud($this->config['tags'], $this->config['minsize'], $this->config['maxsize'], $this->config['shuffle'])
		))->render();
	}

}