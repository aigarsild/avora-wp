<?php get_header(); ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Kontakt</h1>
        <p class="page-description">Võtke meiega ühendust, et arutada oma kinnisvaraprojekti või saada rohkem informatsiooni meie teenuste kohta.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            
            <!-- Company Information -->
            <div class="company-info">
                <h2>Avora Capital OÜ</h2>
                
                <div class="company-details">
                    <p><strong>Registrikood:</strong> 16741810</p>
                    <p><strong>Majandustegevuse reg:</strong> EEH013730</p>
                    <p><strong>KMKR:</strong> EE102691281</p>
                </div>
                
                <div class="company-address">
                    <h3>Aadress:</h3>
                    <p>
                        Tartu mnt 84a,<br>
                        Kesklinna linnaosa, Tallinn<br>
                        Harju maakond, 10112
                    </p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2>Saada sõnum</h2>
                
                <form action="#" method="post" class="form-container">
                    <div class="form-group">
                        <label for="name" class="form-label">Nimi *</label>
                        <input type="text" id="name" name="name" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" name="email" required class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefon</label>
                        <input type="tel" id="phone" name="phone" class="form-input">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Sõnum *</label>
                        <textarea id="message" name="message" rows="5" required class="form-textarea"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Saada sõnum
                    </button>
                    
                    <p class="text-sm text-secondary mt-4">
                        * Kohustuslikud väljad<br>
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