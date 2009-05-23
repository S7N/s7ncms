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
class Comments_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->template->tasks = array(
			array('admin/blog/create', __('New Post')),
			array('admin/blog/comments', __('All comments')),
			array('admin/blog/settings', __('Edit Settings'))
		);

		$this->head->title->append('Blog');
		$this->template->title = html::anchor('admin/blog', 'Blog').' | ';
	}

	public function index()
	{
		$this->template->content = new View('blog/comments');
		$this->template->content->comments = ORM::factory('blog_comment')->orderby('id', 'DESC')->find_all();

		$this->head->title->append(__('All comments'));
		$this->template->title .= __('All comments');
	}

	public function view($blog_post_id)
	{
		$post = ORM::factory('blog_post', (int) $blog_post_id);
		
		if ( ! $post->loaded)
			message::error(__('Invalid ID'), 'admin/blog');

		$this->template->content = new View('blog/comments');
		$this->template->content->comments = $post->blog_comments;

		$this->head->title->append(__('Comments for: %title', array('%title' => $post->title)));
		$this->template->title .= __('Comments for: %title', array('%title' => $post->title));
	}

	public function edit($id)
	{
		$comment = ORM::factory('blog_comment', (int) $id);
		
		if ( ! $comment->loaded)
			message::error(__('Invalid ID'), 'admin/blog');
		
		$this->head->title->append(__('Edit comment #%id', array('%id' => $comment->id)));
		$this->template->title .= __('Edit comment #%id', array('%id' => $comment->id));
		
		$form = Formo::factory()
			->plugin('csrf')
			->add('text', 'author', array('label' => __('Author'), 'value' => $comment->author))
			->add('text', 'email', array('label' => __('Email'), 'value' => $comment->email))
			->add('text', 'url', array('label' => __('Homepage'), 'value' => $comment->url))
			->add('textarea', 'content', array('label' => __('Comment'), 'value' => $comment->content))
			->add('submit', 'submit', array('label' => __('Save')));
			
		if($form->validate())
		{
			$comment->author = $form->author->value;
			$comment->email = $form->email->value;
			$comment->url = $form->url->value;
			$comment->content = $form->content->value;
			$comment->save();

			Cache::instance()->delete('s7n_blog_feed_comments');

			message::info(__('Comment edited successfully'), 'admin/blog/comments/view/'.$comment->blog_post_id);
		}
		
		$this->template->content = View::factory('blog/editcomment', $form->get(TRUE));
	}
	
	public function delete($id)
	{
		$comment = ORM::factory('blog_comment', (int) $id);
		
		if ( ! $comment->loaded)
			message::error(__('Invalid ID'), 'admin/blog');
		
		$comment->delete();

		Cache::instance()->delete('s7n_blog_feed_comments');

		message::info(__('Comment deleted successfully'), 'admin/blog');
	}
	
	public function close($blog_post_id)
	{
		$this->comments_status('open', $blog_post_id);
	}
	
	public function open($blog_post_id)
	{
		$this->comments_status('close', $blog_post_id);
	}
	
	private function change_status($blog_post_id)
	{
		$post = ORM::factory('blog_post', (int) $blog_post_id);

		if ( ! $post->loaded)
			message::error(__('Invalid ID'), 'admin/blog');

		$post->comment_status = $status;
		$post->save();

		message::info(__('Comment status changed to "%status"', array('status' => $status)), 'admin/blog');
	}
	
}