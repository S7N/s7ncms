<?php defined('SYSPATH') or die('No direct script access.');

class hook_cache {

	protected $cache;

	public function __construct()
	{
		$this->cache = new Cache;

		// we dont cache administration pages
		if (strpos(Router::$current_uri, 'admin') !== 0)
		{
			Event::add_before('system.routing', array('Router', 'setup'), array($this, 'load_cache'));
		}
	}

	public function load_cache()
	{
		if ($cache = $this->cache->get('s7n_'.Router::$current_uri))
		{
			Kohana::render($cache);
			exit;
		}
	}

}

new hook_cache;