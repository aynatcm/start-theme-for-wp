<?php
$infoBlog = get_field('blog_info', 'option');
$imageBlog = $infoBlog['image_bg_blog'];
$titleBlog = $infoBlog['title_blog'];
$subtitleBlog = $infoBlog['subtitle_blog'];
?>
<?php get_header() ?>
    <section class="container--blog">
        <div class="container--breadcrum">
            <div class="container--overlay"></div>
            <?php if(!empty($imageBlog)):?>
                <div class="container--video-image">
                    <img src="<?php echo $imageBlog; ?>" alt="image section" class="image--blog">
                </div>
            <?php endif?>

            <?php if(!empty($titleBlog) || !empty($subtitleBlog)):?>
                <div class="container--wrapper">
                    <div class="container--info-breadcrum">
                        <?php if(!empty($titleBlog)):?>
                            <h4 class="breadcrum--title"><?php echo $titleBlog; ?></h4>
                        <?php endif?>

                        <?php if(!empty($subtitleBlog)):?>
                            <h5 class="breadcrum--subtitle"><?php echo $subtitleBlog ?></h5>
                        <?php endif?>
                    </div>
                </div>
            <?php endif?>
        </div>

        <div class="container--wrapper">
            <?php
            $categories = get_categories([
                'taxonomy' => 'category',
                'orderby' => 'name',
                'order' => 'ASC',
            ]);

            $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

            echo '<div class="category-menu">';
            echo '<a href="?category=" class="category-item ' . (empty($selected_category) ? 'active' : '') . '" style="--index: 0;">View all</a>';

            $index = 1;

            foreach ($categories as $category) {
                $active = $selected_category == $category->slug ? 'active' : '';
                echo '<a href="?category=' . esc_attr($category->slug) . '" class="category-item ' . $active . '" style="--index: ' . $index . ';">' . esc_html($category->name) . '</a>';
                $index++;
            }

            echo '</div>';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = [
                'post_type' => 'post',
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged
            ];

            if (!empty($selected_category)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'category',
                        'field' => 'slug',
                        'terms' => $selected_category,
                    ],
                ];
            }

            $query = new WP_Query($args);
            $post_count = 0;


            if ($query->have_posts()) :
                echo '<div class="blog--posts">';
                while ($query->have_posts()) : $query->the_post();
                    $post_count++;
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
                        $total      = count( $post_tags );
                        echo '<div class="post--tags">';

                        foreach ( $post_tags as $index => $tag ) {

                            // Solo procesamos hasta la posición 4 (5 elementos)
                            if ( $index > 4 ) {
                                break;
                            }

                            $tag_link = get_tag_link( $tag->term_id );
                            $color    = get_field( 'property_color_tag', 'term_' . $tag->term_id );

                                $style = $color
                                    ? 'style="border: 1px solid ' . esc_attr( $color ) . '; color: ' . esc_attr( $color ) . ';"'
                                    : '';

                            // Si es el quinto (índice 4) y hay más tags, mostramos +N
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
                    echo '<div class="post--author"> <span class="icon--admin"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M10.0013 8.33335C11.8423 8.33335 13.3346 6.84097 13.3346 5.00002C13.3346 3.15907 11.8423 1.66669 10.0013 1.66669C8.16035 1.66669 6.66797 3.15907 6.66797 5.00002C6.66797 6.84097 8.16035 8.33335 10.0013 8.33335Z" stroke="currentColor" stroke-width="1.25"/>
<path d="M16.6673 14.5834C16.6673 16.6542 16.6673 18.3334 10.0007 18.3334C3.33398 18.3334 3.33398 16.6542 3.33398 14.5834C3.33398 12.5125 6.31898 10.8334 10.0007 10.8334C13.6823 10.8334 16.6673 12.5125 16.6673 14.5834Z" stroke="currentColor" stroke-width="1.25"/>
</svg>
</span> By ' . get_the_author() . '</div>';
                    echo '<div class="post--date"> <span class="icon--date"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M14.1667 11.6667C14.3877 11.6667 14.5996 11.5789 14.7559 11.4226C14.9122 11.2663 15 11.0543 15 10.8333C15 10.6123 14.9122 10.4004 14.7559 10.2441C14.5996 10.0878 14.3877 10 14.1667 10C13.9457 10 13.7337 10.0878 13.5774 10.2441C13.4211 10.4004 13.3333 10.6123 13.3333 10.8333C13.3333 11.0543 13.4211 11.2663 13.5774 11.4226C13.7337 11.5789 13.9457 11.6667 14.1667 11.6667ZM14.1667 15C14.3877 15 14.5996 14.9122 14.7559 14.7559C14.9122 14.5996 15 14.3877 15 14.1667C15 13.9457 14.9122 13.7337 14.7559 13.5774C14.5996 13.4211 14.3877 13.3333 14.1667 13.3333C13.9457 13.3333 13.7337 13.4211 13.5774 13.5774C13.4211 13.7337 13.3333 13.9457 13.3333 14.1667C13.3333 14.3877 13.4211 14.5996 13.5774 14.7559C13.7337 14.9122 13.9457 15 14.1667 15ZM10.8333 10.8333C10.8333 11.0543 10.7455 11.2663 10.5893 11.4226C10.433 11.5789 10.221 11.6667 10 11.6667C9.77899 11.6667 9.56702 11.5789 9.41074 11.4226C9.25446 11.2663 9.16667 11.0543 9.16667 10.8333C9.16667 10.6123 9.25446 10.4004 9.41074 10.2441C9.56702 10.0878 9.77899 10 10 10C10.221 10 10.433 10.0878 10.5893 10.2441C10.7455 10.4004 10.8333 10.6123 10.8333 10.8333ZM10.8333 14.1667C10.8333 14.3877 10.7455 14.5996 10.5893 14.7559C10.433 14.9122 10.221 15 10 15C9.77899 15 9.56702 14.9122 9.41074 14.7559C9.25446 14.5996 9.16667 14.3877 9.16667 14.1667C9.16667 13.9457 9.25446 13.7337 9.41074 13.5774C9.56702 13.4211 9.77899 13.3333 10 13.3333C10.221 13.3333 10.433 13.4211 10.5893 13.5774C10.7455 13.7337 10.8333 13.9457 10.8333 14.1667ZM5.83333 11.6667C6.05435 11.6667 6.26631 11.5789 6.42259 11.4226C6.57887 11.2663 6.66667 11.0543 6.66667 10.8333C6.66667 10.6123 6.57887 10.4004 6.42259 10.2441C6.26631 10.0878 6.05435 10 5.83333 10C5.61232 10 5.40036 10.0878 5.24408 10.2441C5.0878 10.4004 5 10.6123 5 10.8333C5 11.0543 5.0878 11.2663 5.24408 11.4226C5.40036 11.5789 5.61232 11.6667 5.83333 11.6667ZM5.83333 15C6.05435 15 6.26631 14.9122 6.42259 14.7559C6.57887 14.5996 6.66667 14.3877 6.66667 14.1667C6.66667 13.9457 6.57887 13.7337 6.42259 13.5774C6.26631 13.4211 6.05435 13.3333 5.83333 13.3333C5.61232 13.3333 5.40036 13.4211 5.24408 13.5774C5.0878 13.7337 5 13.9457 5 14.1667C5 14.3877 5.0878 14.5996 5.24408 14.7559C5.40036 14.9122 5.61232 15 5.83333 15Z" fill="currentColor"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M5.8338 1.45831C5.99956 1.45831 6.15853 1.52416 6.27574 1.64137C6.39295 1.75858 6.4588 1.91755 6.4588 2.08331V2.71915C7.01047 2.70831 7.61797 2.70831 8.2863 2.70831H11.7138C12.383 2.70831 12.9905 2.70831 13.5421 2.71915V2.08331C13.5421 1.91755 13.608 1.75858 13.7252 1.64137C13.8424 1.52416 14.0014 1.45831 14.1671 1.45831C14.3329 1.45831 14.4919 1.52416 14.6091 1.64137C14.7263 1.75858 14.7921 1.91755 14.7921 2.08331V2.77248C15.0088 2.78915 15.2141 2.81026 15.408 2.83581C16.3846 2.96748 17.1755 3.24415 17.7996 3.86748C18.423 4.49165 18.6996 5.28248 18.8313 6.25915C18.9588 7.20915 18.9588 8.42165 18.9588 9.95331V11.7133C18.9588 13.245 18.9588 14.4583 18.8313 15.4075C18.6996 16.3841 18.423 17.175 17.7996 17.7991C17.1755 18.4225 16.3846 18.6991 15.408 18.8308C14.458 18.9583 13.2455 18.9583 11.7138 18.9583H8.28797C6.7563 18.9583 5.54297 18.9583 4.5938 18.8308C3.61714 18.6991 2.8263 18.4225 2.20214 17.7991C1.5788 17.175 1.30214 16.3841 1.17047 15.4075C1.04297 14.4575 1.04297 13.245 1.04297 11.7133V9.95331C1.04297 8.42165 1.04297 7.20831 1.17047 6.25915C1.30214 5.28248 1.5788 4.49165 2.20214 3.86748C2.8263 3.24415 3.61714 2.96748 4.5938 2.83581C4.78825 2.81026 4.99352 2.78915 5.20963 2.77248V2.08331C5.20963 1.9177 5.27537 1.75885 5.3924 1.64167C5.50943 1.52448 5.66819 1.45853 5.8338 1.45831ZM4.7588 4.07498C3.9213 4.18748 3.43797 4.39915 3.08547 4.75165C2.73297 5.10415 2.5213 5.58748 2.4088 6.42498C2.38991 6.56665 2.3738 6.71637 2.36047 6.87415H17.6405C17.6271 6.71637 17.611 6.56637 17.5921 6.42415C17.4796 5.58665 17.268 5.10331 16.9155 4.75081C16.563 4.39831 16.0796 4.18665 15.2413 4.07415C14.3855 3.95915 13.2563 3.95748 11.6671 3.95748H8.3338C6.74463 3.95748 5.6163 3.95998 4.7588 4.07498ZM2.29214 9.99998C2.29214 9.28831 2.29214 8.66915 2.30297 8.12498H17.698C17.7088 8.66915 17.7088 9.28831 17.7088 9.99998V11.6666C17.7088 13.2558 17.7071 14.385 17.5921 15.2416C17.4796 16.0791 17.268 16.5625 16.9155 16.915C16.563 17.2675 16.0796 17.4791 15.2413 17.5916C14.3855 17.7066 13.2563 17.7083 11.6671 17.7083H8.3338C6.74463 17.7083 5.6163 17.7066 4.7588 17.5916C3.9213 17.4791 3.43797 17.2675 3.08547 16.915C2.73297 16.5625 2.5213 16.0791 2.4088 15.2408C2.2938 14.385 2.29214 13.2558 2.29214 11.6666V9.99998Z" fill="currentColor"/>
</svg>
</span> ' . get_the_date() . '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</article>';
                endwhile;
                echo '</div>';

            else :
                echo '<p>There is no available posts.</p>';
            endif;

            wp_reset_postdata();
            ?>
        </div>

    </section>

<?php get_footer(); ?>