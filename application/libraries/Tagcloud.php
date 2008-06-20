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
class Tagcloud_Core {
	private $config;
	private $tags = array();

	public function __construct($tags = array(), $config = array())
	{
		$this->config = (array) $config + Config::item('tagcloud');


		if(is_null($this->config['uri']))
		{
			$uri = explode('/', Router::$current_uri);
			$this->config['uri'] = $uri[0];
		}

		$this->tags = $tags;
	}

	public function __toString()
	{
		return View::factory('tagcloud')->set('tags', $this->render())->render();
	}

	public function render()
	{
		asort($this->tags);
		$min = current($this->tags);
		$max = end($this->tags);
		$range = $max - $min;
	  
		if ($this->config['sortby'] === 'name')
		{
			ksort($this->tags);
		}
		else
		{
			arsort($this->tags);
		}
	  
	  
		$tags = array();
		foreach($this->tags as $tag => $weight)
		{
			if($range > 0)
			{
				$size = ceil($this->config['maxsize'] * ($weight - $min) / $range);
			}
			else
			{
				$size = ceil($this->config['maxsize'] * ($weight - $min));
			}
			 
			$size += $size > $this->config['minsize'] ? 0 : $this->config['minsize'];
			 
			$tags[] = array
			(
	        	'name' => $tag,
	        	'size' => $size,
	        	'uri' => $this->config['uri'].'/tag/'.$tag
			);
		}

		return $tags;
	}
}