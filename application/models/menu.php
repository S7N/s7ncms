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
class Menu_Model extends Model {

	protected $tree = array();

	public function as_array()
	{
		if ( ! empty($this->tree))
			return $this->tree;

		$table_prefix = Config::item('database.default.table_prefix');

		$result = $this->db->query("
			SELECT
				s.id,
				s.title,
				s.uri,
				count(*)+(s.l>1)-1 AS level,
				s.l,
				s.r
			FROM
				".$table_prefix."menu v,
				".$table_prefix."menu s 
			WHERE
				(v.l <= s.l AND s.l <= v.r)
				AND s.l != 1
			GROUP BY
				s.id 
			ORDER BY
				s.l;
		");

		if(count($result) > 1)
		{
			foreach ($result as $entry)
			{
				$this->tree[] = array(
					'id' => $entry->id,
					'title' => $entry->title,
					'uri' => $entry->uri,
					'level' => $entry->level,
					'left' => $entry->l,
					'right' => $entry->r,
					'is_active' => FALSE
				);
			}
		}

		return $this->tree;
	}

}