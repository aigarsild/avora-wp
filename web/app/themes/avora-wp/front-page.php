<?php get_header(); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Loome väärtust, läbi kinnisvara</h1>
                    <p>Kaasaegne arhitektuur, kõrge ehituskvaliteet ja personaalsus - AVORA kaudu sünnivad kodud, mis peegeldavad Teie lugu.</p>
                    <div class="hero-buttons">
                        <a href="<?php echo home_url('/kontakt'); ?>" class="btn btn-primary">
                            Võta meiega ühendust
                        </a>
                        <a href="<?php echo home_url('/projektid'); ?>" class="btn btn-outline-accent">
                            Vaata projekte
                        </a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="Kaasaegne Hoone Arhitektuur" class="hero-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>40+</h3>
                    <p>projekti</p>
                </div>
                <div class="stat-item">
                    <h3>7 aastat</h3>
                    <p>kogemust</p>
                </div>
                <div class="stat-item">
                    <h3>87+</h3>
                    <p>rahulolu klienti</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Section -->
    <section class="quote-section">
        <div class="video-background">
            <video autoplay muted loop playsinline class="background-video" id="drone-video">
                <source src="<?php echo get_template_directory_uri(); ?>/video/avora-droon.webm" type="video/webm">
                <source src="<?php echo get_template_directory_uri(); ?>/video/avora-droon.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-overlay"></div>
        </div>
        <div class="container">
            <h2>AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte</h2>
            <p>Tegeleme eluhoonete ehitusega, mille tulemusena loodakse detailideni läbimõeldud elukeskkonnad Tallinnas ning Harjumaal.</p>
            <div class="quote-section-cta">
                <a href="<?php echo home_url('/projektid'); ?>" class="btn btn-outline-white">
                    Vaata projekte
                </a>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('drone-video');
        if (video) {
            // Set playback rate to 0.5 (half speed / 2x slower)
            video.playbackRate = 0.5;
        }
    });
    </script>

    <!-- Feature Section -->
    <section class="feature">
        <div class="container">
            <div class="feature-content">
                <div class="feature-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/2 (2).jpg" alt="AVORA Kvaliteetne Ehitus" class="circle-image">
                </div>
                <div class="feature-text">
                    <h2>Kvaliteet ja täpsus igas detailis</h2>
                    <p>Tuginedes kvaliteetsetele materjalidele ja uuenduslikele ehitusviisidele, loome kodusid, mis ei kesta vaid aastaid, vaid aastakümneid - läbi põlvkondade.</p>
                    <div class="feature-buttons" style="display: none;">
                        <button class="btn btn-primary">Vaata galeriid</button>
                        <button class="btn btn-outline">Loe edasi</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Projects Section -->
    <section class="featured-projects">
        <div class="container">
                    <div class="section-header">
            <h2 class="section-title">Meie projektid</h2>
        </div>

            <?php
            // Get 3 featured projects
            $featured_projects = get_posts([
                'post_type' => 'project',
                'posts_per_page' => 3,
                'meta_key' => '_thumbnail_id',
                'orderby' => 'date',
                'order' => 'DESC'
            ]);
            
            if ($featured_projects) : ?>
                <div class="projects-grid">
                    
                    <?php foreach ($featured_projects as $project) : ?>
                        <article class="project-card-dark">
                            
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
                                    <a href="<?php echo get_permalink($project->ID); ?>" class="btn btn-outline-accent">
                                        Vaata detaile
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    
                </div>
                
                <div class="section-cta">
                    <a href="<?php echo home_url('/projektid'); ?>" class="btn btn-outline-white">
                        Vaata kõiki projekte
                    </a>
                </div>
                
            <?php endif; ?>
        </div>
    </section>

    

<?php get_footer(); ?>