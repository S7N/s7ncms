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
class Widget_Core {

	protected $config = array();

	public function __construct($config = array())
	{
		$this->initialize($config);
	}

	public static function factory($widget, $config = array())
	{
		if ($file = Kohana::find_file('widgets', $widget))
		{
			require $file;
				
			$widget = ucfirst($widget).'_Widget';

			if (class_exists($widget))
				return new $widget($config);
		}

		throw new Kohana_Exception('core.resource_not_found', 'Widget', $widget);
	}

	public function __toString()
	{
		return $this->render();
	}

	public function render()
	{
		return '';
	}

	public function initialize($config = array())
	{
		$this->config = $config;
	}

}