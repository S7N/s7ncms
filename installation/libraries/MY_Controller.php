<?php defined('SYSPATH') or die('No direct script access.');

class Controller extends Controller_Core {

    protected $auto_render = true;
    
	// Main template
    protected $template = 'layout';

    public function __construct() {
        parent::__construct();
        
        $this->template = new View($this->template);
        $this->template->title = '';
        $this->template->message = '';
        
        Event::add('system.post_controller', array($this, '_display'));        
	}

    public function _display() {
        if($this->auto_render === true) {
            $this->template->render(true);
        }
    }
}