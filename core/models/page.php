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

class Page_Model extends ORM {

	protected $has_many = array('contents' => 'content_types');
	protected $belongs_to = array('author' => 'user');
	private static $cache = array();

	public function content($language = FALSE)
	{
		$lang = $language ? language::id($language) : language::$id;
		
		if (isset(self::$cache[$lang][$this->id]))
			return self::$cache[$lang][$this->id];

		return self::$cache[$lang][$this->id] = ORM::factory('page', $this->id)->where(array('language_id' => $lang))->contents->current();
	}

	public function uri($language = FALSE)
	{
		$cache_name = sha1('page_uri' . $this->id . ($language ? $language : language::$tag));
		
		if (($cache = Cache::instance()->get($cache_name)) !== NULL)
			return $cache;
		
		$menu_item = ORM::factory('menu')->where('page_id', $this->id)->find();

		$parents = $menu_item->parents()->find_all();

		$uri = array();
		foreach ($parents as $parent)
			if ($parent->lvl !== 0)
				$uri[] = ORM::factory('page', $parent->id)->content($language)->uri;

		if ($menu_item->lvl !== 0)
			$uri[] = $this->content($language)->uri;
			
		$uri = implode('/', $uri).'/';
		
		Cache::instance()->set($cache_name, $uri, array('page'));
		
		return $uri;
	}

}