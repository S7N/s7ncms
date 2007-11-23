<?php defined('SYSPATH') or die('No direct script access.');

class User_Controller extends Controller {
	protected $user;
	
	public function index() {
		$this->user = new User_Model();
        
		$content = new View('user/list');
		$content->users = $this->user->get_all();
		
		$this->template->content = $content;
    }
    
    public function edit() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST') {
    		$user = new User_Model((int)$this->input->post('id'));
    		$user->username = htmlspecialchars($this->input->post('username'));
            $user->email = htmlspecialchars($this->input->post('email'));
            $user->homepage = htmlspecialchars($this->input->post('homepage'));
            $user->first_name = htmlspecialchars($this->input->post('first_name'));
            $user->last_name = htmlspecialchars($this->input->post('last_name'));
            
            $password = trim($this->input->post('password'));
            if(!empty($password)) {
            	$auth = new Auth();
            	$user->password = $auth->hash_password($password);
            }
            
            //$user->save();           

            $this->session->set_flash('flash_msg', 'User edited successfully');

            url::redirect('user');
    	} else {
        	$this->user = new User_Model();
            
    		$content = new View('user/edit');
    		$content->user = $this->user->get((int) $this->uri->segment(3));
    		$this->template->content = $content;
        }
    }
    
    public function create() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST') {
    		$user = new User_Model();
    		$auth = new Auth();
    		
    		$user->username = htmlspecialchars($this->input->post('username'));
            $user->email = htmlspecialchars($this->input->post('email'));
            $user->homepage = htmlspecialchars($this->input->post('homepage'));
            $user->first_name = htmlspecialchars($this->input->post('first_name'));
            $user->last_name = htmlspecialchars($this->input->post('last_name'));
            $user->password = $auth->hash_password($this->input->post('password'));            
            
            $user->save();           

            $this->session->set_flash('flash_msg', 'User created successfully');

            url::redirect('user');
    	} else {
        	$this->template->content = new View('user/create');
    	}
    }
    
    public function action() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST') {
    		if($this->input->post('action') == 'delete') {
    			$ids = $this->input->post('user_id');
    			foreach($ids as $id) {
    				$user = new User_Model($id);
    				$user->delete();
    			}
    		}
    	}
    	
    	$this->session->set_flash('flash_msg', 'User created successfully');

    	url::redirect('user');
    }
}