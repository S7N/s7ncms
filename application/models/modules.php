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
class Modules_Model extends Model {

	public function get()
	{
		$query = $this->db->get('modules');
		
		if(count($query) > 0)
		{
			$modules = array();
			foreach($query->result() as $result)
			{
				if( ! file_exists(MODPATH.$result->name.'/module.xml'))
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
		return $this->db->update('modules', array('status' => (string)$status), array('name' => (string)$module));
	}
	
	public function not_installed()
	{
		$modules = array();
		
		// read all modules
		if ($dh = opendir(MODPATH))
    	{
    		while(($file = readdir($dh)) !== FALSE)
    		{
    			if (file_exists(MODPATH.$file.'/module.xml'))
    			{
    				$modules[] = $file;
    			}
    		}
    	}
    	
    	//remove installed modules
    	$query = $this->db->get('modules');
    	
    	if(count($query) > 0)
    	{
    		foreach($query->result() as $row)
    		{
    			if(in_array($row->name, $modules))
    			{
    				unset($modules[key($modules)]);
    			}
    		}
    	}
    	
    	// create xml objects for each module
    	foreach($modules as $module)
    	{
    		$modules[key($modules)] = simplexml_load_file(MODPATH.$module.'/module.xml');
    	}
    	
    	return $modules;
	}

}