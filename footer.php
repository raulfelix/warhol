<?php
/*
 * The main footer template file.
 *
 * Load either next up or small footer partials.
 */
?>
	
	<?php 
		if (is_page()) {
			get_template_part('partials/footer', 'small');
		} 
		else {
			get_template_part('partials/footer', 'next');
		}
	?>
	
	<?php wp_footer(); ?>
</body>
</html>