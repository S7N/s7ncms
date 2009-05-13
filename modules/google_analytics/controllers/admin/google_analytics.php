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
class Google_analytics_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->head->title->append('Google Analytics');
		$this->template->title = html::anchor('admin/google_analytics', 'Google Analytics').' | ';
	}

	public function index()
	{
		if($_POST)
		{
			config::set('google_analytics.id', $this->input->post('google_analytics_id'));
			message::info('Settings changed successfully', 'admin/google_analytics');
		}
		else
		{
			$this->head->title->append('Settings');
			$this->template->title .= 'Settings';

			$this->template->content = new View('google_analytics/settings');
			$this->template->content->google_analytics_id = config::get('google_analytics.id');
		}
	}

}