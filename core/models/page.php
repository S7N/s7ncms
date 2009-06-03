<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */

class Page_Model extends ORM {

	protected $has_many = array('contents' => 'content_types');
	protected $belongs_to = array('author' => 'user');

	public function __construct($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id))
			$id = $this->id_from_uri($id);

		parent::__construct($id);
	}

	public function id_from_uri($uri, $language = FALSE)
	{
		$lang = $language ? language::id($language) : language::$id;

		$result = Database::instance()->query("
			SELECT `page_id` AS `id` FROM `content_types`
			WHERE `content_id` IN
				(SELECT `id` FROM `contents` WHERE language_id = ".(int) $lang." AND uri = '".$uri."')
			LIMIT 1
		");

		if (count($result) === 1)
			return (int) $result->current()->id;
		else
			return NULL;
	}

	public function content($language = FALSE)
	{
		$lang = $language ? language::id($language) : language::$id;

		$cache_name = sha1('page_content' . $this->id . language::$tag);

		if (($content = Cache::instance()->get($cache_name)) === NULL)
		{
			$content = $this->where(array('language_id' => $lang))->contents->current();

			Cache::instance()->set($cache_name, $content, array('page'));
		}

		return $content;
	}

	public function uri($language = FALSE)
	{
		$cache_name = sha1('page_uri' . $this->id . language::$tag);

		if (($uri = Cache::instance()->get($cache_name)) === NULL)
		{
			$uri = $this->content($language)->uri;

			Cache::instance()->set($cache_name, $uri, array('page'));
		}

		return $uri;
	}

}