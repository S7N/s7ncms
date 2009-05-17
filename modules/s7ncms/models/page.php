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
class Page_Model extends ORM_MPTT {

	public $level_column = 'level';
	protected $children = 'pages';
	protected $belongs_to = array('user');
	protected $sorting = array('lft' => 'ASC');
	private $_identifier;
	private $computed_uri = NULL;

	public static $page_cache = array();

	private $page_columns = array(
		'uri', 'language', 'title', 'content', 'excerpt',
		'date', 'user_id', 'modified', 'password', 'status',
		'view', 'tags', 'keywords');

	public function __construct($id = NULL)
	{
		parent::__construct($id);

		$this->_identifier = text::random();
	}

	public function __get($column)
	{
		if (in_array($column, $this->page_columns))
		{
			if ( ! isset(self::$page_cache[$this->_identifier]))
				self::$page_cache[$this->_identifier] = ORM::factory('page_content')
					->where(array('page_id' => $this->id, 'language' => Router::$language))
					->find();

			return self::$page_cache[$this->_identifier]->$column;
		}

		return parent::__get($column);
	}

	public function title()
	{
		return parent::__get('title');
	}

	public function delete($id = NULL)
	{
		if ($id === NULL)
			$id = $this->id;
		
		$this->db->where('page_id', $id)->delete('page_contents');

		if ($id === $this->id AND isset(self::$page_cache[$this->_identifier]))
			unset(self::$page_cache[$this->_identifier]);

		return parent::delete($id);
	}

	public function uri($lang = NULL)
	{
		if ($this->computed_uri !== NULL AND $lang === NULL)
			return $this->computed_uri;
		
		if ($lang === NULL)
			$lang = Router::$language;

		$path = $this->path();
		$uri = array();
		foreach ($path as $x)
			if ($x->level > 0)
				$uri[] = ORM::factory('page_content')->select('uri')->where(array('language' => $lang, 'page_id' => $x->id))->find()->uri;

		$uri = implode('/', $uri);
		return $this->computed_uri = empty($uri) ? '/' : $uri;
	}

    public function paths()
    {
		$pages = $this->find_all();

		$paths = array('' => __('Do not Redirect'));
		foreach ($pages as $page)
		{
			if ($page->id === $this->id)
				continue;

			$titles = array();
			$uris = array();

			$path = $page->parents(FALSE)->find_all();

			foreach ($path as $pagex)
				$titles[] = $pagex->title();

			$titles[] = $page->title();
			$paths[$page->id] = implode(' &rarr; ', $titles);
		}

		return $paths;
    }

}