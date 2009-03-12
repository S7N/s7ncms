<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */
class Website_Controller extends Template_Controller {

	public $cache_enabled = TRUE;

	public function __construct()
	{
		parent::__construct();

		if (IN_PRODUCTION === TRUE)
		{
			Event::add('system.display', array($this, 'save_cache'));
		}

		$this->session = Session::instance();
		$this->head = Head::instance();
		$this->head->css->append_file('themes/'.config::get('s7n.theme').'/css/layout');
		$this->head->title->set(config::get('s7n.site_title'));

		$this->template->set_global('theme_url', 'themes/'.config::get('s7n.theme').'/');
		$this->template->head = $this->head;
	}

	public function save_cache()
	{
		if ($this->cache_enabled === TRUE)
		{
			Cache::instance()->set('s7n_'.Router::$current_uri, Event::$data);
		}
	}

}
