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
class blog {

	public static function unique_title($title)
	{
		$uri = url::title($title);
		
		$result = Database::instance()->select('uri')->like('uri', $uri.'%', FALSE)->get('blog_posts');
		
		if (count($result) > 0)
		{
			$max = 0;
			foreach ($result as $row)
			{
				$suffix = substr($row->uri, strlen($uri)+1);
				if(ctype_digit($suffix) AND $suffix > $max)
					$max = $suffix;
			}

			if ($max === 0)
				$uri .= '-2';
			else
				$uri .= '-'.($max+1);
		}
		
		return $uri;
	}

}