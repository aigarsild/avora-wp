<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- Project Header -->
<section class="project-header hero">
    <div class="container">
        <div class="project-header-content hero-content">
            <div class="project-header-text hero-text">
                <h1><?php the_title(); ?></h1>
                <?php 
                $project_link = get_post_meta(get_the_ID(), 'project_link', true);
                
                if (!empty($project_link)) : 
                    // Clean the URL for display (remove protocol)
                    $display_url = preg_replace('#^https?://#', '', $project_link);
                    $display_url = rtrim($display_url, '/');
                ?>
                    <div class="project-link">
                        <a href="<?php echo esc_url($project_link); ?>" target="_blank" rel="noopener noreferrer" class="project-external-link">
                            <?php echo esc_html($display_url); ?> →
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (get_the_content()) : ?>
                    <div class="project-description"><?php the_content(); ?></div>
                <?php endif; ?>
                <div class="hero-buttons">
                    <a href="<?php echo home_url('/projektid'); ?>" class="btn btn-outline-accent">
                        ← Tagasi projektidesse
                    </a>
                </div>
            </div>
            <?php 
            // Get hero media settings
            $hero_media_type = get_post_meta(get_the_ID(), 'project_hero_media_type', true);
            $hero_image = get_post_meta(get_the_ID(), 'project_hero_image', true);
            $hero_video = get_post_meta(get_the_ID(), 'project_hero_video', true);
            
            // Default to featured image if no custom media type is set
            if (empty($hero_media_type)) {
                $hero_media_type = 'featured';
            }
            
            // Display hero media based on type
            if ($hero_media_type === 'video' && !empty($hero_video)) : 
                // Get video overlay settings
                $overlay_color = get_post_meta(get_the_ID(), 'project_hero_video_overlay_color', true);
                $overlay_opacity = get_post_meta(get_the_ID(), 'project_hero_video_overlay_opacity', true);
                $overlay_blur = get_post_meta(get_the_ID(), 'project_hero_video_overlay_blur', true);
                $playback_speed = get_post_meta(get_the_ID(), 'project_hero_video_playback_speed', true);
                
                if (empty($overlay_color)) {
                    $overlay_color = '#000000';
                }
                if (empty($overlay_opacity)) {
                    $overlay_opacity = '0.3';
                }
                if (empty($overlay_blur)) {
                    $overlay_blur = '2';
                }
                if (empty($playback_speed)) {
                    $playback_speed = '1';
                }
                
                // Convert hex color to RGB for rgba
                $hex = ltrim($overlay_color, '#');
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $rgba_color = "rgba($r, $g, $b, $overlay_opacity)";
                ?>
                <div class="project-header-image hero-image">
                    <video 
                        autoplay 
                        muted 
                        loop 
                        playsinline 
                        preload="metadata"
                        class="hero-video"
                        poster="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>"
                        loading="lazy"
                        data-src="<?php echo esc_url($hero_video); ?>"
                        data-playback-speed="<?php echo esc_attr($playback_speed); ?>"
                    >
                        <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
                        <source src="<?php echo esc_url($hero_video); ?>" type="video/webm">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-overlay" style="background-color: <?php echo esc_attr($rgba_color); ?>; backdrop-filter: blur(<?php echo esc_attr($overlay_blur); ?>px); -webkit-backdrop-filter: blur(<?php echo esc_attr($overlay_blur); ?>px);"></div>
                </div>
            <?php elseif ($hero_media_type === 'custom_image' && !empty($hero_image)) : ?>
                <div class="project-header-image hero-image">
                    <img src="<?php echo esc_url($hero_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="hero-img">
                </div>
            <?php elseif (has_post_thumbnail()) : ?>
                <div class="project-header-image hero-image">
                    <?php the_post_thumbnail('large', ['class' => 'hero-img']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Project Content Blocks -->
<?php 
$project_content_blocks = get_post_meta(get_the_ID(), 'project_content_blocks', true);
$content_blocks = $project_content_blocks ? json_decode($project_content_blocks, true) : [];

if (!empty($content_blocks)) : ?>
    <?php foreach ($content_blocks as $index => $block) : ?>
        <?php if (!empty($block['title']) || !empty($block['content']) || !empty($block['image'])) : ?>
            <?php 
            $block_type = isset($block['block_type']) ? $block['block_type'] : 'regular';
            ?>
            <section class="content-block-section <?php echo esc_attr($block_type === 'fullwidth' ? 'fullwidth-block' : ''); ?>">
                <div class="container">
                    <?php if ($block_type === 'fullwidth') : ?>
                        <div class="fullwidth-content custom-fullwidth-block">
                            <?php if (!empty($block['title'])) : ?>
                                <h2><?php echo esc_html($block['title']); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($block['content'])) : ?>
                                <div class="fullwidth-text">
                                    <?php 
                                    // Process content from TinyMCE editor
                                    $content = $block['content'];
                                    
                                    // Clean the content first to remove unwanted characters
                                    $cleaned_content = $content;
                                    $cleaned_content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $cleaned_content);
                                    $cleaned_content = preg_replace('/\s+/', ' ', $cleaned_content);
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
                    <?php else : ?>
                        <div class="feature-content <?php echo esc_attr($block['image_position'] === 'right' ? 'reverse' : ''); ?>">
                            <?php if (!empty($block['image'])) : ?>
                                <div class="feature-image">
                                    <img src="<?php echo esc_url($block['image']); ?>" alt="<?php echo esc_attr($block['title']); ?>" class="circle-image">
                                </div>
                            <?php endif; ?>
                            <div class="feature-text">
                                <?php if (!empty($block['title'])) : ?>
                                    <h2><?php echo esc_html($block['title']); ?></h2>
                                <?php endif; ?>
                                <?php if (!empty($block['content'])) : ?>
                                    <div class="block-content">
                                        <?php 
                                        // Process content from TinyMCE editor
                                        $content = $block['content'];
                                        
                                        // Clean the content first to remove unwanted characters
                                        $cleaned_content = $content;
                                        $cleaned_content = str_replace(['\r\n', '\n', '\r', 'rn', '\\r\\n', '\\n', '\\r'], '', $cleaned_content);
                                        $cleaned_content = preg_replace('/\s+/', ' ', $cleaned_content);
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
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

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

