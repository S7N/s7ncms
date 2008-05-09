<?php defined('SYSPATH') or die('No direct script access.');

class Settings_Controller extends Administration_Controller {
	
	public function index()
	{
		$this->head['title']->append('Settings');
		
		$this->template->title = 'Settings';
	    $this->template->content = new View('settings/settings');
	    $this->template->content->site_title = config::item('s7n.site_title');
        $this->template->content->default_uri = config::item('s7n.default_uri');
	}
    
    public function save()
	{
        if($_SERVER["REQUEST_METHOD"] === 'POST')
		{
			// Default URI
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
			
			// Site Title
			$this->db
			->update(
				'config', 
				array(
					'value' => $this->input->post('site_title')
				),
				array(
					'context' => 's7n',
					'key' => 'site_title'
				)
			);
			
			$this->session->set_flash('info_message', 'Settings edited successfully');
        }

        url::redirect('admin/settings');
    }

}