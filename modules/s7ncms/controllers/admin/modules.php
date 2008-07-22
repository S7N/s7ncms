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
class Modules_Controller extends Administration_Controller {

	public  function __construct()
	{
		parent::__construct();
		
		$this->template->tasks = array(
			array('admin/modules/install', 'Install New Modules')
		);
		
		$this->head->title->append('Modules');
	}
	public function index()
	{
        $this->template->title = 'Modules';
		$this->template->content = new View('modules/index');
		
		$modules = new Modules_Model;
		$this->template->content->modules = $modules->get();
    }
    
    public function status()
    {
    	$module = new Modules_Model;
    	
    	$status = $module->status($this->uri->segment(4), $this->uri->segment(5));
    	
    	url::redirect('admin/modules');
    }
    
    public function install($module = NULL)
    {
    	if ($module !== NULL)
    	{
    		// check if module is installed
    		$query = $this->db->where('name', $module)->get('modules');
    		if(count($query) > 0)
    		{
    			$this->session->set_flash('error_message', 'This Module is already installed.');
    			url::redirect('admin/modules/install');
    		}
    		
    		
    		if ( ! is_file(MODPATH.$module.'/module.xml'))
    		{
    			$this->session->set_flash('error_message', 'Could not install module. The file module.xml was not found.');
    			url::redirect('admin/modules/install');
    		}
    			
    		$xml = simplexml_load_file(MODPATH.$module.'/module.xml');
    		$uri = trim((string)$xml->uri);
    		
    		if(empty($uri))
    		{
    			$this->session->set_flash('error_message', 'Could not install module. The file module.xml was not found.');
    			url::redirect('admin/modules/install');
    		}
    		
    		$this->db->insert('modules', array('name' => $uri, 'status' => 'on'));
    		
	    	if (is_file(MODPATH.$module.'/module.sql'))
	    	{
	    		$sql = file_get_contents(MODPATH.$module.'/module.sql');
	    		$sql = preg_replace('/\{table_prefix\}/i', Kohana::config('database.default.table_prefix'), $sql);
	    		$queries = preg_split("/;[\r?\n]+/i", $sql);
	    		foreach ($queries as $query)
	    		{
		    		$query = trim($query);
					if (empty($query))
						continue;
					
					$this->db->query($query);
	    		}
	    	}
	    	
	    	if(isset($xml->config))
	    	{
		    	foreach($xml->config as $item)
		    	{
		    		$key = trim((string) $item->key);
		    		$value = trim((string) $item->value);
		    		
		    		if(!empty($key))
		    		{
			    		$this->db->insert('config', array(
			    			'context' => $module,
			    			'key' => $key,
			    			'value' => $value
			    		));
		    		}
		    	}
	    	}
	    	
	    	$this->session->set_flash('info_message', 'Module installed successfully.');
	    	url::redirect('admin/modules/install');
    	}
    	
    	$this->head->title->append('Install');
    	$this->template->title = 'Modules | Install';
    	
    	$modules = new Modules_Model;
    	$this->template->content = new View('modules/install');
    	$this->template->content->modules = $modules->not_installed();
    }
    
    public function uninstall($module)
    {
    	$xml = simplexml_load_file(MODPATH.$module.'/module.xml');
    	
    	// delete tables
    	$sql = 'DROP TABLE IF EXISTS';
    	foreach($xml->tables->name as $table)
    		$sql .= ' '. Kohana::config('database.default.table_prefix') . (string) $table . ',';

    	// Remove last comma
    	$sql = substr($sql, 0, -1);
    	
    	$this->db->query($sql);
    	
    	// delete entry in modules table
    	$this->db->delete('modules', array('name' => $module));
    	
    	if(isset($xml->config))
    	{
	    	foreach($xml->config as $item)
	    	{
	    		$key = trim((string) $item->key);
	    		$value = trim((string) $item->value);
	    		
	    		if(!empty($key))
	    		{
		    		$this->db->insert('config', array(
		    			'context' => $module,
		    			'key' => $key,
		    			'value' => $value
		    		));
	    		}
	    	}
    	}
    	
    	$this->session->set_flash('info_message', 'Module uninstalled successfully.');
    	
    	url::redirect('admin/modules');
    }

}