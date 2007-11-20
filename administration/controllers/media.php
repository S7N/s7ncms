<?php defined('SYSPATH') or die('No direct script access.');

class Media_Controller extends Controller {

	public function _remap()
	{
		$type = $this->uri->segment(2);
		$file = $this->uri->segment(3);

		$this->auto_render = false;
		
		try {
			echo new View('media/'.$type.'/'.$file);
		} catch (Kohana_Exception $e) {
			throw new Kohana_404_Exception();
		}
	}
}