<?php
/*
 * Adding custom fields to user profiles in admin
 * area.
 */


// --------------------------------------------  
// add custom fields to user profiles
// -------------------------------------------- 
add_action( 'show_user_profile', 'extra_profile_fields' );
add_action( 'edit_user_profile', 'extra_profile_fields' );

function extra_profile_fields( $user ) { ?>

  <h3>Additional information</h3>
  <table class="form-table">
    <tr>
      <th><label for="location">Location</label></th>
      <td>
        <input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="regular-text" /><br />
        <span class="description">Please enter your location</span>
      </td>
    </tr>
    
    <tr>
      <th><label for="display_order">Display Order</label></th>
      <td>
        <select name="display_order">
          <option></option>
          <?php 
            // get count of users less our superuser
            $user_count = count_users();
            $selected = get_the_author_meta( 'display_order', $user->ID );

            for ($i = 1; $i < $user_count['total_users']; $i++):
          ?>
            <option value="<?php echo $i; ?>" <?php echo $selected == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
          <?php endfor; ?>
        </select>
      </td>
    </tr>
  </table>

<?php 
}

function save_extra_profile_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  update_user_meta( $user_id, 'location', $_POST['location'] );
  update_user_meta( $user_id, 'display_order', $_POST['display_order'] );
}
add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );



// --------------------------------------------  
// display custom fields in user admin table
// -------------------------------------------- 
function modify_user_table( $column ) {
    $column['order'] = 'Order';
    return $column;
}
add_filter( 'manage_users_columns', 'modify_user_table' );

function modify_user_table_row( $val, $column_name, $user_id ) {
    $user = get_userdata( $user_id );

    switch ($column_name) {
        case 'order' :
            return $user->display_order;
            break;

        default:
    }

    return $return;
}
add_filter( 'manage_users_custom_column', 'modify_user_table_row', 10, 3 );

?>