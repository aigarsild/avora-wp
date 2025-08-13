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
                    [], 
                    filemtime($asset)
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
    global $post_type;
    
    if ($hook == 'post-new.php' || $hook == 'post.php') {
        if ($post_type == 'project') {
            wp_enqueue_media();
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('project-media-uploader', get_template_directory_uri() . '/admin-media.js', array('jquery', 'jquery-ui-sortable'), '1.0.0', true);
            wp_enqueue_style('project-admin-styles', get_template_directory_uri() . '/admin-styles.css', array(), '1.0.0');
        }
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
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
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
        'project_gallery',
        'Projekti galerii',
        'project_gallery_callback',
        'project',
        'normal',
        'high'
    );
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
    if (!isset($_POST['project_details_nonce_field']) || !wp_verify_nonce($_POST['project_details_nonce_field'], 'project_details_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (get_post_type($post_id) !== 'project') {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = ['project_status', 'project_location', 'project_year', 'project_type', 'project_units', 'project_area', 'project_logo'];
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Save gallery images
    if (isset($_POST['project_gallery_images'])) {
        $gallery_images = sanitize_text_field($_POST['project_gallery_images']);
        update_post_meta($post_id, 'project_gallery_images', $gallery_images);
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

// Auto-create projects on theme activation
add_action('after_switch_theme', 'avora_create_projects');
add_action('init', 'avora_create_projects'); // Also run on init for existing installations

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
