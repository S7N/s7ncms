<?php defined('SYSPATH') or die('No direct script access.');

class Settings_Controller extends Controller {
	public function index() {
	    $this->template->content = new View('settings/settings');
        $this->template->content->default_uri = Settings::item('s7n.default_uri');
	}
    
    public function save() {
        if($_SERVER["REQUEST_METHOD"] !== 'POST') {
            $this->session->set_flash('flash_msg', 'POST it..');
            url::redirect('settings');
        }
        
        if(Settings::save('s7n.default_uri', $this->input->post('default_uri'))) {
            $this->session->set_flash('flash_msg', 'Settings edited successfully');
            url::redirect('settings');
        }
    }
}