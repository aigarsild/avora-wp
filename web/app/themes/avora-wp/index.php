<?php get_header(); ?>

<main class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Hello, Avora WP!</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Welcome to your new WordPress site</h2>
            <p class="text-gray-600 mb-6">
                This is a lightweight WordPress theme built with Bedrock, Vite, and Tailwind CSS. 
                You're ready to start building amazing things!
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-900 mb-2">🚀 Modern Stack</h3>
                    <p class="text-blue-700 text-sm">Built with Bedrock, Vite, and Tailwind CSS</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-900 mb-2">⚡ Fast Development</h3>
                    <p class="text-green-700 text-sm">Hot module replacement and instant builds</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-900 mb-2">🎨 Utility-First CSS</h3>
                    <p class="text-purple-700 text-sm">Tailwind CSS for rapid UI development</p>
                </div>
            </div>
        </div>

        <?php if (have_posts()) : ?>
            <div class="mt-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Latest Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="h-48 bg-gray-200">
                                    <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                
                                <div class="text-sm text-gray-500 mb-4">
                                    <?php echo get_the_date(); ?> • <?php the_author(); ?>
                                </div>
                                
                                <div class="text-gray-600">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" 
                                   class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">
                                    Read more →
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <div class="mt-8">
                    <?php the_posts_pagination([
                        'class' => 'flex justify-center space-x-2',
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
