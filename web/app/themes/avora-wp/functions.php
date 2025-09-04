<?php
/**
 * Avora WP Theme Functions
 * 
 * Pixel-perfect conversion of AVORA static site to WordPress theme
 */

// Theme setup
add_action('after_setup_theme', function () {
    // Add theme support
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    
    // Set image sizes to match design
    set_post_thumbnail_size(1200, 600, true);
    add_image_size('hero', 1200, 800, true);
    add_image_size('feature', 500, 500, true);
    
    // Register navigation menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'avora-wp'),
    ]);
    
    // Set content width
    $GLOBALS['content_width'] = 1400;
});

// Enqueue assets
add_action('wp_enqueue_scripts', function () {
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();

    // Get built assets from dist/assets directory
    $assets_dir = $theme_dir . '/dist/assets';
    if (is_dir($assets_dir)) {
        $assets = glob($assets_dir . '/*');
        
        foreach ($assets as $asset) {
            $filename = basename($asset);
            $asset_uri = $theme_uri . '/dist/assets/' . $filename;
            
            if (strpos($filename, '.css') !== false) {
                wp_enqueue_style(
                    'avora-wp-styles', 
                    $asset_uri, 
                    [], // No dependencies since we're removing default styles
                    filemtime($asset),
                    'all'
                );
            } elseif (strpos($filename, '.js') !== false) {
                wp_enqueue_script(
                    'avora-wp-scripts', 
                    $asset_uri, 
                    [], 
                    filemtime($asset), 
                    true
                );
            }
        }
    }
});

// Clean up WordPress head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Custom excerpt length for Estonian content
add_filter('excerpt_length', function($length) {
    return 25;
});

// Custom excerpt more text
add_filter('excerpt_more', function($more) {
    return '...';
});

// Add Estonian language support
add_action('init', function() {
    load_theme_textdomain('avora-wp', get_template_directory() . '/languages');
});

// Enqueue media uploader scripts in admin
add_action('admin_enqueue_scripts', function($hook) {
    global $post_type, $post;
    
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type == 'project') {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('project-media-uploader', get_template_directory_uri() . '/admin-media.js', array('jquery', 'jquery-ui-sortable'), '1.0.0', true);
            wp_enqueue_script('project-hero-media', get_template_directory_uri() . '/admin-hero-media.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script('project-content-blocks', get_template_directory_uri() . '/admin-content-blocks.js', array('jquery'), '1.0.0', true);
            wp_enqueue_style('project-admin-styles', get_template_directory_uri() . '/admin-styles.css', array(), '1.0.0');
        }
        
        // Enqueue for About Us page (check by template or slug)
        if ($post_type == 'page' && $post && (get_page_template_slug($post->ID) === 'page-meist.php' || $post->post_name === 'ettevottest')) {
            wp_enqueue_media();
            wp_enqueue_script('about-page-admin', get_template_directory_uri() . '/admin-about.js', array('jquery'), '1.0.0', true);
            wp_enqueue_script('about-content-blocks', get_template_directory_uri() . '/admin-content-blocks.js', array('jquery'), '1.0.0', true);
            wp_enqueue_style('project-admin-styles', get_template_directory_uri() . '/admin-styles.css', array(), '1.0.0');
        }
        
        // Enqueue for Contact page (admin styles only)
        if ($post_type == 'page' && $post && $post->post_name === 'kontakt') {
            wp_enqueue_style('project-admin-styles', get_template_directory_uri() . '/admin-styles.css', array(), '1.0.0');
        }
    }

    // Enable drag-and-drop ordering on Projects list screen
    if ($hook === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'project') {
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script(
            'project-ordering',
            get_template_directory_uri() . '/admin-project-order.js',
            array('jquery', 'jquery-ui-sortable'),
            '1.0.0',
            true
        );
        wp_localize_script('project-ordering', 'AvoraOrder', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('avora_update_project_order')
        ));
    }
});

// Enable SVG uploads
add_filter('upload_mimes', function($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

// Add SVG to allowed file types
add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ($wp_version !== '4.7.1') {
        return $data;
    }

    $filetype = wp_check_filetype($filename, $mimes);

    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4);

// Fix SVG display in media library
add_filter('wp_prepare_attachment_for_js', function($response, $attachment, $meta) {
    if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml') {
        $response['image'] = [
            'src' => $response['url'],
            'width' => 300,
            'height' => 300,
        ];
        $response['thumb'] = [
            'src' => $response['url'],
            'width' => 150,
            'height' => 150,
        ];
        $response['sizes'] = [
            'full' => [
                'url' => $response['url'],
                'width' => 300,
                'height' => 300,
                'orientation' => 'landscape',
            ]
        ];
    }
    return $response;
}, 10, 3);

// Basic SVG sanitization for security
add_filter('wp_handle_upload_prefilter', function($file) {
    if ($file['type'] === 'image/svg+xml') {
        $svg_content = file_get_contents($file['tmp_name']);
        
        // Basic security: remove script tags and on* attributes
        $svg_content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $svg_content);
        $svg_content = preg_replace('/\son\w+\s*=\s*["\'][^"\']*["\']/i', '', $svg_content);
        
        // Write sanitized content back
        file_put_contents($file['tmp_name'], $svg_content);
    }
    return $file;
});

// Register custom post type for projects
add_action('init', function() {
    register_post_type('project', [
        'labels' => [
            'name' => 'Projektid',
            'singular_name' => 'Projekt',
            'add_new' => 'Lisa uus projekt',
            'add_new_item' => 'Lisa uus projekt',
            'edit_item' => 'Muuda projekti',
            'new_item' => 'Uus projekt',
            'view_item' => 'Vaata projekti',
            'search_items' => 'Otsi projekte',
            'not_found' => 'Projekte ei leitud',
            'not_found_in_trash' => 'Prügikastis projekte ei leitud'
        ],
        'public' => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'projekt'],
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'show_in_rest' => true,
        'menu_position' => 20
    ]);
});

// Flush rewrite rules when theme is activated to ensure custom post type URLs work
add_action('after_switch_theme', 'avora_flush_rewrite_rules');
function avora_flush_rewrite_rules() {
    flush_rewrite_rules();
}

// Add admin notice to flush permalinks if needed
add_action('admin_notices', function() {
    if (isset($_GET['flush_permalinks']) && $_GET['flush_permalinks'] === '1') {
        flush_rewrite_rules();
        echo '<div class="notice notice-success is-dismissible"><p>Permalinks flushed! Project URLs should work now.</p></div>';
    }
    
    // Show notice if project exists but permalinks might need flushing
    $projects = get_posts(['post_type' => 'project', 'posts_per_page' => 1]);
    if ($projects && !get_option('avora_permalinks_flushed')) {
        $flush_url = add_query_arg('flush_permalinks', '1', admin_url());
        echo '<div class="notice notice-warning"><p>Project URLs might not work. <a href="' . $flush_url . '">Click here to fix permalinks</a>.</p></div>';
    }
});

// Add custom meta fields for projects (simple meta boxes)
add_action('add_meta_boxes', function() {
    add_meta_box(
        'project_details',
        'Projekti detailid',
        'project_details_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_hero_media',
        'Projekti hero pilt/video',
        'project_hero_media_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_content_blocks',
        'Projekti lisasisu plokid',
        'project_content_blocks_callback',
        'project',
        'normal',
        'high'
    );
    
    add_meta_box(
        'project_gallery',
        'Projekti galerii',
        'project_gallery_callback',
        'project',
        'normal',
        'high'
    );
    
    // Add About Us page meta boxes (only for pages using the About Us template or slug)
    global $post;
    if ($post && (get_page_template_slug($post->ID) === 'page-meist.php' || $post->post_name === 'ettevottest')) {
        add_meta_box(
            'about_page_header',
            'Meist lehe päis',
            'about_page_header_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'about_page_values',
            'Meie väärtused sektsiooni',
            'about_page_values_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'about_content_blocks',
            'Lisasisu plokid',
            'about_content_blocks_callback',
            'page',
            'normal',
            'high'
        );
    }
    
    // Add Contact page meta boxes (only for page with slug 'kontakt')
    if ($post && $post->post_name === 'kontakt') {
        add_meta_box(
            'contact_page_header',
            'Kontakti lehe päis',
            'contact_page_header_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'contact_company_info',
            'Ettevõtte informatsioon',
            'contact_company_info_callback',
            'page',
            'normal',
            'high'
        );
        
        add_meta_box(
            'contact_form_settings',
            'Kontaktvormi seaded',
            'contact_form_settings_callback',
            'page',
            'normal',
            'high'
        );
    }
});

