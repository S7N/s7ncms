<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Model extends Model {
	public function get_all() {
		//DATE_FORMAT(content.created_on,'%d.%m.%Y, %H:%i') AS created_on,
		$this->db->select("
			pages.id,
			created_on,
			content.created_by,
			content.modified_on,
			content.title,
			content.uri,
			content.intro,
			content.body,
		");
        $this->db->from('pages');
        $this->db->join('content', 'content.id = pages.content_id', 'left');
        $this->db->groupby('pages.id');
        $this->db->orderby('pages.id','desc');

        $query = $this->db->get();

        if(count($query) > 0) {            
            return $query->result();
        }

        return null;
	}
	
	public function get($uri) {
		//DATE_FORMAT(content.created_on,'%d.%m.%Y, %H:%i') AS created_on,
		$this->db->select("
			pages.id,
			pages.sidebar_content,
			pages.content_id,
			pages.meta_keywords,
			content.created_on,
			content.created_by,
			content.publish_on,
			content.title,
			content.uri,
			content.intro,
			content.body
		");
        $this->db->from('pages');
        $this->db->join('content', 'content.id = pages.content_id', 'left');
        $this->db->groupby('pages.id');
        $this->db->orderby('content.created_on','desc');
        $this->db->limit(1);
        $this->db->where('content.uri', $uri);

        $query = $this->db->get();
		
        if(count($query) == 1) {            
            $result = $query->result();
            return $result[0];            
        }

        return null;
	}
}