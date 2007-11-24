<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Model extends Model {
    protected $id = null;
    public $page = array(
        'content_id' => null,
        'sidebar_content' => null,
        'meta_keywords' => null    
    );
    
    public $content = array(
        'version' => null,
        'title' => null,
        'uri' => null,
        'intro' => null,
        'body' => null,
        'publish_on' => null,
        'created_on' => null,
        'created_by' => null,
        'modified_on' => null,
        'modified_by' => null,
        'tags' => null,
        'status' => null,
        'comment_status' => null,
        'password' => null,
        'view' => null
    );
    
    public function __set($key, $value) {
        if($key == 'id') {
            $this->id = $value;
            return true;
        }
        
        if(array_key_exists($key, $this->page)) {
            $this->page[$key] = $value;
            return true;
        } elseif(array_key_exists($key, $this->content)) {
            $this->content[$key] = $value;
            return true;
        }
        
        
        return false;
    }
    
    public function __get($key) {
        if(in_array($key, $this->page)) {
            return $this->page[$key];
        }
        
        if(in_array($key, $this->content)) {
            return $this->content[$key];
        }
        
        return false;
    }
    
    public function save() {
        /* if there is no ID, we have to create a new page */
        if(is_null($this->id)) {
            $query = $this->db->insert('content', array_filter($this->content, array($this, 'filter_null')));
            $this->page['content_id'] = $query->insert_id();
            $this->db->insert('pages', array_filter($this->page, array($this, 'filter_null')));
            return true;
        } else {
            $this->db->update('content', array_filter($this->content, array($this, 'filter_null')), array('id' => (int) $this->id));        
            $this->db->update('pages', array_filter($this->page, array($this, 'filter_null')), array('id' => (int) $this->id));
            return true;
        }
        
        return false;
    }
    
    public function filter_null($value) {
        return !is_null($value);
    }
    
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