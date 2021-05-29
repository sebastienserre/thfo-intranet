<?php
namespace ThfoIntranet\helpers;
use function add_filter;
use function function_exists;
use function get_current_user_id;
use function get_term_link;
use function get_the_ID;
use function get_the_permalink;
use function get_the_terms;
use function implode;
use function is_post_type_archive;
use function is_single;
use function is_singular;
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
		return wp_login_form( );
	}
}

add_filter( 'the_content', function ( $content ){
	if (! function_exists( 'get_field' ) ){
		return $content;
	}

	if ( ! is_singular( 'intranet' ) || is_post_type_archive( 'intranet' ) ){
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

add_filter( 'template_include', 'ThfoIntranet\helpers\template_chooser' );
function template_chooser( $template ){
    $post_id = get_the_ID();

    // For all other CPT
	if ( get_post_type( $post_id ) != 'intranet' ) {
		return $template;
	}

	if ( is_post_type_archive() ){
	    return get_template_hierarchy( 'archive' );
    }
	return $template;
}

function get_template_hierarchy( $template ){
	// Get the template slug
	$template_slug = rtrim( $template, '.php' );
	$template = $template_slug . '.php';

	// Check if a custom template exists in the theme folder, if not, load the plugin template file
	if ( $theme_file = locate_template( array( 'intranet-template/' . $template ) ) ) {
		$file = $theme_file;
	}
	else {
		$file = THFO_INTRANET_PLUGIN_DIR . '/templates/' . $template;
	}

	return apply_filters( 'intranet_repl_template_' . $template, $file );
}
add_filter( 'template_include', 'ThfoIntranet\helpers\template_chooser' );

function get_cat_list( $post_id ){
	$list = get_the_terms( $post_id, 'intranet_cat' );
	$categories = array();
	foreach ( $list as $term ){
	    $categories[] = '<a href="' . get_term_link( $term->term_id ) . '">' . $term->name . '</a>';
    }
	$category_list = implode( ', ', $categories );
	return $category_list;
}

function excerpt_more( $more ) {
	if (  is_post_type_archive( 'intranet') ) {
		$more = sprintf( ' <a class="read-more" href="%1$s">%2$s</a>',
			get_permalink( get_the_ID() ),
			__( 'Read More', 'thfo-intranet' )
		);
	}

	return $more;
}
add_filter( 'excerpt_more', 'ThfoIntranet\helpers\excerpt_more' );