<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bg-white shadow-sm border-b">
    <nav class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="<?php echo home_url(); ?>" class="text-xl font-bold text-gray-900">
                    <?php bloginfo('name'); ?>
                </a>
                <?php if (get_bloginfo('description')) : ?>
                    <span class="ml-2 text-gray-500 hidden sm:inline">
                        / <?php bloginfo('description'); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <div class="hidden md:block">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex space-x-6',
                    'link_before' => '<span class="text-gray-700 hover:text-gray-900 transition-colors">',
                    'link_after' => '</span>',
                ]);
                ?>
            </div>
            
            <div class="md:hidden">
                <button class="text-gray-700 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>
