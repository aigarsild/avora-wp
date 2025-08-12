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
        <p>AVORA on Tallinna kapitalipõhine kinnisvaraarenduse ettevõte, kes tegeleb peamiselt elamuehitusega. Loome tähelepanelikult läbimõeldud elukeskkondi Tallinna ja Harju maakonna piirkonnas.</p>
        <p>Kasutame kvaliteetseid materjale ning uuenduslikke ehitusmeetodeid, et ehitada kodusid, mis kestavad põlvkondade vältel. Meie jaoks on oluline kvaliteet ja täpsus igas projekti etapis.</p>
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
