<?php
namespace ThfoIntranet\shortcode;

use function add_shortcode;
use function get_current_user_id;
use function ob_get_clean;
use function ob_start;
use function ThfoIntranet\roles\has_access;
use function wp_login_form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_shortcode( 'intranet', 'ThfoIntranet\shortcode\intranet');
function intranet(){
	if ( ! has_access( get_current_user_id() ) ) {
		return wp_login_form( array( 'echo' => false) );
	}

	ob_start();
	?>
	<div>
		Welcome on the Intranet
	</div>
	<?php
	return ob_get_clean();
}
