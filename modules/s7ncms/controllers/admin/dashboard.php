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
class Dashboard_Controller extends Administration_Controller {

	public function index()
	{
        $this->head->title->append('Dashboard');
        
		$this->template->title = 'Dashboard';
        $this->template->content = new View('dashboard/index');
    }

}