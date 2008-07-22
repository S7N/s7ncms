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
		$this->template->content = new View('blog/admin/index');
		
		$this->template->searchbar = TRUE;
		
		$q = trim($this->input->get('q'));
		
		if ( ! empty($q))
		{
			$this->template->searchvalue = $q;
			
			$this->template->content->posts = ORM::factory('blogpost')->orderby('id', 'desc')->orlike(
				array(
					'title' => '%'.$q.'%',
					'excerpt' => '%'.$q.'%',
					'content' => '%'.$q.'%',
					'tags' => '%'.$q.'%'
				)
			)->find_all();
			
			$this->template->title .= 'Filter: '.$q;
			$this->head->title->append('Filter: '.$q);
		}
		else
		{
			$this->template->title .= 'All Posts';
			$this->head->title->append('All Posts');
			$this->template->content->posts = ORM::factory('blogpost')->orderby('id', 'desc')->find_all();
		}
	}

	public function newpost()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$post = new Blogpost_Model;
			$post->user_id = $_SESSION['auth_user']->id;

			$post->title = html::specialchars($this->input->post('form_title'));
			
			$uri = url::title($this->input->post('form_title'));

			// Check if uri already exists and add a suffix
			$result = $this->db->select('uri')->like('uri', $uri.'%')->get('blogposts');
			if (count($result) > 0)
			{
				$new_uri = $uri;
				$suffix = 2;
				$titles = array();
				$title_not_found = TRUE;

				// Create array with uris
				foreach ($result as $row)
				{
					$titles[] = $row->uri;
				}

				// Find new valid uri
				while ($title_not_found)
				{
					$new_uri = $uri.'-'.++$suffix;
						
					if ( ! in_array($new_uri, $titles))
					{
						$title_not_found = FALSE;
						break;
					}
				}
				
				$uri = $new_uri;
			}
			
			$post->uri = $uri;
			
			$post->content = $this->input->post('form_content');

			$post->date = date("Y-m-d H:i:s");
			$page->modified = date("Y-m-d H:i:s");
				
			$post->tags = html::specialchars($this->input->post('form_tags'));

			$post->save();

			$this->session->set_flash('info_message', 'Post created successfully');
			url::redirect('admin/blog');
		}
		else
		{
			$this->head->title->append('New Post');
			$this->template->title .= 'New Post';
				
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->template->content = new View('blog/admin/newpost');
		}
	}

	public function edit()
	{
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$post = ORM::factory('blogpost')->find_by_id((int) $this->input->post('form_id'));

			$post->title = html::specialchars($this->input->post('form_title'));
			$post->uri = url::title($this->input->post('form_title'));
				
			$post->content = $this->input->post('form_content');
				
			$post->modified = date("Y-m-d H:i:s");
			$post->tags = html::specialchars($this->input->post('form_tags'));

			$post->save();

			$this->session->set_flash('info_message', 'Post edited successfully');

			url::redirect('admin/blog');
		}
		else
		{
			$this->template->content = new View('blog/admin/edit');
			$this->template->content->post = ORM::factory('blogpost')->find_by_id((int) $this->uri->segment(4));
				
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: '. $this->template->content->post->title);
			$this->template->title .= 'Edit: '. $this->template->content->post->title;
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
		$post = ORM::factory('blogpost')->find_by_id((int) $id);
		$this->template->content = new View('blog/admin/comments');
		$this->template->content->comments = $post->comments;

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
		$post = ORM::factory('blogpost')->find_by_id((int) $id);

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
		if($_SERVER["REQUEST_METHOD"] == 'POST')
		{
			$comment = ORM::factory('comment')->find_by_id((int) $id);
			$comment->author = $this->input->post('form_author');
			$comment->email = $this->input->post('form_email');
			$comment->url = $this->input->post('form_url');
			$comment->content = $this->input->post('form_content');
			$comment->save();

			$this->session->set_flash('info_message', 'Comment edited successfully');

			url::redirect('admin/blog/comments/'.$comment->blogpost_id);
		}
		else
		{
			$this->template->content = new View('blog/admin/editcomment');
			$this->template->content->comment = ORM::factory('comment')->find_by_id((int) $id);
				
			$this->head->javascript->append_file('vendor/tiny_mce/tiny_mce.js');
			$this->head->title->append('Edit: Comment #'. $this->template->content->comment->id);
			$this->template->title .= 'Edit: Comment #'. $this->template->content->comment->id;
		}
	}

	private function comments_delete($id)
	{
		$comment = ORM::factory('comment')->find_by_id((int) $id);
		if ($comment->id > 0)
		{
			$blogpost_id = $comment->blogpost_id;
			$comment->delete();
				
			$post = ORM::factory('blogpost')->find_by_id((int) $blogpost_id);
			$post->comment_count -= 1;
			$post->save();
				
			$this->session->set_flash('info_message', 'Comment deleted successfully');
			url::redirect('admin/blog/comments/'.$blogpost_id);
		}
		else
		{
			$this->session->set_flash('error_message', 'Invalid id');
			url::redirect('admin/blog');
		}
	}

	public function delete($id)
	{
		$post = ORM::factory('blogpost')->find_by_id((int) $id);
		if ($post->id > 0)
		{
			$post->remove_comments();
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
		if($_SERVER["REQUEST_METHOD"] == 'POST')
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
				
			$this->template->content = new View('blog/admin/settings');
			$this->template->content->items_per_page = Kohana::config('blog.items_per_page');
			$this->template->content->comment_status = (bool) (Kohana::config('blog.comment_status') == 'open' ? TRUE : FALSE);
		}
	}

}