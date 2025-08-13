jQuery(document).ready(function($) {
    var mediaUploader;
    var galleryUploader;
    
    // Logo Upload button click
    $('.logo-upload-btn').on('click', function(e) {
        e.preventDefault();
        
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        // Create the media uploader
        mediaUploader = wp.media({
            title: 'Vali arendaja logo',
            button: {
                text: 'Kasuta seda logot'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });
        
        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            
            // Set the URL in the hidden input
            $('#project_logo').val(attachment.url);
            
            // Update preview
            var previewHtml = '<img src="' + attachment.url + '" alt="Logo eelvaade" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />';
            $('.logo-preview').html(previewHtml);
            
            // Show remove button
            $('.logo-remove-btn').show();
        });
        
        // Open the uploader dialog
        mediaUploader.open();
    });
    
    // Remove button click
    $('.logo-remove-btn').on('click', function(e) {
        e.preventDefault();
        
        // Clear the input
        $('#project_logo').val('');
        
        // Clear preview
        $('.logo-preview').empty();
        
        // Hide remove button
        $(this).hide();
    });
    
    // Gallery Management
    
    // Make gallery sortable
    $('#gallery-preview').sortable({
        items: '.gallery-item',
        handle: '.image-handle',
        update: function() {
            updateGalleryInput();
        }
    });
    
    // Gallery add button
    $('.gallery-add-btn').on('click', function(e) {
        e.preventDefault();
        
        // If the uploader object has already been created, reopen the dialog
        if (galleryUploader) {
            galleryUploader.open();
            return;
        }
        
        // Create the media uploader
        galleryUploader = wp.media({
            title: 'Vali galerii pildid',
            button: {
                text: 'Lisa galeriisse'
            },
            multiple: true,
            library: {
                type: 'image'
            }
        });
        
        // When files are selected, add them to gallery
        galleryUploader.on('select', function() {
            var selection = galleryUploader.state().get('selection');
            
            selection.map(function(attachment) {
                attachment = attachment.toJSON();
                addImageToGallery(attachment.id, attachment.url);
            });
            
            updateGalleryInput();
        });
        
        // Open the uploader dialog
        galleryUploader.open();
    });
    
    // Remove image from gallery
    $(document).on('click', '.remove-image', function(e) {
        e.preventDefault();
        $(this).closest('.gallery-item').remove();
        updateGalleryInput();
    });
    
    // Add image to gallery preview
    function addImageToGallery(imageId, imageUrl) {
        // Check if image already exists
        if ($('#gallery-preview .gallery-item[data-id="' + imageId + '"]').length > 0) {
            return;
        }
        
        var imageHtml = '<div class="gallery-item" data-id="' + imageId + '">' +
                       '<img src="' + imageUrl + '" alt="" style="width: 150px; height: 150px; object-fit: cover;">' +
                       '<button type="button" class="remove-image" title="Eemalda pilt">&times;</button>' +
                       '<div class="image-handle">≡</div>' +
                       '</div>';
        
        $('#gallery-preview').append(imageHtml);
    }
    
    // Update hidden input with gallery image IDs
    function updateGalleryInput() {
        var imageIds = [];
        $('#gallery-preview .gallery-item').each(function() {
            imageIds.push($(this).data('id'));
        });
        $('#project_gallery_images').val(imageIds.join(','));
    }
});
