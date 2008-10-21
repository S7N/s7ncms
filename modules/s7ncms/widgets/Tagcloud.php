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
	
	private $tags = array();
	
	public function initialize($config = array())
	{
		$this->config = (array) $config + Kohana::config('tagcloud');

		if (is_null($this->config['uri']))
		{
			$this->config['uri'] = Router::$routed_uri;
		}
	}
	
	public function render()
	{
		asort($this->config['tags']);
		$min = current($this->config['tags']);
		$max = end($this->config['tags']);
		$range = $max - $min;
	  
		if ($this->config['sortby'] === 'name')
		{
			ksort($this->config['tags']);
		}
		else
		{
			arsort($this->config['tags']);
		}
	  
		$tags = array();
		foreach ($this->config['tags'] as $tag => $weight)
		{
			if ($range > 0)
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
	        	'uri'  => $this->config['uri'].'/tag/'.$tag
			);
		}
	
		return View::factory('widgets/tagcloud')->set(array('tags' => $tags))->render();
	}
	
}