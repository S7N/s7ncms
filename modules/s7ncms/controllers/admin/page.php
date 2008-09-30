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
		
		$this->template->content = new View('page/index_tree');
		
		$this->head->title->append('All Pages');
			
		$this->template->title = 'Pages | All Pages';
		$this->template->content->pages = ORM::factory('page')->orderby('lft', 'ASC')->find_all();
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

			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');
			$page->uri = url::title($this->input->post('form_title'));

			$page->modified = date("Y-m-d H:i:s");
			$page->keywords = html::specialchars($this->input->post('form_keywords'), FALSE);

			$page->save();

			$this->session->set_flash('info_message', 'Page edited successfully');

			url::redirect('admin/page');
		}
		else
		{
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->template->content = new View('page/edit');
			$this->template->content->page = ORM::factory('page', (int) $this->uri->segment(4));
			$this->template->title = 'Pages | Edit: '. $this->template->content->page->title;
			$this->head->title->append('Edit: '. $this->template->content->page->title);
		}
	}

	public function newpage()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
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
			
			$this->template->title = 'Pages | New Page';
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
		$this->template->content = new View('page/settings');
		$this->template->content->views = Kohana::config('s7n.page_views');

		$this->template->content->default_sidebar_title = Kohana::config('s7n.default_sidebar_title');
        $this->template->content->default_sidebar_content = Kohana::config('s7n.default_sidebar_content');
	}

	/*public function recent_entries($number = 10)
	{
		$this->auto_render = FALSE;

		$x = ORM::factory('page')->find_all((int) $number);
		$view = new View('page/recent_entries');

		$entries = array();
		foreach ($x as $entry)
		{
			$entries[] = array('admin/page/edit/'.$entry->id, $entry->title);
		}
		$view->entries = $entries;

		return $view;
	}*/
	
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
		
		$this->session->set_flash('info_message', 'läuft');
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
	
/*

"SELECT *, count(*) AS level
FROM ".$this->table_name. ' AS v, '.$this->table_name.' AS s'."
WHERE
	v.".$this->left_column. ' <= s.'.$this->left_column."
	AND s.".$this->left_column. ' <= v.'.$this->right_column."
GROUP BY s.".$this->primary_key."
ORDER BY s.".$this->left_column." ASC"

*/
}