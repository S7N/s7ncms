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
class Modules_Controller extends Administration_Controller {

	public  function __construct()
	{
		parent::__construct();

		$this->head->title->append(__('Modules'));
		$this->template->title = __('Modules');
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

    	message::info(__('Module status successfully changed'), 'admin/modules');
    }

    public function install($module)
    {
		require_once(MODPATH.$module.'/helpers/'.$module.'_installer.php');

		call_user_func($module.'_installer::install');

		message::info(__('Module installed successfully'), 'admin/modules');
    }

    public function uninstall($module)
    {
    	require_once(MODPATH.$module.'/helpers/'.$module.'_installer.php');

    	call_user_func($module.'_installer::uninstall');

    	message::info(__('Module uninstalled successfully'), 'admin/modules');
    }

}