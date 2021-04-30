<?php
namespace ThfoIntranet\roles;

use function add_role;
use function get_current_user_id;
use function get_role;
use function is_user_logged_in;
use function remove_role;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'admin_init', 'ThfoIntranet\roles\add_cap_admin' );
function add_cap_admin(){
	$roles = array(
		'administrator',
		'editor'
	);
	$capabilities_admin = array(
		'edit_intranet',
		'read_intranet',
		'delete_intranet',
		'edit_intranets',
		'edit_others_intranets',
		'read_others_intranets',
		'publish_intranets',
		'publish_pages_intranets',
		'read_private_intranets',
		'create_private_intranets',
		'edit_published_intranets',
		'delete_published_intranets',
		'delete_others_intranets',
		'edit_private_intranets',
		'delete_private_intranets',
		'manage_intranet_cat',
		'edit_intranet_cat',
		'delete_intranet_cat',
	);

	foreach ( $roles as $role ) {
		$role_administrateur = get_role( $role );
		foreach ( $capabilities_admin as $capabilitie_admin ) {
			$role_administrateur->add_cap( $capabilitie_admin );
		}
	}
}

add_action( 'admin_init', 'ThfoIntranet\roles\add_role_author' );
function add_role_author() {
	// TODO remove this on prod
	remove_role( 'intranet_author' );
	$capabilities = array(
		'edit_intranet'              => true,
		'read_intranet'              => true,
		'delete_intranet'            => true,
		'edit_intranets'             => true,
		'edit_others_intranets'      => false,
		'read_others_intranets'      => false,
		'publish_intranets'          => false,
		'publish_pages_intranets'    => false,
		'read_private_intranets'     => false,
		'create_private_intranets'   => false,
		'edit_published_intranets'   => false,
		'delete_published_intranets' => false,
		'delete_others_intranets'    => false,
		'edit_private_intranets'     => false,
		'delete_private_intranets'   => false,
		'manage_intranet_cat'        => true,
		'edit_intranet_cat'          => true,
		'delete_intranet_cat'        => true,
	);
	add_role( 'intranet_author', __( 'Intranet Author', 'thfo-intranet' ), $capabilities );
}

add_action( 'admin_init', 'ThfoIntranet\roles\add_role_reader' );
function add_role_reader() {
	// TODO remove this on prod
	remove_role( 'intranet_reader' );
	$capabilities = array(
		'edit_intranet'              => false,
		'read_intranet'              => true,
		'delete_intranet'            => false,
		'edit_intranets'             => false,
		'edit_others_intranets'      => false,
		'read_others_intranets'      => true,
		'publish_intranets'          => false,
		'publish_pages_intranets'    => false,
		'read_private_intranets'     => false,
		'create_private_intranets'   => false,
		'edit_published_intranets'   => false,
		'delete_published_intranets' => false,
		'delete_others_intranets'    => false,
		'edit_private_intranets'     => false,
		'delete_private_intranets'   => false,
		'manage_intranet_cat'        => false,
		'edit_intranet_cat'          => false,
		'delete_intranet_cat'        => false,
	);
	add_role( 'intranet_reader', __( 'Intranet Reader', 'thfo-intranet' ), $capabilities );
}
