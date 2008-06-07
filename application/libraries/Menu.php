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
class Menu_Core {

	protected $menu;
	protected $menu_as_array = array();

	public function __construct()
	{
		$this->menu = new Menu_Model;
	}

	public function __toString()
	{
		return $this->render();
	}
	
	public function render($id = NULL, $include_anchors = TRUE)
	{
		empty($this->menu_as_array)
			AND $this->menu_as_array = $this->menu->as_array();

		// return null if we have no menu items
		$size = count($this->menu_as_array);
		if ($size == 0)
			return null;

		// remove 'page/' from current uri
		$current_url = url::current();
		if (strpos($current_url, 'page/') === 0)
			$current_url = substr($current_url, 5);

		// search for aktive menu item
		for($i = count($this->menu_as_array)-1; $i >= 0; $i--)
		{
			if (strpos($current_url, $this->menu_as_array[$i]['uri']) === 0)
			{
				$this->menu_as_array[$i]['is_active'] = TRUE;
				break;
			}
		}

		$id = ($id === NULL) ? '' : ' id="'.$id.'"';
		$html = '<ul'.$id.'>'."\n";
		$current_level = 1;

		foreach ($this->menu_as_array as $item)
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
				//$value = '<span class="test">'.$item['title'].'</span>';
				$value = $item['title'].' <span class="delete_node">(del)</span>';
			}
				
			if ($has_children === TRUE)
			{
				if ($current_level > $item['level'])
				{
					$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
					$html .= '<li id="'.$id.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
				else
				{
					$html .= '<li id="'.$id.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
			}
			elseif ($current_level > $item['level'])
			{
				$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
				$html .= '<li id="'.$id.'">'.$value.'</li>'."\n";
			}
			else
			{
				$html .= '<li id="'.$id.'">'.$value.'</li>'."\n";
			}

			$current_level = $item['level'];
		}

		$html .= str_repeat("</ul></li>\n",$current_level-2);
		$html .= '</ul>';

		return $html;
	}

}