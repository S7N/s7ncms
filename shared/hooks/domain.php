<?php defined('SYSPATH') or die('No direct script access.');

class Newdomain {
    public function __construct() {
        Event::add('system.ready', array($this, 'new_domain'));
    }
    
    public function new_domain() {
    	config::set('core.site_domain', config::item('domain.site_domain'));
    }
}

new Newdomain();
