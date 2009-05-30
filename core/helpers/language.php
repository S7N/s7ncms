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
class language_Core {
	
	public static $browser_language = NULL;
	public static $id;
	
	public static function setup()
	{
		// there is no language tag in the url we have to redirect
		if (Router::$language === NULL)
		{
			$redirect = NULL;
			
			// if the uri is empty
			if (empty(Router::$current_uri))
			{
				// if the browser has a language, use it
				if (($lang = language::browser_language()) !== '')
				{
					$redirect = $lang;
				}
				// if not, use the default language
				else
				{
					$redirect = ORM::factory('language')->where('default', 1)->find()->tag;
				}
			}
			// the uri is not empty
			else
			{
				// if the browser has a language, use it
				if (($lang = language::browser_language()) !== '')
				{
					$redirect = $lang.'/'.Router::$current_uri;
				}
				// if not, use the default language
				else
				{
					$redirect = ORM::factory('language')->where('default', 1)->find()->tag;
				}
			}

			url::redirect($redirect);
		}

		self::$id = ORM::factory('language')->where('tag', Router::$language)->find()->id;
		
		// TODO set locale and I18n::$lang
		//Kohana::config_set('locale.language', language::$available_languages[Router::$language]['language']);
		//I18n::$lang = language::$available_languages[Router::$language]['language'][0];
	}
	
	public static function browser_language()
	{
		if (language::$browser_language === NULL)
		{
			language::$browser_language = '';
			$browser_languages = Kohana::user_agent('languages');

			foreach($browser_languages as $language)
			{
				if (strlen($language) == 2 AND ORM::factory('language')->tag_exists($language))
				{
					language::$browser_language = strtolower($language);
					break;
				}
			}
		}

		return language::$browser_language;
	}
}