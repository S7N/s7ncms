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
class Blog_Controller extends Administration_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->template->tasks = array(
			array('admin/blog/newpost', 'New Post'),
			array('admin/blog/settings', 'Edit Settings')
		);

		$this->head->title->append('Blog');
		$this->template->title = html::anchor('admin/blog', 'Blog').' | ';
	}

	public function index()
	{
		$this->template->searchbar = TRUE;

		$posts = array();

		$q = trim($this->input->get('q'));

		if ( ! empty($q))
		{
			$this->template->searchvalue = $q;
			$this->template->title .= 'Filter: '.$q;
			$this->head->title->append('Filter: '.$q);

			$posts = ORM::factory('blog_post')->orderby('id', 'desc')->orlike(array(
				'title' => '%'.$q.'%',
				'excerpt' => '%'.$q.'%',
				'content' => '%'.$q.'%',
				'tags' => '%'.$q.'%'
			))->find_all();
		}
		else
		{
			$this->template->title .= 'All Posts';
			$this->head->title->append('All Posts');

			$posts = ORM::factory('blog_post')->orderby('id', 'desc')->find_all();
		}

		$this->template->content = View::factory('blog/index')->set(array(
			'posts' => $posts
		))->render();
	}

	public function newpost()
	{
		if($_POST)
		{
			$post = new Blog_post_Model;
			$post->user_id = $_SESSION['auth_user']->id;

			$post->title = html::specialchars($this->input->post('form_title'), FALSE);

			$uri = url::title($this->input->post('form_title'));

			// Check if uri already exists and add a suffix
			$result = $this->db->select('uri')->like('uri', $uri.'%', FALSE)->get('blog_posts');
			if (count($result) > 0)
			{
				$max = 0;
				foreach ($result as $row)
				{
					$suffix = substr($row->uri, strlen($uri)+1);
					if(ctype_digit($suffix) AND $suffix > $max)
						$max = $suffix;
				}

				if ($max === 0)
					$uri .= '-2';
				else
					$uri .= '-'.($max+1);
			}

			$post->uri = $uri;

			$post->content = $this->input->post('form_content');

			$post->date = date("Y-m-d H:i:s");
			$page->modified = date("Y-m-d H:i:s");

			$post->tags = html::specialchars($this->input->post('form_tags'), FALSE);

			$post->save();

			// delete feed cache
			Cache::instance()->delete('s7n_blog_feed');

			$this->session->set_flash('info_message', 'Post created successfully');
			url::redirect('admin/blog');
		}
		else
		{
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('New Post');

			$this->template->title .= 'New Post';
			$this->template->tabs = array('Content', 'Advanced');
			$this->template->content = View::factory('blog/newpost')->render();
		}
	}

	public function edit()
	{
		if($_POST)
		{
			$post = ORM::factory('blog_post', (int) $this->input->post('form_id'));

			$post->title = html::specialchars($this->input->post('form_title'), FALSE);
			$post->uri = url::title($this->input->post('form_title'));

			$post->content = $this->input->post('form_content');

			$post->modified = date("Y-m-d H:i:s");
			$post->tags = html::specialchars($this->input->post('form_tags'), FALSE);

			$post->save();

			// delete feed cache
			Cache::instance()->delete('s7n_blog_feed');

			$this->session->set_flash('info_message', 'Post edited successfully');

			url::redirect('admin/blog');
		}
		else
		{
			$post = ORM::factory('blog_post', (int) $this->uri->segment(4));

			$this->template->tabs = array('Content', 'Advanced');

			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: '. $post->title);
			$this->template->title .= 'Edit: '. $post->title;

			$this->template->content = View::factory('blog/edit')->set(array(
				'post' => $post
			))->render();
		}
	}

	public function comments($action, $id = NULL)
	{
		// accept only valid actions
		if (in_array($action, array('open', 'close', 'edit', 'delete')))
		{
			$function_name = 'comments_'.$action;

			if(ctype_digit($id))
				$this->$function_name($id);
			else
				Event::run('system.404');
		}
		else
		{
			if(ctype_digit($action))
				$this->comments_view($action);
			else
				Event::run('system.404');
		}
	}

	private function comments_view($id)
	{
		$post = ORM::factory('blog_post', (int) $id);
		$this->template->content = new View('blog/comments');
		$this->template->content->comments = $post->blog_comments;

		$this->head->title->append('Comments for: '. $post->title);
		$this->template->title .= 'Comments for: '. $post->title;
	}

	private function comments_open($id)
	{
		$this->comments_status('open', $id);
	}

	private function comments_close($id)
	{
		$this->comments_status('close', $id);
	}

	private function comments_status($status, $id)
	{
		$post = ORM::factory('blog_post', (int) $id);

		if ($post->id === 0)
		{
			$this->session->set_flash('error_message', 'Invalid id');
			url::redirect('admin/blog');
		}

		$post->comment_status = $status;
		$post->save();

		$this->session->set_flash('info_message', 'Comment status changed to "'.$status.'"');

		url::redirect('admin/blog');
	}

	private function comments_edit($id)
	{
		if($_POST)
		{
			$comment = ORM::factory('blog_comment', (int) $id);
			$comment->author = $this->input->post('form_author');
			$comment->email = $this->input->post('form_email');
			$comment->url = $this->input->post('form_url');
			$comment->content = $this->input->post('form_content');
			$comment->save();

			$this->session->set_flash('info_message', 'Comment edited successfully');

			url::redirect('admin/blog/comments/'.$comment->blog_post_id);
		}
		else
		{
			$comment = ORM::factory('blog_comment', (int) $id);

			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: Comment #'. $comment->id);
			$this->template->title .= 'Edit: Comment #'. $comment->id;

			$this->template->content = View::factory('blog/editcomment')->set(array(
				'comment' => $comment
			))->render();
		}
	}

	private function comments_delete($id)
	{
		$comment = ORM::factory('blog_comment', (int) $id);
		if ($comment->loaded)
		{
			$post = ORM::factory('blog_post', (int) $comment->blog_post_id);
			$post->comment_count -= 1;
			$post->save();

			$comment->delete();

			$this->session->set_flash('info_message', 'Comment deleted successfully');
			url::redirect('admin/blog/comments/'.$post->id);
		}
		else
		{
			$this->session->set_flash('error_message', 'Invalid id');
			url::redirect('admin/blog');
		}
	}

	public function delete($id)
	{
		$post = ORM::factory('blog_post', (int) $id);

		if ($post->loaded)
		{
			// remove comments first
			Database::instance()->where('blog_post_id', (int) $post->id)->delete('blog_comments');

			// then delete the post
			$post->delete();

			$this->session->set_flash('info_message', 'Post deleted sucsessfully');
		}
		else
		{
			$this->session->set_flash('error_message', 'Invalid id');
		}

		url::redirect('admin/blog');
	}

	public function settings()
	{
		if($_POST)
		{
			$comment_status = 'closed';

			if ($this->input->post('comment_status') == 'open')
				$comment_status = 'open';

			$this->db->update('config', array('value' => $comment_status), array(
				'context' => 'blog',
				'key' => 'comment_status'
			));

			$this->db->update('config', array('value' => (int) $this->input->post('items_per_page')), array(
				'context' => 'blog',
				'key' => 'items_per_page'
			));

			$this->session->set_flash('info_message', 'Settings changed successfully');

			url::redirect('admin/blog');
		}
		else
		{
			$this->head->title->append('Settings');
			$this->template->title .= 'Settings';

			$this->template->content = new View('blog/settings');
			$this->template->content->items_per_page = Kohana::config('blog.items_per_page');
			$this->template->content->comment_status = (bool) (Kohana::config('blog.comment_status') == 'open' ? TRUE : FALSE);
		}
	}

}