<?php get_header(); ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Loome väärtust, läbi kinnisvara</h1>
                    <p>Kaasaegne arhitektuur, kõrge ehituskvaliteet ja personaalsus - AVORA kaudu sünnivad kodud, mis peegeldavad Teie lugu.</p>
                    <button class="btn btn-outline" style="display: none;">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icons/env-icon.svg" alt="Keskkond" class="btn-icon">
                        Tutvuge projektidega
                    </button>
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
        <div class="container">
            <h2>AVORA on Eesti kapitalil põhinev kinnisvaraarendus ettevõte</h2>
            <p>Tegeleme eluhoonete ehitusega, mille tulemusena loodakse detailideni läbimõeldud elukeskkonnad Tallinnas ning Harjumaal.</p>
        </div>
    </section>

    <!-- Feature Section -->
    <section class="feature">
        <div class="container">
            <div class="feature-content">
                <div class="feature-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/section.jpg" alt="Sisekujundus" class="circle-image">
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

<?php get_footer(); ?>