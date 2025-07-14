<?php
function __PHP_SAFE_NAME___theme_scripts()
{
    // CALLING STYLES
    wp_enqueue_style(
        '__PROJECT_NAME__-style',
        get_template_directory_uri() . '/assets/dist/css/main.css',
        array(),
        filemtime(get_template_directory() . '/assets/dist/css/main.css'),
        'all'
    );

    // CALLING JAVASCRIPT
    wp_enqueue_script(
        '__PROJECT_NAME__-script',
        get_template_directory_uri() . '/assets/dist/js/main.js',
        array('jquery'),
        filemtime(get_template_directory() . '/assets/dist/js/main.js'),
        true
    );
}

add_action('wp_enqueue_scripts', '__PHP_SAFE_NAME___theme_scripts');

/** Disabled Gutenberg Blocks edit only pages */
add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);
function prefix_disable_gutenberg($current_status, $post_type)
{
    if ('page' === $post_type) {
        return false;
    }
    return $current_status;
}

/** Disabled HTML editor */
add_action('init', 'my_remove_editor_from_post_type');
function my_remove_editor_from_post_type()
{
    remove_post_type_support('page', 'editor');
}

/** Allow SVG files */
function enable_svg_upload($upload_mimes)
{
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';
    return $upload_mimes;
}

add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

// Allow custom logo
add_theme_support('custom-logo');
add_theme_support( 'title-tag' );
    
