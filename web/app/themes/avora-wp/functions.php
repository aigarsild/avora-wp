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
