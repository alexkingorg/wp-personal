<?php
/**
 * @package favepersonal
 *
 * This file is part of the FavePersonal Theme for WordPress
 * http://crowdfavorite.com/wordpress/themes/favepersonal/
 *
 * Copyright (c) 2008-2011 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */

define('ABSPATH', realpath(dirname(__FILE__)) . '/');

// Set up an array of files and their handles
$load = array(
	'base.css',
	'utility.css',
	'content.css',
	'masthead.css',
	'comments.css',
	'grid.css',
	'social.css',
);

// Initialize gzip and send headers
ob_start("ob_gzhandler");

header('Content-type: text/css');
header("Cache-Control: public");

// Cache for 1 day
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 86400) . 'GMT'); 

// Test efficiency
// $timer = microtime();

foreach ($load as $file) {
	// Load up file
	$file_contents = file_get_contents(ABSPATH.$file);
	
	// Strip out comments, including multi-line
	$file_contents = preg_replace('/\/\*(.|[\r\n])*?\*\//', '', $file_contents);

	// Strip whitespace and newlines
	$needles = array(
		"\n",
		"\t"
	);
	$file_contents = str_replace($needles, '', $file_contents);
	
	echo $file_contents;
	
	// Alternate method (doesn't touch source)
	// include(ABSPATH.$css_files[$file]);
}

// Test efficiency (cont)
// echo "\n\n".'/* Created in '.(microtime() - $timer).' milliseconds. */';
?>
