<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @package Hanna
 * @since Hanna 1.0
 */
?>

<?php if( is_active_sidebar( 'footer-column' ) || is_active_sidebar( 'footer-column-2' ) ) { ?>

	<!--BEGIN .footer-widgets-->
	<div class="footer-widgets clearfix">
		<div class="footer-widgets-wrap">
		<?php

			if( is_active_sidebar( 'footer-column' ) ) {
				echo '<div class="footer-column">';
					dynamic_sidebar( 'footer-column' );
				echo '</div>';
			}

			if( is_active_sidebar( 'footer-column-2' ) ) {
				echo '<div class="footer-column">';
					dynamic_sidebar( 'footer-column-2' );
				echo '</div>';
			}
		?>
		</div>
	<!--END .footer-widgets-->
	</div>
<?php } ?>