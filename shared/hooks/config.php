<?php defined('SYSPATH') or die('No direct script access.');

class Newconfig {

    public function __construct()
	{
        Event::add('system.ready', array($this, 'new_config'));
    }
	
	public function new_config()
	{
		$db = new Database();
		
		$query = $db->select('key, value')
			->from('config')
			->get();
        
        $result = $query->result();
        
		foreach ($result as $item)
            Config::set('s7n.'.$item->key, $item->value);
    }

}

new Newconfig;
