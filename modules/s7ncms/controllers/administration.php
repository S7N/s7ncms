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
abstract class Administration_Controller extends Controller {

	public $session;
	public $db;
	public $head;
	
	// Template view name
	public $template = 'template';

	// Default to do auto-rendering
	public $auto_render = TRUE;

	public function __construct()
	{
		// don't use config::set() here
		Kohana::config_set('s7n.use_admin_theme', TRUE);

		parent::__construct();
		
		// Load the template
		$this->template = new Admin_View($this->template);

		if ($this->auto_render == TRUE)
		{
			// Render the template immediately after the controller method
			Event::add('system.post_controller', array($this, '_render'));
		}

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
		$this->head->javascript->append_file('vendor/jquery/jquery.js');
		$this->head->javascript->append_file('vendor/jquery/jquery-ui.min.js');
		$this->head->javascript->append_file('vendor/jquery/ui/ui.tree.js');
		$this->head->javascript->append_file('themes/admin/js/stuff.js');

		// Stylesheets
		$this->head->css->append_file('themes/admin/css/ui/jquery-ui');
		$this->head->css->append_file('themes/admin/css/layout');
		$this->head->css->append_file('themes/admin/css/ui.tabs');

		$this->head->title->set('S7Nadmin');

		$this->template->set_global('tasks', array());
		$this->template->set_global('sidebar', array());

		$this->template->title = '';
		$this->template->message = $this->session->get('info_message', NULL);
		$this->template->error = $this->session->get('error_message', NULL);
		$this->template->content = '';
		$this->template->set_global('head', $this->head);

		$this->template->searchbar = FALSE;
		$this->template->searchvalue = '';
	}

	/**
	 * Render the loaded template.
	 */
	public function _render()
	{
		if ($this->auto_render == TRUE)
		{
			// Render the template when the class is destroyed
			$this->template->render(TRUE);
		}
	}

}
