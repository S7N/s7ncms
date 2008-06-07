<?php defined('SYSPATH') or die('No direct script access.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2008, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2008
 * @version $Id$
 */
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