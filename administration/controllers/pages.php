<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Admin_Controller {
	
	protected $page;
	
	public function __construct()
	{
		parent::__construct();
		new Profiler();
		$this->page = new Pages_Model();
		
		$this->template->tasks = array(
			array('pages/newpage', 'New Page'),
			array('pages/settings', 'Edit Page Settings')
		);
		
		$this->template->entries = array(
			array('pages', 'All Entries')
		);
	}

	public function index()
	{
		$this->template->title = 'Pages | All Pages';
		$this->template->content = new View('pages/index');
		$this->template->content->pages = $this->page->get_all();
	}

	public function edit()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$this->page->id = (int) $this->input->post('form_content_id');
			$this->page->title = htmlspecialchars($this->input->post('form_title'));
			
			if(strstr(config::item('s7n.page_views'), $this->input->post('form_view')) !== false)
			{
				$this->page->view = trim($this->input->post('form_view'));
			}
			
			$this->page->intro = $this->input->post('form_intro');
			$this->page->body = $this->input->post('form_body');
			$this->page->uri = url::title($this->input->post('form_title'));
			
			$publish_on = trim($this->input->post('form_publish_on'));        

			if(preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on))
			{                
				$this->page->publish_on = $publish_on;                
			}
			
			$this->page->modified_on = date("Y-m-d H:i:s");
			$this->page->modified_by = $_SESSION['auth_user']->id;
			$this->page->sidebar_content = $this->input->post('form_sidebar_content');
			$this->page->meta_keywords = htmlspecialchars($this->input->post('form_meta_keywords'));
			
			$this->page->save();
			
			$this->session->set_flash('info_message', 'Page edited successfully');

			url::redirect('pages');
		}
		else
		{
			$this->template->content = new View('pages/edit');
			$this->template->content->page = $this->page->get($this->uri->segment(3));
			
			$this->template->title = 'Pages | Edit: '. $this->template->content->page->title ;
		}
	}
	
	public function newpage()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$this->page->title = htmlspecialchars($this->input->post('form_title'));
			$this->page->view = 'default';
			
			if(strstr(config::item('s7n.page_views'), $this->input->post('form_view')) !== false)
			{
				$this->page->view = trim($this->input->post('form_view'));
			} 
			
			$this->page->intro = $this->input->post('form_intro');
			$this->page->body = $this->input->post('form_body');
			$this->page->uri = url::title($this->input->post('form_title'));
			$this->page->created_on = date("Y-m-d H:i:s");
			
			$publish_on = trim($this->input->post('form_publish_on'));        
			$this->page->publish_on = preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on) ? $publish_on : date("Y-m-d H:i:s");
			
			$this->page->modified_on = date("Y-m-d H:i:s");
			$this->page->created_by = $_SESSION['auth_user']->id;
			$this->page->modified_by = $_SESSION['auth_user']->id;
			$this->page->status = 'published';
			$this->page->comment_status = 'closed';
			$this->page->version = 1;
			
			$this->page->sidebar_content = $this->input->post('form_sidebar_content');
			$this->page->meta_keywords = htmlspecialchars($this->input->post('form_meta_keywords'));
			
			$this->page->save();
			
			$this->session->set('info_message', 'Page created successfully');
			url::redirect('pages');
		}
		else
		{
			$this->template->title = 'Pages | New Entry';
			$this->template->content = new View('pages/newpage');
		}
	}
	
	public function action()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if($this->input->post('action') == 'delete')
			{
				$this->page->delete($this->input->post('form_page_id'));
				$this->session->set_flash('flash_msg', 'Pages deleted successfully');
			}
		}
		
		url::redirect('pages');
	}
	
	public function settings()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if(Settings::save('page.views', $this->input->post('form_views')))
			{
				$this->session->set_flash('flash_msg', 'Page Settings edited successfully');
				url::redirect('pages/settings');
			}
		}
		
		$this->template->title = 'Pages | Settings';
		$this->template->content = new View('pages/settings');
		$this->template->content->views = Config::item('s7n.page_views');			
	}

}