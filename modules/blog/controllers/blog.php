<?php
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2008, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Eduard Baun <eduard at baun.de>
 * @copyright Eduard Baun, 2007-2008
 * @version $Id$
 */
class Blog_Controller extends Website_Controller {

	protected $blog;

	public function __construct()
	{
		parent::__construct();
		$this->head->link->append('blog/feed');

		Sidebar::instance()->add
		(
			'Tagcloud',
			array
			(
				'tags' => ORM::factory('blog_post')->all_tags()
			)
		);
	}

	public function __call($method, $arguments)
	{
		if ($method == 'page')
		{
			$method = 'index';
		}
		elseif ( ! method_exists($this, $method))
		{
			$arguments = $method;
			$method = '_view';
		}

		call_user_func_array(array($this, $method), $arguments);
	}

	public function index()
	{
		$this->pagination = new Pagination(array(
			'uri_segment'    => 'page',
			'items_per_page' => (int) Kohana::config('blog.items_per_page'),
			'total_items'    => ORM::factory('blog_post')->count_posts(),
			'style'          => 'digg'
		));

		$view = new View('blog/index');
		$view->posts = ORM::factory('blog_post')->orderby('id', 'desc')->find_all((int) Kohana::config('blog.items_per_page'), $this->pagination->sql_offset);

		$this->template->content = $view;
		$this->template->content->pagination = $this->pagination;
	}

	private function _view($uri)
	{
		$view = new View('blog/view');
		$view->post = ORM::factory('blog_post', (string) $uri);

		// Show 404 if we don't find posts
		if ( ! $view->post->loaded)
			Event::run('system.404');

		$this->head->javascript->append_file('media/js/jquery.js');
		$this->head->javascript->append_file('modules/blog/media/js/comments.js');

		$view->comments = $view->post->blog_comments;
		$view->form = '';

		if ($view->post->comment_status === 'open' AND Kohana::config('blog.comment_status') === 'open')
		{

			$fields = array
			(
				'author'  => '',
				'email'   => '',
				'url'     => '',
				'content' => '',
			);

			$errors = $fields;

			if ($_POST)
			{
				$_POST = new Validation($_POST);

				$_POST
				->pre_filter('trim')

				->post_filter('html::specialchars', 'author', 'url', 'content')

				->add_rules('author', 'required', 'length[2,40]')
				->add_rules('email', 'valid::email')
				->add_rules('content', 'required');

				if ($_POST->validate())
				{
					$comment = new Blog_comment_Model;
					$comment->author  = $_POST['author'];
					$comment->email   = $_POST['email'];
					$comment->content = $_POST['content'];
					$comment->url     = $_POST['url'];
					$comment->ip      = $this->input->ip_address();
					$comment->agent   = html::specialchars(Kohana::$user_agent);
					$comment->date    = date("Y-m-d H:i:s", time());

					// our 'honeypot' part one
					if($this->input->post('location') === 'none' OR $this->session->get('location') === 'none')
					{
						$view->post->add_comment($comment);
			
						$this->session->delete('location');
					}

					url::redirect($view->post->get_url());
				}
				else
				{
					// our 'honeypot' part zwo
					if ($this->input->post('location') === 'none')
						$this->session->set('location', 'none');

					$fields   = arr::overwrite($_POST->as_array());
					$errors = arr::overwrite($_POST->errors('blog_form_error_messages'));
				}
			}

			$view->form = View::factory('blog/form_comment');
			$view->form->fields = $fields;
			$view->form->errors = $errors;
		}

		$this->template->content = $view;

		$this->head->title->prepend($view->post->title);
	}

	public function feed()
	{
		$this->auto_render = FALSE;
		if($this->profiler)
		{
			$this->profiler->disable();
		}
			
		$view = new View('blog/feed');
		$view->posts = ORM::factory('blog_post')->orderby('id', 'desc')->find_all(10);

		header('Content-Type: text/xml; charset=UTF-8', TRUE);
		echo $view;
	}

	public function commentfeed()
	{
		$this->auto_render = FALSE;
		if($this->profiler)
		{
			$this->profiler->disable();
		}
			
		$view = new View('blog/commentfeed');
		$view->comments = ORM::factory('blog_comment')->orderby('id', 'desc')->find_all(20);

		header('Content-Type: text/xml; charset=UTF-8', TRUE);
		echo $view;
	}

	public function tag($tag)
	{
		$view = new View('blog/index');
		$view->posts = ORM::factory('blog_post')->like('tags', '%'.$tag.'%')->orderby('id', 'desc')->find_all();

		$this->template->content = $view;
	}

}