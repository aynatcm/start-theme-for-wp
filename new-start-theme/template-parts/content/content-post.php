<?php get_header() ?>

    <section class="container--blog">
        <div class="container--breadcrum">
            <div class="container--video-image">
                <div class="container--overlay">
                </div>
                <img src="<?php echo get_template_directory_uri() . '/assets/images/blog.jpeg'; ?>" alt="image blog"
                     class="image--breadcrum">

                <div class="container--wrapper">
                    <div class="container--info-breadcrum">
                        <h4 class="breadcrum--title"><?php echo the_title() ?></h4>
                        <h5 class="breadcrum--subtitle">Development</h5>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php
// Obtener las categorías del blog
$categories = get_categories([
    'taxonomy' => 'category', // Cambia 'category' si usas un custom taxonomy
    'orderby' => 'name',
    'order' => 'ASC',
]);

// Verificar si hay una categoría seleccionada a través del parámetro GET
$selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

// Formulario de filtro de categorías
echo '<form method="GET" class="blog-filter-form">';
echo '<select name="category" onchange="this.form.submit()">';
echo '<option value="">All Categories</option>';

foreach ($categories as $category) {
    $selected = $selected_category == $category->slug ? 'selected' : '';
    echo '<option value="' . esc_attr($category->slug) . '" ' . $selected . '>';
    echo esc_html($category->name) . '</option>';
}

echo '</select>';
echo '</form>';

// Parámetros del query de posts
$args = [
    'post_type' => 'post', // Cambia 'post' si es un custom post type
    'posts_per_page' => 10, // Número de posts a mostrar
    'orderby' => 'date',
    'order' => 'DESC',
];

// Agregar el filtro de categoría si está seleccionado
if (!empty($selected_category)) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $selected_category,
        ],
    ];
}

// El loop personalizado
$query = new WP_Query($args);

if ($query->have_posts()) :
    echo '<div class="blog-posts">';
    while ($query->have_posts()) : $query->the_post();
        echo '<article class="blog-post">';
        echo '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
        if (has_post_thumbnail()) {
            echo '<a href="' . get_permalink() . '">';
            the_post_thumbnail('medium');
            echo '</a>';
        }
        echo '<p>' . get_the_excerpt() . '</p>';
        echo '<a href="' . get_permalink() . '">Leer más</a>';
        echo '</article>';
    endwhile;
    echo '</div>';
else :
    echo '<p>No hay entradas disponibles.</p>';
endif;

// Restaurar datos originales del post
wp_reset_postdata();
?>
<?php get_footer() ?>