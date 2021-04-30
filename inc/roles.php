<?php
namespace ThfoIntranet\roles;

use function get_current_user_id;
use function get_role;
use function is_user_logged_in;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_action( 'admin_init', 'ThfoIntranet\roles\add_cap_admin' );
function add_cap_admin(){
	$role_administrateur = get_role( 'administrator' );
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
	);

	foreach( $capabilities_admin as $capabilitie_admin ) {
		$role_administrateur->add_cap( $capabilitie_admin );
	}
}

add_action( 'admin_init', 'ThfoIntranet\roles\add_cap_editor' );
function add_cap_editor(){
	$role_editor = get_role( 'editor' );
	$capabilities_editor = array(
		'edit_intranet',
		'read_intranet',
		'delete_intranet',
		'edit_intranets',
		'read_others_intranets',
		'edit_published_intranets',
	);

	foreach( $capabilities_editor as $capabilitie_edit ) {
		$role_editor->add_cap( $capabilitie_edit );
	}
}

function has_access( $user_id = '' ) {
	if ( ! is_user_logged_in() ) {
		return false;
	}
	$user          = wp_get_current_user();
	$allowed_roles = array( 'administrator', 'editor' );
	if ( array_intersect( $allowed_roles, $user->roles ) ) {
		return true;
	}
	return false;
}
