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
class menus_Core {
	
	private static $tree = NULL;
	public static $page_id = NULL;
	public static $page = NULL;
	public static $uri = array();
	public static $arguments = array();
	
	public static function find_page($uri)
	{
		$menu_items = self::items();
		
		// return FALSE if the menu tree is empty
		if (count($menu_items) == 0)
			return FALSE;
			
		// return the home page if uri is empty
		if(empty($uri))
		{
			self::$tree->rewind();
			
			$page = self::$tree->current()->page;
			self::$page_id = $page->id;
			
			return self::$page = $page;
		}
		
		$uri = explode('/', $uri);

		$load_module = FALSE;
		$found = FALSE;

		for ($level = 1; $level <= count($uri); $level++)
		{
			if ($level > count($menu_items))
			{
				self::$arguments[] = $uri[$level-1];
				continue;
			}

			if ($load_module === TRUE)
				self::$arguments[] = $uri[$level-1];

			foreach($menu_items[$level] as $item)
			{
				if($item['uri'] == $uri[$level-1] OR ($item['type'] == 'module' AND $item['target'] == $uri[$level-1]))
				{
					$found = TRUE;

					self::$page_id = $item['id'];

					self::$uri[] = $item['uri'];
					
					if ($item['type'] == 'module' AND ! empty($item['target']))
						$load_module = TRUE;

					continue 2;
				}
			}
		}
		
		return $found ? self::$page = ORM::factory('page', self::$page_id) : FALSE;
	}
	
	private static function items()
	{
		if (self::$tree === NULL)
			self::$tree = ORM::factory('menu')->find_all();

		$items = array();
		foreach (self::$tree as $item)
		{
			if ($item->lvl == 0) continue;

			$items[$item->lvl][] = array(
				'id' => $item->page_id,
				'uri' => $item->page->content()->uri,
				'type' => $item->page->type,
				'target' => $item->page->target
			);
		}
		
		return $items;
	}
}