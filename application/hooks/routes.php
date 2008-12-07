<?php defined('SYSPATH') or die('No direct script access.');

Event::add_before('system.routing', array('Router', 'setup'), 'new_route');

function new_route() {
	if(empty(Router::$current_uri)) {
		return true;
	}
	
	$segments = explode('/', Router::$current_uri);
	
	if (count($segments) != 2) {
		return true;
	}
	
	$db = new Database();
	$query = $db->query("
		SELECT id
		FROM pages 
		WHERE content_id IN (
			SELECT id 
			FROM content 
			WHERE uri = '".$segments[1]."'
		)
		LIMIT 1
	");
	
	// how many pages were found?
	if (count($query) != 1) {
		return true;
	}
	
	Router::$current_uri = '/pages/'.$segments[1];	
}