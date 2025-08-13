<?php get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Projektid</h1>
        <p class="page-description">Tutvuge meie teostatud ja käimasolevate projektidega - igaüks neist on unikaalne lugu kvaliteetsest arhitektuurist.</p>
    </div>
</section>



<!-- Featured Projects Grid -->
<section class="projects-section">
    <div class="container">
        
        
        <?php
        $projects = get_posts([
            'post_type' => 'project',
            'posts_per_page' => -1,
            'meta_key' => '_thumbnail_id'
        ]);
        
        if ($projects) : ?>
            <div class="projects-grid">
                
                <?php foreach ($projects as $project) : ?>
                    <article class="project-card">
                        <?php if (has_post_thumbnail($project->ID)) : ?>
                            <div class="project-image">
                                <a href="<?php echo get_permalink($project->ID); ?>">
                                    <?php echo get_the_post_thumbnail($project->ID, 'large', ['class' => 'project-img']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="project-content">
                            <h3 class="project-title">
                                <a href="<?php echo get_permalink($project->ID); ?>">
                                    <?php echo get_the_title($project->ID); ?>
                                </a>
                            </h3>
                            
                            <?php if (get_the_excerpt($project->ID)) : ?>
                                <p class="project-excerpt">
                                    <?php echo get_the_excerpt($project->ID); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php 
                            $project_logo = get_post_meta($project->ID, 'project_logo', true);
                            if (!empty($project_logo)) : ?>
                                <div class="project-logo">
                                    <img src="<?php echo esc_url($project_logo); ?>" alt="Arendaja logo" class="developer-logo">
                                </div>
                            <?php else : ?>
                                <a href="<?php echo get_permalink($project->ID); ?>" class="btn btn-outline">
                                    Vaata detaile
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                
            </div>
        <?php else : ?>
            <div class="empty-state">
                <h3>Projektid tulemas peagi</h3>
                <p>Hetkel me veel projekte ei näita, kuid peagi lisandub siia sisu.</p>
            </div>
        <?php endif; ?>
        
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