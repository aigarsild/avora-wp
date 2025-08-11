<?php get_header(); ?>

<main class="py-section bg-brand-white">
    <div class="container">
        <div class="max-w-4xl mx-auto">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article>
                        <header class="mb-xxxl text-center">
                            <h1 class="text-h1 text-brand-primary mb-lg"><?php the_title(); ?></h1>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="mb-xl">
                                    <?php the_post_thumbnail('large', ['class' => 'w-full h-96 object-cover rounded-lg']); ?>
                                </div>
                            <?php endif; ?>
                        </header>
                        
                        <div class="content text-large text-brand-primary leading-relaxed prose prose-lg max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
