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
			
			$page = ORM::factory('page', (int) $id);

			if ( ! $page->loaded)
				Event::run('system.404');
				
			$title = array();
			foreach (Kohana::config('locale.languages') as $key => $value)
			{
				$form = $post[$key];
				
				$page_content = ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => $key))->find();
				if ( ! $page_content->loaded)
				{
					$page_content->page_id  = $page->id;
					$page_content->language = $key;
					$page_content->date = date("Y-m-d H:i:s");
				}
				$page_content->title    = $form['title'];
				$page_content->uri      = url::title($form['title']);
				$page_content->content  = $form['content'];
				$page_content->modified = date("Y-m-d H:i:s");
				$page_content->save();
				
				$title[] = $page_content->title;
			}
			
			$type = NULL;
			$target = NULL;

			if ($post['info']['type'] == 'redirect')
			{
				$redirect = trim($post['info']['redirect_target']);
				if ( ! empty($redirect))
				{
					$type = 'redirect';
					$target = $redirect;
				}
			}
			elseif ($post['info']['type'] == 'module')
			{
				$module = trim($post['info']['module_target']);
				if ( ! empty($module))
				{
					$type = 'module';
					$target = $module;
				}
			}

			$page->type = $type;
			$page->target = $target;
			$page->title = implode(' / ', $title);
			$page->save();
			
			message::info('Page edited successfully', 'admin/page');
		}
		else
		{
			$page = ORM::factory('page', (int) $id);
			
			if ( ! $page->loaded)
				Event::run('system.404');

			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: '. $page->title());

			$this->template->title .= 'Edit: '. $page->title();
			$this->template->content = View::factory('page/edit', array(
				'page' => $page,
				'modules' => module::installed()
			));
			
			foreach (Kohana::config('locale.languages') as $key => $value)
				$form[$key] = ORM::factory('page_content')->where(array('page_id' => $page->id, 'language' => $key))->find();
			
			$this->template->content->form = $form;
		}
	}

	public function newpage()
	{

		if($_POST)
		{
			$post = $this->input->post('form');
			
			$page = ORM::factory('page');
			$page->insert_as_last_child($page->root(1));
				
			$title = array();
			foreach (Kohana::config('locale.languages') as $key => $value)
			{
				$form = $post[$key];
				$page_content = ORM::factory('page_content');
				$page_content->page_id  = $page->id;
				$page_content->language = $key;
				$page_content->title    = $form['title'];
				$page_content->uri      = url::title($form['title']);
				$page_content->content  = $form['content'];
				$page_content->date     = date("Y-m-d H:i:s");
				$page_content->modified = date("Y-m-d H:i:s");
				$page_content->save();
				
				$title[] = $page_content->title;
			}
			
			$page->title = implode(' / ', $title);
			$page->save();

			message::info('Page created successfully', 'admin/page');
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
		message::info('Page deleted successfully', 'admin/page');
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

			message::info('Page Settings edited successfully', 'admin/page/settings');
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