function project_details_callback($post) {
    wp_nonce_field('project_details_nonce', 'project_details_nonce_field');
    
    $status = get_post_meta($post->ID, 'project_status', true);
    $location = get_post_meta($post->ID, 'project_location', true);
    $year = get_post_meta($post->ID, 'project_year', true);
    $type = get_post_meta($post->ID, 'project_type', true);
    $units = get_post_meta($post->ID, 'project_units', true);
    $area = get_post_meta($post->ID, 'project_area', true);
    $logo = get_post_meta($post->ID, 'project_logo', true);
    $link = get_post_meta($post->ID, 'project_link', true);
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="project_status">Staatus</label></th>';
    echo '<td><select id="project_status" name="project_status">';
    echo '<option value="">Vali staatus</option>';
    $statuses = ['Valmis', 'Ehituses', 'Planeerimisel', 'Müügis'];
    foreach ($statuses as $s) {
        echo '<option value="' . $s . '"' . selected($status, $s, false) . '>' . $s . '</option>';
    }
    echo '</select></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_location">Asukoht</label></th>';
    echo '<td><input type="text" id="project_location" name="project_location" value="' . esc_attr($location) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_year">Aasta</label></th>';
    echo '<td><input type="text" id="project_year" name="project_year" value="' . esc_attr($year) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_type">Tüüp</label></th>';
    echo '<td><input type="text" id="project_type" name="project_type" value="' . esc_attr($type) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_units">Ühikud</label></th>';
    echo '<td><input type="text" id="project_units" name="project_units" value="' . esc_attr($units) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_area">Pindala</label></th>';
    echo '<td><input type="text" id="project_area" name="project_area" value="' . esc_attr($area) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_link">Projekti link</label></th>';
    echo '<td><input type="url" id="project_link" name="project_link" value="' . esc_attr($link) . '" class="regular-text" placeholder="https://example.com" />';
    echo '<p class="description">Lisa projekti kodulehe või lisainfo link. Link kuvatakse projekti pealkirja all.</p></td></tr>';
    
    echo '<tr><th scope="row"><label for="project_logo">Arendaja logo</label></th>';
    echo '<td>';
    echo '<div class="project-logo-upload">';
    echo '<input type="hidden" id="project_logo" name="project_logo" value="' . esc_attr($logo) . '" />';
    echo '<div class="logo-preview">';
    if (!empty($logo)) {
        echo '<img src="' . esc_url($logo) . '" alt="Logo eelvaade" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />';
    }
    echo '</div>';
    echo '<button type="button" class="button logo-upload-btn">Vali logo</button> ';
    echo '<button type="button" class="button logo-remove-btn" style="' . (empty($logo) ? 'display:none;' : '') . '">Eemalda logo</button>';
    echo '<p class="description">Vali arendaja logo. Kui logo puudub, kuvatakse "Vaata detaile" nupp.</p>';
    echo '</div>';
    echo '</td></tr>';
    
    echo '</table>';
}

// About Us page header callback
function about_page_header_callback($post) {
    wp_nonce_field('about_page_header_nonce', 'about_page_header_nonce_field');
    
    $page_title = get_post_meta($post->ID, 'about_page_title', true);
    $page_description = get_post_meta($post->ID, 'about_page_description', true);
    
    // Use defaults if empty
    if (empty($page_title)) {
        $page_title = 'Meist';
    }
    if (empty($page_description)) {
        $page_description = 'AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte, mis loob tuleviku kodusid täna.';
    }
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="about_page_title">Lehe pealkiri</label></th>';
    echo '<td><input type="text" id="about_page_title" name="about_page_title" value="' . esc_attr($page_title) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="about_page_description">Lehe kirjeldus</label></th>';
    echo '<td>';
    wp_editor($page_description, 'about_page_description', [
        'textarea_name' => 'about_page_description',
        'textarea_rows' => 12,
        'media_buttons' => true,
        'teeny' => false,
        'wpautop' => true,
        'tinymce' => [
            'height' => 300,
            'menubar' => true,
            'plugins' => 'advlist,autolink,lists,link,image,charmap,print,preview,anchor,searchreplace,visualblocks,code,fullscreen,insertdatetime,media,table,paste,code,help,wordcount',
            'toolbar1' => 'formatselect,fontselect,fontsizeselect',
            'toolbar2' => 'bold,italic,underline,strikethrough,forecolor,backcolor,removeformat',
            'toolbar3' => 'alignleft,aligncenter,alignright,alignjustify,outdent,indent',
            'toolbar4' => 'bullist,numlist,blockquote,hr,link,unlink,image,media,table',
            'toolbar5' => 'undo,redo,cut,copy,paste,searchreplace,visualblocks,code,fullscreen,help'
        ],
        'quicktags' => [
            'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
        ]
    ]);
    echo '<p class="description">Sisesta lehe kirjeldus. Saad kasutada rikkalikku tekstitoimturit vorminduseks. See tekst kuvatakse lehe päises täislaiuses.</p>';
    echo '</td></tr>';
    
    echo '</table>';
}

// About Us page values section callback
function about_page_values_callback($post) {
    wp_nonce_field('about_page_values_nonce', 'about_page_values_nonce_field');
    
    $values_title = get_post_meta($post->ID, 'about_values_title', true);
    $values_image = get_post_meta($post->ID, 'about_values_image', true);
    $values_content = get_post_meta($post->ID, 'about_values_content', true);
    
    // Use defaults if empty
    if (empty($values_title)) {
        $values_title = 'Meie väärtused';
    }
    if (empty($values_content)) {
        $values_content = '<ul class="text-lg">
    <li class="mb-4"><strong>Kvaliteet:</strong> Kasutame ainult parimaid materjale ja töötame tunnustatud partneritega.</li>
    <li class="mb-4"><strong>Täpsus:</strong> Iga detail on läbi mõeldud ja hoolikalt teostatud.</li>
    <li class="mb-4"><strong>Jätkusuutlikkus:</strong> Ehitame kodusid, mis kestavad põlvkondade vältel.</li>
    <li class="mb-4"><strong>Innovatsioon:</strong> Kasutame uuenduslikke ehitusmeetodeid ja lahendusi.</li>
</ul>';
    }
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="about_values_title">Sektsiooni pealkiri</label></th>';
    echo '<td><input type="text" id="about_values_title" name="about_values_title" value="' . esc_attr($values_title) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="about_values_image">Sektsiooni pilt</label></th>';
    echo '<td>';
    echo '<div class="about-values-image-upload">';
    echo '<input type="hidden" id="about_values_image" name="about_values_image" value="' . esc_attr($values_image) . '" />';
    echo '<div class="image-preview">';
    if (!empty($values_image)) {
        echo '<img src="' . esc_url($values_image) . '" alt="Väärtuste sektsiooni pilt" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />';
    }
    echo '</div>';
    echo '<button type="button" class="button values-image-upload-btn">Vali pilt</button> ';
    echo '<button type="button" class="button values-image-remove-btn" style="' . (empty($values_image) ? 'display:none;' : '') . '">Eemalda pilt</button>';
    echo '<p class="description">Vali väärtuste sektsiooni pilt. Kui pilt puudub, kuvatakse vaikimisi pilt.</p>';
    echo '</div>';
    echo '</td></tr>';
    
    echo '<tr><th scope="row" style="vertical-align: top; padding-top: 20px;"><label for="about_values_content">Sektsiooni sisu</label></th>';
    echo '<td>';
    
    // Use WordPress editor for the content
    $editor_settings = array(
        'textarea_name' => 'about_values_content',
        'textarea_rows' => 15,
        'media_buttons' => true,
        'teeny' => false,
        'tinymce' => array(
            'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv',
            'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
        ),
        'quicktags' => true
    );
    
    wp_editor($values_content, 'about_values_content', $editor_settings);
    
    echo '<p class="description">Kasutage redaktorit väärtuste sektsiooni sisu muutmiseks. Saate kasutada nimekirju, rõhutamist ja muid vormindusi.</p>';
    echo '</td></tr>';
    
    echo '</table>';
}

// About Us content blocks callback
function about_content_blocks_callback($post) {
    wp_nonce_field('about_content_blocks_nonce', 'about_content_blocks_nonce_field');
    
    $content_blocks = get_post_meta($post->ID, 'about_content_blocks', true);
    $content_blocks = $content_blocks ? json_decode($content_blocks, true) : [];
    
    echo '<div class="about-content-blocks-manager">';
    echo '<div class="blocks-actions">';
    echo '<button type="button" class="button add-content-block">Lisa uus sisuplokk</button>';
    echo '<p class="description">Lisa lisasisu plokke koos piltidega. Saad valida, millisel küljel pilt asub.</p>';
    echo '</div>';
    
    echo '<div class="content-blocks-container" id="content-blocks-container">';
    
    if (!empty($content_blocks)) {
        foreach ($content_blocks as $index => $block) {
            echo_content_block_html($index, $block);
        }
    }
    
    echo '</div>';
    
    echo '<input type="hidden" id="about_content_blocks_data" name="about_content_blocks_data" value="' . esc_attr(json_encode($content_blocks, JSON_UNESCAPED_UNICODE)) . '" />';
    echo '</div>';
    
    // Add template for new blocks
    echo '<script type="text/html" id="content-block-template">';
    echo_content_block_html('{{INDEX}}', [
        'title' => '',
        'content' => '',
        'image' => '',
        'image_position' => 'left',
        'block_type' => 'regular'
    ]);
    echo '</script>';
}

