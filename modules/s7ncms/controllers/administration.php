<?php
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
class Administration_Controller extends Template_Controller {

	public $session;
	public $db;
	public $head;

	public function __construct()
	{
		// don't use config::set() here
		Kohana::config_set('s7n.use_admin_theme', TRUE);

		parent::__construct();

		$this->session = Session::instance();
		$this->db = Database::instance();

		// check if user is logged in or not. also check if he has admin role
		if ( ! Auth::factory()->logged_in('admin'))
		{
			$this->session->set('redirect_me_to', url::current());
			url::redirect('admin/auth/login');
		}
		$this->head = Head::instance();

		// Javascripts
		$this->head->javascript->append_file('vendor/jquery.js');
		$this->head->javascript->append_file('vendor/ui.tabs.js');
		$this->head->javascript->append_file('themes/admin/js/stuff.js');

		// Stylesheets
		$this->head->css->append_file('themes/admin/css/layout');
		$this->head->css->append_file('themes/admin/css/ui.tabs');

		$this->head->title->set('S7Nadmin');

		$this->template->tasks = array();

		$this->template->title = '';
		$this->template->message = $this->session->get('info_message', NULL);
		$this->template->error = $this->session->get('error_message', NULL);
		$this->template->content = '';
		$this->template->head = $this->head;

		$this->template->searchbar = FALSE;
		$this->template->searchvalue = '';
	}

	public function recent_entries($number = 10) {
		return '';
	}

}
