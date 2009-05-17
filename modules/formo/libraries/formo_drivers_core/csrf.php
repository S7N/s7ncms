<?php defined('SYSPATH') or die('No direct script access.');

class Formo_csrf_Driver extends Formo_Element {

	public function render()
	{
		$token = $_SESSION['formo_csrf_token'] = text::random('alnum', 16);
		return '<input type="hidden" name="'.$this->name.'" value="'.$token.'"'.Formo::quicktagss($this->_find_tags()).'" />';
	}
	
	protected function build()
	{
		return "\t".$this->render()."\n";
	}

	protected function validate_this()
	{
		if (Input::instance()->post($this->name) !== Session::instance()->get_once('formo_csrf_token', FALSE))
		{
			$this->error = $this->error_msg;

			return $this->error;
		}
	}

}