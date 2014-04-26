<?php
/*
 * The main footer template file.
 *
 * Load either next up or small footer partials.
 * wp_reset_query() must be called for this to work.
 */
?>
	
	<?php 
		if ( is_page() || is_page_template( 'templates/page-category.php' ) ) {
			get_template_part('partials/footer', 'small');
		} 
		else {
			get_template_part('partials/footer', 'next');
		}
	?>
	
	<?php wp_footer(); ?>
</body>
</html>