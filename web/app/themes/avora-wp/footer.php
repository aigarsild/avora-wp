<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
                <div class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/avora-logo-white.svg" alt="<?php bloginfo('name'); ?> Logo" class="logo-img">
                </div>
                <p>&nbsp;</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61566708334193" class="social-link" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/facebook-icon.svg" alt="Facebook" class="social-icon">
                    </a>
                    <a href="https://www.instagram.com/mannisalu_kodud/" class="social-link" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/instagram-icon.svg" alt="Instagram" class="social-icon">
                    </a>
                </div>
            </div>
            <div class="footer-right">
                <div class="contact-info">
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/phone-icon.svg" alt="Telefon" class="contact-icon">
                        +372 5084851
                    </p>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail-icon.svg" alt="E-post" class="contact-icon">
                        <a href="mailto:info@avora.ee" class="link-white">info@avora.ee</a>
                    </p>
                    <p>
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/map-icon.svg" alt="Asukoht" class="contact-icon">
                        Tartu mnt 84a, Kesklinna linnaosa, Tallinn, Harju maakond, 10112
                    </p>

                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?>. Kõik õigused kaitstud.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
