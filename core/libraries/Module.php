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

abstract class Module_Core {

	public $config = NULL;
	public $info = NULL;

	public function __construct()
	{
		echo "construct";
		$this->info = ORM::factory('module', strtolower(__CLASS__));
		$this->config = new Config($this->info->id);
	}

	public function modtest()
	{
		return "modtest";
	}

	abstract public function install();

	abstract public function uninstall();

}