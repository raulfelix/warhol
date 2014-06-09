<?php
/*
 * The main footer template file.
 *
 * Load either next up or small footer partials.
 * wp_reset_query() must be called for this to work.
 */
?>
	
	<?php 


		if ( is_page() || is_author() || is_page_template( 'templates/page-category.php' ) || is_tax('news_tax')) {
			get_template_part('partials/footer', 'small');
		} 
		else {
			get_template_part('partials/footer', 'next');
		}

	  get_template_part('partials/module', 'js-data');
    get_template_part( 'partials/module', 'search' );
		
	?>
	
	<?php wp_footer(); ?>
</body>
</html>