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

class User_Model extends ORM {

	protected $belongs_to = array('country', 'role');
	
	public $formo_label_filters = array
	(
	  'ucwords'
	);
	
	public $formo_ignores = array
	(
	  'id',
	  'last_login',
	  'created',
	  'auth_code',
	  'nation_id'
	);
	
	public $formo_pre_filters = array
	(
		'email' => array('trim')
	);
	
	public $formo_rules = array
	(
		'email' => array('email', 'Invalid email')
	);
	
	public $formo_order = array
	(
		'username',
		'password',
		'password_conf',
		'email',
		'register'
	);
	
}