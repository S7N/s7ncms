<?php defined('SYSPATH') or die('No direct script access.');

class Website_Controller extends Template_Controller {
	
	public $cache_enabled = TRUE;
	
	public function __construct()
	{
		parent::__construct();
		
		if (IN_PRODUCTION === FALSE)
		{
			new Profiler;
		}
		else
		{
			Event::add('system.display', array($this, 'save_cache'));
		}
		
		$this->session = Session::instance();
		$this->template->meta = '';
	}
	
	public function save_cache()
	{
		if ($this->cache_enabled === TRUE)
		{
			Cache::instance()->set('s7n_'.Router::$current_uri, Event::$data);
		}
	}

}
