/*
 * Attaches the attachment uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_attachment_frame;
 
    // Runs when the attachment button is clicked.
    $('#leadbribe-button').click(function(e){
 
        // Prevents the default action from occuring.
        e.preventDefault();
 
        // If the frame already exists, re-open it.
        if ( meta_attachment_frame ) {
            meta_attachment_frame.open();
            return;
        }
 
        // Sets up the media library frame
        meta_attachment_frame = wp.media.frames.meta_attachment_frame = wp.media({
            title: meta_attachment.title,
            button: { text:  meta_attachment.button }
        });
 
        // Runs when an attachment is selected.
        meta_attachment_frame.on('select', function(){
 
            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_attachment_frame.state().get('selection').first().toJSON();
 
            // Sends the attachment URL to our custom attachment input field.
            $('#leadbribe').val(media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_attachment_frame.open();
    });
});