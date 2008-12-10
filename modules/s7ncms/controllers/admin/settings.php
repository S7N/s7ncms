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
class Settings_Controller extends Administration_Controller {

	public function index()
	{
		$themes = array();
		if ($dh = opendir(THEMEPATH))
		{
			while(($theme = readdir($dh)) !== FALSE)
			{
				$path = THEMEPATH.$theme.'/theme.xml';
				if (is_file($path))
				{
					$xml = simplexml_load_file($path);
					$themes[$theme] = (string) $xml->name;
				}
			}
		}

		$this->head->title->append('Settings');

		$this->template->title = 'Settings';
	    $this->template->content = View::factory('settings/settings')->set(array(
    		'site_title' => Kohana::config('s7n.site_title'),
	    	'theme' => Kohana::config('s7n.theme'),
	    	'themes' => $themes
	    ))->render();
	}

    public function save()
	{
        if($_POST)
		{
			// Site Title
			$this->db
			->update(
				'config',
				array(
					'value' => $this->input->post('site_title')
				),
				array(
					'context' => 's7n',
					'key' => 'site_title'
				)
			);

			// Site Title
			$this->db
			->update(
				'config',
				array(
					'value' => $this->input->post('theme')
				),
				array(
					'context' => 's7n',
					'key' => 'theme'
				)
			);

			$this->session->set_flash('info_message', 'Settings edited successfully');
        }

        url::redirect('admin/settings');
    }

}