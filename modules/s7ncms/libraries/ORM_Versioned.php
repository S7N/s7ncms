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
class ORM_Versioned_Core extends ORM {

	protected $last_version = NULL;
	
	/**
	 * Overload ORM::save() to support versioned data
	 *
	 * @chainable
	 * @return  ORM
	 */
	public function save()
	{
		$this->last_version = 1 + ($this->last_version === NULL ? $this->object['version'] : $this->last_version);
		$this->__set('version', $this->last_version);
		
		parent::save();

		$data = array();
		foreach ($this->object as $key => $value)
		{
			if ($key == 'id')
				continue;

			$data[$key] = $value;
		}
		$data[$this->foreign_key()] = $this->id;

		$query = $this->db->insert($this->table_name.'_versions', $data);

		return $this;
	}
	
	/**
	 * Loads previous version from current object
	 *
	 * @chainable
	 * @return  ORM
	 */
	public function previous()
	{
		if ($this->loaded)
		{
			$this->last_version = ($this->last_version === NULL) ? $this->object['version'] : $this->last_version;
			$version = $this->last_version - 1;

			$this->db->where($this->foreign_key(), $this->object[$this->primary_key]);
			$this->db->where('version', $version);
			$result = $this->db->get($this->table_name.'_versions');

			if ($result->count() === 1)
			{
				$this->load_values($result->result(FALSE)->current());
			}
		}

		return $this;
	}

	/**
	 * Restores the object with data from stored version
	 *
	 * @param   integer  version number you want to restore
	 * @return  ORM
	 */
	public function restore($version)
	{
		if ($this->loaded)
		{
			$this->db->where($this->foreign_key(), $this->object[$this->primary_key]);
			$this->db->where('version', $version);
			$query = $this->db->get($this->table_name.'_versions');
	
			if ($query->count() === 1)
			{
				$row = $query->as_array();
				foreach ($row[0] as $key => $value)
				{
					if ($key == $this->primary_key OR $key == $this->foreign_key())
						continue;
	
					if ($key == 'version')
						$this->__set('version', $this->object['version']);
					else
						$this->__set($key, $value);
				}
	
				$this->save();
			}
		}

		return $this;
	}
	
	/**
	 * Overloads ORM::delete() to delete all versioned entries of current object
	 * and the object itself
	 *
	 * @param   integer  id of the object you want to delete
	 * @return  ORM
	 */
	public function delete($id = NULL)
	{
		if ($id === NULL AND $this->loaded)
			$this->db->where($this->foreign_key(), $this->object[$this->primary_key]);
		else
			$this->db->where($this->foreign_key(), $id);
		
		$this->db->delete($this->table_name.'_versions');

		return parent::delete($id);
	}

}