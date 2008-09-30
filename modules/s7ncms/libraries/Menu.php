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
class Menu_Core {

	protected $menu = array();
	protected $submenu = array();

	static $obj = NULL;

	public function __construct()
	{
		$this->menu = $this->as_array();
	}

	public static function instance($config = array())
	{
		(self::$obj === NULL) and self::$obj = new Menu($config);

		return self::$obj;
	}

	public function __toString()
	{
		return $this->render();
	}

	public function submenu($page)
	{
		$path = $page->path();
		$path->next();

		$this->submenu = $this->as_array($path->current()->descendants);

		$uri = array($path->current()->uri);

		$size = count($this->submenu);
		if ($size == 0)
			return null;

		// remove 'page/' from current uri
		$current_url = url::current();
		if (strpos($current_url, 'page/index/') === 0)
			$current_url = substr($current_url, 11);

		// search for active menu item
		for($i = $size-1; $i >= 0; $i--)
		{
			if ($current_url == $this->submenu[$i]['id'])
			{
				$this->submenu[$i]['is_active'] = TRUE;

				$parent_id = $this->submenu[$i]['parent_id'];
				for($j = 0; $j < $size; $j++)
				{
					if ($this->submenu[$j]['id'] == $parent_id)
					{
						$this->submenu[$j]['is_active'] = TRUE;
						$parent_id = $this->submenu[$j]['parent_id'];
						$j = -1;
					}
				}

				break;
			}
		}

		$html = '<ul class="submenu">'."\n";
		$current_level = 1;
		foreach ($this->submenu as $menu)
		{
			$has_children = (bool) ( ($menu['right'] - $menu['left'] - 1) > 0 );
			$class = $menu['is_active'] === TRUE ? 'active' : '';
				
			if ( $has_children === TRUE)
			{

				if ($current_level > $menu['level'])
				{
					array_pop($uri);
					array_push($uri, $menu['uri']);
					$value = html::anchor(implode('/', $uri), $menu['title'], array('class' => $class));
						
					$html .= str_repeat("</ul></li>\n",($current_level - $menu['level']));
					$html .= '<li class="'.$class.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
				else
				{
					array_push($uri, $menu['uri']);
					$value = html::anchor(implode('/', $uri), $menu['title'], array('class' => $class));
					$html .= '<li class="'.$class.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
			}
			elseif ($current_level > $menu['level'])
			{
				$count = $current_level - $menu['level'];

				for($i=0; $i < $count; $i++)
					array_pop($uri);

				array_push($uri, $menu['uri']);
				$value = html::anchor(implode('/', $uri), $menu['title'], array('class' => $class));
				$html .= str_repeat("</ul></li>\n",($count));
				$html .= '<li class="'.$class.'">'.$value.'</li>'."\n";
				array_pop($uri);
			}
			else
			{
				array_push($uri, $menu['uri']);
				$value = html::anchor(implode('/', $uri), $menu['title'], array('class' => $class));
				$html .= '<li class="'.$class.'">'.$value.'</li>'."\n";
				array_pop($uri);
			}

			$current_level = $menu['level'];
				
		}

		$html .= str_repeat("</ul></li>\n",$current_level-2);
		$html .= '</ul>';

		return $html;
	}

	public function render($id = NULL, $include_anchors = TRUE, $nested = FALSE)
	{
		// return null if we have no menu items
		$size = count($this->menu);
		if ($size == 0)
			return null;

		// remove 'page/' from current uri
		$current_url = url::current();
		if (strpos($current_url, 'page/index/') === 0)
			$current_url = substr($current_url, 11);

		// search for active menu item
		for($i = $size-1; $i >= 0; $i--)
		{
			if ($current_url == $this->menu[$i]['id'])
			{
				$this->menu[$i]['is_active'] = TRUE;

				$parent_id = $this->menu[$i]['parent_id'];
				for($j = 0; $j < $size; $j++)
				{
					if ($this->menu[$j]['id'] == $parent_id)
					{
						$this->menu[$j]['is_active'] = TRUE;
						$parent_id = $this->menu[$j]['parent_id'];
						$j = -1;
					}
				}

				break;
			}
		}

		//echo Kohana::debug($this->menu_as_array);

		$id = ($id === NULL) ? '' : ' id="'.$id.'"';
		$html = '<ul'.$id.' class="menu">'."\n";
		$current_level = 1;

		foreach ($this->menu as $item)
		{
			$has_children = (bool) ( ($item['right'] - $item['left'] - 1) > 0 );
				
			$id = 'item'.$item['id'];
			$class = $item['is_active'] === TRUE ? 'active' : '';
				
			if ($include_anchors === TRUE)
			{
				$value = html::anchor($item['uri'], $item['title'], array('class' => $class));
			}
			else
			{
				$value = $item['title'].' <span class="delete_node">(del)</span>';
			}

			if($nested === TRUE)
			{
				if ( $has_children === TRUE)
				{
					if ($current_level > $item['level'])
					{
						$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
						$html .= '<li id="'.$id.'" class="'.$class.'">'.$value."\n";
						$html .= '<ul>'."\n";
					}
					else
					{
						$html .= '<li id="'.$id.'" class="'.$class.'">'.$value."\n";
						$html .= '<ul>'."\n";
					}
				}
				elseif ($current_level > $item['level'])
				{
					$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
					$html .= '<li id="'.$id.'" class="'.$class.'">'.$value.'</li>'."\n";
				}
				else
				{
					$html .= '<li id="'.$id.'" class="'.$class.'">'.$value.'</li>'."\n";
				}

				$current_level = $item['level'];
			}
			else
			{
				if ($item['level'] > $current_level)
				{
					continue;
				}

				$html .= '<li id="'.$id.'" class="'.$class.'">'.$value.'</li>'."\n";
			}
		}

		$html .= str_repeat("</ul></li>\n",$current_level-1);
		$html .= '</ul>';

		return $html;
	}

	public function as_array($object = NULL)
	{
		if ($object === NULL)
		{
			$result = Database::instance()
				->select('id, parent_id, uri, title, level, lft, rgt')
				->where('level > 0')
				->orderby('lft', 'ASC')
				->get('pages');
		}
		else
		{
			$result = $object;
		}

		if(count($result) > 1)
		{
			foreach ($result as $entry)
			{
				$tree[] = array(
					'id' => $entry->id,
					'parent_id' => $entry->parent_id,
					'title' => $entry->title,
					'uri' => $entry->uri,
					'level' => $entry->level,
					'left' => $entry->lft,
					'right' => $entry->rgt,
					'is_active' => FALSE
				);
			}
		}

		return $tree;
	}

}