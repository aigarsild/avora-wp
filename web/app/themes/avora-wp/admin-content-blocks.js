jQuery(document).ready(function($) {
    let blockIndex = $('.content-block').length;
    
    // Add new content block
    $('.add-content-block').on('click', function(e) {
        e.preventDefault();
        
        let template = $('#content-block-template').html();
        let blockHtml = template.replace(/\{\{INDEX\}\}/g, blockIndex)
                               .replace(/\{\{INDEX_DISPLAY\}\}/g, blockIndex + 1);
        
        $('#content-blocks-container').append(blockHtml);
        
        // Note: New blocks will use plain textareas that get converted to wp_editor on page save/reload
        // WordPress native editors can't be dynamically initialized via JavaScript easily
        
        // Update radio button names for the new block
        updateRadioButtonNames();
        
        blockIndex++;
        updateBlocksData();
    });
    
    // Remove content block
    $(document).on('click', '.remove-content-block', function(e) {
        e.preventDefault();
        
        if (confirm('Kas oled kindel, et tahad selle sisuploki eemaldada?')) {
            let blockToRemove = $(this).closest('.content-block');
            let textarea = blockToRemove.find('.block-content');
            
            // Remove TinyMCE instance if it exists
            if (textarea.length && textarea.attr('id') && typeof tinymce !== 'undefined') {
                let editorId = textarea.attr('id');
                let editor = tinymce.get(editorId);
                if (editor) {
                    editor.remove();
                }
            }
            
            blockToRemove.remove();
            updateBlockNumbers();
            updateRadioButtonNames();
            updateBlocksData();
        }
    });
    
    // Update blocks data when any field changes
    $(document).on('input change', '.content-block input, .content-block textarea', function() {
        updateBlocksData();
    });
    
    // Image upload functionality
    $(document).on('click', '.block-image-upload-btn', function(e) {
        e.preventDefault();
        
        let button = $(this);
        let block = button.closest('.content-block');
        let hiddenInput = block.find('.block-image');
        let preview = block.find('.image-preview');
        let removeBtn = block.find('.block-image-remove-btn');
        
        let mediaFrame = wp.media({
            title: 'Vali ploki pilt',
            button: {
                text: 'Kasuta seda pilti'
            },
            multiple: false
        });
        
        mediaFrame.on('select', function() {
            let attachment = mediaFrame.state().get('selection').first().toJSON();
            
            hiddenInput.val(attachment.url);
            preview.html('<img src="' + attachment.url + '" alt="Ploki pilt" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />');
            removeBtn.show();
            
            updateBlocksData();
        });
        
        mediaFrame.open();
    });
    
    // Remove image
    $(document).on('click', '.block-image-remove-btn', function(e) {
        e.preventDefault();
        
        let button = $(this);
        let block = button.closest('.content-block');
        let hiddenInput = block.find('.block-image');
        let preview = block.find('.image-preview');
        
        hiddenInput.val('');
        preview.html('');
        button.hide();
        
        updateBlocksData();
    });
    
    // Update block numbers after removal
    function updateBlockNumbers() {
        $('.content-block').each(function(index) {
            $(this).find('h4').text('Sisuplokk ' + (index + 1));
            $(this).attr('data-index', index);
        });
        blockIndex = $('.content-block').length;
    }
    
    // Update radio button names to ensure each block has unique radio groups
    function updateRadioButtonNames() {
        $('.content-block').each(function(index) {
            $(this).find('.block-image-position').attr('name', 'block_image_position_' + index);
        });
    }
    
    // Update hidden field with current blocks data
    function updateBlocksData() {
        let blocks = [];
        
        $('.content-block').each(function() {
            let block = $(this);
            let contentElement = block.find('.block-content');
            let content = '';
            
            // Get content from TinyMCE if it exists, otherwise from textarea
            if (contentElement.attr('id') && typeof tinymce !== 'undefined') {
                let editor = tinymce.get(contentElement.attr('id'));
                if (editor) {
                    content = editor.getContent();
                } else {
                    content = contentElement.val() || '';
                }
            } else {
                content = contentElement.val() || '';
            }
            
            let blockData = {
                title: block.find('.block-title').val() || '',
                content: content,
                image: block.find('.block-image').val() || '',
                image_position: block.find('.block-image-position:checked').val() || 'left'
            };
            blocks.push(blockData);
        });
        
        $('#about_content_blocks_data').val(JSON.stringify(blocks));
    }
    
    // Initialize TinyMCE change listeners for existing editors
    function initializeExistingEditors() {
        if (typeof tinymce !== 'undefined') {
            // Wait a bit for TinyMCE to initialize
            setTimeout(function() {
                $('.content-block').each(function() {
                    let contentElement = $(this).find('.block-content');
                    if (contentElement.attr('id')) {
                        let editor = tinymce.get(contentElement.attr('id'));
                        if (editor) {
                            editor.on('change keyup', function() {
                                updateBlocksData();
                            });
                        }
                    }
                });
            }, 1000);
        }
    }
    
    // Initialize data on page load
    updateRadioButtonNames();
    updateBlocksData();
    initializeExistingEditors();
});
