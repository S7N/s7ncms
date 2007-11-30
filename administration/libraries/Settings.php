<?php defined('SYSPATH') or die('No direct script access.');

class Settings_Core {
    private static $items = array();
    
    public static function save($key=false, $value=false) {
        if($value===false) {
            return false;
        }
        
        $key = explode('.', $key);
		if(count($key) != 2) {
			return false;
		}
        
        $context = $key[0];
		$key = $key[1];
        
        $db = new Database();
        $db->update('settings', array('value' => $value), array('context' => $context, 'key' => $key));
        return true;
    }
    
    public static function item($key = false) {
        if(empty(self::$items)) {
            self::get_all();
        }
        
		if($key === false) {
			return null;
		}
		
		$key = explode('.', $key);
		if(count($key) != 2) {
			return null;
		}
		
		$context = $key[0];
		$key = $key[1];

		if(array_key_exists($context, self::$items) and array_key_exists($key, self::$items[$context])) {
		    return self::$items[$context][$key];
		}
	}
    
    private static function get_all() {
        $db = new Database();
		
		$query = $db->select('context, key, value')
			->from('settings')
			->get();
        
        $result = $query->result();
        foreach ($result as $item) {
            self::$items[$item->context] = array($item->key => $item->value);
        }        
    }
}