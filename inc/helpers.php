<?php
namespace ThfoIntranet\helpers;
use function add_filter;
use function function_exists;
use function get_current_user_id;
use function get_the_ID;
use function ob_get_clean;
use function ob_get_flush;
use function ob_start;
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
		echo wp_login_form( );
	}
}

add_filter( 'the_content', function ( $content ){
	if (! function_exists( 'get_field' ) ){
		return $content;
	}

	if ( !  has_access() ){
	    $content = check_access();
	    return $content;
    }

	$files = get_field( 'intranet_protected_files' );
	if ( empty( $files ) ){
		return $content;
	}
	ob_start();
	?>
	<h2><?php _e( 'Available downloads', 'thfo-intranet' );?></h2>
	<ul>
		<?php
		foreach ( $files as $file ){
			?>
			<li>
				<a href="<?php echo $file['fichiers']['url'] ?>"><?php echo $file['fichiers']['filename'] ?></a>
			</li>
			<?php
		}
		?>
	</ul>
<?php
	$download = ob_get_clean();
	$content = $content . $download;
	return $content;

});