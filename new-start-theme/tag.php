<?php
get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$tag = get_queried_object();
$args = array(
    'post_type' => 'post',
    'tag_id' => $tag->term_id,
    'posts_per_page' => -1, // Mostrar todos los posts
    'paged' => $paged,
);
$the_query = new WP_Query($args);
?>

    <main class="container--tags-items">

        <div class="container--title-tags">
            <h1>Posts with the tag: <?php single_tag_title(); ?></h1>
        </div>

        <div class="container--wrapper">
            <?php if ($the_query->have_posts()) : ?>
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                    <article class="tag--item">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="item--cta-tag">
                                <?php the_post_thumbnail('full'); ?>
                            </a>
                        <?php endif; ?>
                        <h2 class="item--title-tag"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p>There are no posts with this tag.</p>
            <?php endif; ?>
        </div>

        <?php
        if ($the_query->max_num_pages > 1) :
            echo '<div class="pagination">';
            paginate_links(array(
                'total' => $the_query->max_num_pages,
                'current' => $paged,
            ));
            echo '</div>';
        endif;
        wp_reset_postdata();
        ?>

    </main>

<?php get_footer(); ?>