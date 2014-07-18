<?php
/*
 * Adding custom fields to categories in admin
 * area.
 *
 * Dependency on: Simple meta plugin
 */

function extra_category_fields( $tax ) { ?>
  <?php $category_url = get_term_meta( $tax->term_id, 'c-feature-url', true ); ?>
  <?php $sponsor_url = get_term_meta( $tax->term_id, 'c-sponsor-url', true ); ?>
  <?php $hex_value = get_term_meta( $tax->term_id, 'c-category-hex', true ); ?>
  <?php $opacity_value = get_term_meta( $tax->term_id, 'c-category-opacity', true ); ?>
  <?php $sponsor_link = get_term_meta( $tax->term_id, 'c-sponsor-link', true ); ?>
  
  <tr id="poststuff" class="form-field">
    <th>Category branding</th>
    <td>
      <div class="c-category-postbox postbox">
        <h3 class="hndle"><span>Set Background Image</span></h3>
        <div class="inside">
          <a data-input="#c-feature-url" data-uploader-title="Set featured image" href="<?php echo get_home_url(); ?>/wp-admin/media-upload.php?type=image" id="set-category-thumbnail" class="thickbox">
            <?php if ($category_url): ?>
              <img src="<?php echo $category_url; ?>" style="width: 200px;">
            <?php else: ?>
              Set image
            <?php endif; ?>
          </a>
          <a data-input="#c-feature-url" href="#" id="c-feature-url-remove" style="display: <?php echo ($category_url) ? 'block':'none'?>;" class="c-remove">Remove image</a>
          <input type="hidden" value="<?php echo $category_url; ?>" id="c-feature-url" name="c-feature-url"/> 
        </div>
      </div>

      <div class="c-category-postbox c-category-postbox-dark postbox">
        <h3 class="hndle"><span>Set Sponsor Logo</span></h3>
        <div class="inside">
          <a data-input="#c-sponsor-url" data-uploader-title="Set sponsor image" href="<?php echo get_home_url(); ?>/wp-admin/media-upload.php?type=image" id="set-sponsor-thumbnail" class="thickbox">
            <?php if ($sponsor_url): ?>
              <img src="<?php echo $sponsor_url; ?>" style="width: 200px;">
            <?php else: ?>
              Set image
            <?php endif; ?>
          </a>
          <a data-input="#c-sponsor-url" href="#" id="c-sponsor-url-remove" style="display: <?php echo ($sponsor_url) ? 'block':'none'?>;" class="c-remove">Remove image</a>
          <input type="hidden" value="<?php echo $sponsor_url; ?>" id="c-sponsor-url" name="c-sponsor-url"/>
        </div>
      </div>
    </td>
  </tr>
  <tr id="c-sponsor-link" class="form-field">
    <th>Sponsor link</th>
    <td>
      <input type="text" value="<?php echo $sponsor_link; ?>" id="c-sponsor-link" name="c-sponsor-link"/>
      <p class="description">Enter fully qualified url such as http://www.somename.com</p>
    </td>
  </tr>
  <tr id="c-hex" class="form-field">
    <th>Hex colour value</th>
    <td>
      <input type="text" value="<?php echo $hex_value; ?>" id="c-category-hex" name="c-category-hex"/>
      <p class="description">A hexidecimal value. Defaults to #000000 if blank</p>
    </td>
  </tr>
  <tr id="c-opacity" class="form-field">
    <th>Opacity overlay</th>
    <td>
      <input type="text" value="<?php echo $opacity_value; ?>" id="c-category-opacity" name="c-category-opacity"/>
      <p class="description">An opacity value. Defaults to 0.6 if blank</p>
    </td>
  </tr>
<?php 
}
add_action( 'featured_tax_edit_form_fields', 'extra_category_fields');
add_action( 'news_tax_edit_form_fields', 'extra_category_fields');


function save_category_extras( $term_id ) {
  if (isset($_POST['c-feature-url'])) {
    update_term_meta( $term_id, 'c-feature-url', $_POST['c-feature-url'] );
  } 
  if (isset($_POST['c-sponsor-url'])) {
    update_term_meta( $term_id, 'c-sponsor-url', $_POST['c-sponsor-url'] );
  } 
  if (isset($_POST['c-category-hex'])) {
    update_term_meta( $term_id, 'c-category-hex', $_POST['c-category-hex'] );
  }
  if (isset($_POST['c-category-opacity'])) {
    update_term_meta( $term_id, 'c-category-opacity', $_POST['c-category-opacity'] );
  }
  if (isset($_POST['c-sponsor-link'])) {
    update_term_meta( $term_id, 'c-sponsor-link', $_POST['c-sponsor-link'] );
  }              
}
add_action('edited_featured_tax', 'save_category_extras', 10, 1);
add_action('edited_news_tax', 'save_category_extras', 10, 1);


function delete_category_extras( $term_id ) {
  delete_term_meta( $term_id, 'c-feature-url' );
  delete_term_meta( $term_id, 'c-sponsor-url' );
  delete_term_meta( $term_id, 'c-category-hex' );
  delete_term_meta( $term_id, 'c-category-opacity' );
  delete_term_meta( $term_id, 'c-sponsor-link' );
}
add_action('delete_featured_tax', 'delete_category_extras', 10, 1);
add_action('delete_news_tax', 'delete_category_extras', 10, 1);

?>