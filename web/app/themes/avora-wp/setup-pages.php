<?php
/**
 * Page Setup Script for AVORA WP Theme
 * Run this file once to create the required pages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // Include WordPress
    require_once(__DIR__ . '/../../../../wp-config.php');
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

// Run the setup
if (function_exists('wp_insert_post')) {
    echo "<h2>AVORA WP Theme - Page Setup</h2>\n";
    echo "<pre>\n";
    
    $created = avora_create_pages();
    
    echo "\n" . str_repeat("-", 50) . "\n";
    echo "Setup completed!\n";
    echo "Pages created: " . count($created) . "\n";
    
    if (!empty($created)) {
        echo "Created pages:\n";
        foreach ($created as $page) {
            echo "- {$page}\n";
        }
    }
    
    echo "\nNext steps:\n";
    echo "1. Go to Appearance > Menus to manage navigation\n";
    echo "2. Go to Settings > Reading to set front page\n";
    echo "3. Visit your site: " . home_url() . "\n";
    echo "</pre>\n";
} else {
    echo "Error: WordPress not loaded properly.\n";
}
?>
