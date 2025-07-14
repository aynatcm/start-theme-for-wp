<?php get_header(); ?>

<main class="container--items-category">
    <div class="container--title-category">
        <h1>Posts with the category: <?php single_cat_title(); ?></h1>
    </div>

    <div class="container--wrapper">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article class="category--item">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="category--cta-item">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    <?php endif; ?>
                    <h2 class="item--title-category"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>There is no posts with this category.</p>
        <?php endif; ?>
    </div>

</main>

<?php get_footer(); ?>
