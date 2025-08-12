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

<!-- Projects Categories -->
<section style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 50px; font-size: 36px; color: var(--color-primary);">Projektide kategooriad</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 64px; margin-bottom: 20px;">🏢</div>
                <h3 style="color: var(--color-primary); margin-bottom: 15px;">Korterimajad</h3>
                <p style="color: #666; font-size: 16px;">25+ projektii valmis</p>
            </div>
            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 64px; margin-bottom: 20px;">🏘️</div>
                <h3 style="color: var(--color-primary); margin-bottom: 15px;">Ridaelamu</h3>
                <p style="color: #666; font-size: 16px;">12+ projekti valmis</p>
            </div>
            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="font-size: 64px; margin-bottom: 20px;">🏡</div>
                <h3 style="color: var(--color-primary); margin-bottom: 15px;">Eramajad</h3>
                <p style="color: #666; font-size: 16px;">8+ projekti valmis</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Grid -->
<section style="padding: 80px 0;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 60px; font-size: 36px; color: var(--color-primary);">Esilevaetud projektid</h2>
        <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 40px;">
            
            <!-- Project 1 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Kristiine Kvartal" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 15px; left: 15px; background: var(--color-accent); color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">VALMIS</div>
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: var(--color-primary);">Kristiine Kvartal</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Moodne 65-korterilise elukompleks Kristiine linnaosas. Kaasaegne arhitektuur ja roheline sisehovi.</p>
                    <div class="project-meta" style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Asukoht:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">Kristiine, Tallinn</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Kortereid:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">65 tk</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Valmis:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">2023</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 12px 24px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                        Vaata detaile
                    </a>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="Maardu Villas" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 15px; left: 15px; background: #28a745; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">EHITUSES</div>
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: var(--color-primary);">Maardu Villas</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Eksklusiivne 18 eramaja arendus Maardu looduskauni piirkonna südames. Privaatsus ja mugavus.</p>
                    <div class="project-meta" style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Asukoht:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">Maardu, Harjumaa</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Maju:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">18 tk</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Valmimine:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">2024 II pool</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 12px 24px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                        Vaata detaile
                    </a>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Noblessner Residence" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 15px; left: 15px; background: #007bff; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">PLANEERIMISEL</div>
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: var(--color-primary);">Noblessner Residence</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Premium korterelamu merele Noblessneri sadamakvartalis. Ekskluisiivne asukoht ja vaated.</p>
                    <div class="project-meta" style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Asukoht:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">Noblessner, Tallinn</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Kortereid:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">32 tk</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Alustamine:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">2025</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 12px 24px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                        Eelhuvi registreerimine
                    </a>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="project-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                <div class="project-image" style="height: 250px; background: var(--color-gray); position: relative;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="Tondi Terraces" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 15px; left: 15px; background: var(--color-accent); color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">VALMIS</div>
                </div>
                <div class="project-content" style="padding: 30px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: var(--color-primary);">Tondi Terraces</h3>
                    <p style="font-size: 16px; line-height: 1.6; color: #666; margin-bottom: 20px;">Kaasaegne ridaelamu kompleks Tondi piirkonna südames. 12 maja terrasside ja aiakestega.</p>
                    <div class="project-meta" style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Asukoht:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">Tondi, Tallinn</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Ridamaju:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">12 tk</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <span style="color: #888; font-size: 14px;">Valmis:</span>
                            <span style="color: var(--color-primary); font-weight: 600; font-size: 14px;">2022</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline" style="display: inline-block; padding: 12px 24px; border: 2px solid var(--color-primary); color: var(--color-primary); text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                        Vaata detaile
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Project Process Section -->
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 60px; font-size: 36px; color: var(--color-primary);">Meie projektitsükkel</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--color-accent); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">1</div>
                <h4 style="color: var(--color-primary); margin-bottom: 15px; font-size: 20px;">Kontseptsioon</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.6;">Turuvajaduse analüüs ja projekti kontseptsiooni väljatöötamine</p>
            </div>
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--color-accent); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">2</div>
                <h4 style="color: var(--color-primary); margin-bottom: 15px; font-size: 20px;">Planeerimine</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.6;">Detailne projekteerimise ja ehituslubade taotlmise etapp</p>
            </div>
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--color-accent); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">3</div>
                <h4 style="color: var(--color-primary); margin-bottom: 15px; font-size: 20px;">Ehitamine</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.6;">Kvaliteetne ja ajakas ehitustööde teostamine</p>
            </div>
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: var(--color-accent); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">4</div>
                <h4 style="color: var(--color-primary); margin-bottom: 15px; font-size: 20px;">Üleandmine</h4>
                <p style="color: #666; font-size: 16px; line-height: 1.6;">Objekti üleandmine ja järelteeninduse tagamine</p>
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
