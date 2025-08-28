<?php 
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

get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
        <p class="page-description"><?php echo esc_html($page_description); ?></p>
    </div>
</section>

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