<?php defined('SYSPATH') or die('No direct script access.');

class Media_Controller extends Controller {

	public function _default()
	{
		
		$segments = $this->uri->argument_array();
		
		$filename = array_pop($segments);
		$type = implode('/',$segments);
		
		if (($pos = strrpos($filename, '.')) !== false)
		{
			$extension = substr($filename, $pos+1);
			$filename = substr($filename, 0, $pos);
		}
		else
		{
			$extension = '';
		}
		
		if($path = Kohana::find_file('views/media/'.$type, $filename, FALSE, $extension))
		{
			$time_file = filemtime($path);

			if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
			{
				$time_cache = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);

				if ($time_file <= $time_cache)
				{
					header('HTTP/1.1 304 Not Modified');
					exit;
				}
			}

			$header = 'Last-Modified: ';
			$header .= gmdate('D, d M Y H:i:s', $time_file);
			$header .= ' GMT';
			header($header);

			echo new View('media/'.$type.'/'.$filename, null, $extension);
		}
		else
		{
			Event::run('system.404');
		}
	}	
}