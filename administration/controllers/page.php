<?php defined('SYSPATH') or die('No direct script access.');

class Page_Controller extends Admin_Controller {
	
	protected $page;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->template->tasks = array(
			array('page/newpage', 'New Page'),
			array('page/settings', 'Edit Settings')
		);
	}

	public function index()
	{
		$this->template->title = 'Pages | All Pages';
		$this->template->content = new View('page/index');
		$this->template->content->pages = ORM::factory('page')->find_all();
	}

	public function edit()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$page = ORM::factory('page')->find_by_id((int) $this->input->post('form_id'));
			
			$page->title = htmlspecialchars($this->input->post('form_title'));
			
			if(strstr(config::item('s7n.page_views'), $this->input->post('form_view')) !== false)
			{
				$page->view = trim($this->input->post('form_view'));
			}
			
			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');
			$page->uri = url::title($this->input->post('form_title'));
			
			$page->modified = date("Y-m-d H:i:s");
			$page->keywords = htmlspecialchars($this->input->post('form_keywords'));
			
			$page->save();
			
			$this->session->set_flash('info_message', 'Page edited successfully');

			url::redirect('page');
		}
		else
		{
			$this->template->meta .= html::script('vendor/tiny_mce/tiny_mce.js');
			$this->template->content = new View('page/edit');
			$this->template->content->page = ORM::factory('page')->find_by_id((int)$this->uri->segment(3));
			$this->template->title = 'Pages | Edit: '. $this->template->content->page->title ;
		}
	}
	
	public function newpage()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$page = new Page_Model;
			$page->user_id = $_SESSION['auth_user']->id;
			
			$page->title = htmlspecialchars($this->input->post('form_title'));
			$page->uri = url::title($this->input->post('form_title'));
			
			$page->view = 'default';
			
			$page->excerpt = $this->input->post('form_excerpt');
			$page->content = $this->input->post('form_content');
			
			$page->date = date("Y-m-d H:i:s");
			$page->modified = date("Y-m-d H:i:s");
			
			$page->keywords = htmlspecialchars($this->input->post('form_keywords'));
			
			$page->save();
			
			$this->session->set_flash('info_message', 'Page created successfully');
			url::redirect('page');
		}
		else
		{
			$this->template->meta .= html::script('vendor/tiny_mce/tiny_mce.js');
			$this->template->title = 'Pages | New Page';
			$this->template->content = new View('page/newpage');
		}
	}
	
	public function delete()
	{
		
		ORM::factory('page')->find_by_id((int) $this->uri->segment(3))->delete();
		$this->session->set_flash('info_message', 'Page deleted successfully');
		url::redirect('page');
	}
	
	public function settings()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if(Settings::save('page.views', $this->input->post('form_views')))
			{
				$this->session->set_flash('info_message', 'Page Settings edited successfully');
				url::redirect('page/settings');
			}
		}
		
		$this->template->title = 'Pages | Settings';
		$this->template->content = new View('page/settings');
		$this->template->content->views = Config::item('s7n.page_views');			
	}
	
	public function recent_entries($number = 10)
	{
		$this->auto_render = FALSE;
		
		$x = ORM::factory('page')->limit((int) $number)->find_all();
		$view = new View('page/recent_entries');
		
		$entries = array();
		foreach ($x as $entry)
		{
			$entries[] = array('page/edit/'.$entry->id, $entry->title);
		}
		$view->entries = $entries;
		
		return $view;
	}

}