<?php

namespace ThfoIntranet;

use function add_action;
use function add_filter;
use function content_url;
use function define;
use function delete_option;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function get_current_blog_id;
use function get_post;
use function get_post_type;
use function is_file;
use function is_multisite;
use function is_post_type_archive;
use function is_singular;
use function mc_activation_function;
use function mkdir;
use function plugin_dir_path;
use function plugin_dir_url;
use function preg_match;
use function scandir;
use function ThfoIntranet\acf\intranet_acf;
use function untrailingslashit;
use function update_option;
use function var_dump;
use function wp_enqueue_style;
use function wp_upload_dir;
use const FILE_APPEND;
use const LOCK_EX;
use const MC_DIR_PATH;
use const THFO_INTRANET_PLUGIN_PATH;
use const THFO_MEDIA_UPLOAD;
use const THFO_MEDIA_UPLOAD_URL;

/**
 * Plugin Name: Intranet
 * Plugin URI: https://thivinfo.com
 * Description: Share content only with registred users
 * Author: Sébastien SERRE
 * Author URI: https://thivinfo.com
 * Text Domain: thfo-intranet
 * Domain Path: /languages/
 * Version: 1.0.0
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'plugins_loaded', 'ThfoIntranet\define_constant' );
function define_constant() {
	define( 'THFO_INTRANET_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	define( 'THFO_INTRANET_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'THFO_INTRANET_PLUGIN_DIR', untrailingslashit( THFO_INTRANET_PLUGIN_PATH ) );
	define( 'THFO_INTRANET_CUST_INC', THFO_INTRANET_PLUGIN_PATH . 'inc/' );
}

add_action( 'plugins_loaded', 'ThfoIntranet\load_files' );
function load_files() {

	$files = scandir( THFO_INTRANET_PLUGIN_PATH . '/inc/' );

	//Load files
	foreach ( $files as $file ) {
		if ( is_file( THFO_INTRANET_PLUGIN_PATH . '/inc/' . $file ) ) {
			require_once THFO_INTRANET_PLUGIN_PATH . '/inc/' . $file;
		}
	}

}


add_action( 'plugins_loaded', 'ThfoIntranet\activate' );
function activate() {
	// prepare htaccess Content
	$intranet_path = THFO_INTRANET_PLUGIN_PATH;

	$htaccessContent = "\n# BEGIN intranet Plugin\n";
	$htaccessContent .= "RewriteCond %{REQUEST_FILENAME} -s\n";
	$htaccessContent .= "RewriteRule ^(.*)$ {$intranet_path}get-files.php?file=$1 [QSA,L]\n";
	$htaccessContent .= "# END intranet Plugin\n";

	$uploads_dir       = wp_upload_dir();
	$protected_folder = '/intranet/protected';
	$media_uploads_dir = $uploads_dir['basedir'] . $protected_folder;

	define( 'THFO_MEDIA_UPLOAD', $media_uploads_dir );
	define( 'THFO_MEDIA_UPLOAD_URL', $uploads_dir['baseurl'] . $protected_folder );

	// if media folder doesn't exist create it
	if ( ! file_exists( $media_uploads_dir ) ) {
		mkdir( $media_uploads_dir, 0777, true );
	}

	// check if htaccess does not exists
	if ( ! file_exists( $media_uploads_dir . '/.htaccess' ) ) {
		file_put_contents( $media_uploads_dir . '/' . '.htaccess', $htaccessContent );
	}
	// if htaccess already exists
	if ( file_exists( $media_uploads_dir . '/.htaccess' ) && preg_match( '/(# BEGIN intranet Plugin)(.*?)(# END intranet Plugin)/is', file_get_contents( $media_uploads_dir . '/.htaccess' ) ) == 0 ) {
		file_put_contents( $media_uploads_dir . '/.htaccess', $htaccessContent, FILE_APPEND | LOCK_EX );
	}
}

add_filter( 'upload_dir', 'ThfoIntranet\chg_media_dir' );
function chg_media_dir( $uploads ) {
	if ( ! empty( $_REQUEST['data'] ) && 'intranet' === get_post_type( $_REQUEST['data']['wp-refresh-post-lock']['post_id'] ) ) {
		$uploads['path'] = THFO_MEDIA_UPLOAD . $uploads['subdir'];
		$uploads['url']  = THFO_MEDIA_UPLOAD_URL . $uploads['subdir'];
	}

	return $uploads;
}

add_filter( 'wp_handle_upload_prefilter', 'ThfoIntranet\pre_upload' );
function pre_upload( $file ) {
	add_filter( 'upload_dir', 'ThfoIntranet\custom_upload_dir' );

	return $file;
}

function custom_upload_dir( $uploads ) {
	$id = $_REQUEST['post_id'];
	if ( 'intranet' === get_post_type( $id ) ) {
		$uploads['path'] = THFO_MEDIA_UPLOAD . $uploads['subdir'];
		$uploads['url']  = THFO_MEDIA_UPLOAD_URL . $uploads['subdir'];
	}

	return $uploads;

}

add_action( 'init', 'ThfoIntranet\load_textdomain' );

/**
 * Load plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'thfo-intranet', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'wp_enqueue_scripts', 'ThfoIntranet\load_style', 20 );
function load_style(){
	$posttype = is_post_type_archive( 'intranet' );
	if ( is_post_type_archive( 'intranet' ) || is_singular( 'intranet' ) ){
		wp_enqueue_style( 'intranet-style', THFO_INTRANET_PLUGIN_URL . 'assets/css/intranet.css' );
	}
}