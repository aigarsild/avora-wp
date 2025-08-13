<?php get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php if (has_excerpt()) : ?>
                    <p class="page-description"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Page Content -->
<section class="page-content">
    <div class="container">
        <div class="page-content-inner">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-10">
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-96 object-cover rounded-lg shadow-lg']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>