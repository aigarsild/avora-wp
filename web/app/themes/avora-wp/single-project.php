<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- Project Header -->
<section class="project-header">
    <div class="container">
        <div class="project-header-content">
            <div class="project-header-text">
                <h1><?php the_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                    <p class="project-description"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
            <div>
                <a href="<?php echo home_url('/projektid'); ?>" class="btn btn-outline">
                    ← Tagasi projektidesse
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Project Gallery -->
<?php 
// Get custom gallery images
$gallery_image_ids = get_post_meta(get_the_ID(), 'project_gallery_images', true);
$gallery_images = array();

if (!empty($gallery_image_ids)) {
    $image_ids = explode(',', $gallery_image_ids);
    foreach ($image_ids as $image_id) {
        if ($image_id && wp_get_attachment_url($image_id)) {
            $gallery_images[] = get_post($image_id);
        }
    }
}

if (has_post_thumbnail() || !empty($gallery_images)) : ?>
<section class="project-gallery">
    <div class="container p-0">
        
        <!-- Main Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="featured-image">
                <?php the_post_thumbnail('large'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Image Gallery Grid -->
        <?php if (!empty($gallery_images)) : ?>
            <div class="gallery-section">
                <h2 class="gallery-title">Projekti galerii</h2>
                <div class="gallery-grid">
                    <?php foreach ($gallery_images as $image) : ?>
                        <div class="gallery-item" onclick="openLightbox('<?php echo wp_get_attachment_url($image->ID); ?>', '<?php echo esc_attr($image->post_title); ?>')">
                            <?php echo wp_get_attachment_image($image->ID, 'large'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<!-- Lightbox Modal -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <div class="lightbox-content">
        <img id="lightbox-image" class="lightbox-image" src="" alt="">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    </div>
</div>

<script>
function openLightbox(src, alt) {
    document.getElementById('lightbox').style.display = 'flex';
    document.getElementById('lightbox-image').src = src;
    document.getElementById('lightbox-image').alt = alt;
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close lightbox with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});
</script>

<?php endif; ?>

<!-- Project Details -->
<section class="project-details">
    <div class="container">
        <div class="project-details-grid">
            
            <!-- Project Content -->
            <div class="project-content">
                <?php if (get_the_content()) : ?>
                    <?php the_content(); ?>
                <?php endif; ?>
            </div>
            
            <!-- Project Meta -->
            <div class="project-meta-sidebar">
                <h3 class="meta-title">Projekti detailid</h3>
                
                <?php
                $project_status = get_field('project_status') ?: 'Teadmata';
                $project_location = get_field('project_location') ?: '';
                $project_year = get_field('project_year') ?: '';
                $project_type = get_field('project_type') ?: '';
                $project_units = get_field('project_units') ?: '';
                $project_area = get_field('project_area') ?: '';
                ?>
                
                <div class="meta-list">
                    <?php if ($project_status) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Staatus:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_status); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($project_location) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Asukoht:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_location); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($project_year) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Aasta:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_year); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($project_type) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Tüüp:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_type); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($project_units) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Ühikuid:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_units); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($project_area) : ?>
                        <div class="meta-list-item">
                            <span class="meta-list-label">Pindala:</span>
                            <span class="meta-list-value"><?php echo esc_html($project_area); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Related Projects -->
<?php
$related_projects = get_posts([
    'post_type' => 'project',
    'posts_per_page' => 3,
    'exclude' => [get_the_ID()],
    'meta_key' => '_thumbnail_id'
]);

if ($related_projects) : ?>
<section class="related-projects">
    <div class="container">
        <h2 class="section-title">Teised projektid</h2>
        <div class="projects-grid">
            
            <?php foreach ($related_projects as $project) : ?>
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
                            <a href="<?php echo get_permalink($project->ID); ?>"><?php echo get_the_title($project->ID); ?></a>
                        </h3>
                        <?php if (get_the_excerpt($project->ID)) : ?>
                            <p class="project-excerpt"><?php echo get_the_excerpt($project->ID); ?></p>
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
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>