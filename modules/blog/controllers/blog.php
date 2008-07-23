<?php defined('SYSPATH') or die('No direct script access.');
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
		$this->template->tagcloud = new Tagcloud(ORM::factory('blogpost')->all_tags());
	}

	public function _remap($method, $arguments)
	{
		if ($method == 'page')
		{
			$method = 'index';
		}
		elseif ( ! method_exists($this, $method))
		{
			$arguments = $method;
			$method = 'view';				
		}
		
		call_user_func_array(array($this, $method), $arguments);
	}
	
	public function index()
	{
		$this->pagination = new Pagination(array(
			'uri_segment'    => 'page',
			'items_per_page' => (int) Kohana::config('blog.items_per_page'),
			'total_items'    => ORM::factory('blogpost')->count_posts(),
			'style'          => 'digg'
		));
		
		$view = new View('blog/index');
		$view->blogposts = ORM::factory('blogpost')->orderby('id', 'desc')->find_all((int) Kohana::config('blog.items_per_page'), $this->pagination->sql_offset);
		
		$this->template->content = $view;
		$this->template->content->pagination = $this->pagination;
	}
	
	public function view($uri)
	{
		$view = new View('blog/view');
		$view->blogpost = ORM::factory('blogpost', (string) $uri);
		
		// Show 404 if we don't find blogposts
		if ((int) $view->blogpost->id === 0)
			Event::run('system.404');
			
		$this->head->javascript->append_file('media/js/jquery.js');
		$this->head->javascript->append_file('modules/blog/media/js/comments.js');
		
		$view->comments = $view->blogpost->comments;
		$view->form = '';
		
		if ($view->blogpost->comment_status === 'open' AND Kohana::config('blog.comment_status') === 'open')
		{
			$form = new Forge();
			$form->error_format('<span class="error">{message}</span><br />');
			$form->input('form_name')->label('Name')->rules('required|length[3,40]');
			$form->input('form_email')->label('E-Mail')->rules('valid_email');
			$form->input('form_homepage')->label('Homepage');
			$form->textarea('form_comment')->label('Kommentar')->rules('required');
			$form->submit('submit');
	 
			if ($form->validate())
			{
			    $comment = new Comment_Model;
				$comment->author = html::specialchars($form->form_name->value, TRUE);
				$comment->email = $form->form_email->value;
				$comment->url = html::specialchars($form->form_homepage->value, TRUE);
				$comment->ip = $this->input->ip_address();
				$comment->agent = html::specialchars(Kohana::$user_agent, TRUE);
				$comment->content = html::specialchars($form->form_comment->value, TRUE);
				$comment->date = date("Y-m-d H:i:s", time());
				
				// our 'honeypot'
				if($this->input->post('location') === 'none' OR $this->session->get('location') === 'none')
				{
					$view->blogpost->add_comment($comment);
					
					$this->session->delete('location');
				}
				
				url::redirect('blog/'.$uri);
			}
			else
			{
				if ($this->input->post('location') === 'none')
					$this->session->set('location', 'none');
	
			    $view->form = $form->render('blog/form_comment', TRUE);
			}
		}
		
		$this->template->content = $view;
		
		$this->head->title->prepend($view->blogpost->title);
	}
	
	public function feed()
	{
		$this->auto_render = FALSE;
		if($this->profiler)
		{
			$this->profiler->disable();
		}
			
		$view = new View('blog/feed');
		$view->posts = ORM::factory('blogpost')->orderby('id', 'desc')->find_all(10);
		
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
		$view->comments = ORM::factory('comment')->orderby('id', 'desc')->find_all(20);
		
		header('Content-Type: text/xml; charset=UTF-8', TRUE);
		echo $view;
	}
	
	public function tag($tag)
	{
		$view = new View('blog/index');
		$view->blogposts = ORM::factory('blogpost')->like('tags', '%'.$tag.'%')->orderby('id', 'desc')->find_all();
		
		$this->template->content = $view;
	}

}