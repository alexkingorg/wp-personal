<?php
/**
 * @package personal
 *
 * This file is part of the Personal Theme for WordPress
 * http://github.com/alexkingorg/wp-personal
 * (Forked from http://crowdfavorite.com/favepersonal/)
 *
 * Copyright (c) 2008-2013 Crowd Favorite, Ltd. All rights reserved.
 * http://crowdfavorite.com
 *
 * Copyright (c) 2015 Alex King.
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
 * **********************************************************************
 */
if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

// Load bundler config.
include_once(CFCT_PATH.'assets/config.php');
// Helper class for enqueueing bundles
include_once(CFCT_PATH.'assets/asset-build/lib/Bundler_Loader.php');
// Load custom color styles
include_once(CFCT_PATH.'assets/colors.php');

// Used for conditional comments with wp_enqueue_style
global $wp_styles;
$assets_url = trailingslashit(get_template_directory_uri()) . 'assets/';
$personal_bundle = (CFCT_PRODUCTION ? array('bundle-personal') : array());

wp_register_script(
	'jquery-cycle',
	$assets_url.'js/jquery.cycle.all.min.js',
	array('jquery'),
	'2.99',
	true
);

// Enqueue bundles compiled by bundler script
$loader = new Bundler_Loader($assets_url);
// Set the default cache-busting version number. Used if the bundle doesn't have one set.
$loader->set_default_ver(CFCT_URL_VERSION);

// If we're in production mode, enqueue the built files
if (CFCT_PRODUCTION) {
	$loader->enqueue_bundled_files();
}
// Otherwise, if we're in development mode, enqueue the original separate files
else {
	$loader->enqueue_original_files();
}

// Automatically enqueue child styles
if (is_child_theme() && !is_admin()) {
	wp_enqueue_style('personal-child', get_bloginfo('stylesheet_url'), $personal_bundle, CFCT_URL_VERSION, 'screen');
}


/* Add JavaScript to pages with the comment form to support threaded comments (when in use). */
if ( is_singular() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

function cfcp_viewport_meta() {
// Mobile viewport optimized: j.mp/bplateviewport
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
}
add_action('wp_head', 'cfcp_viewport_meta');

/**
 * Additional CSS fixes for IE to run at wp_head:8
 */
function cfcp_ie_css_overrides() {
?>
<!--[if IE 7]>
	<style type="text/css" media="screen">
		#featured-posts .featured:hover .featured-content {
			background-color: <?php echo cf_colors_color('light', 'featured_posts_hover_content_background'); ?>;
		}
	</style>
<![endif]-->
<?php
}
add_action('wp_head', 'cfcp_ie_css_overrides', 8);
?>
