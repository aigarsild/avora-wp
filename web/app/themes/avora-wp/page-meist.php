<?php get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Meist</h1>
        <p class="page-description">AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte, mis loob tuleviku kodusid täna.</p>
    </div>
</section>




<!-- Values Section -->
<section class="feature">
    <div class="container">
        <div class="feature-content">
            <div class="feature-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Meie väärtused" class="circle-image">
            </div>
            <div class="feature-text">
                <h2>Meie väärtused</h2>
                <ul class="text-lg">
                    <li class="mb-4"><strong>Kvaliteet:</strong> Kasutame ainult parimaid materjale ja töötame tunnustatud partneritega.</li>
                    <li class="mb-4"><strong>Täpsus:</strong> Iga detail on läbi mõeldud ja hoolikalt teostatud.</li>
                    <li class="mb-4"><strong>Jätkusuutlikkus:</strong> Ehitame kodusid, mis kestavad põlvkondade vältel.</li>
                    <li class="mb-4"><strong>Innovatsioon:</strong> Kasutame uuenduslikke ehitusmeetodeid ja lahendusi.</li>
                </ul>
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