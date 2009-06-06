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

class Menu_Core {

	public static $instance = NULL;
	protected $scope;
	protected $include_root;
	protected $items = array();

	public static $page = NULL;
	public static $page_id = NULL;

	public function __construct($scope = 'main', $include_root = FALSE)
	{
		$this->scope = $scope;
		$this->include_root = $include_root;
	}

	public function __toString()
	{
		try {
			return (string) $this->render();
		} catch (Exception $e) {
			return $e->getMessage();
		}

	}

	protected function render($id = NULL)
	{
		$output = '';

		if ($id === NULL)
		{
			$cache_name = sha1('menu' . language::$tag . Menu::$page_id . $this->scope);

			if (($cache_output = Cache::instance()->get($cache_name)) !== NULL)
				return $cache_output;

			foreach ($this->items() as $item)
				$item->rendered = FALSE;

			$output = '<ul class="nav">';

			foreach ($this->items() as $item)
			{
				if ($item->lvl == 0)
				{
					if ($this->include_root)
					{
						$class = $item->id === Menu::$page_id ? 'active' : '';
						$output .= '<li class="'.$class.'">'.html::anchor($item->uri, html::specialchars($item->title), array('class' => $class)).'</li>';
					}

					continue;
				}

				$output .= $this->render($item->id);
			}

			$output .= '</ul>';

			Cache::instance()->set($cache_name, $output, array('menu'));
		}
		else
		{
			$item = $this->items($id);

			if ($item === FALSE)
				return '';

			$class = $item->active === TRUE ? 'active' : '';

			if (empty($item->children))
			{
				$output .= '<li class="'.$class.'">'.html::anchor($item->uri, html::specialchars($item->title), array('class' => $class)).'</li>';
			}
			else
			{
				$output .= '<li class="'.$class.'">'.html::anchor($item->uri, html::specialchars($item->title), array('class' => $class));
				$output .= '<ul>';

				foreach ($item->children as $child)
					$output .= $this->render($child->id);

				$output .= '</ul></li>';
			}

			$this->rendered = TRUE;
		}

		return $output;
	}

	public function items($id = NULL)
	{
		if ($id !== NULL)
		{
			if (array_key_exists($id, $this->items))
				return $this->items[$id];

			return FALSE;
		}

		if (empty($this->items))
		{
			$menu_items = ORM::factory('menu')->root($this->scope)->descendants(TRUE)->find_all();

			foreach ($menu_items as $item)
			{
				$menu = new Menu_Item;
				$page = ORM::factory('page', $item->page_id);

				$menu->id = (int) $page->id;
				$menu->title = $page->content()->menu_title;
				$menu->uri = $page->uri();
				$menu->parent = (int) $item->parent()->id;
				$menu->lvl = (int) $item->lvl;

				$this->items[$menu->id] = $menu;

				if ($menu->parent > 0)
					$this->items[$menu->parent]->append_child($menu->id);

				if ($menu->id === Menu::$page_id)
					$this->set_active($menu->id);
			}
		}

		return $this->items;
	}

	public function set_active($id)
	{
		if ($id === 0)
			return;

		$item = $this->items($id);

		if ($item === FALSE)
			return;

		$item->active = TRUE;

		$this->set_active($item->parent);
	}

	public static function home_page_id()
	{
		$root = ORM::factory('menu')->root('main');

		if ( ! $root->loaded)
			return NULL;

		return $root->page_id;
	}

	public static function breadcrumb()
	{
		$cache_name = sha1('menu_breadcrumb' . language::$tag . Menu::$page_id . 'main');

		if (($cache_output = Cache::instance()->get($cache_name)) !== NULL)
			return $cache_output;

		$item = ORM::factory('menu')->where(array('page_id' => Menu::$page_id, 'scope' => 'main'))->find();

		$output = '<ul class="breadcrumb">';
		if ($item->loaded)
		{
			$parents = $item->parents()->find_all();
			foreach ($parents as $parent)
			{
				$page = ORM::factory('page', $parent->page_id);
				$uri = $parent->lvl === 0 ? '/' : $page->content()->uri;
				$output .= '<li>'.html::anchor($uri, $page->content()->menu_title);
			}

			$page = ORM::factory('page', Menu::$page_id);
			$uri = $item->is_root() ? '/' : $page->content()->uri;
			$output .= '<li>'.html::anchor($uri, $page->content()->menu_title).'</li>';
		}
		$output .= '</ul>';

		Cache::instance()->set($cache_name, $output, array('menu'));

		return $output;
	}

}

class Menu_Item {

	public $id = 0;
	public $title;
	public $uri;
	public $parent = 0;
	public $level = 0;
	public $children = array();
	public $rendered = FALSE;
	public $active = FALSE;

	public function append_child($id)
	{
		$this->children[] = $id;
	}
}