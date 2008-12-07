<?php defined('SYSPATH') or die('No direct script access.');

class Pages_Model extends Model {
	public function get($uri = false) {
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
            content.tags
        FROM pages
        LEFT JOIN content
        ON content.id = pages.content_id
        WHERE content.status = 'published'
            AND content.publish_on <= NOW()
            AND content.uri = ?
        GROUP BY pages.id
        ORDER BY content.created_on
        DESC LIMIT 0, 1
		", array($uri));

        if($query->num_rows() > 0) {
            
            $result = $query->result();
            return $result[0];
            
        }

        return null;
	}
}