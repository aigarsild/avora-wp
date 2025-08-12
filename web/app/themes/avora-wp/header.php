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

<!-- Header Section -->
<header class="header">
    <div class="container">
        <div class="header-content" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">
            <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/logo.svg" alt="<?php bloginfo('name'); ?> Logo" class="logo-img" style="height: 50px;">
                </a>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="main-navigation" style="display: flex; align-items: center;">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                        'container' => false,
                        'depth' => 1,
                    ]);
                } else {
                    // Fallback menu if navigation menu is not set up in admin
                    echo '<ul class="nav-menu" style="display: flex; list-style: none; margin: 0; padding: 0; gap: 30px;">';
                    echo '<li><a href="' . home_url() . '" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 16px;">Esileht</a></li>';
                    echo '<li><a href="' . home_url('/meist') . '" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 16px;">Meist</a></li>';
                    echo '<li><a href="' . home_url('/projektid') . '" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 16px;">Projektid</a></li>';
                    echo '<li><a href="' . home_url('/kontakt') . '" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 16px;">Kontakt</a></li>';
                    echo '</ul>';
                }
                ?>
                
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" style="display: none; background: none; border: none; font-size: 20px; color: var(--color-primary); cursor: pointer; margin-left: 20px;" onclick="toggleMobileMenu()">
                    ☰
                </button>
            </nav>
        </div>
        
        <!-- Mobile Navigation Menu -->
        <nav class="mobile-navigation" id="mobileNav" style="display: none; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-top: 20px; border-radius: 10px; overflow: hidden;">
            <ul style="list-style: none; margin: 0; padding: 0;">
                <li><a href="<?php echo home_url(); ?>" style="display: block; padding: 15px 20px; color: var(--color-primary); text-decoration: none; border-bottom: 1px solid #eee;">Esileht</a></li>
                <li><a href="<?php echo home_url('/meist'); ?>" style="display: block; padding: 15px 20px; color: var(--color-primary); text-decoration: none; border-bottom: 1px solid #eee;">Meist</a></li>
                <li><a href="<?php echo home_url('/projektid'); ?>" style="display: block; padding: 15px 20px; color: var(--color-primary); text-decoration: none; border-bottom: 1px solid #eee;">Projektid</a></li>
                <li><a href="<?php echo home_url('/kontakt'); ?>" style="display: block; padding: 15px 20px; color: var(--color-primary); text-decoration: none;">Kontakt</a></li>
            </ul>
        </nav>
    </div>
</header>

<style>
/* Navigation Styles */
.nav-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 30px;
}

.nav-menu a {
    color: var(--color-primary);
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s ease;
}

.nav-menu a:hover {
    color: var(--color-accent);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .main-navigation .nav-menu {
        display: none;
    }
    
    .mobile-menu-toggle {
        display: block !important;
    }
}

@media (min-width: 769px) {
    .mobile-navigation {
        display: none !important;
    }
}
</style>

<script>
function toggleMobileMenu() {
    const mobileNav = document.getElementById('mobileNav');
    const isVisible = mobileNav.style.display === 'block';
    mobileNav.style.display = isVisible ? 'none' : 'block';
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileNav = document.getElementById('mobileNav');
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    
    if (!mobileNav.contains(event.target) && !menuToggle.contains(event.target)) {
        mobileNav.style.display = 'none';
    }
});
</script>
