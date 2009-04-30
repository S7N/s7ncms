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
class Install_Controller extends Template_Controller {

	public function index()
	{
		url::redirect('install/step_systemcheck');
	}

	public function step_systemcheck()
	{
		$view = new View('step_systemcheck');

		$view->php_version           = version_compare(PHP_VERSION, '5.2', '>=');
		$view->system_directory      = is_dir(SYSPATH) AND is_file(SYSPATH.'core/Bootstrap'.EXT);
		$view->application_directory = is_dir(APPPATH) AND is_file(APPPATH.'config/config'.EXT);
		$view->modules_directory     = is_dir(MODPATH);
		$view->config_writable       = is_writable(DOCROOT.'config');
		$view->pcre_utf8             = @preg_match('/^.$/u', 'ñ');
		$view->pcre_unicode          = @preg_match('/^\pL$/u', 'ñ');
		$view->reflection_enabled    = class_exists('ReflectionClass');
		$view->filters_enabled       = function_exists('filter_list');
		$view->iconv_loaded          = extension_loaded('iconv');
		$view->mbstring              = ! (extension_loaded('mbstring') AND ini_get('mbstring.func_overload') AND MB_OVERLOAD_STRING);
		$view->uri_determination     = isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']);

		if (    $view->php_version
			AND $view->system_directory
			AND $view->application_directory
			AND $view->modules_directory
			AND $view->config_writable
			AND $view->pcre_utf8
			AND $view->pcre_unicode
			AND $view->reflection_enabled
			AND $view->filters_enabled
			AND $view->iconv_loaded
			AND $view->mbstring
			AND $view->uri_determination)
			url::redirect('install/step_database');
		else
			$view->failed = true;

		$this->template->content = $view;

	}

	public function step_database()
	{
		$this->template->content = View::factory('step_database')->bind('form', $form);

		$form = array(
			'user' => '',
			'password' => '',
			'host' => '',
			'database' => ''
		);

		if ($_POST)
		{
			$user = $this->input->post('user');
			$password = $this->input->post('password');
			$host = $this->input->post('host');
			$database= $this->input->post('database');

			try
			{
				installer::check_database($user, $password, $host, $database);
				
				$config = new View('database_config');
				$config->user = $user;
				$config->password = $password;
				$config->host = $host;
				$config->database = $database;
				$config->table_prefix = ''; // TODO

				file_put_contents(DOCROOT.'config/database.php', $config);

				url::redirect('install/step_create_data');
			} 
			catch (Exception $e)
			{
				$form = arr::overwrite($form, $this->input->post());
				$view = View::factory('error');
				$error = $e->getMessage();

				// TODO create better error messages
				switch ($error)
				{
					case 'access':
						$view->error = 'wrong username or password';
						break;
					case 'unknown_host':
						$view->error = 'could not find the host';
						break;
					case 'connect_to_host':
						$view->error = 'could not connect to host';
						break;
					case 'select':
						$view->error = 'could not select the database';
						break;
					default:
						$view->error = 'unknown error';
				}

				$this->template->error = $view;
			}
		}

	}
	
	public function step_create_data()
	{
		$this->template->content = 'create data here';
	}

}
