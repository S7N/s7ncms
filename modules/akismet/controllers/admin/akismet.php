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
class Akismet_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->head->title->append('Akismet');
		$this->template->title = html::anchor('admin/akismet', 'Akismet').' | ';
	}

	public function index()
	{
		if($_POST)
		{
			config::set('akismet.api_key', $this->input->post('akismet_api_key'));
			message::info('Settings changed successfully', 'admin/akismet');
		}
		else
		{
			$this->head->title->append('Settings');
			$this->template->title .= 'Settings';

			$this->template->content = new View('akismet/settings');
			$this->template->content->akismet_api_key = config::get('akismet.api_key');
		}
	}

}