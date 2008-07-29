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
class Sidebar_Core {
	
	private static $instance;
	
	protected $widgets = array();
	
	public function __construct()
	{
		if (self::$instance === NULL)
		{
			self::$instance = $this;
		}
	}
	
	public static function instance()
	{
		if (self::$instance == NULL)
		{
			new Sidebar;
		}

		return self::$instance;
	}
	
	public function add($widget, $config = NULL)
	{
		$this->widgets[] = array
		(
			'name' => $widget,
			'config' => $config
		);
	}
	
	public function __toString()
	{
		return $this->render();
	}
	
	public function render()
	{
		$output = '';
		foreach ($this->widgets as $widget)
		{
			if (is_string($widget['name']))
			{
				$output .= Widget::factory($widget['name'], $widget['config'])->render();
			}
			elseif (is_object($widget['name']))
			{
				$output .= $widget['name']->render();
			}
		}
		
		return $output;
	}
	
}