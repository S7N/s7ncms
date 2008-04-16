<?php defined('SYSPATH') or die('No direct script access.');

class Newroute {

    public function __construct()
	{
        Event::add_before('system.routing', array('Router', 'setup'), array($this, 'new_route'));
    }

    public function new_route()
	{
        if(empty(Router::$current_uri))
    		return TRUE;

    	$segments = explode('/', Router::$current_uri);

    	/**
    	 * Don't rewrite the route if we have other than one segments
    	 */
    	if (count($segments) != 1)
    		return TRUE;
		
    	/**
    	 * Don't rewrite the route if the first segment is 'admin'
    	 */
    	if ($segments[0] === 'admin')
    		return TRUE;

    	$db = new Database();
        $query = $db->select('id')->limit(1)->getwhere('pages', array('uri =' => $segments[0]));

    	/**
    	 * how many pages were found?
    	 */
    	if (count($query) != 1)
    		return true;

    	Router::$current_uri = '/page/'.$segments[0];
    }

}

new Newroute();