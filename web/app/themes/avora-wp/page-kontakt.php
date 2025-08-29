<?php 
// Get custom field values with fallbacks
$page_title = get_post_meta(get_the_ID(), 'contact_page_title', true);
$page_description = get_post_meta(get_the_ID(), 'contact_page_description', true);

// Use defaults if empty
if (empty($page_title)) {
    $page_title = 'Kontakt';
}
if (empty($page_description)) {
    $page_description = 'Võtke meiega ühendust, et arutada oma kinnisvaraprojekti või saada rohkem informatsiooni meie teenuste kohta.';
}

get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title"><?php echo esc_html($page_title); ?></h1>
        <p class="page-description"><?php echo esc_html($page_description); ?></p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            
            <!-- Company Information -->
            <div class="company-info">
                <?php
                // Get company information with fallbacks
                $company_name = get_post_meta(get_the_ID(), 'contact_company_name', true);
                $company_registry_code = get_post_meta(get_the_ID(), 'contact_company_registry_code', true);
                $company_economic_reg = get_post_meta(get_the_ID(), 'contact_company_economic_reg', true);
                $company_vat_reg = get_post_meta(get_the_ID(), 'contact_company_vat_reg', true);
                $company_email = get_post_meta(get_the_ID(), 'contact_company_email', true);
                $company_address = get_post_meta(get_the_ID(), 'contact_company_address', true);
                
                // Use defaults if empty
                if (empty($company_name)) {
                    $company_name = 'Avora Capital OÜ';
                }
                if (empty($company_registry_code)) {
                    $company_registry_code = '16741810';
                }
                if (empty($company_economic_reg)) {
                    $company_economic_reg = 'EEH013730';
                }
                if (empty($company_vat_reg)) {
                    $company_vat_reg = 'EE102691281';
                }
                if (empty($company_email)) {
                    $company_email = 'info@avora.ee';
                }
                if (empty($company_address)) {
                    $company_address = "Tartu mnt 84a,\nKesklinna linnaosa, Tallinn\nHarju maakond, 10112";
                }
                ?>
                
                <h2><?php echo esc_html($company_name); ?></h2>
                
                <div class="company-details">
                    <p><strong>Registrikood:</strong> <?php echo esc_html($company_registry_code); ?></p>
                    <p><strong>Majandustegevuse reg:</strong> <?php echo esc_html($company_economic_reg); ?></p>
                    <p><strong>KMKR:</strong> <?php echo esc_html($company_vat_reg); ?></p>
                    <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($company_email); ?>"><?php echo esc_html($company_email); ?></a></p>
                </div>
                
                <div class="company-address">
                    <h3>Aadress:</h3>
                    <p><?php echo nl2br(esc_html($company_address)); ?></p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <?php
                // Get form settings with fallbacks
                $form_title = get_post_meta(get_the_ID(), 'contact_form_title', true);
                if (empty($form_title)) {
                    $form_title = 'Saada sõnum';
                }
                ?>
                <h2><?php echo esc_html($form_title); ?></h2>
                
                <?php
                // Display success/error messages
                if (isset($_GET['contact_msg'])) {
                    $msg_key = sanitize_text_field($_GET['contact_msg']);
                    
                    // Check for success message
                    if (strpos($msg_key, 'avora_contact_success_') === 0) {
                        $success_message = get_transient($msg_key);
                        if ($success_message) {
                            delete_transient($msg_key);
                            ?>
                            <div id="contact-form" class="contact-message success-message" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                                <?php echo esc_html($success_message); ?>
                            </div>
                            <?php
                        }
                    }
                    // Check for error messages
                    elseif (strpos($msg_key, 'avora_contact_errors_') === 0) {
                        $error_messages = get_transient($msg_key);
                        if ($error_messages) {
                            delete_transient($msg_key);
                            ?>
                            <div id="contact-form" class="contact-message error-message" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                                <?php foreach ($error_messages as $error): ?>
                                    <p style="margin: 0 0 5px 0;"><?php echo esc_html($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                
                <form action="" method="post" class="form-container" id="contact-form">
                    <div class="form-group">
                        <label for="name" class="form-label">Nimi *</label>
                        <input type="text" id="name" name="name" required class="form-input" value="<?php echo esc_attr($_POST['name'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" required class="form-input" value="<?php echo esc_attr($_POST['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" id="phone" name="phone" class="form-input" value="<?php echo esc_attr($_POST['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Sõnum *</label>
                        <textarea id="message" name="message" rows="5" required class="form-textarea"><?php echo esc_textarea($_POST['message'] ?? ''); ?></textarea>
                    </div>
                    
                    <!-- Honeypot field for spam protection -->
                    <div style="position: absolute; left: -9999px;">
                        <label for="website">Website (leave empty):</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    
                    <!-- Security fields -->
                    <?php wp_nonce_field('avora_contact_form', 'avora_contact_nonce'); ?>
                    <input type="hidden" name="avora_contact_form_submit" value="1">
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Saada sõnum
                    </button>
                    
                    <p class="text-sm text-secondary mt-4">
                        * Kohustuslikud väljad<br>
                        Teie isikuandmeid kasutatakse ainult päringu töötlemiseks.
                    </p>
                </form>
            </div>
        </div>
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