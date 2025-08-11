<?php get_header(); ?>

<main class="py-section bg-brand-white">
    <div class="container">
        <div class="max-w-4xl mx-auto">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="mb-xxxl">
                        <header class="mb-xxxl text-center">
                            <h1 class="text-h1 text-brand-primary mb-lg"><?php the_title(); ?></h1>
                            <div class="text-large text-brand-primary opacity-60 mb-xl">
                                <?php echo get_the_date(); ?> • <?php the_author(); ?>
                            </div>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="mb-xl">
                                    <?php the_post_thumbnail('large', ['class' => 'w-full h-96 object-cover rounded-lg']); ?>
                                </div>
                            <?php endif; ?>
                        </header>
                        
                        <div class="content text-large text-brand-primary leading-relaxed prose prose-lg max-w-none">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php if (get_the_tags()) : ?>
                            <div class="mt-xxxl pt-xl border-t border-brand-gray">
                                <h4 class="text-h4 text-brand-primary mb-md">Märksõnad:</h4>
                                <div class="flex flex-wrap gap-sm">
                                    <?php foreach (get_the_tags() as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" 
                                           class="btn btn-outline text-xs py-xs px-md">
                                            <?php echo $tag->name; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </article>
                    
                    <nav class="border-t border-brand-gray pt-xl">
                        <div class="flex justify-between">
                            <div>
                                <?php previous_post_link('%link', '← %title', true); ?>
                            </div>
                            <div>
                                <?php next_post_link('%link', '%title →', true); ?>
                            </div>
                        </div>
                    </nav>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
