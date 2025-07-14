<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package news_theme
 */

get_header();
?>

<main id="main-content" class="site-main">
	<?php
	while (have_posts()):
		the_post();

		the_content();

	endwhile; // End of the loop.
	?>

<?php include(get_template_directory() . '/ACF/acf-generate-page.php'); ?>

</main><!-- #main -->

<?php

get_footer();