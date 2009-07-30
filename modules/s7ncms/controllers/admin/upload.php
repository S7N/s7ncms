<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * S7Ncms - www.s7n.de
 *
 * Copyright (c) 2007-2009, Eduard Baun <eduard at baun.de>
 * All rights reserved.
 *
 * See license.txt for full text and disclaimer
 *
 * @author Stefan Löhers
 * @copyright Eduard Baun, 2007-2009
 * @version $Id$
 */
class Upload_Controller extends Administration_Controller {

	public function save()
	{
		$this->auto_render = FALSE;

		$files = Validation::factory($_FILES)
			->add_rules('picture', 'upload::valid', 'upload::required', 'upload::type[gif,jpg,png,jpeg]', 'upload::size[4M]');

		echo '<script language="javascript" type="text/javascript">';

		if ($files->validate())
		{
			$filename = upload::save('picture');
			echo 'window.top.window.stopUploadSuccess("' . url::base().'upload/'.basename($filename).'");';
		}
		else
		{
			$errors=$files->errors();
			echo 'window.top.window.stopUploadError("' . $errors['picture'] . '");';
		}

		echo '</script>';
		exit();
	}

}
