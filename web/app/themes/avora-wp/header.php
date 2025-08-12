<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Favicons and Icons -->
    <link rel="icon" type="image/svg+xml" href="<?php echo get_template_directory_uri(); ?>/av-favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/icons/favicon-16x16.png">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/icons/favicon.ico">
    
    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/icons/apple-touch-icon-57x57.png">
    
    <!-- Android/Chrome Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/icons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo get_template_directory_uri(); ?>/icons/android-chrome-512x512.png">
    
    <!-- Microsoft Tile Icons -->
    <meta name="msapplication-TileColor" content="#14213D">
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/icons/mstile-150x150.png">
    <meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/icons/browserconfig.xml">
    
    <!-- Theme Color -->
    <meta name="theme-color" content="#14213D">
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/site.webmanifest">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('font-brand'); ?>>
<?php wp_body_open(); ?>

<!-- Modern Responsive Header -->
<header class="modern-header">
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <div class="logo">
                <a href="<?php echo home_url(); ?>" class="logo-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/logo.svg" alt="<?php bloginfo('name'); ?> Logo" class="logo-img">
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="desktop-navigation">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                        'container' => false,
                        'depth' => 1,
                    ]);
                } else {
                    // Fallback menu with modern styling
                    echo '<ul class="nav-menu">';
                    
                    $current_url = $_SERVER['REQUEST_URI'];
                    $menu_items = [
                        ['url' => home_url(), 'title' => 'Esileht', 'slug' => '/'],
                        ['url' => home_url('/meist'), 'title' => 'Meist', 'slug' => '/meist'],
                        ['url' => home_url('/projektid'), 'title' => 'Projektid', 'slug' => '/projektid'],
                        ['url' => home_url('/kontakt'), 'title' => 'Kontakt', 'slug' => '/kontakt']
                    ];
                    
                    foreach ($menu_items as $item) {
                        $is_active = ($current_url === $item['slug'] || str_contains($current_url, $item['slug']));
                        $active_class = $is_active ? ' class="active"' : '';
                        echo '<li' . $active_class . '><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>';
                    }
                    
                    echo '</ul>';
                }
                ?>
            </nav>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" id="mobileToggle" aria-label="Toggle mobile menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </div>
    
    <!-- Mobile Navigation Overlay -->
    <div class="mobile-nav-overlay" id="mobileOverlay"></div>
    
    <!-- Mobile Navigation Menu -->
    <nav class="mobile-navigation" id="mobileNav">
        <div class="mobile-nav-content">
            <ul class="mobile-nav-menu">
                <li><a href="<?php echo home_url(); ?>">Esileht</a></li>
                <li><a href="<?php echo home_url('/meist'); ?>">Meist</a></li>
                <li><a href="<?php echo home_url('/projektid'); ?>">Projektid</a></li>
                <li><a href="<?php echo home_url('/kontakt'); ?>">Kontakt</a></li>
            </ul>
        </div>
    </nav>
</header>