if (!empty($gallery_images)) : ?>
<section class="project-gallery">
    <div class="container p-0">
        
        <!-- Image Gallery Grid -->
        <?php if (!empty($gallery_images)) : ?>
            <div class="gallery-section">
                <h2 class="gallery-title">Projekti galerii</h2>
                <div class="gallery-grid">
                    <?php foreach ($gallery_images as $index => $image) : ?>
                        <div class="gallery-item" onclick="openLightbox(<?php echo $index; ?>)">
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
        <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation(); previousImage()">‹</button>
        <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation(); nextImage()">›</button>
    </div>
</div>

<script>
// Gallery data for navigation
const galleryImages = [
    <?php foreach ($gallery_images as $image) : ?>
    {
        src: '<?php echo wp_get_attachment_url($image->ID); ?>',
        alt: '<?php echo esc_attr($image->post_title); ?>'
    },
    <?php endforeach; ?>
];

let currentImageIndex = 0;

function openLightbox(index) {
    currentImageIndex = index;
    showCurrentImage();
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Show/hide navigation arrows based on position
    updateNavigationVisibility();
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function showCurrentImage() {
    if (galleryImages[currentImageIndex]) {
        const img = document.getElementById('lightbox-image');
        img.src = galleryImages[currentImageIndex].src;
        img.alt = galleryImages[currentImageIndex].alt;
    }
}

function nextImage() {
    if (currentImageIndex < galleryImages.length - 1) {
        currentImageIndex++;
        showCurrentImage();
        updateNavigationVisibility();
    }
}

function previousImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
        showCurrentImage();
        updateNavigationVisibility();
    }
}

function updateNavigationVisibility() {
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    
    if (prevBtn) {
        prevBtn.style.display = currentImageIndex === 0 ? 'none' : 'block';
    }
    
    if (nextBtn) {
        nextBtn.style.display = currentImageIndex === galleryImages.length - 1 ? 'none' : 'block';
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').style.display === 'flex') {
        switch(e.key) {
            case 'Escape':
                closeLightbox();
                break;
            case 'ArrowLeft':
                previousImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
        }
    }
});

// Video loading optimization
document.addEventListener('DOMContentLoaded', function() {
    const heroVideo = document.querySelector('.hero-video');
    
    if (heroVideo) {
        // Intersection Observer for lazy loading
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const video = entry.target;
                    
                    // Load video when it comes into view
                    if (video.dataset.src && !video.src) {
                        video.src = video.dataset.src;
                        video.load();
                    }
                    
                    // Mark as loaded for smooth transition
                    video.addEventListener('loadeddata', () => {
                        video.setAttribute('data-loaded', 'true');
                        
                        // Apply custom playback speed
                        const playbackSpeed = parseFloat(video.dataset.playbackSpeed) || 1;
                        video.playbackRate = playbackSpeed;
                    });
                    
                    videoObserver.unobserve(video);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        videoObserver.observe(heroVideo);
        
        // Pause video when not visible (performance)
        const pauseObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const video = entry.target;
                if (entry.isIntersecting) {
                    video.play().catch(e => console.log('Video autoplay prevented:', e));
                } else {
                    video.pause();
                }
            });
        }, {
            threshold: 0.5
        });
        
        pauseObserver.observe(heroVideo);
        
        // Reduce video quality on slow connections
        if ('connection' in navigator) {
            const connection = navigator.connection;
            if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g') {
                heroVideo.style.display = 'none';
                console.log('Video hidden due to slow connection');
            }
        }
        
        // Error handling
        heroVideo.addEventListener('error', function() {
            console.error('Video failed to load:', this.src);
            // Fallback to poster image
            this.style.display = 'none';
        });
    }
});
</script>

<?php endif; ?>


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