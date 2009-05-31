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

Event::add('system.ready', 'module::load_core_modules');
//Event::add('system.ready', 'module::load_modules');
//Event::add('system.ready', 'config::load');
Event::add_before('system.routing', array('Router', 'setup'), 'language::setup');
Event::add_after('system.routing', 'language::setup', 'Router::new_route');
//Event::add_after('system.routing', 'url::new_route', 'access::check');
//Event::add('system.post_routing', 'theme::load');