<?php defined('SYSPATH') or die('No direct script access.');

class Settings_Controller extends Administration_Controller {
	
	public function index()
	{
	    $this->template->content = new View('settings/settings');
        $this->template->content->default_uri = config::item('s7n.default_uri');
	}
    
    public function save()
	{
        if($_SERVER["REQUEST_METHOD"] === 'POST')
		{
            $this->db
			->update(
				'config', 
				array(
					'value' => $this->input->post('default_uri')
				),
				array(
					'context' => 's7n',
					'key' => 'default_uri'
				)
			);

			$this->session->set_flash('info_message', 'Settings edited successfully');
        }

        url::redirect('admin/settings');
    }

}