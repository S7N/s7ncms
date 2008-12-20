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
class Modules_Controller extends Administration_Controller {

	public  function __construct()
	{
		parent::__construct();

		$this->head->title->append('Modules');
		$this->template->title = 'Modules';
	}
	public function index()
	{
		$this->template->content = View::factory('modules/index', array(
			'modules' => module::available()
		));
    }

    public function status($module, $new_status)
    {
    	module::change_status($module, $new_status);

    	$this->session->set_flash('info_message', 'Module status successfully changed.');

    	url::redirect('admin/modules');
    }

    public function install($module)
    {
		require_once(MODPATH.$module.'/helpers/'.$module.'_installer.php');

		call_user_func($module.'_installer::install');

		$this->session->set_flash('info_message', 'Module installed successfully.');
    	url::redirect('admin/modules');
    }

    public function uninstall($module)
    {
    	require_once(MODPATH.$module.'/helpers/'.$module.'_installer.php');

    	call_user_func($module.'_installer::uninstall');

    	$this->session->set_flash('info_message', 'Module uninstalled successfully.');
    	url::redirect("admin/modules");
    }

}