// Helper function to generate content block HTML
function echo_content_block_html($index, $block) {
    $title = isset($block['title']) ? $block['title'] : '';
    $content = isset($block['content']) ? $block['content'] : '';
    $image = isset($block['image']) ? $block['image'] : '';
    $image_position = isset($block['image_position']) ? $block['image_position'] : 'left';
    $block_type = isset($block['block_type']) ? $block['block_type'] : 'regular';
    
    echo '<div class="content-block" data-index="' . esc_attr($index) . '">';
    echo '<div class="content-block-header">';
    echo '<h4>Sisuplokk ' . (is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}') . '</h4>';
    echo '<button type="button" class="button-link remove-content-block" title="Eemalda plokk">&times;</button>';
    echo '</div>';
    
    echo '<table class="form-table">';
    
    // Title
    echo '<tr><th scope="row"><label>Pealkiri</label></th>';
    echo '<td><input type="text" class="block-title regular-text" value="' . esc_attr($title) . '" placeholder="Sisesta ploki pealkiri" /></td></tr>';
    
    // Block type
    echo '<tr><th scope="row"><label>Ploki tüüp</label></th>';
    echo '<td>';
    echo '<label><input type="radio" name="block_type_' . esc_attr($index) . '" class="block-type" value="regular" ' . checked($block_type, 'regular', false) . '> Tavaline (koos pildiga)</label><br>';
    echo '<label><input type="radio" name="block_type_' . esc_attr($index) . '" class="block-type" value="fullwidth" ' . checked($block_type, 'fullwidth', false) . '> Täislaiuses (ilma pildita)</label>';
    echo '</td></tr>';
    
    // Image
    echo '<tr><th scope="row"><label>Pilt</label></th>';
    echo '<td>';
    echo '<div class="block-image-upload">';
    echo '<input type="hidden" class="block-image" value="' . esc_attr($image) . '" />';
    echo '<div class="image-preview">';
    if (!empty($image)) {
        echo '<img src="' . esc_url($image) . '" alt="Ploki pilt" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />';
    }
    echo '</div>';
    echo '<button type="button" class="button block-image-upload-btn">Vali pilt</button> ';
    echo '<button type="button" class="button block-image-remove-btn" style="' . (empty($image) ? 'display:none;' : '') . '">Eemalda pilt</button>';
    echo '</div>';
    echo '</td></tr>';
    
    // Image position
    echo '<tr><th scope="row"><label>Pildi asukoht</label></th>';
    echo '<td>';
    echo '<label><input type="radio" name="block_image_position_' . esc_attr($index) . '" class="block-image-position" value="left" ' . checked($image_position, 'left', false) . '> Vasakul</label><br>';
    echo '<label><input type="radio" name="block_image_position_' . esc_attr($index) . '" class="block-image-position" value="right" ' . checked($image_position, 'right', false) . '> Paremal</label>';
    echo '</td></tr>';
    
    // Content
    echo '<tr><th scope="row"><label>Sisu</label></th>';
    echo '<td>';
    
    // Use wp_editor for real blocks, textarea for template
    if (is_numeric($index)) {
        // Real block - use wp_editor
        $editor_id = 'block_content_' . $index;
        wp_editor($content, $editor_id, [
            'textarea_name' => 'block_content_' . $index,
            'textarea_rows' => 12,
            'media_buttons' => true,
            'teeny' => false,
            'wpautop' => true,
            'editor_class' => 'block-content-editor',
            'tinymce' => [
                'height' => 300,
                'menubar' => true,
                'plugins' => 'advlist,autolink,lists,link,image,charmap,print,preview,anchor,searchreplace,visualblocks,code,fullscreen,insertdatetime,media,table,paste,code,help,wordcount',
                'toolbar1' => 'formatselect,fontselect,fontsizeselect',
                'toolbar2' => 'bold,italic,underline,strikethrough,forecolor,backcolor,removeformat',
                'toolbar3' => 'alignleft,aligncenter,alignright,alignjustify,outdent,indent',
                'toolbar4' => 'bullist,numlist,blockquote,hr,link,unlink,image,media,table',
                'toolbar5' => 'undo,redo,cut,copy,paste,searchreplace,visualblocks,code,fullscreen,help'
            ],
            'quicktags' => [
                'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,more,close'
            ]
        ]);
    } else {
        // Template - use textarea that will be replaced by TinyMCE later
        echo '<textarea class="block-content large-text" rows="8" placeholder="Sisesta ploki sisu...">' . esc_textarea($content) . '</textarea>';
    }
    
    echo '<p class="description">Sisesta ploki sisu. Saad kasutada rikkalikku tekstitoimturit vorminduseks.</p>';
    echo '</td></tr>';
    
    echo '</table>';
    echo '</div>';
}

// Contact page header callback
function contact_page_header_callback($post) {
    wp_nonce_field('contact_page_header_nonce', 'contact_page_header_nonce_field');
    
    $page_title = get_post_meta($post->ID, 'contact_page_title', true);
    $page_description = get_post_meta($post->ID, 'contact_page_description', true);
    
    // Use defaults if empty
    if (empty($page_title)) {
        $page_title = 'Kontakt';
    }
    if (empty($page_description)) {
        $page_description = 'Võtke meiega ühendust, et arutada oma kinnisvaraprojekti või saada rohkem informatsiooni meie teenuste kohta.';
    }
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="contact_page_title">Lehe pealkiri</label></th>';
    echo '<td><input type="text" id="contact_page_title" name="contact_page_title" value="' . esc_attr($page_title) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_page_description">Lehe kirjeldus</label></th>';
    echo '<td><textarea id="contact_page_description" name="contact_page_description" rows="3" class="large-text">' . esc_textarea($page_description) . '</textarea></td></tr>';
    
    echo '</table>';
}

// Contact company info callback
function contact_company_info_callback($post) {
    wp_nonce_field('contact_company_info_nonce', 'contact_company_info_nonce_field');
    
    $company_name = get_post_meta($post->ID, 'contact_company_name', true);
    $company_registry_code = get_post_meta($post->ID, 'contact_company_registry_code', true);
    $company_economic_reg = get_post_meta($post->ID, 'contact_company_economic_reg', true);
    $company_vat_reg = get_post_meta($post->ID, 'contact_company_vat_reg', true);
    $company_email = get_post_meta($post->ID, 'contact_company_email', true);
    $company_address = get_post_meta($post->ID, 'contact_company_address', true);
    
    // Use defaults if empty
    if (empty($company_name)) {
        $company_name = 'Avora Capital OÜ';
    }
    if (empty($company_registry_code)) {
        $company_registry_code = '16741810';
    }
    if (empty($company_economic_reg)) {
        $company_economic_reg = 'EEH013730';
    }
    if (empty($company_vat_reg)) {
        $company_vat_reg = 'EE102691281';
    }
    if (empty($company_email)) {
        $company_email = 'info@avora.ee';
    }
    if (empty($company_address)) {
        $company_address = "Tartu mnt 84a,\nKesklinna linnaosa, Tallinn\nHarju maakond, 10112";
    }
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="contact_company_name">Ettevõtte nimi</label></th>';
    echo '<td><input type="text" id="contact_company_name" name="contact_company_name" value="' . esc_attr($company_name) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_company_registry_code">Registrikood</label></th>';
    echo '<td><input type="text" id="contact_company_registry_code" name="contact_company_registry_code" value="' . esc_attr($company_registry_code) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_company_economic_reg">Majandustegevuse reg</label></th>';
    echo '<td><input type="text" id="contact_company_economic_reg" name="contact_company_economic_reg" value="' . esc_attr($company_economic_reg) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_company_vat_reg">KMKR</label></th>';
    echo '<td><input type="text" id="contact_company_vat_reg" name="contact_company_vat_reg" value="' . esc_attr($company_vat_reg) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_company_email">Email</label></th>';
    echo '<td><input type="email" id="contact_company_email" name="contact_company_email" value="' . esc_attr($company_email) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_company_address">Aadress</label></th>';
    echo '<td><textarea id="contact_company_address" name="contact_company_address" rows="4" class="large-text">' . esc_textarea($company_address) . '</textarea></td></tr>';
    
    echo '</table>';
}

