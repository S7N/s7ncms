<?php defined('SYSPATH') or die('No direct script access.');

class Controller extends Controller_Core {

    protected $auto_render = true;
    
	// Main template
    protected $template = 'layout';

    // Controllers which you can access without login
    protected $not_protected = array(
    	'media', 'auth'
    );
    
    public function __construct() {
        parent::__construct();
        
        $current_url = url::current();
        $current_controller = explode('/', $current_url);        
        
        if(!in_array($current_controller[0], $this->not_protected)) {
        	if ($this->session->get('user_id')) {
        		$user = new User_Model((int) $this->session->get('user_id'));
        		if(!$user->has_role('admin')) {
        			// The user has no access to the admin interface!
        			Kohana::show_error('No Access', 'You have no access to the administration interface');
        		}
        	} else {
        		$this->session->set('redirect_me_to', $current_url);
        		url::redirect('auth/login');
        	}
        }
        
        $this->template = new View($this->template);
        $this->template->title = '';
        $this->template->meta = '';
        $this->template->content = '';
        
        Event::add('system.post_controller', array($this, '_display'));        
	}

    public function _display() {
        if($this->auto_render === true) {
            $this->template->render(true);
        }
    }
}