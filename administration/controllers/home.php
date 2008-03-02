<?php defined('SYSPATH') or die('No direct script access.');

class Home_Controller extends Admin_Controller {

	public function __construct() {
		parent::__construct();
	}
    public function index() {
        $this->template->title = 'Home';
        $this->template->content = new View('home/home');
    }
    public function xyz() {
    	$this->template->content = 'hi@';
    }

}