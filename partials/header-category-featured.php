<?php
  /*
   * Header for featured category
   */
?>

<?php
  $tax = get_term_by('slug', $featured_tax, 'featured_tax');

  $feature_url = get_term_meta( $tax->term_id, 'c-feature-url', true );
  $logo_url    = get_term_meta( $tax->term_id, 'c-sponsor-url', true ); 
  $hex         = get_term_meta( $tax->term_id, 'c-category-hex', true );
  $opacity     = get_term_meta( $tax->term_id, 'c-category-opacity', true ); 
  $hex_value   = ($hex) ? $hex : '#000000';
  $alpha_value = ($opacity) ? $opacity : '0.6';
?>

<header class="header header-feature header-category">
  <div class="header-feature-bg" style="background-image: url(<?php echo $feature_url; ?>);"></div>
  <div class="blanket-overlay" style="background-color:<?php echo $hex_value; ?>;opacity: <?php echo $alpha_value; ?>;"></div>

  <?php get_template_part('partials/header', 'nav'); ?>
  <div class="f-grid f-row">
    <div class="f-1">
      <div class="header-category-content">
        <div class="header-category-h1"><?php echo $tax->name; ?></div>
        <div class="header-category-h2"><?php echo $tax->description; ?></div>
      </div>
      <div class="f-1-2 header-category-branded">
        <?php if ( $logo_url ): ?>
          <img src="<?php echo $logo_url; ?>">
          <div class="header-category-h2">in partnership with</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>