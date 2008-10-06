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
class Modules_Model extends Model {

	public function get()
	{
		$query = $this->db->get('modules');

		if(count($query) > 0)
		{
			$modules = array();
			foreach($query->result() as $result)
			{
				if( ! is_file(MODPATH.$result->name.'/module.xml'))
					continue;
					
				$modules[] = array(
					'xml' => simplexml_load_file(MODPATH.$result->name.'/module.xml'),
					'db' => $result
				);
			}
				
			return $modules;
		}

		return array();
	}

	public function status($module, $status)
	{
		return $this->db->update('modules', array('status' => (string) $status), array('name' => (string) $module));
	}

	public function not_installed()
	{
		$installed_modules = array();

		$query = $this->db->select('name')->get('modules');
		if(count($query) > 0)
		{
			foreach($query->result() as $row)
			{
				$installed_modules[] = $row->name;
			}
		}
		unset($query);
		 
		// read all modules
		$modules = array();
		if ($dh = opendir(MODPATH))
		{
			while(($file = readdir($dh)) !== FALSE)
			{
				$path = MODPATH.$file.'/module.xml';
				if (is_file($path) AND ! in_array($file, $installed_modules))
				{
					$modules[] = simplexml_load_file($path);
				}
			}
		}
		 
		return $modules;
	}

}