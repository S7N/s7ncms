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
class Page_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->template->tasks = array(
			array('admin/page', 'Show All'),
			array('admin/page/newpage', 'New Page'),
			array('admin/page/settings', 'Edit Settings')
		);

		$this->head->title->append('Pages');
		$this->template->title = 'Pages | ';
	}

	public function index()
	{
		$this->head->javascript->append_file('vendor/jquery/ui/ui.draggable.js');
		$this->head->javascript->append_file('vendor/jquery/ui/ui.droppable.js');
		$this->head->javascript->append_file('vendor/jquery/ui/ui.sortable.js');
		$this->head->javascript->append_file('vendor/jquery/ui/ui.tree.js');

		$this->template->content = View::factory('page/index_tree', array(
			'pages' => ORM::factory('page')->find_all()
		));

		$this->head->title->append('All Pages');
		$this->template->title .= 'All Pages';
	}

	public function edit($id)
	{
		if($_POST)
		{
			$post = $this->input->post('form');

			$info = $post['info'];
			$de = $post['de'];
			$en = $post['en'];

			$page = ORM::factory('page', (int) $id);

			if ( ! $page->loaded)
				Event::run('system.404');

			$page->title = $info['title'];

			$type = NULL;
			$target = NULL;

			if ($info['type'] == 'redirect')
			{
				$redirect = trim($info['redirect_target']);
				if ( ! empty($redirect))
				{
					$type = 'redirect';
					$target = $redirect;
				}
			}
			elseif ($info['type'] == 'module')
			{
				$module = trim($info['module_target']);
				if ( ! empty($module))
				{
					$type = 'module';
					$target = $module;
				}
			}

			$page->type = $type;
			$page->target = $target;
			$page->save();

			$page_de           = ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => 'de'))->find();
			$page_de->page_id  = $page->id;
			$page_de->language = 'de';
			$page_de->title    = $de['title'];
			$page_de->uri      = url::title($de['title']);
			$page_de->content  = $de['content'];
			//$page_de->date     = date("Y-m-d H:i:s");
			$page_de->modified = date("Y-m-d H:i:s");
			$page_de->save();

			$page_en           = ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => 'en'))->find();
			$page_en->page_id  = $page->id;
			$page_en->language = 'en';
			$page_en->title    = $en['title'];
			$page_en->uri      = url::title($en['title']);
			$page_en->content  = $en['content'];
			//$page_en->date     = date("Y-m-d H:i:s");
			$page_en->modified = date("Y-m-d H:i:s");
			$page_en->save();

			$this->session->set_flash('info_message', 'Page edited successfully');
			url::redirect('admin/page');

			/*$page = ORM::factory('page', (int) $this->input->post('form_id'));

			$page->title = html::specialchars($this->input->post('form_title'), FALSE);

			if(strstr(config::get('s7n.page_views'), $this->input->post('form_view')) !== FALSE)
			{
				$page->view = trim($this->input->post('form_view'));
			}

			$page->content = $this->input->post('form_content');
			$page->uri = url::title($this->input->post('form_title'));

			$page->modified = date("Y-m-d H:i:s");
			$page->keywords = html::specialchars($this->input->post('form_keywords'), FALSE);

			if ($this->input->post('form_type') == 'redirect')
			{
				$target = trim($this->input->post('form_redirect_target'));
				if ( ! empty($target))
				{
					$page->type = 'redirect';
					$page->target = $this->input->post('form_redirect_target');
				}
			}
			elseif ($this->input->post('form_type') == 'module')
			{
				$target = trim($this->input->post('form_module_target'));
				if ( ! empty($target))
				{
					$page->type = 'module';
					$page->target = $this->input->post('form_module_target');
				}
			}
			else
			{
				$page->type = NULL;
				$page->target = NULL;
			}

			$page->save();

			$this->session->set_flash('info_message', 'Page edited successfully');

			url::redirect('admin/page');*/
		}
		else
		{
			$page = ORM::factory('page', (int) $id);

			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: '. $page->title());

			$this->template->title .= 'Edit: '. $page->title();
			//$this->template->tabs = array('Content', 'Advanced');

			$this->template->content = View::factory('page/edit', array(
				'page' => $page,
				'page_de' => ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => 'de'))->find(),
				'page_en' => ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => 'en'))->find(),
				'modules' => module::installed()
			));
		}
	}

	public function newpage()
	{

		if($_POST)
		{
			$post = $this->input->post('form');

			$info = $post['info'];
			$de = $post['de'];
			$en = $post['en'];

			$page = ORM::factory('page');
			$page->title = $info['title'];
			$page->save();

			$page_de           = ORM::factory('page_content');
			$page_de->page_id  = $page->id;
			$page_de->language = 'de';
			$page_de->title    = $de['title'];
			$page_de->uri      = url::title($de['title']);
			$page_de->content  = $de['content'];
			$page_de->date     = date("Y-m-d H:i:s");
			$page_de->modified = date("Y-m-d H:i:s");
			$page_de->save();

			$page_en           = ORM::factory('page_content');
			$page_en->page_id  = $page->id;
			$page_en->language = 'en';
			$page_en->title    = $en['title'];
			$page_en->uri      = url::title($en['title']);
			$page_en->content  = $en['content'];
			$page_en->date     = date("Y-m-d H:i:s");
			$page_en->modified = date("Y-m-d H:i:s");
			$page_en->save();

			$this->session->set_flash('info_message', 'Page created successfully');
			url::redirect('admin/page');

			/*$page = new Page_Model;
			$page->user_id = $_SESSION['auth_user']->id;

			$page->title = html::specialchars($this->input->post('form_title'), FALSE);
			$page->uri = url::title($this->input->post('form_title'));

			$page->view = 'default';

			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');

			$page->date = date("Y-m-d H:i:s");
			$page->modified = date("Y-m-d H:i:s");

			$page->keywords = html::specialchars($this->input->post('form_keywords'), FALSE);

			$page->save();

			$this->session->set_flash('info_message', 'Page created successfully');
			url::redirect('admin/page');*/
		}
		else
		{
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('New Page');

			$this->template->tabs = array('Content', 'Advanced');
			$this->template->title .= 'New Page';
			$this->template->content = new View('page/newpage');
		}
	}

	public function delete($id)
	{
		ORM::factory('page', (int) $id)->delete();
		$this->session->set_flash('info_message', 'Page deleted successfully');
		url::redirect('admin/page');
	}

	public function settings()
	{
		if($_POST)
		{
			// Available Vews
            config::set('s7n.views', $this->input->post('views'));

			// Default Sidebar Title
            config::set('s7n.default_sidebar_title', $this->input->post('default_sidebar_title'));

			// Default Sidebar Content
            config::set('s7n.default_sidebar_content', $this->input->post('default_sidebar_content'));

			$this->session->set_flash('info_message', 'Page Settings edited successfully');

			url::redirect('admin/page/settings');
		}

		$this->head->title->append('Settings');

		$this->template->title .= 'Settings';
		$this->template->content = View::factory('page/settings', array(
			'views' => config::get('s7n.page_views'),
			'default_sidebar_title' => config::get('s7n.default_sidebar_title'),
			'default_sidebar_content' => config::get('s7n.default_sidebar_content')
		));
	}

	public function save_tree()
	{
		$tree = json_decode($this->input->post('tree', NULL), TRUE);

		$this->tree = array();
		$this->counter = 0;
		$this->level_zero = 0;

		$this->calculate_mptt($tree);

		if ($this->level_zero > 1)
		{
			$this->session->set_flash('error_message', 'Page order could not be saved.');
			exit;
		}

		foreach($this->tree as $node)
		{
			$this->db
				->set(array('parent_id' => $node['parent_id'], 'level' => $node['level'], 'lft' => $node['lft'], 'rgt' => $node['rgt']))
				->where('id', $node['id'])
				->update('pages');
		}

		$this->session->set_flash('info_message', 'Page order saved successfully');
		exit;
	}

	private function calculate_mptt($tree, $parent = 0, $level = 0)
	{
		foreach ($tree as $key => $children)
		{
			$id = substr($key, 5);

			$left = ++$this->counter;

			if ( ! empty($children))
				$this->calculate_mptt($children, $id, $level+1);

			$right = ++$this->counter;

			if ($level === 0)
				$this->level_zero++;

			$this->tree[] = array(
				'id' => $id,
				'parent_id' => $parent,
				'level' => $level,
				'lft' => $left,
				'rgt' => $right
			);
		}
	}
}