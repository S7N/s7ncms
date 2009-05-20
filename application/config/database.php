<?php defined('SYSPATH') OR die('No direct access allowed.');

if (file_exists(DOCROOT.'config/database.php'))
	require_once(DOCROOT.'config/database.php');
else
{
	header('Location: install.php');
	exit;
}
