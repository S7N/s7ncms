<?php defined('SYSPATH') or die('No direct script access.');

class Newroute {
    public function __construct() {
        Event::add_before('system.routing', array('Router', 'setup'), array($this, 'new_route'));
    }
    
    public function new_route() {
        if(empty(Router::$current_uri)) {
    		return true;
    	}
    	
    	$segments = explode('/', Router::$current_uri);
    	
    	if (count($segments) != 1) {
    		return true;
    	}
    	
    	$db = new Database();
        $prefix = Config::item('database.table_prefix');
    	$query = $db->query("
    		SELECT id
    		FROM ".$prefix."pages 
    		WHERE content_id IN (
    			SELECT id 
    			FROM content 
    			WHERE uri = '".$segments[0]."'
    		)
    		LIMIT 1
    	");
    	
    	// how many pages were found?
    	if (count($query) != 1) {
    		return true;
    	}
    	
    	Router::$current_uri = '/pages/'.$segments[0];
    }
}

$newroute = new Newroute();
unset($newroute);
