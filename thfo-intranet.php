<?php
namespace ThfoIntranet;
use function define;
use function is_file;
use function plugin_dir_path;
use function plugin_dir_url;
use function scandir;
use function untrailingslashit;
use const THFO_INTRANET_PLUGIN_PATH;

/**
 * Plugin Name: Intranet
 * Plugin URI: https://www.thivinfo.com
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