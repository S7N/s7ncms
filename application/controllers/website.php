<?php defined('SYSPATH') or die('No direct script access.');

class Website_Controller extends Template_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		(IN_PRODUCTION === FALSE) AND new Profiler;
	}

}
