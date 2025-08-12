<?php get_header(); ?>

<!-- Contact Hero Section -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Kontakt</h1>
                <p>Võtke meiega ühendust, et arutada oma kinnisvaraprojekti või saada rohkem informatsiooni meie teenuste kohta.</p>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="Võta ühendust AVORA-ga" class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Contact Information Section -->
<section style="padding: 60px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            
            <!-- Contact Details -->
            <div class="contact-info">
                <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 30px; color: var(--color-primary);">Kontaktandmed</h2>
                
                <div class="contact-item" style="display: flex; align-items: center; margin-bottom: 20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/phone-icon.svg" alt="Telefon" style="width: 24px; height: 24px; margin-right: 15px;">
                    <a href="tel:+37250848851" style="color: var(--color-primary); text-decoration: none; font-size: 18px;">+372 5084851</a>
                </div>
                
                <div class="contact-item" style="display: flex; align-items: center; margin-bottom: 20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail-icon.svg" alt="Email" style="width: 24px; height: 24px; margin-right: 15px;">
                    <a href="mailto:info@avora.ee" style="color: var(--color-primary); text-decoration: none; font-size: 18px;">info@avora.ee</a>
                </div>
                
                <div class="contact-item" style="display: flex; align-items: flex-start; margin-bottom: 30px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icons/map-icon.svg" alt="Aadress" style="width: 24px; height: 24px; margin-right: 15px; margin-top: 2px;">
                    <div>
                        <p style="margin: 0; font-size: 18px; line-height: 1.5;">
                            Tartu mnt 84a<br>
                            Kesklinna linnaosa<br>
                            Tallinn, Harju maakond<br>
                            10112
                        </p>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="business-hours" style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 15px; color: var(--color-primary);">Lahtiolekuajad</h3>
                    <div style="font-size: 16px; line-height: 1.6;">
                        <p style="margin: 5px 0;"><strong>E-R:</strong> 9:00 - 17:00</p>
                        <p style="margin: 5px 0;"><strong>L:</strong> 10:00 - 14:00</p>
                        <p style="margin: 5px 0;"><strong>P:</strong> Suletud</p>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="social-media">
                    <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 15px; color: var(--color-primary);">Jälgi meid</h3>
                    <div style="display: flex; gap: 15px;">
                        <a href="#" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; text-decoration: none;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/facebook-icon.svg" alt="Facebook" style="width: 20px; height: 20px;">
                        </a>
                        <a href="#" style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: var(--color-primary); border-radius: 50%; text-decoration: none;">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icons/instagram-icon.svg" alt="Instagram" style="width: 20px; height: 20px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2 style="font-size: 28px; font-weight: 700; margin-bottom: 30px; color: var(--color-primary);">Saada sõnum</h2>
                
                <form action="#" method="post" style="background: #f8f9fa; padding: 30px; border-radius: 15px;">
                    <div style="margin-bottom: 20px;">
                        <label for="name" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-primary);">Nimi *</label>
                        <input type="text" id="name" name="name" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="email" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-primary);">Email *</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-primary);">Telefon</label>
                        <input type="tel" id="phone" name="phone" style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="subject" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-primary);">Teema</label>
                        <select id="subject" name="subject" style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
                            <option value="">Vali teema</option>
                            <option value="project-inquiry">Projekti päring</option>
                            <option value="consultation">Konsultatsioon</option>
                            <option value="partnership">Koostöö</option>
                            <option value="other">Muu</option>
                        </select>
                    </div>
                    
                    <div style="margin-bottom: 30px;">
                        <label for="message" style="display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-primary);">Sõnum *</label>
                        <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; resize: vertical; box-sizing: border-box;"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="background: var(--color-primary); color: white; border: none; padding: 15px 30px; border-radius: 5px; font-size: 16px; font-weight: 500; cursor: pointer; width: 100%;">
                        Saada sõnum
                    </button>
                    
                    <p style="font-size: 14px; color: #666; margin-top: 15px; line-height: 1.5;">
                        * Kohustuslikud väljad<br>
                        Vastame teile 24 tunni jooksul.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Company Information -->
<section class="quote-section">
    <div class="container">
        <h2>AVORA OÜ</h2>
        <p>Registrikood: 14602827<br>
        Käibemaksukohustuslane alates: 21.11.2018</p>
        <p>Oleme kinnisvaraarenduse valdkonnas tegutsenud üle 7 aasta ja tegutseme Tallinna ning Harjumaa piirkonnas.</p>
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
