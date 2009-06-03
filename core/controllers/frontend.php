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

class Frontend_Controller extends Controller {
	
	// Template view name
	public $template = 'template';
	
	// Default to do auto-rendering
	public $auto_render = TRUE;
	
	public $content;

	public function __construct()
	{
		parent::__construct();
		
		// Load the template
		$this->template = View::factory($this->template)
			->bind('content', $this->content);

		if ($this->auto_render == TRUE)
		{
			// Render the template immediately after the controller method
			Event::add('system.post_controller', array($this, '_render'));
		}
	}
	
	/**
	 * Render the loaded template.
	 */
	public function _render()
	{
		if ($this->auto_render == TRUE)
		{
			// Render the template when the class is destroyed
			$this->template->render(TRUE);
		}
	}
	
}