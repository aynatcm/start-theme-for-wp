<?php
get_header();

$content = get_the_content();
$author_id = get_post_field('post_author', get_the_ID());
$author_name = get_the_author_meta('display_name', $author_id);
?>

<section class="blog-content">
    <div class="container--breadcrum">
        <div class="container--overlay"></div>
        <?php if(!empty(get_the_post_thumbnail())):?>
            <div class="container--video-image">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title_attribute(); ?>" class="image--blog">
            </div>
        <?php endif?>

        <div class="container--wrapper">
            <div class="container--info-breadcrum">
                <div class="title--categories-post">
                    <div class="single-categories">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category--post" alt="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a> ';
                            }
                        }
                        ?>
                    </div>
                    <h4 class="breadcrum--title"><?php echo get_the_title(get_queried_object_id()); ?></h4>
                </div>
                <div class="avatar--name-post">
                    <div class="post--author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
                    </div>
                    <div class="post--author-name">
                        <span class="author--name">Post by
                            <span>
                                <?php echo $author_name ?>
                            </span>
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container--wrapper blog--detail-info">

        <div class="info--detail">
            <?php echo do_blocks($content); ?>

            <?php if (!empty(get_the_tags())): ?>
                <div class="container--tags-blog">
                    <span class="title--tags">Popular tags</span>
                    <hr>
                    <div class="tags--item">
                        <?php
                        $tags = get_the_tags();
                        if ($tags) :
                            foreach ($tags as $tag) : ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="post--tag">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach;
                        else : ?>
                            <span class="no-tags">No tags</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif ?>

        </div>

        <div class="sidebar--blog">
            <div class="container--share-blog">
                <span class="title--share">Share</span>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                           target="_blank" aria-label="Share on Facebook">
                            <svg width="11" height="22" viewBox="0 0 11 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_223_2636)">
                                    <path d="M2.72963 22V11.677H0V7.96017H2.72963V4.78555C2.72963 2.2909 4.34203 0 8.05735 0C9.56162 0 10.674 0.14421 10.674 0.14421L10.5863 3.61506C10.5863 3.61506 9.4519 3.60402 8.21399 3.60402C6.87419 3.60402 6.65953 4.22145 6.65953 5.24623V7.96017H10.6928L10.5173 11.677H6.65953V22H2.72963Z"
                                          fill="currentColor"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_223_2636">
                                        <rect width="10.6929" height="22" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" aria-label="Share on Twitter">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M21.6732 4.52558C20.9078 4.86475 20.0855 5.09392 19.2211 5.1975C20.113 4.66381 20.7803 3.82384 21.0985 2.83433C20.2605 3.33207 19.3434 3.68243 18.387 3.87017C17.7438 3.18346 16.8919 2.7283 15.9636 2.57535C15.0352 2.4224 14.0824 2.58022 13.2529 3.02431C12.4235 3.4684 11.7638 4.17391 11.3764 5.03131C10.989 5.88871 10.8955 6.85002 11.1105 7.766C9.4125 7.68075 7.75145 7.23942 6.2351 6.47066C4.71874 5.70191 3.38098 4.6229 2.30862 3.30367C1.94196 3.93617 1.73113 4.6695 1.73113 5.4505C1.73072 6.15358 1.90385 6.84589 2.23518 7.466C2.56651 8.08612 3.04577 8.61487 3.63046 9.00533C2.95238 8.98376 2.28926 8.80054 1.69629 8.47092V8.52592C1.69622 9.51201 2.03732 10.4678 2.66171 11.231C3.2861 11.9942 4.15532 12.5179 5.12188 12.7133C4.49284 12.8835 3.83335 12.9086 3.19321 12.7866C3.46591 13.6351 3.99712 14.377 4.71246 14.9086C5.4278 15.4402 6.29147 15.7347 7.18254 15.7511C5.66989 16.9385 3.80177 17.5827 1.87871 17.5798C1.53806 17.5799 1.19769 17.56 0.859375 17.5203C2.81139 18.7753 5.08369 19.4414 7.40438 19.4388C15.2602 19.4388 19.5548 12.9323 19.5548 7.28933C19.5548 7.106 19.5502 6.92083 19.542 6.7375C20.3773 6.13339 21.0984 5.38532 21.6714 4.52833L21.6732 4.52558Z"
                                      fill="currentColor"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/shareArticle?url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" aria-label="Share on LinkedIn">
                            <svg width="24" height="22" viewBox="0 0 24 22" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.22471 22V7.15664H0.291082V22H5.22471ZM2.75853 5.12881C4.47898 5.12881 5.54987 3.98901 5.54987 2.56465C5.51782 1.10816 4.47904 0 2.79118 0C1.10359 0 0 1.10818 0 2.56465C0 3.98908 1.07063 5.12881 2.72633 5.12881H2.75853ZM7.95546 22H12.8891V13.7107C12.8891 13.2671 12.9211 12.8239 13.0514 12.5068C13.4081 11.6205 14.2199 10.7024 15.5827 10.7024C17.368 10.7024 18.0822 12.0636 18.0822 14.059V21.9999H23.0155V13.4888C23.0155 8.92955 20.5816 6.80816 17.3355 6.80816C14.674 6.80816 13.5055 8.29584 12.8563 9.30909H12.8892V7.15633H7.95557C8.02031 8.54915 7.95546 22 7.95546 22Z"
                                      fill="currentColor"/>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                           target="_blank" aria-label="Share on Pinterest">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_223_2643)">
                                    <path d="M0 10C0 14.2692 2.67583 17.9142 6.44167 19.3483C6.35 18.5675 6.2525 17.28 6.4625 16.3767C6.64333 15.6 7.63 11.4283 7.63 11.4283C7.63 11.4283 7.3325 10.8325 7.3325 9.95C7.3325 8.56667 8.13417 7.53333 9.13333 7.53333C9.98333 7.53333 10.3933 8.17083 10.3933 8.935C10.3933 9.78917 9.84917 11.0658 9.56833 12.25C9.33417 13.2408 10.0658 14.0492 11.0425 14.0492C12.8117 14.0492 14.1725 12.1833 14.1725 9.49C14.1725 7.10583 12.4592 5.44 10.0133 5.44C7.18167 5.44 5.51917 7.56417 5.51917 9.76C5.51917 10.6158 5.84833 11.5325 6.26 12.0317C6.2951 12.0694 6.3199 12.1155 6.33201 12.1655C6.34412 12.2156 6.34314 12.2679 6.32917 12.3175C6.25333 12.6325 6.085 13.3083 6.0525 13.4467C6.00833 13.6283 5.90833 13.6675 5.71917 13.5792C4.47583 13.0008 3.69917 11.1833 3.69917 9.72333C3.69917 6.5825 5.98 3.69917 10.2758 3.69917C13.7292 3.69917 16.4133 6.16 16.4133 9.44833C16.4133 12.8792 14.2508 15.6408 11.2475 15.6408C10.2383 15.6408 9.29083 15.1158 8.96583 14.4967C8.96583 14.4967 8.46667 16.3983 8.34583 16.8633C8.11083 17.7667 7.45917 18.91 7.055 19.5592C7.98667 19.8458 8.975 20 10 20C15.5225 20 20 15.5225 20 10C20 4.4775 15.5225 0 10 0C4.4775 0 0 4.4775 0 10Z"
                                          fill="currentColor"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_223_2643">
                                        <rect width="20" height="20" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
                           target="_blank" aria-label="Share on WhatsApp">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.1933 14.7241C14.8994 7.18813 8.80919 1.1006 1.27607 0.806932C0.992787 0.795884 0.759442 1.02348 0.760547 1.30699L0.766513 2.81423C0.767396 3.0847 0.982843 3.30589 1.25309 3.3176C7.43144 3.58807 12.4123 8.56765 12.6828 14.7473C12.6945 15.0176 12.9159 15.2328 13.1862 15.2339L14.6934 15.2399C14.9767 15.2407 15.2043 15.0074 15.1933 14.7241ZM3.87889 12.1213C3.09776 11.3402 1.83159 11.3402 1.05046 12.1213C0.269328 12.9024 0.269328 14.1686 1.05046 14.9497C1.83159 15.7309 3.09776 15.7309 3.87889 14.9497C4.66002 14.1686 4.66002 12.9024 3.87889 12.1213ZM10.2044 14.7526C9.90984 9.95336 6.04153 6.0899 1.24757 5.79579C0.960304 5.77811 0.721435 6.00726 0.723424 6.29474L0.733367 7.80685C0.735135 8.07024 0.939754 8.29254 1.20293 8.31177C4.66157 8.56323 7.43762 11.3464 7.6882 14.797C7.70743 15.0602 7.9295 15.2651 8.19312 15.2666L9.70523 15.2765C9.99293 15.2788 10.2221 15.0394 10.2044 14.7526Z"
                                      fill="currentColor"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="container--top-related">
                <span class="title--related">Top related</span>
                <div class="container--related-posts">
                    <?php
                    $current_post_id = get_the_ID();
                    $related_posts = new WP_Query([
                        'posts_per_page' => 4,
                        'post__not_in' => [$current_post_id],
                        'orderby' => 'rand',
                    ]);

                    if ($related_posts->have_posts()) :
                        while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <div class="related--post-item">
                                <a href="<?php the_permalink(); ?>" class="related--post-link">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="related--post-image">
                                            <?php the_post_thumbnail('full'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <span class="related--post-title"><?php the_title(); ?></span>
                                </a>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>

    <div class="container--form-cta">
        <div class="container--wrapper">
            <div class="info--titles-form">
                <h4 class="title--form-cta">Stay connected with us</h4>
                <p class="description--form-cta">Get the latest updates, expert tips, and exclusive offers delivered
                    straight to your inbox. Don’t
                    miss out on the best of real estate, lifestyle, and more.</p>
            </div>

            <div class="form--cta">
                <?php echo do_shortcode('[ninja_form id=6]') ?>
            </div>
        </div>
    </div>

    <div class="container--wrapper container--related-links">
        <h4 class="title--links">Links</h4>
        <h5 class="title--stories">Latest Blogs</h5>

        <div class="container--latest-story">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                echo '<div class="blog--posts">';
                while ($query->have_posts()) : $query->the_post();
                    echo '<article class="blog--item">';

                    echo '<div class="post--image">';
                    if (has_post_thumbnail()) {
                        echo '<a href="' . get_permalink() . '">';
                        the_post_thumbnail('full');
                        echo '</a>';
                    }
                    echo '</div>';

                    echo '<div class="post--content">';

                    echo '<h4 class="title--post"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';

                    $post_tags = get_the_tags();
                    if ( $post_tags ) {
                        $total = count( $post_tags );
                        echo '<div class="post--tags">';

                        foreach ( $post_tags as $index => $tag ) {
                            // Solo hasta 5 tags
                            if ( $index > 4 ) {
                                break;
                            }

                            $tag_link = get_tag_link( $tag->term_id );
                            $color    = get_field( 'property_color_tag', 'term_' . $tag->term_id );
                            // Lógica de colores intacta
                            $style = $color
                                ? 'style="border: 1px solid ' . esc_attr( $color ) . '; color: ' . esc_attr( $color ) . ';"'
                                : '';

                            // Si es el quinto tag (índice 4) y hay más, mostramos "+N"
                            if ( $index === 4 && $total > 5 ) {
                                $label = '+' . ( $total - 5 );
                            } else {
                                $label = esc_html( $tag->name );
                            }

                            echo '<a href="' . esc_url( $tag_link ) . '" class="tag--item" ' . $style . '>'
                                . $label .
                                '</a>';
                        }

                        echo '</div>';
                    }

                    echo '<div class="date--author">';
                    echo '<div class="post--author"> <span class="icon--admin"><svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8.0013 7.83329C9.84225 7.83329 11.3346 6.34091 11.3346 4.49996C11.3346 2.65901 9.84225 1.16663 8.0013 1.16663C6.16035 1.16663 4.66797 2.65901 4.66797 4.49996C4.66797 6.34091 6.16035 7.83329 8.0013 7.83329Z" stroke="#777472" stroke-width="1.25"/>
<path d="M14.6673 14.0833C14.6673 16.1541 14.6673 17.8333 8.00065 17.8333C1.33398 17.8333 1.33398 16.1541 1.33398 14.0833C1.33398 12.0124 4.31898 10.3333 8.00065 10.3333C11.6823 10.3333 14.6673 12.0124 14.6673 14.0833Z" stroke="#777472" stroke-width="1.25"/>
</svg>
</span> By ' . get_the_author() . '</div>';
                    echo '<div class="post--date"> <span class="icon--date"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.1667 12.1667C14.3877 12.1667 14.5996 12.0789 14.7559 11.9226C14.9122 11.7663 15 11.5543 15 11.3333C15 11.1123 14.9122 10.9004 14.7559 10.7441C14.5996 10.5878 14.3877 10.5 14.1667 10.5C13.9457 10.5 13.7337 10.5878 13.5774 10.7441C13.4211 10.9004 13.3333 11.1123 13.3333 11.3333C13.3333 11.5543 13.4211 11.7663 13.5774 11.9226C13.7337 12.0789 13.9457 12.1667 14.1667 12.1667ZM14.1667 15.5C14.3877 15.5 14.5996 15.4122 14.7559 15.2559C14.9122 15.0996 15 14.8877 15 14.6667C15 14.4457 14.9122 14.2337 14.7559 14.0774C14.5996 13.9211 14.3877 13.8333 14.1667 13.8333C13.9457 13.8333 13.7337 13.9211 13.5774 14.0774C13.4211 14.2337 13.3333 14.4457 13.3333 14.6667C13.3333 14.8877 13.4211 15.0996 13.5774 15.2559C13.7337 15.4122 13.9457 15.5 14.1667 15.5ZM10.8333 11.3333C10.8333 11.5543 10.7455 11.7663 10.5893 11.9226C10.433 12.0789 10.221 12.1667 10 12.1667C9.77899 12.1667 9.56702 12.0789 9.41074 11.9226C9.25446 11.7663 9.16667 11.5543 9.16667 11.3333C9.16667 11.1123 9.25446 10.9004 9.41074 10.7441C9.56702 10.5878 9.77899 10.5 10 10.5C10.221 10.5 10.433 10.5878 10.5893 10.7441C10.7455 10.9004 10.8333 11.1123 10.8333 11.3333ZM10.8333 14.6667C10.8333 14.8877 10.7455 15.0996 10.5893 15.2559C10.433 15.4122 10.221 15.5 10 15.5C9.77899 15.5 9.56702 15.4122 9.41074 15.2559C9.25446 15.0996 9.16667 14.8877 9.16667 14.6667C9.16667 14.4457 9.25446 14.2337 9.41074 14.0774C9.56702 13.9211 9.77899 13.8333 10 13.8333C10.221 13.8333 10.433 13.9211 10.5893 14.0774C10.7455 14.2337 10.8333 14.4457 10.8333 14.6667ZM5.83333 12.1667C6.05435 12.1667 6.26631 12.0789 6.42259 11.9226C6.57887 11.7663 6.66667 11.5543 6.66667 11.3333C6.66667 11.1123 6.57887 10.9004 6.42259 10.7441C6.26631 10.5878 6.05435 10.5 5.83333 10.5C5.61232 10.5 5.40036 10.5878 5.24408 10.7441C5.0878 10.9004 5 11.1123 5 11.3333C5 11.5543 5.0878 11.7663 5.24408 11.9226C5.40036 12.0789 5.61232 12.1667 5.83333 12.1667ZM5.83333 15.5C6.05435 15.5 6.26631 15.4122 6.42259 15.2559C6.57887 15.0996 6.66667 14.8877 6.66667 14.6667C6.66667 14.4457 6.57887 14.2337 6.42259 14.0774C6.26631 13.9211 6.05435 13.8333 5.83333 13.8333C5.61232 13.8333 5.40036 13.9211 5.24408 14.0774C5.0878 14.2337 5 14.4457 5 14.6667C5 14.8877 5.0878 15.0996 5.24408 15.2559C5.40036 15.4122 5.61232 15.5 5.83333 15.5Z" fill="#777472"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M5.8338 1.95837C5.99956 1.95837 6.15853 2.02422 6.27574 2.14143C6.39295 2.25864 6.4588 2.41761 6.4588 2.58337V3.21921C7.01047 3.20837 7.61797 3.20837 8.2863 3.20837H11.7138C12.383 3.20837 12.9905 3.20837 13.5421 3.21921V2.58337C13.5421 2.41761 13.608 2.25864 13.7252 2.14143C13.8424 2.02422 14.0014 1.95837 14.1671 1.95837C14.3329 1.95837 14.4919 2.02422 14.6091 2.14143C14.7263 2.25864 14.7921 2.41761 14.7921 2.58337V3.27254C15.0088 3.28921 15.2141 3.31032 15.408 3.33587C16.3846 3.46754 17.1755 3.74421 17.7996 4.36754C18.423 4.99171 18.6996 5.78254 18.8313 6.75921C18.9588 7.70921 18.9588 8.92171 18.9588 10.4534V12.2134C18.9588 13.745 18.9588 14.9584 18.8313 15.9075C18.6996 16.8842 18.423 17.675 17.7996 18.2992C17.1755 18.9225 16.3846 19.1992 15.408 19.3309C14.458 19.4584 13.2455 19.4584 11.7138 19.4584H8.28797C6.7563 19.4584 5.54297 19.4584 4.5938 19.3309C3.61714 19.1992 2.8263 18.9225 2.20214 18.2992C1.5788 17.675 1.30214 16.8842 1.17047 15.9075C1.04297 14.9575 1.04297 13.745 1.04297 12.2134V10.4534C1.04297 8.92171 1.04297 7.70837 1.17047 6.75921C1.30214 5.78254 1.5788 4.99171 2.20214 4.36754C2.8263 3.74421 3.61714 3.46754 4.5938 3.33587C4.78825 3.31032 4.99352 3.28921 5.20963 3.27254V2.58337C5.20963 2.41776 5.27537 2.25891 5.3924 2.14173C5.50943 2.02454 5.66819 1.95859 5.8338 1.95837ZM4.7588 4.57504C3.9213 4.68754 3.43797 4.89921 3.08547 5.25171C2.73297 5.60421 2.5213 6.08754 2.4088 6.92504C2.38991 7.06671 2.3738 7.21643 2.36047 7.37421H17.6405C17.6271 7.21643 17.611 7.06643 17.5921 6.92421C17.4796 6.08671 17.268 5.60337 16.9155 5.25087C16.563 4.89837 16.0796 4.68671 15.2413 4.57421C14.3855 4.45921 13.2563 4.45754 11.6671 4.45754H8.3338C6.74463 4.45754 5.6163 4.46004 4.7588 4.57504ZM2.29214 10.5C2.29214 9.78837 2.29214 9.16921 2.30297 8.62504H17.698C17.7088 9.16921 17.7088 9.78837 17.7088 10.5V12.1667C17.7088 13.7559 17.7071 14.885 17.5921 15.7417C17.4796 16.5792 17.268 17.0625 16.9155 17.415C16.563 17.7675 16.0796 17.9792 15.2413 18.0917C14.3855 18.2067 13.2563 18.2084 11.6671 18.2084H8.3338C6.74463 18.2084 5.6163 18.2067 4.7588 18.0917C3.9213 17.9792 3.43797 17.7675 3.08547 17.415C2.73297 17.0625 2.5213 16.5792 2.4088 15.7409C2.2938 14.885 2.29214 13.7559 2.29214 12.1667V10.5Z" fill="#777472"/>
</svg>
</span> ' . get_the_date() . '</div>';
                    echo '</div>';

                    echo '</div>';

                    echo '</article>';
                endwhile;
                echo '</div>';
            else :
                echo 'No hay publicaciones disponibles.';
            endif;

            wp_reset_postdata();
            ?>
        </div>
    </div>


</section>

<?php
get_footer();
?>
