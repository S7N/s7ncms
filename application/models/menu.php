<?php defined('SYSPATH') or die('No direct script access.');

class Menu_Model extends Model {

	protected $tree = array();

	public function as_array()
	{
		if ( ! empty($this->tree))
			return $this->tree;

		$table_prefix = Config::item('database.table_prefix');

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
				);
			}
		}

		return $this->tree;
	}

}