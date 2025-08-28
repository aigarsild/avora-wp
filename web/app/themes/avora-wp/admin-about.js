jQuery(document).ready(function($) {
    
    // Values Image Upload functionality
    var valuesImageFrame;
    
    // Upload button click
    $('.values-image-upload-btn').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var hiddenInput = button.parent().find('#about_values_image');
        var preview = button.parent().find('.image-preview');
        var removeBtn = button.parent().find('.values-image-remove-btn');
        
        // If the media frame already exists, reopen it
        if (valuesImageFrame) {
            valuesImageFrame.open();
            return;
        }
        
        // Create a new media frame
        valuesImageFrame = wp.media({
            title: 'Vali väärtuste sektsiooni pilt',
            button: {
                text: 'Kasuta seda pilti'
            },
            multiple: false
        });
        
        // When an image is selected in the media frame
        valuesImageFrame.on('select', function() {
            var attachment = valuesImageFrame.state().get('selection').first().toJSON();
            
            // Set the image URL to the hidden input
            hiddenInput.val(attachment.url);
            
            // Show preview
            preview.html('<img src="' + attachment.url + '" alt="Väärtuste sektsiooni pilt" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />');
            
            // Show remove button
            removeBtn.show();
        });
        
        // Open the media frame
        valuesImageFrame.open();
    });
    
    // Remove image button click
    $('.values-image-remove-btn').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var hiddenInput = button.parent().find('#about_values_image');
        var preview = button.parent().find('.image-preview');
        
        // Clear the hidden input
        hiddenInput.val('');
        
        // Clear preview
        preview.html('');
        
        // Hide remove button
        button.hide();
    });
});
