<?php get_header(); ?>

<main class="py-section bg-brand-white min-h-screen flex items-center">
    <div class="container">
        <div class="max-w-2xl mx-auto text-center">
            <h1 class="text-h1 text-brand-primary mb-lg">404</h1>
            <h2 class="text-h2 text-brand-primary mb-xl">Lehte ei leitud</h2>
            <p class="text-large text-brand-primary opacity-80 mb-xxxl">
                Kahjuks ei leidnud me otsitavat lehte. Võimalik, et leht on teisaldatud või kustutatud.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-md justify-center">
                <a href="<?php echo home_url(); ?>" class="btn btn-primary">
                    Tagasi avalehele
                </a>
                <a href="mailto:info@avora.ee" class="btn btn-outline">
                    Võta ühendust
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
