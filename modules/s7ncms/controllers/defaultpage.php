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
class Defaultpage_Controller extends Controller {

	public function index()
	{
		$redirect = Kohana::config('s7n.default_uri');

		if(is_null($redirect))
			throw new Kohana_User_Exception('No start page defined', "The system couldn't find a start page to display.");

		url::redirect($redirect);
	}

}