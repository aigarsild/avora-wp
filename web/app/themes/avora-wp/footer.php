<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-left">
                <div class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/avora-logo-white.svg" alt="<?php bloginfo('name'); ?> Logo" class="logo-img">
                </div>
                <p>
                    <div class="contact-icon-wrapper">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/map-icon.svg" alt="Asukoht" class="contact-icon">
                    </div>
                    <span class="contact-text">Tartu mnt 84a, Kesklinna linnaosa, Tallinn, Harju maakond, 10112</span>
                </p>
            </div>
            <div class="footer-right">
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61566708334193" class="social-link" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/facebook-icon.svg" alt="Facebook" class="social-icon">
                    </a>
                    <a href="https://www.instagram.com/mannisalu_kodud/" class="social-link" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/instagram-icon.svg" alt="Instagram" class="social-icon">
                    </a>
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
