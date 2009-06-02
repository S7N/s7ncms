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

// 1: Load modules and config
Event::add('system.ready', 'module::load_core_modules');
Event::add('system.ready', 'module::load_modules');
//Event::add('system.ready', 'config::load');

// 2: Get language preferences
Event::add_before('system.routing', array('Router', 'setup'), 'language::setup');

// 3: Get the new URL route
Event::add_after('system.routing', 'language::setup', 'Router::new_route');

// 4: Process access control
Event::add_after('system.routing', 'Router::new_route', 'acl::current_page');

// 5: Load the theme
//Event::add('system.post_controller', 'theme::load');