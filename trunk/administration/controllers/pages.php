<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Admin_Controller {
	
	protected $page;
	
	public function __construct()
	{
		parent::__construct();

		$this->page = new Pages_Model();
		$this->template->meta .= html::script('media/js/mootabs.js', TRUE);
		$this->template->meta .= html::stylesheet('media/css/mootabs.css', '', TRUE);
	}

	public function index()
	{
		$this->template->title = 'Home';
		$this->template->content = new View('pages/all');
		$this->template->content->pages = $this->page->get_all();
	}

	public function edit()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$this->page->id = (int) $this->input->post('content_id');
			$this->page->title = htmlspecialchars($this->input->post('title'));
			
			if(strstr(Settings::item('page.views'), $this->input->post('view')) !== false)
			{
				$this->page->view = trim($this->input->post('view'));
			}
			
			$this->page->intro = $this->input->post('intro');
			$this->page->body = $this->input->post('body');
			$this->page->uri = url::title($this->input->post('title'));
			
			$publish_on = trim($this->input->post('publish_on'));        

			if(preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on))
			{                
				$this->page->publish_on = $publish_on;                
			}
			
			$this->page->modified_on = date("Y-m-d H:i:s");
			$this->page->modified_by = $this->session->get('user_id');
			$this->page->sidebar_content = $this->input->post('sidebar_content');
			$this->page->meta_keywords = htmlspecialchars($this->input->post('meta_keywords'));
			
			$this->page->save();
			
			$this->session->set_flash('flash_msg', 'Page edited successfully');

			url::redirect('pages');
		}
		else
		{
			$this->template->content = new View('pages/edit');
			$this->template->content->page = $this->page->get($this->uri->segment(3));
		}
	}
	
	public function newpage()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$this->page->title = htmlspecialchars($this->input->post('title'));
			$this->page->view = 'default';
			
			if(strstr(Settings::item('page.views'), $this->input->post('view')) !== false)
			{
				$this->page->view = trim($this->input->post('view'));
			} 
			
			$this->page->intro = $this->input->post('intro');
			$this->page->body = $this->input->post('body');
			$this->page->uri = url::title($this->input->post('title'));
			$this->page->created_on = date("Y-m-d H:i:s");
			
			$publish_on = trim($this->input->post('publish_on'));        
			$this->page->publish_on = preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on) ? $publish_on : date("Y-m-d H:i:s");
			
			$this->page->modified_on = date("Y-m-d H:i:s");
			$this->page->created_by = $this->session->get('user_id');
			$this->page->modified_by = $this->session->get('user_id');
			$this->page->status = 'published';
			$this->page->comment_status = 'closed';
			$this->page->version = 1;
			
			$this->page->sidebar_content = $this->input->post('sidebar_content');
			$this->page->meta_keywords = htmlspecialchars($this->input->post('meta_keywords'));
			
			$this->page->save();
			
			$this->session->set('message', 'Page created successfully');
			url::redirect('pages');
		}
		else
		{
			$this->template->content = new View('pages/new');
		}
	}
	
	public function action()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if($this->input->post('action') == 'delete')
			{
				$this->page->delete($this->input->post('page_id'));
				$this->session->set_flash('flash_msg', 'Pages deleted successfully');
			}
		}
		
		url::redirect('pages');
	}
	
	public function settings()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			if(Settings::save('page.views', $this->input->post('views')))
			{
				$this->session->set_flash('flash_msg', 'Page Settings edited successfully');
				url::redirect('pages/settings');
			}
		}
		
		$this->template->content = new View('pages/settings');
		$this->template->content->views = Settings::item('page.views');			
	}

}