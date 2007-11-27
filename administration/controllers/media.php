<?php defined('SYSPATH') or die('No direct script access.');

class Media_Controller extends Controller {

	public function _remap() {
		$type = $this->uri->segment(2);
		$file = $this->uri->segment(3);
        $ext = substr(strrchr($file, '.'), 1 );
        
		$this->auto_render = false;
		
        $path = Kohana::find_file('views', 'media/'.$type.'/'.$file, FALSE, $ext);
        
        if(file_exists($path)) {
		
		    $time_file = filemtime(Kohana::find_file('views', 'media/'.$type.'/'.$file, FALSE, $ext));
            
            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {    		    
                $time_cache = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
                
                if ($time_file <= $time_cache) {
                    header('HTTP/1.1 304 Not Modified');
                    exit;
                }
            }
            
            $header = 'Last-Modified: ';
            $header .= gmdate('D, d M Y H:i:s', $time_file);
            $header .= ' GMT';
            header($header);
            
			echo new View('media/'.$type.'/'.$file);
		} else {
			Event::run('system.404');
		}
	}	
}