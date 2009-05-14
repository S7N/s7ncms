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
class akismet_Core {
	
	public static function valid_key()
	{
		return self::send_request('verify', 'key='.config::get('akismet.api_key').'&blog='.urlencode(url::base(TRUE, 'http')));
	}
	
	public static function check_spam()
	{
		$comment = array(
			'comment_type' => 'comment',
			'comment_author' => Event::$data->author,
			'comment_author_email' => Event::$data->email,
			'comment_author_url' => Event::$data->url,
			'comment_content' => Event::$data->content,
			'referrer' => request::referrer(),
			'user_ip' => Event::$data->ip,
			'user_agent' => Kohana::user_agent(),
			'blog' => url::base(TRUE, 'http'),
		);
		
		$result = self::send_request('comment', $comment);
		
		if ($result === 'true')
		{
			Event::$data->approved = 'no';
			Event::$data->save();
		}
	}
	
	public static function submit_spam()
	{
		// TODO
	}
	
	public static function submit_ham()
	{
		// TODO
	}
	
	private static function send_request($type, $request)
	{
		$request_types = array(
			'comment' => 'http://'.config::get('akismet.api_key').'.rest.akismet.com/1.1/comment-check',
			'spam' => 'http://'.config::get('akismet.api_key').'.rest.akismet.com/1.1/submit-spam',
			'ham' => 'http://'.config::get('akismet.api_key').'.rest.akismet.com/1.1/submit-ham',
			'verify' => 'http://rest.akismet.com/1.1/verify-key',
		);
		
		if ( ! array_key_exists($type, $request_types))
			return FALSE;

		$akismet = curl_init($request_types[$type]);
		curl_setopt($akismet, CURLOPT_POSTFIELDS, $request);
		curl_setopt($akismet, CURLOPT_TIMEOUT, 5);
		curl_setopt($akismet, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($akismet, CURLOPT_HTTPHEADER, array('User-Agent' => 'S7Ncms/'.config::get('s7n.version').' | Akismet/'.module::version('akismet')));
		
		return curl_exec($akismet);
	}
	
}