<?php
namespace ThfoIntranet\shortcode;

use function add_shortcode;
use function get_current_user_id;
use function ob_get_clean;
use function ob_start;
use function ThfoIntranet\helpers\check_access;
use function ThfoIntranet\helpers\has_access;
use function wp_list_categories;
use function wp_login_form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

add_shortcode( 'intranet', 'ThfoIntranet\shortcode\intranet');
function intranet(){


	ob_start();
	check_access();
	if ( has_access() ) {
	?>
	<div class="intranet-menu">
        <ul>
        <?php
        wp_list_categories(
	        array(
		        'taxonomy'           => 'intranet_cat',
		        'show_count'         => 1,
		        'style'              => 'list',
		        'title_li'           => '',
		        'use_desc_for_title' => 1
	        ),
        );
        ?>
        </ul>

	</div>
	<?php
    }
	return ob_get_clean();
}
