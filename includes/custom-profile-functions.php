<?php
/*
 * Adding custom fields to user profiles in admin
 * area.
 */

// --------------------------------------------  
// add a location field for to user profiles
// -------------------------------------------- 
add_action( 'show_user_profile', 'extra_profile_fields' );
add_action( 'edit_user_profile', 'extra_profile_fields' );

function extra_profile_fields( $user ) { ?>

  <h3>Additional information</h3>
  <table class="form-table">
    <tr>
      <th><label for="twitter">Location</label></th>
      <td>
        <input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="regular-text" /><br />
        <span class="description">Please enter your location</span>
      </td>
    </tr>
  </table>

<?php 
}


function save_extra_profile_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  update_usermeta( $user_id, 'location', $_POST['location'] );
}
add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

?>