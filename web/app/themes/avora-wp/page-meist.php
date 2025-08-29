<?php
/*
Template Name: About Us Page
*/

// Get custom field values with fallbacks
$page_title = get_post_meta(get_the_ID(), 'about_page_title', true);
$page_description = get_post_meta(get_the_ID(), 'about_page_description', true);
$values_title = get_post_meta(get_the_ID(), 'about_values_title', true);
$values_image = get_post_meta(get_the_ID(), 'about_values_image', true);
$values_content = get_post_meta(get_the_ID(), 'about_values_content', true);

// Use defaults if empty
if (empty($page_title)) {
    $page_title = 'Meist';
}
if (empty($page_description)) {
    $page_description = 'AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte, mis loob tuleviku kodusid täna.';
}
if (empty($values_title)) {
    $values_title = 'Meie väärtused';
}
if (empty($values_image)) {
    $values_image = get_template_directory_uri() . '/images/section.jpg';
}
if (empty($values_content)) {
    $values_content = '<ul class="text-lg">
    <li class="mb-4"><strong>Kvaliteet:</strong> Kasutame ainult parimaid materjale ja töötame tunnustatud partneritega.</li>
    <li class="mb-4"><strong>Täpsus:</strong> Iga detail on läbi mõeldud ja hoolikalt teostatud.</li>
    <li class="mb-4"><strong>Jätkusuutlikkus:</strong> Ehitame kodusid, mis kestavad põlvkondade vältel.</li>
    <li class="mb-4"><strong>Innovatsioon:</strong> Kasutame uuenduslikke ehitusmeetodeid ja lahendusi.</li>
</ul>';
}

// Get content blocks
$content_blocks = get_post_meta(get_the_ID(), 'about_content_blocks', true);
$content_blocks = $content_blocks ? json_decode($content_blocks, true) : [];

get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
    </div>
</section>

<!-- Page Description - Full Width -->
<?php if (!empty($page_description)): ?>
<section class="page-description-section">
    <div class="container">
        <div class="page-description-content">
            <?php 
            // Clean the content first to remove unwanted characters
            $cleaned_content = $page_description;
            
            // Remove various types of unwanted characters
            $cleaned_content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $cleaned_content);
            $cleaned_content = preg_replace('/\s+/', ' ', $cleaned_content); // Replace multiple spaces with single space
            $cleaned_content = trim($cleaned_content);
            
            // Check if content has paragraph tags already (from TinyMCE)
            if (strpos($cleaned_content, '<p>') !== false || strpos($cleaned_content, '<br') !== false) {
                // Content already has HTML formatting from TinyMCE
                echo wp_kses_post($cleaned_content);
            } else {
                // Plain text content - convert line breaks to paragraphs
                echo wp_kses_post(wpautop($cleaned_content));
            }
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Values Section -->
<section class="feature">
    <div class="container">
        <div class="feature-content">
            <div class="feature-image">
                <img src="<?php echo esc_url($values_image); ?>" alt="<?php echo esc_attr($values_title); ?>" class="circle-image">
            </div>
            <div class="feature-text">
                <h2><?php echo esc_html($values_title); ?></h2>
                <div class="values-content">
                    <?php echo wp_kses_post($values_content); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Blocks -->
<?php if (!empty($content_blocks)): ?>
    <?php foreach ($content_blocks as $index => $block): ?>
        <?php if (!empty($block['title']) || !empty($block['content']) || !empty($block['image'])): ?>
            <section class="content-block-section">
                <div class="container">
                    <div class="feature-content <?php echo esc_attr($block['image_position'] === 'right' ? 'reverse' : ''); ?>">
                        <?php if (!empty($block['image'])): ?>
                            <div class="feature-image">
                                <img src="<?php echo esc_url($block['image']); ?>" alt="<?php echo esc_attr($block['title']); ?>" class="circle-image">
                            </div>
                        <?php endif; ?>
                        <div class="feature-text">
                            <?php if (!empty($block['title'])): ?>
                                <h2><?php echo esc_html($block['title']); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($block['content'])): ?>
                                <div class="block-content">
                                    <?php 
                                    // Process content from TinyMCE editor
                                    $content = $block['content'];
                                    
                                    // Clean the content first to remove unwanted characters
                                    $cleaned_content = $content;
                                    $cleaned_content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $cleaned_content);
                                    $cleaned_content = preg_replace('/\s+/', ' ', $cleaned_content); // Replace multiple spaces with single space
                                    $cleaned_content = trim($cleaned_content);
                                    
                                    // Check if content has paragraph tags already (from TinyMCE)
                                    if (strpos($cleaned_content, '<p>') !== false || strpos($cleaned_content, '<br') !== false) {
                                        // Content already has HTML formatting from TinyMCE
                                        echo wp_kses_post($cleaned_content);
                                    } else {
                                        // Plain text content - convert line breaks to paragraphs
                                        echo wp_kses_post(wpautop($cleaned_content));
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>



<!-- Custom Page Content -->
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php if (get_the_content()) : ?>
            <section class="page-content">
                <div class="container">
                    <div class="page-content-inner">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>