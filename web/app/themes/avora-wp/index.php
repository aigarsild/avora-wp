<?php get_header(); ?>

<div class="container" style="padding: 60px 20px;">
    <h1 style="font-size: 40px; font-weight: 900; color: var(--color-primary); margin-bottom: 40px;">Blogi</h1>
    
    <?php if (have_posts()) : ?>
        <div class="blog-posts">
            <?php while (have_posts()) : the_post(); ?>
                <article class="blog-post" style="margin-bottom: 40px; padding-bottom: 40px; border-bottom: 1px solid var(--color-gray);">
                    <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 15px;">
                        <a href="<?php the_permalink(); ?>" style="color: var(--color-primary); text-decoration: none;">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    
                    <div class="post-meta" style="color: #666; margin-bottom: 20px; font-size: 16px;">
                        <time datetime="<?php echo get_the_date('c'); ?>">
                            <?php echo get_the_date('j. F Y'); ?>
                        </time>
                    </div>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail" style="margin-bottom: 20px;">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', ['style' => 'width: 100%; height: auto; border-radius: 10px;']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-excerpt" style="font-size: 18px; line-height: 1.6; margin-bottom: 20px;">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="display: inline-block; padding: 12px 24px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 5px; font-weight: 500;">
                        Loe edasi
                    </a>
                </article>
            <?php endwhile; ?>
            
            <div class="pagination" style="margin-top: 40px;">
                <?php the_posts_pagination([
                    'prev_text' => '← Eelmised',
                    'next_text' => 'Järgmised →',
                ]); ?>
            </div>
        </div>
    <?php else : ?>
        <p style="font-size: 18px; color: #666;">Blogi postitusi ei leitud.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>