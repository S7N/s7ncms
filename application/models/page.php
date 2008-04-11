<?php defined('SYSPATH') or die('No direct script access.');

class Page_Model extends ORM {
	protected $belongs_to = array('user');
	
	/**
	 * Allows Pages to be loaded by id or uri title.
	 */
	protected function where_key($id = NULL)
	{
		if(! ctype_digit($id))
		{
			return 'uri';
		}
		
		return parent::where_key($id);
	}
}

/*class Pages_Model extends Model {
	
	public function get($uri = false)
	{
		$prefix = config::item('database.default.table_prefix');
		
		$query = $this->db->query("
		SELECT 
            pages.id,
            pages.sidebar_content,
            pages.meta_keywords,
            DATE_FORMAT(content.created_on,'%d.%m.%Y, %H:%i') AS created_on,
            content.created_by,
            content.title,
            content.uri,
            content.intro,
            content.body,
            content.tags,
			content.view
        FROM ".$prefix."pages AS pages
        LEFT JOIN ".$prefix."content AS content
        ON content.id = pages.content_id
        WHERE content.status = 'published'
            AND content.publish_on <= NOW()
            AND content.uri = ?
        GROUP BY pages.id
        ORDER BY content.created_on
        DESC LIMIT 0, 1
		", array($uri));

        if(count($query) > 0)
		{
            $result = $query->result();
            return $result[0];
        }

        return null;
	}
	
}*/