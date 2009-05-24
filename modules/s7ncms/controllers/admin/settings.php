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
class Settings_Controller extends Administration_Controller {

	public function index()
	{
		$this->head->title->append(__('Settings'));
		$this->template->title = __('Settings');
		
		$form = Formo::factory()
			->plugin('csrf')
			->add('text', 'site_title', array('label' => __('Site title'), 'value' => config::get('s7n.site_title')))
			->add_select('theme', theme::available(), array('label' => __('Theme'), 'value' => config::get('s7n.theme')))
			->add('submit', 'submit', array('label' => __('Save')));
		
		if ($form->validate())
		{
			config::set('s7n.site_title', $form->site_title->value);
			config::set('s7n.theme', $form->theme->value);
			
			message::info(__('Settings edited successfully'), 'admin/settings');
		}
		
		$this->template->content = View::factory('settings/settings', $form->get(TRUE));
	}

}