// Contact form settings callback
function contact_form_settings_callback($post) {
    wp_nonce_field('contact_form_settings_nonce', 'contact_form_settings_nonce_field');
    
    $form_title = get_post_meta($post->ID, 'contact_form_title', true);
    $form_email = get_post_meta($post->ID, 'contact_form_email', true);
    $form_success_message = get_post_meta($post->ID, 'contact_form_success_message', true);
    $form_error_message = get_post_meta($post->ID, 'contact_form_error_message', true);
    
    // Use defaults if empty
    if (empty($form_title)) {
        $form_title = 'Saada sõnum';
    }
    if (empty($form_email)) {
        $form_email = 'info@avora.ee';
    }
    if (empty($form_success_message)) {
        $form_success_message = 'Täname! Teie sõnum on edukalt saadetud. Võtame teiega peagi ühendust.';
    }
    if (empty($form_error_message)) {
        $form_error_message = 'Vabandust, sõnumi saatmisel tekkis viga. Palun proovige uuesti või võtke meiega otse ühendust.';
    }
    
    echo '<table class="form-table">';
    echo '<tr><th scope="row"><label for="contact_form_title">Vormi pealkiri</label></th>';
    echo '<td><input type="text" id="contact_form_title" name="contact_form_title" value="' . esc_attr($form_title) . '" class="regular-text" /></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_form_email">Vastuvõtja email</label></th>';
    echo '<td><input type="email" id="contact_form_email" name="contact_form_email" value="' . esc_attr($form_email) . '" class="regular-text" />';
    echo '<p class="description">Email aadress, kuhu kontaktvormi sõnumid saadetakse.</p></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_form_success_message">Edukas saatmine sõnum</label></th>';
    echo '<td><textarea id="contact_form_success_message" name="contact_form_success_message" rows="2" class="large-text">' . esc_textarea($form_success_message) . '</textarea></td></tr>';
    
    echo '<tr><th scope="row"><label for="contact_form_error_message">Vea sõnum</label></th>';
    echo '<td><textarea id="contact_form_error_message" name="contact_form_error_message" rows="2" class="large-text">' . esc_textarea($form_error_message) . '</textarea></td></tr>';
    
    echo '</table>';
}

// Hero media callback
function project_hero_media_callback($post) {
    wp_nonce_field('project_hero_media_nonce', 'project_hero_media_nonce_field');
    
    $hero_image = get_post_meta($post->ID, 'project_hero_image', true);
    $hero_video = get_post_meta($post->ID, 'project_hero_video', true);
    $hero_media_type = get_post_meta($post->ID, 'project_hero_media_type', true);
    
    // Default to 'featured' if not set
    if (empty($hero_media_type)) {
        $hero_media_type = 'featured';
    }
    
    echo '<table class="form-table">';
    
    // Media type selection
    echo '<tr><th scope="row"><label>Hero meedia tüüp</label></th>';
    echo '<td>';
    echo '<label><input type="radio" name="project_hero_media_type" value="featured" ' . checked($hero_media_type, 'featured', false) . '> Kasuta featured image (vaikimisi)</label><br>';
    echo '<label><input type="radio" name="project_hero_media_type" value="custom_image" ' . checked($hero_media_type, 'custom_image', false) . '> Kohandatud pilt</label><br>';
    echo '<label><input type="radio" name="project_hero_media_type" value="video" ' . checked($hero_media_type, 'video', false) . '> Video</label>';
    echo '</td></tr>';
    
    // Custom image upload
    echo '<tr class="hero-custom-image-row" style="' . ($hero_media_type !== 'custom_image' ? 'display:none;' : '') . '"><th scope="row"><label for="project_hero_image">Hero pilt</label></th>';
    echo '<td>';
    echo '<div class="hero-image-upload">';
    echo '<input type="hidden" id="project_hero_image" name="project_hero_image" value="' . esc_attr($hero_image) . '" />';
    echo '<div class="hero-image-preview">';
    if (!empty($hero_image)) {
        echo '<img src="' . esc_url($hero_image) . '" alt="Hero pilt" style="max-width: 300px; height: auto; margin-bottom: 10px; display: block;" />';
    }
    echo '</div>';
    echo '<button type="button" class="button hero-image-upload-btn">Vali hero pilt</button> ';
    echo '<button type="button" class="button hero-image-remove-btn" style="' . (empty($hero_image) ? 'display:none;' : '') . '">Eemalda pilt</button>';
    echo '<p class="description">Vali kohandatud hero pilt. See asendab featured image projekti detailide lehel.</p>';
    echo '</div>';
    echo '</td></tr>';
    
    // Video upload
    echo '<tr class="hero-video-row" style="' . ($hero_media_type !== 'video' ? 'display:none;' : '') . '"><th scope="row"><label for="project_hero_video">Hero video</label></th>';
    echo '<td>';
    echo '<div class="hero-video-upload">';
    echo '<input type="hidden" id="project_hero_video" name="project_hero_video" value="' . esc_attr($hero_video) . '" />';
    echo '<div class="hero-video-preview">';
    if (!empty($hero_video)) {
        echo '<video controls style="max-width: 300px; height: auto; margin-bottom: 10px; display: block;">';
        echo '<source src="' . esc_url($hero_video) . '">';
        echo 'Your browser does not support the video tag.';
        echo '</video>';
    }
    echo '</div>';
    echo '<button type="button" class="button hero-video-upload-btn">Vali hero video</button> ';
    echo '<button type="button" class="button hero-video-remove-btn" style="' . (empty($hero_video) ? 'display:none;' : '') . '">Eemalda video</button>';
    echo '<p class="description">Vali hero video. Video kuvatakse automaatselt mängides hero sektsioonis.</p>';
    echo '</div>';
    echo '</td></tr>';
    
    echo '</table>';
}

// Project content blocks callback (reuses About Us content blocks logic)
function project_content_blocks_callback($post) {
    wp_nonce_field('project_content_blocks_nonce', 'project_content_blocks_nonce_field');
    
    $content_blocks = get_post_meta($post->ID, 'project_content_blocks', true);
    $content_blocks = $content_blocks ? json_decode($content_blocks, true) : [];
    
    echo '<div class="project-content-blocks-manager">';
    echo '<div class="blocks-actions">';
    echo '<button type="button" class="button add-content-block">Lisa uus sisuplokk</button>';
    echo '<p class="description">Lisa lisasisu plokke koos piltidega. Saad valida, millisel küljel pilt asub. Pildid kuvatakse ümmargustena.</p>';
    echo '</div>';
    
    echo '<div class="content-blocks-container" id="content-blocks-container">';
    
    if (!empty($content_blocks)) {
        foreach ($content_blocks as $index => $block) {
            echo_project_content_block_html($index, $block);
        }
    }
    
    echo '</div>';
    
    echo '<input type="hidden" id="project_content_blocks_data" name="project_content_blocks_data" value="' . esc_attr(json_encode($content_blocks, JSON_UNESCAPED_UNICODE)) . '" />';
    echo '</div>';
    
    // Add template for new blocks
    echo '<script type="text/html" id="project-content-block-template">';
    echo_project_content_block_html('{{INDEX}}', [
        'title' => '',
        'content' => '',
        'image' => '',
        'image_position' => 'left',
        'block_type' => 'regular'
    ]);
    echo '</script>';
}

