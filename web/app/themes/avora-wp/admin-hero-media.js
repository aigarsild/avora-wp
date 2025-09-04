jQuery(document).ready(function($) {
    // Handle radio button changes to show/hide relevant sections
    $('input[name="project_hero_media_type"]').on('change', function() {
        const selectedType = $(this).val();
        
        // Hide all conditional rows
        $('.hero-custom-image-row, .hero-video-row, .hero-video-overlay-row').hide();
        
        // Show relevant row based on selection
        if (selectedType === 'custom_image') {
            $('.hero-custom-image-row').show();
        } else if (selectedType === 'video') {
            $('.hero-video-row, .hero-video-overlay-row').show();
        }
    });
    
    // Hero Image Upload
    $('.hero-image-upload-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const preview = button.siblings('.hero-image-preview');
        const input = button.siblings('#project_hero_image');
        const removeBtn = button.siblings('.hero-image-remove-btn');
        
        const mediaUploader = wp.media({
            title: 'Vali Hero Pilt',
            button: {
                text: 'Kasuta seda pilti'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });
        
        mediaUploader.on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            
            input.val(attachment.url);
            preview.html('<img src="' + attachment.url + '" alt="Hero pilt" style="max-width: 300px; height: auto; margin-bottom: 10px; display: block;" />');
            removeBtn.show();
        });
        
        mediaUploader.open();
    });
    
    // Hero Image Remove
    $('.hero-image-remove-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const preview = button.siblings('.hero-image-preview');
        const input = button.siblings('#project_hero_image');
        
        input.val('');
        preview.empty();
        button.hide();
    });
    
    // Hero Video Upload
    $('.hero-video-upload-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const preview = button.siblings('.hero-video-preview');
        const input = button.siblings('#project_hero_video');
        const removeBtn = button.siblings('.hero-video-remove-btn');
        
        const mediaUploader = wp.media({
            title: 'Vali Hero Video',
            button: {
                text: 'Kasuta seda videot'
            },
            multiple: false,
            library: {
                type: 'video'
            }
        });
        
        mediaUploader.on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            
            input.val(attachment.url);
            preview.html('<video controls style="max-width: 300px; height: auto; margin-bottom: 10px; display: block;"><source src="' + attachment.url + '">Your browser does not support the video tag.</video>');
            removeBtn.show();
        });
        
        mediaUploader.open();
    });
    
    // Hero Video Remove
    $('.hero-video-remove-btn').on('click', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const preview = button.siblings('.hero-video-preview');
        const input = button.siblings('#project_hero_video');
        
        input.val('');
        preview.empty();
        button.hide();
    });
    
    // Handle opacity slider display update
    $('#project_hero_video_overlay_opacity').on('input', function() {
        $('#opacity-display').text($(this).val());
    });
    
    // Handle blur slider display update
    $('#project_hero_video_overlay_blur').on('input', function() {
        $('#blur-display').text($(this).val() + 'px');
    });
    
    // Handle speed slider display update
    $('#project_hero_video_playback_speed').on('input', function() {
        $('#speed-display').text($(this).val() + 'x');
    });
});
