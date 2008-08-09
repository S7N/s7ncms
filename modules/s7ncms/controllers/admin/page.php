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
		$this->template->content = new View('page/index');
		
		$this->template->searchbar = TRUE;
		
		$q = trim($this->input->get('q'));
		
		if ( ! empty($q))
		{
			$this->template->searchvalue = $q;
			
			$this->template->content->pages = ORM::factory('page')->orlike(
				array(
					'title' => '%'.$q.'%',
					'excerpt' => '%'.$q.'%',
					'content' => '%'.$q.'%',
					'tags' => '%'.$q.'%'
				)
			)->find_all();
			
			$this->template->title = 'Pages | Filter: '.$q;
			$this->head->title->append('Filter: '.$q);
		}
		else
		{
			$this->template->title = 'Pages | All Pages';
			$this->head->title->append('All Pages');
			$this->template->content->pages = ORM::factory('page')->find_all();
		}
		
	}

	public function edit()
	{
		if($_POST)
		{
			$page = ORM::factory('page', (int) $this->input->post('form_id'));

			$page->title = html::specialchars($this->input->post('form_title'));

			if(strstr(Kohana::config('s7n.page_views'), $this->input->post('form_view')) !== false)
			{
				$page->view = trim($this->input->post('form_view'));
			}

			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');
			$page->uri = url::title($this->input->post('form_title'));

			$page->modified = date("Y-m-d H:i:s");
			$page->keywords = html::specialchars($this->input->post('form_keywords'));

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

			$page->title = html::specialchars($this->input->post('form_title'));
			$page->uri = url::title($this->input->post('form_title'));

			$page->view = 'default';

			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');

			$page->date = date("Y-m-d H:i:s");
			$page->modified = date("Y-m-d H:i:s");

			$page->keywords = html::specialchars($this->input->post('form_keywords'));

			$page->save();

			$this->session->set_flash('info_message', 'Page created successfully');
			url::redirect('admin/page');
		}
		else
		{
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->headtitle->append('New Page');
			
			$this->template->title = 'Pages | New Page';
			$this->template->content = new View('page/newpage');
		}
	}

	public function delete()
	{
		ORM::factory('page', (int) $this->uri->segment(4))->delete();
		$this->session->set_flash('info_message', 'Page deleted successfully');
		url::redirect('admin/page');
	}

	public function settings()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if(Settings::save('page.views', $this->input->post('form_views')))
			{
				$this->session->set_flash('info_message', 'Page Settings edited successfully');
				url::redirect('admin/page/settings');
			}
		}
		
		$this->head->title->append('Settings');
		
		$this->template->title = 'Pages | Settings';
		$this->template->content = new View('page/settings');
		$this->template->content->views = Kohana::config('s7n.page_views');			
	}

	public function recent_entries($number = 10)
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
	}

}