<?php defined('SYSPATH') or die('No direct script access.');
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
class Install_Controller extends Controller {
	
	public function index() {
		$check = $this->check_writable();
		
		//if(empty($check)) {
			$this->template->content = new View('not_writable');
			$this->template->content->files = $check;
		//} else {
		//	url::redirect('install/database');
		//}
	}
	
	public function database() {
		
		if($_SERVER["REQUEST_METHOD"] !== 'POST') {
			$this->template->content = new View('database');
			
			$this->template->content->host = 'localhost';
			$this->template->content->database = '';
			$this->template->content->username = '';
			$this->template->content->password = '';
			$this->template->content->prefix = 's7n_';
			
			return;
		}
		
		$host = $this->input->post('host');
		$database = $this->input->post('database');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$prefix = $this->input->post('prefix');
		
		if(($check = $this->check_mysql($host, $database, $username, $password)) !== true) {
			$this->template->message = 'Can\'t connect to MySQL: ' .$check;
			
			$this->template->content = new View('database');
			$this->template->content->host = $this->input->post('host');
			$this->template->content->database = $this->input->post('database');
			$this->template->content->username = $this->input->post('username');
			$this->template->content->password = $this->input->post('password');
			$this->template->content->prefix = $this->input->post('prefix');
			
			return;
		}
		
		$this->session->set('database', array(
			'driver' => 'mysql',
			'username' => $username,
			'password' => $password,
			'host' => $host,
			'database' => $database,
			'prefix' => $prefix
		));
		
		url::redirect('install/settings');
	}
	
	public function settings() {
		if($_SERVER["REQUEST_METHOD"] !== 'POST') {
			$this->template->content = new View('settings');
			
			$this->template->content->username = '';
			$this->template->content->password = '';
			$this->template->content->url = url::base();
			return;
		}
		
		$this->session->set('settings', array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'url' => $this->input->post('url'),
			'mod_rewrite' => $this->input->post('mod_rewrite')
		));
		
		url::redirect('install/finalize');
	}
	
	public function finalize() {
		$this->write_config('config');
		$this->write_config('database');
		$this->insert_sql();
		$this->create_admin();
		
		$settings = $this->session->get('settings');
		$this->template->content = new View('finalize');
		$this->template->content->url_site = $settings['url'];
		
		if(is_null($settings['mod_rewrite'])) {
			$this->template->content->url_admin = $settings['url'].'admin.php';
		} else {
			$this->template->content->url_admin = $settings['url'].'admin/';
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
			
			return $error;
		}
		
		$select = mysql_select_db($database, $link);
		if (!$select) {
			return mysql_error();
		}
		
		return true;
	}
	
	private function check_writable() {
		$files = array(
			DOCROOT.'application/config/config.php',
			DOCROOT.'administration/config/config.php',
			DOCROOT.'shared/config/database.php',
			DOCROOT.'shared/config/domain.php'
		);
		
		$array = array();
		foreach ($files as $file) {
			if(!is_writable($file)) {
				if(!@chmod($file, 0755)) {
					$array[] = $file;
				}
			}
		}
		
		
		return $array;
	}
	
	private function write_config($type) {
		$check = $this->check_writable();
		if (empty($check)) {
			switch ($type) {
				case 'config':
					$this->write_core_config();
					break;
					
				case 'database';
					$this->write_database_config();
					break;
				default:
					return false;
					break;
			} 
		}		
	}
	
	private function write_core_config() {		
		$config = Kohana::find_file('views', 'config.template.php', false, 'php');
		$config = file_get_contents($config);
		
		$domain = Kohana::find_file('views', 'domain.template.php', false, 'php');
		$domain = file_get_contents($domain);
		
		$settings = $this->session->get('settings');
		
		$search = array(
			'{index_page}',
			'{libraries}'
		);
		
		$index_page = false;
		if (is_null($settings['mod_rewrite'])) {
			$index_page = true;
		}
		
		$replace_application = array(
			$index_page === true ? 'index.php' : '',
			''
		);
		
		$replace_admin = array(
			$index_page === true ? 'admin.php' : 'admin',
			'session'
		);
		
		//$text_out = preg_replace(array_keys($relation), array_values($relation), $text_in);
		$config_application = str_replace($search, $replace_application, $config);
		$config_admin = str_replace($search, $replace_admin, $config);
		$config_domain = str_replace('{site_domain}', str_replace('http://', '', $settings['url']), $domain);
		
		$app = file_put_contents(DOCROOT.'application/config/config.php', $config_application);
		$admin = file_put_contents(DOCROOT.'administration/config/config.php', $config_admin);
		$domain = file_put_contents(DOCROOT.'shared/config/domain.php', $config_domain);
		return;		
	}
	
	private function write_database_config() {
		$config = Kohana::find_file('views', 'database.template.php', false, 'php');
		$config = file_get_contents($config);
		
		$database = $this->session->get('database');
		
		$search = array(
			'{driver}',
			'{user}',
			'{password}',
			'{server}',
			'{database}',
			'{prefix}'
		);
		
		$replace = array(
			'mysql',
			$database['username'],
			$database['password'],
			$database['host'],
			$database['database'],
			$database['prefix']
		);
		
		$config = str_replace($search, $replace, $config);
		
		$db = file_put_contents(DOCROOT.'shared/config/database.php', $config);
		
		return;
	}
	
	private function insert_sql() {
		$database = $this->session->get('database');
		
		$link = mysql_connect($database['host'], $database['username'], $database['password']);
		if(!$link) {
			$error = '';
			
			if(strpos(mysql_error(), 'Access denied') !== false) {
				$error = 'wrong username or password';
			} elseif(strpos(mysql_error(), 'server host') !== false) {
				$error = 'unknown host: '.$host;
			} elseif(strpos(mysql_error(), 'connect to') !== false) {
				$error = 'Can\'t connect to host: '.$host;
			} else {
				$error = mysql_error();
			}
			
			echo $error; exit;
		}
		
		$select = mysql_select_db($database['database'], $link);
		if (!$select) {
			return mysql_error();
		}
		
		$sql = Kohana::find_file('views', 'sql.template.php', false, 'php');
		$sql = file_get_contents($sql);
		$sql = preg_replace('/\{table_prefix\}/i', $database['prefix'], $sql);
		
		$queries = preg_split("/;[\r?\n]+/i", $sql);
		
		
		foreach ($queries as $query) {
			$query = trim($query);
			if (empty($query)) {
				continue;
			}
			$q = mysql_query($query, $link);			
		}
		
	}
	
	private function create_admin() {
		$settings = $this->session->get('settings');
		$database = $this->session->get('database');
		
		$username = $settings['username'];
		$auth = new Auth();
		$password = $auth->hash_password($settings['password']);
		
		$query = "INSERT INTO `".$database['prefix']."users` (`email`,`username`,`password`,`logins`,`homepage`,`first_name`,`last_name`,`registered_on`) VALUES ('email@example.net','".$username."','".$password."','0','http://www.example.com','','', NOW());";
		$link = mysql_connect($database['host'], $database['username'], $database['password']);
		$select = mysql_select_db($database['database'], $link);
		$q = mysql_query($query, $link);
		$id = mysql_insert_id($link);
		
		$query1 = "INSERT INTO `".$database['prefix']."users_roles` (`user_id`,`role_id`) VALUES (".$id.",'1')";
		$query2 = "INSERT INTO `".$database['prefix']."users_roles` (`user_id`,`role_id`) VALUES (".$id.",'2')";
		
		$q = mysql_query($query1, $link);
		$q = mysql_query($query2, $link);		
	}
}