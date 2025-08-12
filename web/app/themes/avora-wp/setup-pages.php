<?php
/**
 * Page Setup Script for AVORA WP Theme
 * Run this file once to create the required pages
 * 
 * Access via: https://avora-wp.test/wp-content/themes/avora-wp/setup-pages.php
 */

// Load WordPress
if (!defined('ABSPATH')) {
    // Try to load WordPress
    $wp_config_path = __DIR__ . '/../../../../wp-config.php';
    if (file_exists($wp_config_path)) {
        require_once($wp_config_path);
    } else {
        die('WordPress not found. Please run this from your WordPress installation.');
    }
}

// Basic HTML output
if (!function_exists('wp_insert_post')) {
    echo '<!DOCTYPE html><html><head><title>AVORA Setup</title>';
    echo '<style>body{font-family:Arial;max-width:800px;margin:40px auto;padding:20px;background:#f5f5f5;}';
    echo '.container{background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}';
    echo 'h1{color:#14213D;}.success{color:#28a745;}.error{color:#dc3545;}.info{color:#007bff;}</style>';
    echo '</head><body><div class="container">';
    echo '<h1>AVORA WP Theme Setup</h1>';
    echo '<p class="error">WordPress functions not available. Please make sure WordPress is properly installed.</p>';
    echo '<p><a href="/wp-admin/">Go to WordPress Admin</a></p>';
    echo '</div></body></html>';
    exit;
}

function avora_create_pages() {
    // Pages to create
    $pages = [
        [
            'title' => 'Esileht',
            'slug' => 'esileht',
            'content' => 'See on AVORA koduleht - kinnisvaraarenduse ettevõte.',
            'is_front_page' => true
        ],
        [
            'title' => 'Meist',
            'slug' => 'meist',
            'content' => 'AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte, mis loob tuleviku kodusid täna. Tegeleme eluhoonete ehitusega, mille tulemusena loodakse detailideni läbimõeldud elukeskkonnad Tallinnas ning Harjumaal.',
            'is_front_page' => false
        ],
        [
            'title' => 'Projektid',
            'slug' => 'projektid',
            'content' => 'Tutvuge meie teostatud ja käimasolevate projektidega. Iga projekt on unikaalne lugu kvaliteetsest arhitektuurist ja tähelepanelikult läbimõeldud elukeskkonnast.',
            'is_front_page' => false
        ],
        [
            'title' => 'Kontakt',
            'slug' => 'kontakt',
            'content' => 'Võtke meiega ühendust, et arutada oma kinnisvaraprojekti või saada rohkem informatsiooni meie teenuste kohta.',
            'is_front_page' => false
        ]
    ];

    $created_pages = [];

    foreach ($pages as $page) {
        // Check if page already exists
        $existing_page = get_page_by_path($page['slug']);
        
        if (!$existing_page) {
            $page_data = [
                'post_title'   => $page['title'],
                'post_name'    => $page['slug'],
                'post_content' => $page['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => 1
            ];
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id && !is_wp_error($page_id)) {
                $created_pages[] = $page['title'] . ' (ID: ' . $page_id . ')';
                
                // Set as front page if specified
                if ($page['is_front_page']) {
                    update_option('show_on_front', 'page');
                    update_option('page_on_front', $page_id);
                }
                
                echo "✅ Created page: " . $page['title'] . " (ID: {$page_id})\n";
            } else {
                echo "❌ Failed to create page: " . $page['title'] . "\n";
            }
        } else {
            echo "ℹ️  Page already exists: " . $page['title'] . " (ID: {$existing_page->ID})\n";
            
            // Set as front page if specified and not already set
            if ($page['is_front_page']) {
                $current_front_page = get_option('page_on_front');
                if ($current_front_page != $existing_page->ID) {
                    update_option('show_on_front', 'page');
                    update_option('page_on_front', $existing_page->ID);
                    echo "✅ Set as front page: " . $page['title'] . "\n";
                }
            }
        }
    }

    // Create navigation menu
    avora_create_navigation_menu();

    return $created_pages;
}

function avora_create_navigation_menu() {
    $menu_name = 'Peamenüü';
    $menu_location = 'primary';
    
    // Check if menu already exists
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        if (!is_wp_error($menu_id)) {
            // Add menu items
            $menu_items = [
                ['title' => 'Esileht', 'url' => home_url('/'), 'order' => 1],
                ['title' => 'Meist', 'url' => home_url('/meist/'), 'order' => 2],
                ['title' => 'Projektid', 'url' => home_url('/projektid/'), 'order' => 3],
                ['title' => 'Kontakt', 'url' => home_url('/kontakt/'), 'order' => 4]
            ];
            
            foreach ($menu_items as $item) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title' => $item['title'],
                    'menu-item-url' => $item['url'],
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $item['order']
                ]);
            }
            
            // Set menu location
            $locations = get_theme_mod('nav_menu_locations');
            $locations[$menu_location] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
            
            echo "✅ Created navigation menu: {$menu_name}\n";
        } else {
            echo "❌ Failed to create navigation menu\n";
        }
    } else {
        echo "ℹ️  Navigation menu already exists: {$menu_name}\n";
    }
}

// Run the setup with HTML output
if (function_exists('wp_insert_post')) {
    echo '<!DOCTYPE html><html><head><title>AVORA Setup</title>';
    echo '<style>body{font-family:Arial;max-width:800px;margin:40px auto;padding:20px;background:#f5f5f5;}';
    echo '.container{background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}';
    echo 'h1{color:#14213D;}.success{color:#28a745;}.error{color:#dc3545;}.info{color:#007bff;}';
    echo 'ul{list-style:none;padding:0;}li{padding:5px 0;border-bottom:1px solid #eee;}';
    echo '.btn{display:inline-block;padding:10px 20px;background:#14213D;color:white;text-decoration:none;border-radius:5px;margin:10px 5px 0 0;}';
    echo '</style></head><body><div class="container">';
    
    echo "<h1>AVORA WP Theme - Page Setup</h1>\n";
    
    $created = avora_create_pages();
    
    echo "<div class='success'><h2>✅ Setup completed!</h2></div>";
    echo "<p><strong>Pages created:</strong> " . count($created) . "</p>";
    
    if (!empty($created)) {
        echo "<h3>Created pages:</h3><ul>";
        foreach ($created as $page) {
            echo "<li class='success'>✅ {$page}</li>";
        }
        echo "</ul>";
    }
    
    echo "<h3>Next steps:</h3>";
    echo "<ol>";
    echo "<li>Visit your homepage: <a href='" . home_url() . "' target='_blank'>" . home_url() . "</a></li>";
    echo "<li>Test navigation between pages</li>";
    echo "<li>Go to WordPress admin to manage content</li>";
    echo "</ol>";
    
    echo "<div style='margin-top:30px;'>";
    echo "<a href='" . home_url() . "' class='btn'>Visit Website</a>";
    echo "<a href='" . admin_url() . "' class='btn'>WordPress Admin</a>";
    echo "</div>";
    
    echo '</div></body></html>';
} else {
    echo "<div class='error'>Error: WordPress not loaded properly.</div>";
}
?>
