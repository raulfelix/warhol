// Uploading files
var file_frame;
 
jQuery('#set-category-thumbnail, #set-sponsor-thumbnail').live('click', function( event ) {

  event.preventDefault();
  
  var $link = jQuery(this);
  var $inputField = jQuery($link.data('input'));
  var $linkRemove = jQuery($link.data('input') + '-remove');

  // Create the media frame.
  file_frame = wp.media.frames.file_frame = wp.media({
    title: $link.data('uploader-title'),
    button: {
      text: $link.data( 'uploader_button_text' ),
    },
    multiple: false
  });

  // When an image is selected, run a callback.
  file_frame.on('select', function() {
    // We set multiple to false so only get one image from the uploader
    attachment = file_frame.state().get('selection').first().toJSON();
    console.log(attachment);

    $inputField.attr('value', attachment.url);
    $link.html('<img src="' + attachment.url + '" style="width: 200px;">');
    $linkRemove.show();
  });

  // Finally, open the modal
  file_frame.open();
});

jQuery('#c-sponsor-url-remove, #c-feature-url-remove').live('click', function( event ) {
  event.preventDefault();
  
  var $link = jQuery(this).hide().prev().html('Set image');
  var $inputField = jQuery($link.data('input'));
  $inputField.attr('value', '');
});