<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Controller extends Controller {
	protected $page;
	
	public function __construct() {
		parent::__construct();
		$this->page = new Pages_Model();
		$this->template->meta .= html::script('media/js/mootabs');
        $this->template->meta .= html::stylesheet('media/css/mootabs');
	}

	public function index() {
        $this->template->title = 'Home';
        $this->template->content = new View('pages/all');
        $this->template->content->pages = $this->page->get_all();
    }

    public function edit() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST') {
    		$data = array();
            $data['title'] = htmlspecialchars($this->input->post('title'));
            $data['intro'] = $this->input->post('intro');
            $data['body'] = $this->input->post('body');
            $data['uri'] = url::title($this->input->post('title'));
            
            $publish_on = trim($this->input->post('publish_on'));        
            if(preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on)) {                
                $data['publish_on'] = $publish_on;                
            } /*else {
            	$data['publish_on'] = date("Y-m-d H:i:s");
            }*/
            
            $data['modified_on'] = date("Y-m-d H:i:s");
            $data['modified_by'] = $this->session->get('user_id');
            $this->db->where('id', (int)$this->input->post('content_id'));
            $this->db->update('content', $data);
            
            $data = array();
	        $data['sidebar_content'] = $this->input->post('sidebar_content');
	        $data['meta_keywords'] = htmlspecialchars($this->input->post('meta_keywords'));
	        
	        $this->db->where('content_id', (int)$this->input->post('content_id'));
	        $this->db->update('pages', $data);

            $this->session->set_flash('flash_msg', 'Page edited successfully');

            url::redirect('pages');
    	} else {
        	$this->template->content = new View('pages/edit');
        	$this->template->content->page = $this->page->get($this->uri->segment(3));
    	}
    }
    
    public function newpage() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST') {
        	$data['title'] = htmlspecialchars($this->input->post('title'));
            $data['intro'] = $this->input->post('intro');
            $data['body'] = $this->input->post('body');
            $data['uri'] = url::title($this->input->post('title'));
            $data['created_on'] = date("Y-m-d H:i:s");
            
            $publish_on = trim($this->input->post('publish_on'));        
            $data['publish_on'] = preg_match('/^\d{4}\-\d{2}\-\d{2} \d{2}\:\d{2}\:\d{2}$/', $publish_on) ? $publish_on : date("Y-m-d H:i:s");
            
            $data['modified_on'] = date("Y-m-d H:i:s");
            $data['created_by'] = $this->session->get('user_id');
            $data['modified_by'] = $this->session->get('user_id');
            $data['status'] = 'published';
            $data['comment_status'] = 'closed';
            $data['version'] = 1;
            $query = $this->db->insert('content',$data);
            
            $data = array();
            $data['content_id'] = $query->insert_id();
            $data['sidebar_content'] = $this->input->post('sidebar_content');
            $data['meta_keywords'] = htmlspecialchars($this->input->post('meta_keywords'));
            
            $this->db->insert('pages', $data);
            
            $this->session->set('message', 'Page created successfully');
            url::redirect('pages');
    	} else {
        	$this->template->content = new View('pages/new');
        }
    }

}