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
class User_Controller extends Administration_Controller {
	protected $user;

	public function index()
	{
		$this->template->content = View::factory('user/list', array(
			'users' => ORM::factory('user')->get_all()
		));
	}

    public function edit() {
    	if($_POST)
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

            $user->username = html::specialchars($this->input->post('username'));
            $user->email = html::specialchars($this->input->post('email'));
            $user->homepage = html::specialchars($this->input->post('homepage'));
            $user->first_name = html::specialchars($this->input->post('first_name'));
            $user->last_name = html::specialchars($this->input->post('last_name'));

            $password = trim($this->input->post('password'));
            if(!empty($password))
			{
            	$user->password = $password;
            }

            $user->save();

            $this->session->set_flash('flash_msg', 'User edited successfully');

            url::redirect('admin/user');
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

    		$user->username = html::specialchars($this->input->post('username'));
            $user->email = html::specialchars($this->input->post('email'));
            $user->homepage = html::specialchars($this->input->post('homepage'));
            $user->first_name = html::specialchars($this->input->post('first_name'));
            $user->last_name = html::specialchars($this->input->post('last_name'));
            $user->password = $this->input->post('password');

    		if ($user->save() AND $user->add_role('login'))
			{
				$this->session->set_flash('flash_msg', 'User created successfully');
			}

		    url::redirect('admin/user');
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

    	url::redirect('admin/user');
    }

}