<?php defined('SYSPATH') or die('No direct script access.');

class User_Controller extends Admin_Controller {
	protected $user;
	
	public function index()
	{
		$this->user = new User_Model();
        
		$this->template->content = new View('user/list');
		$this->template->content->users = $this->user->get_all();
	}
    
    public function edit() {
    	if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
    		$user = new User_Model((int)$this->input->post('id'));
    		
			$new_roles = array_diff($this->input->post('roles'), $user->roles);
            $old_roles = array_diff($user->roles, $this->input->post('roles'));
            
            $myself = ((int)$this->input->post('id') == (int) $this->session->get('user_id'));
            
            foreach($new_roles as $role)
                $user->add_role($role);
            
            foreach($old_roles as $role)
			{
                if($myself and ($role == 'admin' or $role == 'login'))
				{
                    continue;
                }
                
                $user->remove_role($role);
            }
            
            $user->username = htmlspecialchars($this->input->post('username'));
            $user->email = htmlspecialchars($this->input->post('email'));
            $user->homepage = htmlspecialchars($this->input->post('homepage'));
            $user->first_name = htmlspecialchars($this->input->post('first_name'));
            $user->last_name = htmlspecialchars($this->input->post('last_name'));
            
            $password = trim($this->input->post('password'));
            if(!empty($password))
			{
            	$user->password = $password;                
            }
            
            $user->save();
            
            $this->session->set_flash('flash_msg', 'User edited successfully');

            url::redirect('user');
    	}
		else
		{
        	$user = new User_Model();
            $roles = new Role_Model();
            
			$user_id = (int) $this->uri->segment(3);
			
    		$content = new View('user/edit');
    		$content->user = $user->get($user_id);
            $content->usermodel = new User_Model($user_id);
            $content->roles = $roles->get_all();
            
            $this->template->content = $content;
        }
    }
    
    public function create()
	{
    	if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
    		$user = new User_Model();
    		$auth = new Auth();
    		
    		$user->username = htmlspecialchars($this->input->post('username'));
            $user->email = htmlspecialchars($this->input->post('email'));
            $user->homepage = htmlspecialchars($this->input->post('homepage'));
            $user->first_name = htmlspecialchars($this->input->post('first_name'));
            $user->last_name = htmlspecialchars($this->input->post('last_name'));
            $user->password = $this->input->post('password');
            
    		if ($user->save() AND $user->add_role('login'))
			{
				$this->session->set_flash('flash_msg', 'User created successfully');
			}
            
		    url::redirect('user');
    	}
		else
		{
        	$this->template->content = new View('user/create');
    	}
    }
    
    public function action()
	{
    	if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
    		if($this->input->post('action') == 'delete')
			{
    			$ids = $this->input->post('user_id');
    			foreach($ids as $id)
				{
    				$user = new User_Model($id);
    				$user->delete();
    			}
    		}
    	}
    	
    	$this->session->set_flash('flash_msg', 'User created successfully');

    	url::redirect('user');
    }
	
	public function roles()
	{
	    //$roles = new Role_Model();
        //echo Kohana::debug($roles->find_all());
	}
}