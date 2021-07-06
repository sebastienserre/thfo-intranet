<?php

use function ThfoIntranet\helpers\check_access;
use function ThfoIntranet\helpers\get_cat_list;
use function ThfoIntranet\helpers\has_access;


get_header();
?>

    <main class="main-intranet">
		<?php
		if ( have_posts() && has_access() ) {
			?>
            <div class="intranet-content">
				<?php
				while ( have_posts() ) {
					the_post();
					?>
                    <div class="intranet-detail">
                        <h2><a href="<?php echo get_the_permalink() ?>">
							<?php
							the_title();
							?>
                        </a>
                        </h2>
                        <?php the_content(); ?>
                    </div>
					<?php
				}
				?>
            </div>
			<?php
		} else {
			check_access();
		}
		?>
    </main>
<?php

get_footer();
