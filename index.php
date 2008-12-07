<?php

/**
 * Define the website environment status. When this flag is set to TRUE, some
 * module demonstration controllers will result in 404 errors. For more information
 * about this option, read the documentation about deploying Kohana.
 *
 * @see http://doc.kohanaphp.com/installation/deployment
 */
define('IN_PRODUCTION', FALSE);

/**
 * Upload directory.
 *
 * This path can be absolute or relative to this file.
 */
$s7n_upload = 'upload';

/**
 * Test to make sure that Kohana is running on PHP 5.2 or newer. Once you are
 * sure that your environment is compatible with Kohana, you can comment this
 * line out. When running an application on a new server, uncomment this line
 * to check the PHP version quickly.
 */
version_compare(PHP_VERSION, '5.2', '<') and exit('Kohana requires PHP 5.2 or newer.');

/**
 * Set the error reporting level. Unless you have a special need, E_ALL is a
 * good level for error reporting.
 */
error_reporting(E_ALL & ~E_STRICT);

/**
 * Turning off display_errors will effectively disable Kohana error display
 * and logging. You can turn off Kohana errors in application/config/config.php
 */
ini_set('display_errors', TRUE);

/**
 * If you rename all of your .php files to a different extension, set the new
 * extension here. This option can left to .php, even if this file is has a
 * different extension.
 */
define('EXT', '.php');

//
// DO NOT EDIT BELOW THIS LINE, UNLESS YOU FULLY UNDERSTAND THE IMPLICATIONS.
// ----------------------------------------------------------------------------
// $Id$
//

// Define the front controller name and docroot
define('DOCROOT', getcwd().DIRECTORY_SEPARATOR);
define('KOHANA',  basename(__FILE__));

// If the front controller is a symlink, change to the real docroot
is_link(KOHANA) and chdir(dirname(realpath(__FILE__)));

// Define application and system paths
define('APPPATH', str_replace('\\', '/', realpath('application')).'/');
define('MODPATH', str_replace('\\', '/', realpath('modules')).'/');
define('SYSPATH', str_replace('\\', '/', realpath('system')).'/');
define('THEMEPATH', str_replace('\\', '/', realpath('themes')).'/');
define('UPLOADPATH', str_replace('\\', '/', realpath('upload')).'/');

// Initialize.
require SYSPATH.'core/Bootstrap'.EXT;