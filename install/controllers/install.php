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

	public function step_systemcheck()
	{

		$view = new View('step_systemcheck');
		// TODO checken ob die Database.conf writable ist
		
		$view->php_version = version_compare(PHP_VERSION, '5.2', '>=');
		$view->system_directory = is_dir(SYSPATH) AND is_file(SYSPATH.'core/Bootstrap'.EXT);
		$view->application_directory = is_dir(APPPATH) AND is_file(APPPATH.'config/config'.EXT);
		$view->modules_directory = is_dir(MODPATH);
		$view->pcre_utf8 = ! @preg_match('/^.$/u', 'ñ');
		$view->pcre_unicode = ! @preg_match('/^\pL$/u', 'ñ');
		$view->reflection_enabled = class_exists('ReflectionClass');
		$view->filters_enabled = function_exists('filter_list');
		$view->iconv_loaded = extension_loaded('iconv');
		// perhaps not right
		$view->mbstring = !extension_loaded('mbstring') OR (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING);
		
		$view->uri_determination = isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']);
		
		
		if($view->php_version AND $view->system_directory AND $view->application_directory AND $view->modules_directory
			AND	(! $view->pcre_utf8 ) AND (! $view->pcre_unicode) AND $view->reflection_enabled AND $view->filters_enabled
			AND $view->iconv_loaded AND (! $view->mbstring) AND $view->uri_determination
		)
			url_redirect('install/step_database');
		else
			$view->failed=true;
			
		$this->template->content=$view;

	}
	public function index()
	{
		// TODO check
		url::redirect('install/step_systemcheck');
	}
	
	public function step_database()
	{
		$dbuser='';
		$dbpass='';
		$dbhost='';
		$dbdatabase='';

		if($_POST)
		{
			$dbuser=$_POST['dbuser'];
			$dbpass=$_POST['dbpass'];
			$dbhost=$_POST['dbhost'];
			$dbdatabase= $_POST['dbdatabase'];
		}
			
		try
		{
			$this->check_mysql($dbhost, $dbdatabase, $dbuser, $dbpass);
			
			// TODO write db config file
			echo 'database config ok';
		} 
		catch (Exception $e)
		{
			$this->template->error =$e->getMessage();
		}
	}
	
	
	private function check_mysql($host, $database, $username, $password) {
		$link = @mysql_connect($host, $username, $password);
		if(!$link) {
				$error = '';
				
				if(strpos(mysql_error(), 'Access denied') !== false) {
						$error = 'wrong username or password';
				} elseif(strpos(mysql_error(), 'server host') !== false) {
						$error = 'unknown host: '.$host;
				} elseif(strpos(mysql_error(), 'connect to') !== false) {
						$error = 'Can\'t connect to host: '.$host;
				}else {
						$error = mysql_error();
				}
				
				throw new Exception($error);
				return $error;
		}
		
		$select = mysql_select_db($database, $link);
		if (!$select) {
			throw new Exception(mysql_error());
				return mysql_error();
		}
		
		return true;
	}

}
