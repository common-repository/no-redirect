<?php
/*
Plugin Name: No Redirect
Plugin URI: http://wordpress.org/plugins/no-redirect/
Description: No Redirect prevents wordpress from being redirected to canonical url.
Author: Mjbmr
Version: 0.1
Author URI: http://mjbmr.com/
*/

function no_redirect_fix_url($url)
{
	if(!filter_var($url, FILTER_VALIDATE_URL)) return $url;
	$parts = parse_url($url);
	$url = (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") ? 'https' : 'http';
	$url .= '://';
	$url .= $_SERVER['HTTP_HOST'];
	$url .= $parts['path'];
	if(isset($parts['query']))
	{
		$url .= '?' . $parts['query'];
	}
	return $url;
}
/*
 * Fix all links
 */
add_filter( 'site_url', 'no_redirect_fix_url' );
add_filter( 'home_url', 'no_redirect_fix_url' );
add_filter( 'bloginfo', 'no_redirect_fix_url' );
add_filter( 'bloginfo_url', 'no_redirect_fix_url' );
add_filter( 'plugin_url', 'no_redirect_fix_url' );
add_filter( 'template_directory_uri', 'no_redirect_fix_url' );
add_filter( 'stylesheet_directory_uri', 'no_redirect_fix_url' );

/**
 * Prevents redirection
 */
remove_action('template_redirect', 'redirect_canonical');
/**
 * Removes canonical link added by yoast seo plugin
 */
add_filter( 'wpseo_canonical', '__return_false' );
