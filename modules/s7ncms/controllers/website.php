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

		$this->session = Session::instance();
		$this->head = Head::instance();
		$this->head->css->append_file('themes/'.config::get('s7n.theme').'/css/layout');
		$this->head->title->set(config::get('s7n.site_title'));

		$this->template->set_global('theme_url', 'themes/'.config::get('s7n.theme').'/');
		$this->template->head = $this->head;
	}

}
