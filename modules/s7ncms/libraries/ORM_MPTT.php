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
class ORM_MPTT_Core extends ORM_Tree_Core {

	// Left number column name
	protected $left_column = 'lft';
	
	// Right number column name
	protected $right_column = 'rgt';
	
	// Path of a Node
	protected $path = array();
	
	/**
	 * Overload ORM::__get to support "descendants" property.
	 *
	 * @param   string  column name
	 * @return  mixed
	 */
	public function __get($column)
	{
		if ($column === 'descendants')
		{
			if (empty($this->related[$column]))
			{
				$left_column = $this->left_column;
				
				$this->related[$column] = ORM::factory(inflector::singular($this->table_name))
					->from($this->table_name. ' AS v, '.$this->table_name.' AS s')
					->where('v.'.$this->left_column. ' <= s.'.$this->left_column)
					->where('s.'.$this->left_column. ' <= v.'.$this->right_column)
					->where('s.'.$this->left_column. ' != '.$this->$left_column)
					->groupby('s.'.$this->primary_key)
					->orderby('s.'.$this->left_column, 'ASC')
					->find_all();
			}

			return $this->related[$column];
		}
		
		return parent::__get($column);
	}
	
	/**
	 * Counts the number of children of the current node
	 *
	 * @return  integer  number of children
	 */
	public function count_children()
	{
		$left_column = $this->left_column;
		$right_column = $this->right_column;
		
		return ($this->$right_column - $this->$left_column - 1) / 2;
	}
	
	/**
	 * Checks if a node has children
	 *
	 * @return  boolean  
	 */
	public function has_children()
	{
		$left_column = $this->left_column;
		$right_column = $this->right_column;
		
		return ($this->$right_column - $this->$left_column) > 1;
	}
	
	/**
	 * Calculates the path from the rootnode to the current node
	 *
	 * @return  ORM_Iterator  Path to the current node
	 */
	public function path()
	{
		if (empty($this->path))
		{
			if ($this->loaded)
			{
				$left_column = $this->left_column;
				$right_column = $this->right_column;
				
				$this->path = $this
					->where($this->left_column.' <= '.$this->$left_column)
					->where($this->right_column.' >= '.$this->$right_column)
					->orderby($this->left_column, 'ASC')
					->find_all();
			}
		}
		
		return $this->path;
	}
	
	/**
	 * Adds a Child to the current node
	 *
	 * @param   ORM_MPTT  Node we want to add as a child
	 * @return  ORM
	 */
	public function add_child(ORM_MPTT $model)
	{
		if ( ! $this->loaded)
			return FALSE;
		
		$left_column = $this->left_column;
		$right_column = $this->right_column;
		
		// adjust left and right values
		$this->db->query("UPDATE ".$this->table_name." SET ".$this->left_column."=".$this->left_column."+2 WHERE ".$this->left_column." > ".$this->$right_column);
		$this->db->query("UPDATE ".$this->table_name." SET ".$this->right_column."=".$this->right_column."+2 WHERE ".$this->right_column." >= ".$this->$right_column);
		
		$parent_key = $this->parent_key;
		$model->$parent_key = $this->id;
		$model->$left_column = $this->$right_column;
		$model->$right_column = $this->$right_column + 1;
		$model->save();
		
		return $this;
	}
	
	/**
	 * Deletes the current node and its descendants
	 *
	 * @return  ORM
	 */
	public function delete($id = NULL)
	{
		$left_column = $this->left_column;
		$right_column = $this->right_column;
		
		$move = 2 * ($this->count_children() + 1);
		
		// adjust left and right values
		$this->db->query('UPDATE '.$this->table_name.' SET '.$this->left_column.'='.$this->left_column.'-'.$move.' WHERE '.$this->left_column.' > '.$this->$right_column);
		$this->db->query('UPDATE '.$this->table_name.' SET '.$this->right_column.'='.$this->right_column.'-'.$move.' WHERE '.$this->right_column.' > '.$this->$right_column);			
		
		// delete children
		$this->db
			->where($this->left_column.' < '.$this->$right_column)
			->where($this->left_column.' > '.$this->$left_column)
			->delete($this->table_name);
		
		// delete entry
		return parent::delete($id);
	}
	
	
	/**
	 * Saves the current node. If the node is new
	 * it will be the child of the root node
	 *
	 * @return ORM
	 */
	public function save()
	{
		$parent_key = $this->parent_key;
		$left_column = $this->left_column;
		$right_column = $this->right_column;
		
		if (is_null($this->parent_id))
		{
			// get root node
			$query = $this->db->select('id', $this->left_column, $this->right_column)->where($this->left_column, 1)->limit(1)->get($this->table_name)->current();

			// adjust the right value of the root node
			$this->db->query('UPDATE '.$this->table_name.' SET '.$this->right_column.'='.($query->$right_column + 2).' WHERE id = '.$query->id);
			
			// add parent_id, left and right to the new node
			$this->$parent_key = $query->id;
			$this->$left_column = $query->$right_column;
			$this->$right_column = $query->$right_column + 1;
		}
			
		return parent::save();
	}

}