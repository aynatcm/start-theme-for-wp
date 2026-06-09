<?php

/**
 * news_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package news_theme
 */

/**
 * Enqueue scripts and styles
 */
require_once "includes/base/scripts-and-styles.php";

/**
 * ACF (Styles)
 */
require_once "includes/features/acf.php";

/**
 * Menus
 */
require_once "includes/base/menus.php";

require_once "includes/base/vue-integration.php";

// Remove automatic <p> and <br /> from Contact Form 7
add_filter("wpcf7_autop_or_not", "__return_false");

add_theme_support("post-thumbnails");

// Resto de tus funciones (disable emojis, remove block library css, load swiper) ...
add_action("wp_enqueue_scripts", "remove_dashicons_if_not_logged_in");
function remove_dashicons_if_not_logged_in()
{
    if (!is_user_logged_in()) {
        wp_dequeue_style("dashicons");
    }
}

// Disable styles for gutenberg

function remove_block_library_css()
{
    wp_dequeue_style("wp-block-library");
    wp_dequeue_style("wp-block-library-theme");
    wp_dequeue_style("wc-block-style"); // Si usas WooCommerce
}

add_action("wp_enqueue_scripts", "remove_block_library_css", 100);

add_action(
    "wp_enqueue_scripts",
    function () {
        if (!is_user_logged_in()) {
            wp_dequeue_style("dashicons");
            wp_deregister_style("dashicons");
        }
    },
    100,
);

function load_swiper_globally()
{
    wp_enqueue_script(
        "swiper",
        "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js",
        [],
        null,
        true, // true para que lo cargue en el footer
    );
}
add_action("wp_enqueue_scripts", "load_swiper_globally");
//
