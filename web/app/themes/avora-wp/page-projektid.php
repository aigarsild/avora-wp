<?php get_header(); ?>

<!-- Projects Hero Section -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Projektid</h1>
                <p>Tutvuge meie teostatud ja käimasolevate projektidega - igaüks neist on unikaalne lugu kvaliteetsest arhitektuurist.</p>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="AVORA projektid" class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Projects Grid Section -->
<section style="padding: 60px 0;">
    <div class="container">
        <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            
            <!-- Project 1 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Projekt 1" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px;">Moodne Elukompleks</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Kaasaegne elukompleks Tallinnas, mis ühendab endas funktsionaalsuse ja esteetika.</p>
                    <div class="project-meta" style="display: flex; gap: 20px; margin-bottom: 20px; font-size: 14px; color: #888;">
                        <span><strong>Asukoht:</strong> Tallinn</span>
                        <span><strong>Staatus:</strong> Valmis</span>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 10px 20px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 5px; font-weight: 500;">
                        Vaata detaile
                    </a>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="Projekt 2" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px;">Privaatmajad Harjumaal</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Eksklusiivne privaatmajade arendus kaunis looduskeskkonnas.</p>
                    <div class="project-meta" style="display: flex; gap: 20px; margin-bottom: 20px; font-size: 14px; color: #888;">
                        <span><strong>Asukoht:</strong> Harjumaa</span>
                        <span><strong>Staatus:</strong> Ehituses</span>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 10px 20px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 5px; font-weight: 500;">
                        Vaata detaile
                    </a>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Projekt 3" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px;">Luksuslik Korterelamu</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Premium kvaliteediga korterelamu kesklinnas tänapäevase disainiga.</p>
                    <div class="project-meta" style="display: flex; gap: 20px; margin-bottom: 20px; font-size: 14px; color: #888;">
                        <span><strong>Asukoht:</strong> Tallinn</span>
                        <span><strong>Staatus:</strong> Planeerimine</span>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 10px 20px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 5px; font-weight: 500;">
                        Vaata detaile
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="quote-section">
    <div class="container">
        <h2>Olete huvitatud meie projektidest?</h2>
        <p>Võtke meiega ühendust, et saada rohkem informatsiooni või kokku leppida kohtumine.</p>
        <a href="<?php echo home_url('/kontakt'); ?>" class="btn btn-primary" style="display: inline-block; padding: 15px 30px; background: var(--color-primary); color: white; text-decoration: none; border-radius: 5px; font-weight: 500; margin-top: 20px;">
            Võta ühendust
        </a>
    </div>
</section>

<!-- Custom Page Content -->
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php if (get_the_content()) : ?>
            <section class="page-content" style="padding: 60px 0;">
                <div class="container">
                    <div style="font-size: 18px; line-height: 1.6;">
                        <?php the_content(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
