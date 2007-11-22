<?php defined('SYSPATH') or die('No direct script access.');

class Settings_Core {
	public static function item($key = false) {
		if($key === false) {
			return null;
		}
		
		$key = explode('.', $key);
		if(count($key) != 2) {
			return null;
		}
		
		$context = $key[0];
		$key = $key[1];

		$db = new Database();
		
		$query = $db->select('value')
			->from('settings')
			->where('context', $context)
			->where('key', $key)
			->limit(1)
			->get();
		
		if(count($query) != 1) {
			return null; 
		}
		
		$result = $query->result();
        return $result[0]->value;
	}
}