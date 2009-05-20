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

	public function __construct()
	{
		if (file_exists(DOCROOT.'config/database.php'))
			die('S7Ncms is already installed.');
		
		parent::__construct();
		
		$this->template->bind('title', $this->title);
		$this->template->bind('content', $this->content);
		$this->template->bind('error', $this->error);
	}

	public function index()
	{
		url::redirect('install/step_systemcheck');
	}

	public function step_systemcheck()
	{
		$this->title = 'System Check';
		
		$view = new View('step_systemcheck');

		$view->php_version           = version_compare(PHP_VERSION, '5.2', '>=');
		$view->system_directory      = is_dir(SYSPATH) AND is_file(SYSPATH.'core/Bootstrap'.EXT);
		$view->application_directory = is_dir(APPPATH) AND is_file(DOCROOT.'application/config/config'.EXT);
		$view->modules_directory     = is_dir(MODPATH);
		$view->config_writable       = is_dir(DOCROOT.'config') AND is_writable(DOCROOT.'config');
		$view->cache_writable        = is_dir(DOCROOT.'application/cache') AND is_writable(DOCROOT.'application/cache');
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
			AND $view->cache_writable
			AND $view->pcre_utf8
			AND $view->pcre_unicode
			AND $view->reflection_enabled
			AND $view->filters_enabled
			AND $view->iconv_loaded
			AND $view->mbstring
			AND $view->uri_determination)
			url::redirect('install/step_database');
		else
		{
			$this->error = 'S7Ncms may not work correctly with your environment.';
		}

		$this->content = $view;
		$this->title = 'System Check';
	}

	public function step_database()
	{
		$this->content = View::factory('step_database')->bind('form', $form);
		$this->title = 'Database Configuration';
		
		$form = array(
			'username' => '',
			'password' => '',
			'hostname' => '',
			'database' => ''
		);

		if ($_POST)
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$hostname = $this->input->post('hostname');
			$database = $this->input->post('database');

			try
			{
				installer::check_database($username, $password, $hostname, $database);
				
				$config = new View('database_config');
				$config->username = $username;
				$config->password = $password;
				$config->hostname = $hostname;
				$config->database = $database;
				$config->table_prefix = ''; // TODO

				file_put_contents(DOCROOT.'config/database.php', $config);

				url::redirect('install/step_create_data');
			}
			catch (Exception $e)
			{
				$form = arr::overwrite($form, $this->input->post());
				$error = $e->getMessage();

				// TODO create better error messages
				switch ($error)
				{
					case 'access':
						$this->error = 'wrong username or password';
						break;
					case 'unknown_host':
						$this->error = 'could not find the host';
						break;
					case 'connect_to_host':
						$this->error = 'could not connect to host';
						break;
					case 'select':
						$this->error = 'could not select the database';
						break;
					default:
						$this->error = 'unknown error';
				}
			}
		}

	}
	
	public function step_create_data()
	{
		$this->content = 'create data here';
	}

}
