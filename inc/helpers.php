<?php
namespace ThfoIntranet\helpers;
use function get_current_user_id;
use function wp_login_form;

/**
 * @param string $user_id
 *
 * @return bool
 * @author  sebastien
 * @package sme
 * @since   30/04/2021
 */
function has_access( $user_id = '' ) {
	if ( ! is_user_logged_in() ) {
		return false;
	}
	$user          = wp_get_current_user();
	$allowed_roles = array( 'administrator', 'editor', 'intranet_reader', 'intranet_author' );
	if ( array_intersect( $allowed_roles, $user->roles ) ) {
		return true;
	}
	return false;
}

function check_access(){
	if ( ! has_access( get_current_user_id() ) ) {
		return wp_login_form( array( 'echo' => false) );
	}
}