// Helper function to generate project content block HTML (similar to about us)
function echo_project_content_block_html($index, $block) {
    $title = isset($block['title']) ? $block['title'] : '';
    $content = isset($block['content']) ? $block['content'] : '';
    $image = isset($block['image']) ? $block['image'] : '';
    $image_position = isset($block['image_position']) ? $block['image_position'] : 'left';
    $block_type = isset($block['block_type']) ? $block['block_type'] : 'regular';
    
    echo '<div class="content-block" data-index="' . esc_attr($index) . '">';
    echo '<div class="content-block-header">';
    echo '<h4>Sisuplokk ' . (is_numeric($index) ? ($index + 1) : '{{INDEX_DISPLAY}}') . '</h4>';
    echo '<button type="button" class="button-link remove-content-block" title="Eemalda plokk">&times;</button>';
    echo '</div>';
    
    echo '<table class="form-table">';
    
    // Title
    echo '<tr><th scope="row"><label>Pealkiri</label></th>';
    echo '<td><input type="text" class="block-title regular-text" value="' . esc_attr($title) . '" placeholder="Sisesta ploki pealkiri" /></td></tr>';
    
    // Block type
    echo '<tr><th scope="row"><label>Ploki tüüp</label></th>';
    echo '<td>';
    echo '<label><input type="radio" name="block_type_' . esc_attr($index) . '" class="block-type" value="regular" ' . checked($block_type, 'regular', false) . '> Tavaline (koos pildiga)</label><br>';
    echo '<label><input type="radio" name="block_type_' . esc_attr($index) . '" class="block-type" value="fullwidth" ' . checked($block_type, 'fullwidth', false) . '> Täislaiuses (ilma pildita)</label>';
    echo '</td></tr>';
    
    // Image
    echo '<tr><th scope="row"><label>Pilt</label></th>';
    echo '<td>';
    echo '<div class="block-image-upload">';
    echo '<input type="hidden" class="block-image" value="' . esc_attr($image) . '" />';
    echo '<div class="image-preview">';
    if (!empty($image)) {
        echo '<img src="' . esc_url($image) . '" alt="Ploki pilt" style="max-width: 200px; height: auto; margin-bottom: 10px; display: block;" />';
    }
    echo '</div>';
    echo '<button type="button" class="button block-image-upload-btn">Vali pilt</button> ';
    echo '<button type="button" class="button block-image-remove-btn" style="' . (empty($image) ? 'display:none;' : '') . '">Eemalda pilt</button>';
    echo '</div>';
    echo '</td></tr>';
    
    // Image position
    echo '<tr><th scope="row"><label>Pildi asukoht</label></th>';
    echo '<td>';
    echo '<label><input type="radio" name="block_image_position_' . esc_attr($index) . '" class="block-image-position" value="left" ' . checked($image_position, 'left', false) . '> Vasakul</label><br>';
    echo '<label><input type="radio" name="block_image_position_' . esc_attr($index) . '" class="block-image-position" value="right" ' . checked($image_position, 'right', false) . '> Paremal</label>';
    echo '</td></tr>';
    
    // Content
    echo '<tr><th scope="row"><label>Sisu</label></th>';
    echo '<td>';
    
    // Use wp_editor for real blocks, textarea for template
    if (is_numeric($index)) {
        // Real block - use wp_editor
        $editor_id = 'project_block_content_' . $index;
        wp_editor($content, $editor_id, [
            'textarea_name' => 'project_block_content_' . $index,
            'textarea_rows' => 8,
            'media_buttons' => true,
            'teeny' => false,
            'wpautop' => true,
            'editor_class' => 'block-content-editor',
            'tinymce' => [
                'height' => 250,
                'menubar' => false,
                'plugins' => 'lists,link,image,paste,code',
                'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist,link,unlink,removeformat',
                'toolbar2' => 'alignleft,aligncenter,alignright,undo,redo,code'
            ],
            'quicktags' => [
                'buttons' => 'strong,em,link,ul,ol,li,code'
            ]
        ]);
    } else {
        // Template - use textarea that will be replaced by TinyMCE later
        echo '<textarea class="block-content large-text" rows="6" placeholder="Sisesta ploki sisu...">' . esc_textarea($content) . '</textarea>';
    }
    
    echo '<p class="description">Sisesta ploki sisu. Pilt kuvatakse ümmargusena nagu Meist lehel.</p>';
    echo '</td></tr>';
    
    echo '</table>';
    echo '</div>';
}

// Gallery management callback
function project_gallery_callback($post) {
    wp_nonce_field('project_gallery_nonce', 'project_gallery_nonce_field');
    
    $gallery_images = get_post_meta($post->ID, 'project_gallery_images', true);
    $gallery_images = $gallery_images ? explode(',', $gallery_images) : array();
    
    echo '<div class="project-gallery-manager">';
    echo '<div class="gallery-actions">';
    echo '<button type="button" class="button gallery-add-btn">Lisa pildid</button>';
    echo '<p class="description">Lohista pildid ümber, et muuta järjekorda. Kliki "X", et eemaldada.</p>';
    echo '</div>';
    
    echo '<div class="gallery-preview" id="gallery-preview">';
    if (!empty($gallery_images)) {
        foreach ($gallery_images as $image_id) {
            if ($image_id && wp_get_attachment_url($image_id)) {
                echo '<div class="gallery-item" data-id="' . $image_id . '">';
                echo wp_get_attachment_image($image_id, 'thumbnail');
                echo '<button type="button" class="remove-image" title="Eemalda pilt">&times;</button>';
                echo '<div class="image-handle">≡</div>';
                echo '</div>';
            }
        }
    }
    echo '</div>';
    
    echo '<input type="hidden" id="project_gallery_images" name="project_gallery_images" value="' . esc_attr(implode(',', $gallery_images)) . '" />';
    echo '</div>';
}

