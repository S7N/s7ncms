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

$config = Kohana::config('database.default');

if (empty($config))
	url::redirect('install.php');

Event::add('system.ready', 'module::load_modules');
Event::add('system.ready', 'config::load');

Event::add_before('system.routing', array('Router', 'setup'), array('language', 'setup'));
Event::add_before('system.routing', array('Router', 'setup'), array('url', 'new_route'));

Event::add('system.post_routing', 'theme::load_themes');

function __($string, array $values = array())
{
	return empty($values) ? $string : strtr($string, $values);
}

function __n($singular, $plural, $count, array $values = array())
{
	if ($count === 1)
		return empty($values) ? $singular : strtr($singular, $values);
		
	return strtr($plural, array_merge($values, array('%count' => $count)));
}