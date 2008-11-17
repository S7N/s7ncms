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
class Page_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->template->tasks = array(
			array('admin/page/newpage', 'New Page'),
			array('admin/page/settings', 'Edit Settings')
		);

		$this->head->title->append('Pages');
	}

	public function index()
	{
		$this->head->javascript->append_file('media/admin/js/ui.core.js');
		$this->head->javascript->append_file('media/admin/js/ui.draggable.js');
		$this->head->javascript->append_file('media/admin/js/ui.droppable.js');
		$this->head->javascript->append_file('media/admin/js/ui.sortable.js');
		$this->head->javascript->append_file('media/admin/js/ui.tree.js');

		$this->template->content = View::factory('page/index_tree')->set(array(
			'pages' => ORM::factory('page')->orderby('lft', 'ASC')->find_all()
		))->render();

		$this->head->title->append('All Pages');

		$this->template->title = 'Pages | All Pages';
	}

	public function edit()
	{
		if($_POST)
		{
			$page = ORM::factory('page', (int) $this->input->post('form_id'));

			$page->title = html::specialchars($this->input->post('form_title'), FALSE);

			if(strstr(Kohana::config('s7n.page_views'), $this->input->post('form_view')) !== FALSE)
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

			url::redirect('admin/page');
		}
		else
		{
			$page = ORM::factory('page', (int) $this->uri->segment(4));

			$modules = new Modules_Model;

			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: '. $page->title);

			$this->template->title = 'Pages | Edit: '. $page->title;
			$this->template->tabs = array('Content', 'Advanced');

			$this->template->content = View::factory('page/edit')->set(array(
				'page' => $page,
				'modules' => $modules->get()
			))->render();
		}
	}

	public function newpage()
	{
		if($_POST)
		{
			$page = new Page_Model;
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
			url::redirect('admin/page');
		}
		else
		{
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('New Page');

			$this->template->tabs = array('Content', 'Advanced');
			$this->template->title = 'Pages | New Page';
			$this->template->content = new View('page/newpage');

			$modules = new Modules_Model;
			$this->template->content->modules = $modules->get();
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
			// Default Sidebar Title
            Database::instance()
			->update(
				'config',
				array(
					'value' => $this->input->post('views')
				),
				array(
					'context' => 's7n',
					'key' => 'views'
				)
			);

			// Default Sidebar Title
            Database::instance()
			->update(
				'config',
				array(
					'value' => $this->input->post('default_sidebar_title')
				),
				array(
					'context' => 's7n',
					'key' => 'default_sidebar_title'
				)
			);

			// Default Sidebar Content
            Database::instance()
			->update(
				'config',
				array(
					'value' => $this->input->post('default_sidebar_content')
				),
				array(
					'context' => 's7n',
					'key' => 'default_sidebar_content'
				)
			);

			$this->session->set_flash('info_message', 'Page Settings edited successfully');

			url::redirect('admin/page/settings');
		}

		$this->head->title->append('Settings');

		$this->template->title = 'Pages | Settings';
		$this->template->content = View::factory('page/settings')->set(array(
			'views' => Kohana::config('s7n.page_views'),
			'default_sidebar_title' => Kohana::config('s7n.default_sidebar_title'),
			'default_sidebar_content' => Kohana::config('s7n.default_sidebar_content')
		))->render();
	}

	public function save_tree()
	{
		$tree = json_decode($this->input->post('tree', NULL), TRUE);

		$this->counter = 0;
		$this->tree = array();

		$this->calculate_mptt($tree);

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
		foreach ($tree as $key => $value)
		{
			$id = substr($key, 5);
			$children = $value;
			$left = ++$this->counter;
			if ( ! empty($children))
			{
				$this->calculate_mptt($children, $id, $level+1);
			}
			$right = ++$this->counter;

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