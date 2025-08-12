<?php get_header(); ?>

<!-- About Hero Section -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Meist</h1>
                <p>AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte, mis loob tuleviku kodusid täna.</p>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/hero.jpg" alt="AVORA meeskond" class="hero-img">
            </div>
        </div>
    </div>
</section>

<!-- Company Story Section -->
<section class="quote-section">
    <div class="container">
        <h2>Meie lugu</h2>
        <p>AVORA sündis 2016. aastal visioonist luua Eestisse erakordset kvaliteeti omavaid elukeskkondi. Alustasime väikese meeskonnaga, kuid suure unistusega muuta kinnisvara arendamise standardeid.</p>
        <p>Esimesed aastad olid pühendatud meeskonna loomisele ja partnerlussuhete ülesehitamisele. Töötasime koos parimate arhitektide, ehitajate ja inseneridega, et luua tugev alus meie tulevikuplaanidele.</p>
        <p>2018. aastal käivitasime oma esimese suure projekti - 40-korterilise elukompleksi Tallinna südalinnas. See oli meie jaoks oluline verstapost, mis tõestas, et meie visioon võib saada reaalsuseks.</p>
        <p>Täna, pärast üle 40 edukalt lõpetatud projekti, oleme uhked selle üle, mida oleme saavutanud. Iga hoone räägib lugu kvaliteedist, täpsusest ja armastusest detailide vastu.</p>
    </div>
</section>

<!-- Our Team Section -->
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: 60px; font-size: 36px; color: var(--color-primary);">Meie meeskond</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            
            <div style="text-align: center; background: white; padding: 40px 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="width: 120px; height: 120px; background: var(--color-gray); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 48px; color: var(--color-primary);">👨‍💼</div>
                <h3 style="font-size: 24px; margin-bottom: 10px; color: var(--color-primary);">Markus Tamm</h3>
                <p style="color: var(--color-accent); font-weight: 600; margin-bottom: 15px;">Tegevjuht</p>
                <p style="font-size: 16px; line-height: 1.6; color: #666;">15 aastat kogemust kinnisvaraarenduses. Visioon ja strateegiline mõtlemine on tema tugevused.</p>
            </div>

            <div style="text-align: center; background: white; padding: 40px 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="width: 120px; height: 120px; background: var(--color-gray); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 48px; color: var(--color-primary);">👩‍🏗️</div>
                <h3 style="font-size: 24px; margin-bottom: 10px; color: var(--color-primary);">Liisa Kask</h3>
                <p style="color: var(--color-accent); font-weight: 600; margin-bottom: 15px;">Projektijuht</p>
                <p style="font-size: 16px; line-height: 1.6; color: #666;">Meister projektide koordineerimisel. Tagab, et iga detail oleks täiuslik ja ajakavas.</p>
            </div>

            <div style="text-align: center; background: white; padding: 40px 30px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="width: 120px; height: 120px; background: var(--color-gray); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 48px; color: var(--color-primary);">👨‍🎨</div>
                <h3 style="font-size: 24px; margin-bottom: 10px; color: var(--color-primary);">Andres Saar</h3>
                <p style="color: var(--color-accent); font-weight: 600; margin-bottom: 15px;">Peaarhitekt</p>
                <p style="font-size: 16px; line-height: 1.6; color: #666;">Loov visioonär, kes suudab muuta unistused tööjoonisteks ja hooneiks.</p>
            </div>
        </div>
    </div>
</section>

<!-- Philosophy Section -->
<section style="padding: 80px 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="font-size: 36px; margin-bottom: 30px; color: var(--color-primary);">Meie filosoofia</h2>
            <p style="font-size: 20px; line-height: 1.6; margin-bottom: 40px; color: #666;">
                "Kodu ei ole lihtsalt ruum - see on emotsioon, tunne, koht, kus elu toimub. Meie eesmärk on luua ruume, mis inspireerivad, rahustavad ja rikastavavad inimeste elu iga päev."
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-top: 60px;">
                <div style="text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 15px;">🏆</div>
                    <h4 style="color: var(--color-primary); margin-bottom: 10px;">Kvaliteet</h4>
                    <p style="font-size: 16px; color: #666;">Iga detail on oluline</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 15px;">🌱</div>
                    <h4 style="color: var(--color-primary); margin-bottom: 10px;">Jätkusuutlikkus</h4>
                    <p style="font-size: 16px; color: #666;">Mõtleme tulevikule</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 15px;">💡</div>
                    <h4 style="color: var(--color-primary); margin-bottom: 10px;">Innovatsioon</h4>
                    <p style="font-size: 16px; color: #666;">Uued lahendused</p>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 15px;">❤️</div>
                    <h4 style="color: var(--color-primary); margin-bottom: 10px;">Kiindums</h4>
                    <p style="font-size: 16px; color: #666;">Armastus töö vastu</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="feature">
    <div class="container">
        <div class="feature-content">
            <div class="feature-image">
                <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Meie väärtused" class="circle-image">
            </div>
            <div class="feature-text">
                <h2>Meie väärtused</h2>
                <ul style="font-size: 18px; line-height: 1.6; list-style: none; padding: 0;">
                    <li style="margin-bottom: 15px;"><strong>Kvaliteet:</strong> Kasutame ainult parimaid materjale ja töötame tunnustatud partneritega.</li>
                    <li style="margin-bottom: 15px;"><strong>Täpsus:</strong> Iga detail on läbi mõeldud ja hoolikalt teostatud.</li>
                    <li style="margin-bottom: 15px;"><strong>Jätkusuutlikkus:</strong> Ehitame kodusid, mis kestavad põlvkondade vältel.</li>
                    <li style="margin-bottom: 15px;"><strong>Innovatsioon:</strong> Kasutame uuenduslikke ehitusmeetodeid ja lahendusi.</li>
                </ul>
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
                <p>Teostatud projekti</p>
            </div>
            <div class="stat-item">
                <h3>7+</h3>
                <p>Aastat kogemust</p>
            </div>
            <div class="stat-item">
                <h3>87+</h3>
                <p>Rahul klienti</p>
            </div>
        </div>
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