// Save custom meta fields
add_action('save_post', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save project meta fields
    if (get_post_type($post_id) === 'project' && 
        isset($_POST['project_details_nonce_field']) && 
        wp_verify_nonce($_POST['project_details_nonce_field'], 'project_details_nonce')) {
        
                 $fields = ['project_status', 'project_location', 'project_year', 'project_type', 'project_units', 'project_area', 'project_logo', 'project_link', 'project_hero_media_type', 'project_hero_image', 'project_hero_video'];
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if ($field === 'project_link' || $field === 'project_hero_image' || $field === 'project_hero_video') {
                    // Use esc_url_raw for URL fields
                    update_post_meta($post_id, $field, esc_url_raw($_POST[$field]));
                } else {
                    update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                }
            }
        }
        
        // Save gallery images
        if (isset($_POST['project_gallery_images'])) {
            $gallery_images = sanitize_text_field($_POST['project_gallery_images']);
            update_post_meta($post_id, 'project_gallery_images', $gallery_images);
        }
    }
    
    // Save project hero media fields
    if (get_post_type($post_id) === 'project' && 
        isset($_POST['project_hero_media_nonce_field']) && 
        wp_verify_nonce($_POST['project_hero_media_nonce_field'], 'project_hero_media_nonce')) {
        
        $hero_fields = ['project_hero_media_type', 'project_hero_image', 'project_hero_video'];
        
        foreach ($hero_fields as $field) {
            if (isset($_POST[$field])) {
                if ($field === 'project_hero_image' || $field === 'project_hero_video') {
                    update_post_meta($post_id, $field, esc_url_raw($_POST[$field]));
                } else {
                    update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                }
            }
        }
    }
    
    // Save project content blocks
    if (get_post_type($post_id) === 'project' && 
        isset($_POST['project_content_blocks_nonce_field']) && 
        wp_verify_nonce($_POST['project_content_blocks_nonce_field'], 'project_content_blocks_nonce')) {
        
        // Try to get data from JSON first (for JavaScript-managed blocks)
        $blocks_data = [];
        if (isset($_POST['project_content_blocks_data']) && !empty($_POST['project_content_blocks_data'])) {
            $decoded_blocks = json_decode(stripslashes($_POST['project_content_blocks_data']), true);
            if (is_array($decoded_blocks)) {
                $blocks_data = $decoded_blocks;
            }
        }
        
        // Also check for individual wp_editor fields (for existing blocks)
        $index = 0;
        while (isset($_POST['project_block_content_' . $index])) {
            // If we don't have this block in JSON data, try to reconstruct it
            if (!isset($blocks_data[$index])) {
                $blocks_data[$index] = [];
            }
            
            // Update content from wp_editor field
            $blocks_data[$index]['content'] = wp_kses_post($_POST['project_block_content_' . $index]);
            
            $index++;
        }
        
        if (!empty($blocks_data)) {
            // Sanitize each block
            $sanitized_blocks = [];
            foreach ($blocks_data as $block) {
                $content = $block['content'] ?? '';
                // Clean unwanted characters from content
                $content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $content);
                $content = preg_replace('/\s+/', ' ', $content);
                $content = trim($content);
                
                $sanitized_blocks[] = [
                    'title' => sanitize_text_field($block['title'] ?? ''),
                    'content' => wp_kses_post($content),
                    'image' => esc_url_raw($block['image'] ?? ''),
                    'image_position' => in_array($block['image_position'] ?? 'left', ['left', 'right']) ? $block['image_position'] : 'left',
                    'block_type' => in_array($block['block_type'] ?? 'regular', ['regular', 'fullwidth']) ? $block['block_type'] : 'regular'
                ];
            }
            update_post_meta($post_id, 'project_content_blocks', json_encode($sanitized_blocks, JSON_UNESCAPED_UNICODE));
        } else {
            update_post_meta($post_id, 'project_content_blocks', '');
        }
    }
    
    // Save About Us page meta fields
    if (get_post_type($post_id) === 'page') {
        $post = get_post($post_id);
        
        // Save header fields
        if (isset($_POST['about_page_header_nonce_field']) && 
            wp_verify_nonce($_POST['about_page_header_nonce_field'], 'about_page_header_nonce') &&
            (get_page_template_slug($post->ID) === 'page-meist.php' || $post->post_name === 'ettevottest')) {
            
            if (isset($_POST['about_page_title'])) {
                update_post_meta($post_id, 'about_page_title', sanitize_text_field($_POST['about_page_title']));
            }
            if (isset($_POST['about_page_description'])) {
                $description = $_POST['about_page_description'];
                // Clean unwanted characters before saving
                $description = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $description);
                $description = preg_replace('/\s+/', ' ', $description);
                $description = trim($description);
                update_post_meta($post_id, 'about_page_description', wp_kses_post($description));
            }
        }
        
        // Save About Us values fields
        if (isset($_POST['about_page_values_nonce_field']) && 
            wp_verify_nonce($_POST['about_page_values_nonce_field'], 'about_page_values_nonce') &&
            (get_page_template_slug($post->ID) === 'page-meist.php' || $post->post_name === 'ettevottest')) {
            
            if (isset($_POST['about_values_title'])) {
                update_post_meta($post_id, 'about_values_title', sanitize_text_field($_POST['about_values_title']));
            }
            if (isset($_POST['about_values_image'])) {
                update_post_meta($post_id, 'about_values_image', sanitize_text_field($_POST['about_values_image']));
            }
            if (isset($_POST['about_values_content'])) {
                // Use wp_kses_post to allow safe HTML content from the editor
                update_post_meta($post_id, 'about_values_content', wp_kses_post($_POST['about_values_content']));
            }
        }
        
        // Save About Us content blocks
        if (isset($_POST['about_content_blocks_nonce_field']) && 
            wp_verify_nonce($_POST['about_content_blocks_nonce_field'], 'about_content_blocks_nonce') &&
            (get_page_template_slug($post->ID) === 'page-meist.php' || $post->post_name === 'ettevottest')) {
            
            // Try to get data from JSON first (for JavaScript-managed blocks)
            $blocks_data = [];
            if (isset($_POST['about_content_blocks_data']) && !empty($_POST['about_content_blocks_data'])) {
                $decoded_blocks = json_decode(stripslashes($_POST['about_content_blocks_data']), true);
                if (is_array($decoded_blocks)) {
                    $blocks_data = $decoded_blocks;
                }
            }
            
            // Also check for individual wp_editor fields (for existing blocks)
            $index = 0;
            while (isset($_POST['block_content_' . $index])) {
                // If we don't have this block in JSON data, try to reconstruct it
                if (!isset($blocks_data[$index])) {
                    $blocks_data[$index] = [];
                }
                
                // Update content from wp_editor field
                $blocks_data[$index]['content'] = wp_kses_post($_POST['block_content_' . $index]);
                
                $index++;
            }
            
            if (!empty($blocks_data)) {
                                    // Sanitize each block
                    $sanitized_blocks = [];
                    foreach ($blocks_data as $block) {
                        $content = $block['content'] ?? '';
                        // Clean unwanted characters from content
                        $content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $content);
                        $content = preg_replace('/\s+/', ' ', $content);
                        $content = trim($content);
                        
                        $sanitized_blocks[] = [
                            'title' => sanitize_text_field($block['title'] ?? ''),
                            'content' => wp_kses_post($content),
                            'image' => esc_url_raw($block['image'] ?? ''),
                            'image_position' => in_array($block['image_position'] ?? 'left', ['left', 'right']) ? $block['image_position'] : 'left',
                            'block_type' => in_array($block['block_type'] ?? 'regular', ['regular', 'fullwidth']) ? $block['block_type'] : 'regular'
                        ];
                    }
                update_post_meta($post_id, 'about_content_blocks', json_encode($sanitized_blocks, JSON_UNESCAPED_UNICODE));
            } else {
                update_post_meta($post_id, 'about_content_blocks', '');
            }
        }
        
        // Save Contact page header fields
        if (isset($_POST['contact_page_header_nonce_field']) && 
            wp_verify_nonce($_POST['contact_page_header_nonce_field'], 'contact_page_header_nonce') &&
            $post->post_name === 'kontakt') {
            
            if (isset($_POST['contact_page_title'])) {
                update_post_meta($post_id, 'contact_page_title', sanitize_text_field($_POST['contact_page_title']));
            }
            if (isset($_POST['contact_page_description'])) {
                update_post_meta($post_id, 'contact_page_description', sanitize_textarea_field($_POST['contact_page_description']));
            }
        }
        
        // Save Contact company info fields
        if (isset($_POST['contact_company_info_nonce_field']) && 
            wp_verify_nonce($_POST['contact_company_info_nonce_field'], 'contact_company_info_nonce') &&
            $post->post_name === 'kontakt') {
            
            $company_fields = [
                'contact_company_name', 'contact_company_registry_code', 
                'contact_company_economic_reg', 'contact_company_vat_reg'
            ];
            
            foreach ($company_fields as $field) {
                if (isset($_POST[$field])) {
                    update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
                }
            }
            
            // Save company email separately with email validation
            if (isset($_POST['contact_company_email'])) {
                update_post_meta($post_id, 'contact_company_email', sanitize_email($_POST['contact_company_email']));
            }
            
            if (isset($_POST['contact_company_address'])) {
                update_post_meta($post_id, 'contact_company_address', sanitize_textarea_field($_POST['contact_company_address']));
            }
        }
        
        // Save Contact form settings fields
        if (isset($_POST['contact_form_settings_nonce_field']) && 
            wp_verify_nonce($_POST['contact_form_settings_nonce_field'], 'contact_form_settings_nonce') &&
            $post->post_name === 'kontakt') {
            
            if (isset($_POST['contact_form_title'])) {
                update_post_meta($post_id, 'contact_form_title', sanitize_text_field($_POST['contact_form_title']));
            }
            if (isset($_POST['contact_form_email'])) {
                update_post_meta($post_id, 'contact_form_email', sanitize_email($_POST['contact_form_email']));
            }
            if (isset($_POST['contact_form_success_message'])) {
                update_post_meta($post_id, 'contact_form_success_message', sanitize_textarea_field($_POST['contact_form_success_message']));
            }
            if (isset($_POST['contact_form_error_message'])) {
                update_post_meta($post_id, 'contact_form_error_message', sanitize_textarea_field($_POST['contact_form_error_message']));
            }
        }
    }
});

// Helper functions for custom fields (fallback for ACF functions)
if (!function_exists('get_field')) {
    function get_field($field_name, $post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        return get_post_meta($post_id, $field_name, true);
    }
}

if (!function_exists('update_field')) {
    function update_field($field_name, $value, $post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        return update_post_meta($post_id, $field_name, $value);
    }
}

// Auto-create projects and pages on theme activation
add_action('after_switch_theme', 'avora_create_projects');
add_action('init', 'avora_create_projects'); // Also run on init for existing installations

// Create About Us and Contact pages if they don't exist
add_action('after_switch_theme', 'avora_create_about_page');
add_action('init', 'avora_create_about_page');
add_action('after_switch_theme', 'avora_create_contact_page');
add_action('init', 'avora_create_contact_page');

function avora_create_projects() {
    // Create Manni project
    avora_create_manni_project();
    
    // Create Seaside project
    avora_create_seaside_project();
    
    // Create Urban Loft project
    avora_create_urban_loft_project();
    
    // Create Forest Retreat project
    avora_create_forest_retreat_project();
}

