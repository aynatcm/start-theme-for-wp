<?php

register_nav_menus(
	array(
		'menu-1' => esc_html__( 'Primary', 'news-theme' ),
		'menu-2' => esc_html__( 'Secondary', 'news-theme' ),
		'menu-3' => esc_html__( 'Sidebar', 'news-theme' ),
	)
);

// /** Calling menu.js file */
// function menu() {
//     wp_enqueue_script( 'menu_script', get_stylesheet_directory_uri() . '/assets/js/menu.js', array(), '1.0.0', true );
// }
// add_action( 'wp_enqueue_scripts', 'menu' );
