<?php defined('SYSPATH') or die('No direct script access.');

class Menu_Core {

	protected $menu;
	protected $menu_as_array = array();

	public function __construct()
	{
		$this->menu = new Menu_Model;
	}

	public function __toString()
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

		$html = '<ul>'."\n";
		$current_level = 1;

		foreach ($this->menu_as_array as $item)
		{
			$has_children = (bool) ( ($item['right'] - $item['left'] - 1) > 0 );
			$id = 'item'.$item['id'];
			$class = (strpos($current_url, $item['uri']) === 0) ? 'active' : '';
				
			$value = html::anchor($item['uri'], $item['title']);
				
			if ($has_children === TRUE)
			{
				if ($current_level > $item['level'])
				{
					$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
					$html .= '<li class="'.$class.'" id="'.$id.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
				else
				{
					$html .= '<li class="'.$class.'" id="'.$id.'">'.$value."\n";
					$html .= '<ul>'."\n";
				}
			}
			elseif ($current_level > $item['level'])
			{
				$html .= str_repeat("</ul></li>\n",($current_level - $item['level']));
				$html .= '<li class="'.$class.'" id="'.$id.'">'.$value.'</li>'."\n";
			}
			else
			{
				$html .= '<li class="'.$class.'" id="'.$id.'">'.$value.'</li>'."\n";
			}

			$current_level = $item['level'];
		}

		$html .= str_repeat("</ul></li>\n",$current_level-2);
		$html .= '</ul>';

		return $html;
	}

}