function avora_create_manni_project() {
    // Only run once
    if (get_option('avora_manni_project_created')) {
        return;
    }
    
    // Check if project already exists
    $existing = get_posts([
        'post_type' => 'project',
        'name' => 'manni-villa-kompleks',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_manni_project_created', true);
        return;
    }
    
    // Create the project
    $project_data = [
        'post_title' => 'Manni Villa Kompleks',
        'post_name' => 'manni-villa-kompleks',
        'post_content' => 'Eksklusiivne villa kompleks Harjumaal, mis ühendab kaasaegse arhitektuuri ja looduslähedase elukeskkonna. Kompleks koosneb kuuest unikaalsest villast, mis on projekteeritud maksimaalset privaatsust ja mugavust silmas pidades.

Iga villa on ehitatud kvaliteetsetest materjalidest, kasutades uusimaid ehitustehnoloogiaid ja energiatõhusaid lahendusi. Villad on varustatud kaasaegsete kommunikatsioonidega ja pakuvad elanikele kõiki mugavusi.

Kompleksi ümbritseb roheline park koos jalutusradadega. Igal villal on oma aiamaa, kaetud terrassid ja privaatne parkimisala. Siseviimistlus on teostatud kõrgeimate kvaliteedistandardite kohaselt.

Villad on ideaalsed peredele, kes hindavad kvaliteeti, privaatsust ja looduslähedust. Kompleks asub vaid 25 minuti kaugusel Tallinna keskusest, pakkudes samas täielikku rahu ja vaikust.',
        'post_excerpt' => 'Eksklusiivne kuue villa kompleks Harjumaal. Kaasaegne arhitektuur, kvaliteetsed materjalid ja looduslähedane elukeskkond.',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1
    ];
    
    $project_id = wp_insert_post($project_data);
    
    if (is_wp_error($project_id)) {
        return;
    }
    
    // Add meta fields
    update_post_meta($project_id, 'project_status', 'Valmis');
    update_post_meta($project_id, 'project_location', 'Harjumaa');
    update_post_meta($project_id, 'project_year', '2023');
    update_post_meta($project_id, 'project_type', 'Eramajad');
    update_post_meta($project_id, 'project_units', '6 villat');
    update_post_meta($project_id, 'project_area', '2,500 m²');
    
    // Upload Manni images
    avora_upload_project_images($project_id, ['2 (2).jpg', '3 (2).jpg', '40.jpg', '5 (1).jpg', '6 (2).jpg', '7 (1).jpg'], 'Manni Villa');
    
    // Mark as created
    update_option('avora_manni_project_created', true);
}

function avora_create_seaside_project() {
    // Only run once
    if (get_option('avora_seaside_project_created')) {
        return;
    }
    
    // Check if project already exists
    $existing = get_posts([
        'post_type' => 'project',
        'name' => 'seaside-residence',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_seaside_project_created', true);
        return;
    }
    
    // Create the project
    $project_data = [
        'post_title' => 'Seaside Residence',
        'post_name' => 'seaside-residence',
        'post_content' => 'Kaasaegne korterelamu kompleks mere ääres, mis pakub elanikele suurepäraseid vaadeteid ja luksuslikku elukeskkonda. Hoone arhitektuur ühendab endas modernset disaini ja funktsionaalsust.

Igal korteril on oma rõdu või terrass, kust avaneb vaade merele või linna panoraamile. Hoones on kaasaegne ventilatsiooni- ja küttesüsteem, mis tagab optimaalse mikroklima aastaringselt.

Kompleks asub vaid mõne sammukese kaugusel merest ja pakkub elanikele täielikku privaatsust ning rahu. Hoone ümbritseb hoolega planeeritud haljasala, mis loob rahulikku atmosfääri.

Kõik korterid on varustatud kvaliteetsete materjalide ja seadmetega. Hoones on ka ühisruumid, sealhulgas fitness-keskus ja saunakompleks.',
        'post_excerpt' => 'Kaasaegne korterelamu mere ääres. Luksuslikud korterid suurepäraste vaadetega ja tänapäevaste mugavustega.',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1
    ];
    
    $project_id = wp_insert_post($project_data);
    
    if (is_wp_error($project_id)) {
        return;
    }
    
    // Add meta fields
    update_post_meta($project_id, 'project_status', 'Ehituses');
    update_post_meta($project_id, 'project_location', 'Tallinn, Pirita');
    update_post_meta($project_id, 'project_year', '2024');
    update_post_meta($project_id, 'project_type', 'Korterimaja');
    update_post_meta($project_id, 'project_units', '24 korterit');
    update_post_meta($project_id, 'project_area', '3,200 m²');
    
    // Upload Seaside images
    avora_upload_project_images($project_id, ['DSC09488.jpg', 'DSC09694.jpg', 'DSC09704.jpg', 'DSC09737.jpg', 'DSC09779.jpg', 'DSC09784.jpg', 'DSC09787.jpg', 'DSC09790.jpg', 'DSC09795.jpg', 'DSC09811.jpg'], 'Seaside Residence');
    
    // Mark as created
    update_option('avora_seaside_project_created', true);
}

function avora_create_urban_loft_project() {
    // Only run once
    if (get_option('avora_urban_loft_project_created')) {
        return;
    }
    
    // Check if project already exists
    $existing = get_posts([
        'post_type' => 'project',
        'name' => 'urban-loft-tallinn',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_urban_loft_project_created', true);
        return;
    }
    
    // Create the project
    $project_data = [
        'post_title' => 'Urban Loft Tallinn',
        'post_name' => 'urban-loft-tallinn',
        'post_content' => 'Innovatiivne loft-stiilis eluhoone Tallinna südames, mis ühendab industriaalse disaini kaasaegsete mugavustega. Hoone on rekonstrueeritud endisest tehasehoones, säilitades selle autentse charmi ja lisades tänapäevaseid elemente.

Iga loft on unikaalne avatud planeeringuga ruum, kus kõrged laed ja suured aknad loovad avarad ja valgusrikkad eluruumid. Säilinud on algsed tellistseinad ja metallikonstruktsioonid, mis annavad ruumidele erilise iseloomu.

Hoones on modernne infrastruktuur, sealhulgas lift, turvasüsteem ja kiire internetiühendus. Loftide asukoht linna keskuses võimaldab mugavat juurdepääsu kõigile teenustele ja kultuuriasutustele.

Ideaalne valik noortele professionaalidele ja kunstiinimestele, kes hindavad eripärast arhitektuuri ja urbaanse elukeskkonna eeliseid.',
        'post_excerpt' => 'Unikaalsed loft-korterid rekonstrueeritud tehasehoones Tallinna kesklinnas. Industriaalne disain kohtub kaasaegsete mugavustega.',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1
    ];
    
    $project_id = wp_insert_post($project_data);
    
    if (is_wp_error($project_id)) {
        return;
    }
    
    // Add meta fields
    update_post_meta($project_id, 'project_status', 'Planeerimisel');
    update_post_meta($project_id, 'project_location', 'Tallinn, Kesklinn');
    update_post_meta($project_id, 'project_year', '2025');
    update_post_meta($project_id, 'project_type', 'Loft-korterid');
    update_post_meta($project_id, 'project_units', '18 lofti');
    update_post_meta($project_id, 'project_area', '2,800 m²');
    
    // Upload Urban Loft images
    avora_upload_project_images($project_id, [
        '240420_Reigo-Kiili_Erlend_Štaub_25.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_28.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_30.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_31.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_32.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_33.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_35.jpg',
        '240420_Reigo-Kiili_Erlend_Štaub_37.jpg',
        '240612_Reigo_Kiili_Erlend_Štaub_33.jpg',
        '240612_Reigo_Kiili_Erlend_Štaub_34.jpg',
        '240612_Reigo_Kiili_Erlend_Štaub_38.jpg',
        '240612_Reigo_Kiili_Erlend_Štaub_43.jpg'
    ], 'Urban Loft Tallinn');
    
    // Mark as created
    update_option('avora_urban_loft_project_created', true);
}

function avora_create_forest_retreat_project() {
    // Only run once
    if (get_option('avora_forest_retreat_project_created')) {
        return;
    }
    
    // Check if project already exists
    $existing = get_posts([
        'post_type' => 'project',
        'name' => 'forest-retreat-resort',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_forest_retreat_project_created', true);
        return;
    }
    
    // Create the project
    $project_data = [
        'post_title' => 'Forest Retreat Resort',
        'post_name' => 'forest-retreat-resort',
        'post_content' => 'Eksklusiivne spa- ja puhkekeskus Eesti looduskauni metsa südames, mis pakub täielikku rahu ja ühendust loodusega. Resort koosneb luksuslikest puhkemajakestest ja keskushoonetest, mis on ehitatud keskkonnasõbralikke materjale kasutades.

Iga puhkemajake on unikaalselt disainitud, pakkudes panoraamvaadet ümbritsevale metsale. Hooned on projekteeritud minimaalselt mõjutama looduskeskkonda, kasutades geotermaalset kütet ja päikeseenergia lahendusi.

Resordis on täisteenindusega spa-keskus, restoran kohaliku köögiga, konverentsisaalid ja mitmesugused tegevused nagu matkaraja, veesõidukite rent ja loodusgiidiga ekskursioonid.

Ideaalne sihtkoht äriürituste, pulmade või lihtsalt kvaliteetse puhkuse veetmiseks keset Eesti kauneid metsi. Resort pakub kõrgetasemelist teenindust ja privaatsust.',
        'post_excerpt' => 'Luksuslik spa- ja puhkekeskus Eesti metsade südames. Keskkonnasõbralik arhitektuur ja täisteenindusega resort.',
        'post_status' => 'publish',
        'post_type' => 'project',
        'post_author' => 1
    ];
    
    $project_id = wp_insert_post($project_data);
    
    if (is_wp_error($project_id)) {
        return;
    }
    
    // Add meta fields
    update_post_meta($project_id, 'project_status', 'Müügis');
    update_post_meta($project_id, 'project_location', 'Harjumaa, Kõrvemaa');
    update_post_meta($project_id, 'project_year', '2024');
    update_post_meta($project_id, 'project_type', 'Puhkekeskus');
    update_post_meta($project_id, 'project_units', '12 maja + keskus');
    update_post_meta($project_id, 'project_area', '15,000 m²');
    
    // Upload Forest Retreat images
    avora_upload_project_images($project_id, [
        'NZ6_6802-Edit.jpg',
        'NZ6_6833-Edit.jpg',
        'NZ6_6846-Edit.jpg',
        'NZ6_6865_ENF.jpg',
        'NZ6_6868_ENF.jpg',
        'NZ6_6904-Edit.jpg',
        'NZ6_6913_ENF.jpg',
        'NZ6_6919_ENF.jpg',
        'NZ6_6921_ENF.jpg',
        'NZ6_6932_ENF.jpg',
        'NZ6_6936_ENF.jpg',
        'NZ6_6941_ENF.jpg',
        'NZ6_6946_ENF.jpg',
        'NZ6_6948_ENF.jpg',
        'NZ6_6950_ENF.jpg',
        'NZ6_6953_ENF.jpg',
        'NZ6_6954_ENF.jpg',
        'NZ6_6955_ENF.jpg',
        'NZ6_6956_ENF.jpg',
        'NZ6_6957_ENF.jpg'
    ], 'Forest Retreat Resort');
    
    // Mark as created
    update_option('avora_forest_retreat_project_created', true);
}

function avora_upload_project_images($project_id, $image_files, $project_name) {
    $images_dir = get_template_directory() . '/images/projects';
    if (!is_dir($images_dir)) {
        return;
    }
    
    $thumbnail_set = false;
    
    foreach ($image_files as $filename) {
        $image_path = $images_dir . '/' . $filename;
        if (!file_exists($image_path)) {
            continue;
        }
        
        $upload_file = wp_upload_bits($filename, null, file_get_contents($image_path));
        
        if (!$upload_file['error']) {
            $wp_filetype = wp_check_filetype($filename, null);
            $attachment = [
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => $project_name . ' - ' . pathinfo($filename, PATHINFO_FILENAME),
                'post_content' => '',
                'post_status' => 'inherit'
            ];
            
            $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $project_id);
            
            if ($attachment_id) {
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
                wp_update_attachment_metadata($attachment_id, $attachment_data);
                
                // Set first image as featured image
                if (!$thumbnail_set) {
                    set_post_thumbnail($project_id, $attachment_id);
                    $thumbnail_set = true;
                }
            }
        }
    }
    
    // Flush rewrite rules to make sure the custom post type URLs work
    flush_rewrite_rules();
}

// Create About Us page function
function avora_create_about_page() {
    // Only run once
    if (get_option('avora_about_page_created')) {
        return;
    }
    
    // Check if About Us page already exists
    $existing = get_posts([
        'post_type' => 'page',
        'name' => 'meist',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_about_page_created', true);
        return;
    }
    
    // Create the About Us page
    $page_data = [
        'post_title' => 'Meist',
        'post_name' => 'meist',
        'post_content' => 'Lisasisu saate lisada siia WordPressi redaktoris. Ülalolev päis ja väärtuste sektsioon on hallatav läbi kohandatud väljade.',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_author' => 1
    ];
    
    $page_id = wp_insert_post($page_data);
    
    if (!is_wp_error($page_id)) {
        // Mark as created
        update_option('avora_about_page_created', true);
    }
}

// Create Contact page function
function avora_create_contact_page() {
    // Only run once
    if (get_option('avora_contact_page_created')) {
        return;
    }
    
    // Check if Contact page already exists
    $existing = get_posts([
        'post_type' => 'page',
        'name' => 'kontakt',
        'posts_per_page' => 1,
        'post_status' => 'any'
    ]);
    
    if ($existing) {
        update_option('avora_contact_page_created', true);
        return;
    }
    
    // Create the Contact page
    $page_data = [
        'post_title' => 'Kontakt',
        'post_name' => 'kontakt',
        'post_content' => 'Lisasisu saate lisada siia WordPressi redaktoris. Ülalolev päis, ettevõtte informatsioon ja kontaktvorm on hallatav läbi kohandatud väljade.',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_author' => 1
    ];
    
    $page_id = wp_insert_post($page_data);
    
    if (!is_wp_error($page_id)) {
        // Mark as created
        update_option('avora_contact_page_created', true);
    }
}

// Custom body classes for better styling
add_filter('body_class', function($classes) {
    $classes[] = 'font-brand';
    $classes[] = 'avora-theme';
    
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    
    return $classes;
});

// Optimize WordPress for performance (matching static site speed)
add_action('init', function() {
    // Remove unnecessary WordPress features for this static-like site
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    
    // Remove WordPress version for security
    remove_action('wp_head', 'wp_generator');
});

// Remove WordPress default block styles that conflict with theme
add_action('wp_enqueue_scripts', function() {
    // Only remove conflicting styles in production, be gentler in development
    if (wp_get_environment_type() === 'production') {
        // Remove WordPress default styles that can conflict with theme
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
        
        // Also deregister to prevent them from loading
        wp_deregister_style('wp-block-library');
        wp_deregister_style('wp-block-library-theme');
        wp_deregister_style('classic-theme-styles');
        wp_deregister_style('global-styles');
    } else {
        // In development, just dequeue but don't deregister
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('global-styles');
    }
}, 100);

// Remove global styles completely (only in production)
if (wp_get_environment_type() === 'production') {
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
}

// Disable core block patterns
add_action('after_setup_theme', function() {
    remove_theme_support('core-block-patterns');
});

// Save drag-and-drop ordering (menu_order) for Projects
add_action('wp_ajax_avora_update_project_order', function() {
    check_ajax_referer('avora_update_project_order', 'nonce');
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Insufficient permissions');
    }

    $order = isset($_POST['order']) && is_array($_POST['order']) ? array_map('intval', $_POST['order']) : array();
    if (empty($order)) {
        wp_send_json_error('No order received');
    }

    // Set incremental menu_order starting from 0
    $position = 0;
    foreach ($order as $post_id) {
        wp_update_post(array(
            'ID' => $post_id,
            'menu_order' => $position
        ));
        $position++;
    }

    wp_send_json_success('Order updated');
});

// Default admin list ordering for Projects by menu_order ASC
add_action('pre_get_posts', function($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    $post_type = $query->get('post_type');
    if ($post_type === 'project' && empty($_GET['orderby'])) {
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
});

// Handle contact form submission
add_action('init', function() {
    if (isset($_POST['avora_contact_form_submit']) && isset($_POST['avora_contact_nonce'])) {
        avora_handle_contact_form();
    }
});

function avora_handle_contact_form() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['avora_contact_nonce'], 'avora_contact_form')) {
        wp_die('Security check failed');
    }
    
    // Sanitize and validate form data
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Nimi on kohustuslik väli.';
    }
    
    if (empty($email) || !is_email($email)) {
        $errors[] = 'Palun sisestage kehtiv email aadress.';
    }
    
    if (empty($message)) {
        $errors[] = 'Sõnum on kohustuslik väli.';
    }
    
    // Check for spam (simple honeypot and time-based protection)
    if (!empty($_POST['website'])) { // Honeypot field
        $errors[] = 'Spam detected.';
    }
    
    if (!empty($errors)) {
        // Store errors in transient to display
        $error_key = 'avora_contact_errors_' . wp_generate_password(12, false);
        set_transient($error_key, $errors, 300);
        wp_redirect($_POST['_wp_http_referer'] . '?contact_msg=' . $error_key . '#contact-form');
        exit;
    }
    
    // Get recipient email from page meta or use default
    $page_id = url_to_postid($_POST['_wp_http_referer']);
    $recipient_email = get_post_meta($page_id, 'contact_form_email', true);
    
    if (empty($recipient_email)) {
        $recipient_email = 'info@avora.ee';
    }
    
    // Prepare email
    $subject = 'Uus kontaktsõnum AVORA veebilehelt';
    $email_message = "Uus kontaktsõnum AVORA veebilehelt:\n\n";
    $email_message .= "Nimi: {$name}\n";
    $email_message .= "Email: {$email}\n";
    
    if (!empty($phone)) {
        $email_message .= "Telefon: {$phone}\n";
    }
    
    $email_message .= "\nSõnum:\n{$message}\n\n";
    $email_message .= "---\n";
    $email_message .= "Sõnum saadeti: " . date('d.m.Y H:i') . "\n";
    $email_message .= "IP aadress: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    ];
    
    // Send email
    $sent = wp_mail($recipient_email, $subject, $email_message, $headers);
    
    if ($sent) {
        // Success - store success message
        $success_message = get_post_meta($page_id, 'contact_form_success_message', true);
        if (empty($success_message)) {
            $success_message = 'Täname! Teie sõnum on edukalt saadetud. Võtame teiega peagi ühendust.';
        }
        $success_key = 'avora_contact_success_' . wp_generate_password(12, false);
        set_transient($success_key, $success_message, 300);
        wp_redirect($_POST['_wp_http_referer'] . '?contact_msg=' . $success_key . '#contact-form');
    } else {
        // Error - store error message
        $error_message = get_post_meta($page_id, 'contact_form_error_message', true);
        if (empty($error_message)) {
            $error_message = 'Vabandust, sõnumi saatmisel tekkis viga. Palun proovige uuesti või võtke meiega otse ühendust.';
        }
        $error_key = 'avora_contact_errors_' . wp_generate_password(12, false);
        set_transient($error_key, [$error_message], 300);
        wp_redirect($_POST['_wp_http_referer'] . '?contact_msg=' . $error_key . '#contact-form');
    }
    exit;
}
