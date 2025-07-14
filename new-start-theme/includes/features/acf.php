<?php

/** Allow flexible content nested */
const ACF_NESTED = false;

/** Allow use only components ACF. Disable Blocks */
const ACF_ONLY_CP = false;

/** Allow modal for add components en flexible content */
const ACF_MODAL = false;


/** Use block editor only for page and gutenberg for posts */
add_filter( 'use_block_editor_for_page', '__return_false', 10 );


/** Allow use ACF blocks in gutenberg for posts */
add_action('acf/init', function(){
    if (function_exists('acf_register_block_type')){
        acf_register_block_type(array(
            'name'            => 'bk_gutenberg-cta',
            'title'           => 'Call to Action',
            'description'     => 'Block to add a CTA features',
            'mode'=> 'edit',
            'render_template' => get_stylesheet_directory() . '/ACF/blocks/template-blocks/bk_gutenberg-cta.php',
            'enqueue_style'   => get_stylesheet_directory_uri() . '/assets/sass/components/blocks/_cp-cta.scss',
            'icon'            => 'dashicons dashicons-align-full-width',
            "supports" => array (
                "anchor" => true,
                "align" => true,
                "html" => false,
                "mode" => false
            ),
        ));
    }
});


/** ACF Custom save */
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point($path)
{
    /** Set custom path */
    $path = get_stylesheet_directory() . '/ACF/acf-json';
    return $path;
}


/** ACF Custom load */
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths)
{

    /** Remove original path (optional) */
    unset($paths[0]);

    /** append path */
    $paths[] = get_stylesheet_directory() . '/ACF/acf-json';

    return $paths;
}


/** Styles admin */
add_action('acf/input/admin_enqueue_scripts', 'sp_acf_register_assets');
add_action('acf/input/admin_enqueue_scripts', 'sp_acf_enqueue_assets');


/** Register assets */
add_action('admin_enqueue_scripts', 'sp_acf_register_assets');
function sp_acf_register_assets()
{
    $screen_id = get_current_screen()->id;
    $excluded_screens = array('acf-field-group', 'acf-post-type', 'acf-taxonomy', 'acf-ui-options-page');

    /** Check if the current screen should exclude the style */
    $should_enqueue_style = !in_array($screen_id, $excluded_screens);

    /** Enqueue ACF styles if the condition is met */
    if ($should_enqueue_style) {
        $style_path = get_template_directory_uri() . '/assets/css/acf-styles.css';
        wp_enqueue_style('acf_styles', $style_path, false, filemtime(get_template_directory() . '/assets/css/acf-styles.css'));
    }

    /** Check if ACF_MODAL is true */
    if (defined('ACF_MODAL') && ACF_MODAL) {
        /** Register and enqueue styles for ACF Flexible Content */
        wp_register_style('acf-fl', get_template_directory_uri() . '/assets/css/acf-flexible-content.css', false, '1.0');
        wp_enqueue_style('acf-fl');

        /** Register and enqueue script for ACF Flexible Content */
        wp_register_script('acf-fl', get_template_directory_uri() . '/assets/js/acf-flexible-content.js', array('jquery'), '1.0', true);
        wp_enqueue_script('acf-fl');
    }
}

/** Enqueue assets */
function sp_acf_enqueue_assets()
{
    if (ACF_MODAL) {
        wp_enqueue_script('acf-fl');
        wp_enqueue_style('acf-fl');
    }

    wp_enqueue_style('acf-styles');
}

add_action(
    'admin_head',
    function () {
        echo $styles_injected = <<<HERE
		<style>
		:root {
			--icon-settings: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-gear-fill' viewBox='0 0 16 16'%3E%3Cpath d='M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z'/%3E%3C/svg%3E");
		}

		.icon-acf {
			background-repeat: no-repeat;
			background-size: contain;
			background-position: center;
			width: 22px;
			height: 15px;
			display: inline-block;
			-webkit-transition: .3s;
			-o-transition: .3s;
			transition: .3s;
			transform: scale(1.3) translate(0px, 3px);
		}

		.icon-settings {
			background-image: var(--icon-settings)
		}
	</style>
	HERE;
    }
);


/** Filter HTML anchor before save into DB */
add_filter('acf/update_value/name=html_anchor', 'filter_slug_id', 10, 1);
function filter_slug_id($field)
{
    return sp_acf_slugify($field);
}


/** Returns a slug friendly string. */
function sp_acf_slugify($str = '', $glue = '-')
{
    $raw = $str;
    $slug = str_replace(array('_', '-', '/', ' '), $glue, strtolower(remove_accents($raw)));
    $slug = preg_replace('/[^A-Za-z0-9' . preg_quote($glue) . ']/', '', $slug);

    /** Filters the slug created by acf_slugify(). */
    return apply_filters('sp_acf_slugify', $slug, $raw, $glue);
}

if (ACF_ONLY_CP) {

    /** Register blocks for ACF */
    function my_acf_block_render_callback($block)
    {

        /** convert name ("acf/nameblock") into path friendly slug ("nameblock") */
        $slug = str_replace('acf/', '', $block['name']);

        /** include a template part from within the "ACF/blocks/template-blocks" folder */
        if (file_exists(get_theme_file_path("../../ACF/blocks/template-blocks/bk_{$slug}.php"))) {
            include get_theme_file_path("../../ACF/blocks/template-blocks/bk_{$slug}.php");
        }
    }

    add_action('acf/init', 'my_acf_blocks_init');
    function my_acf_blocks_init()
    {
        foreach (glob(get_theme_file_path('../../ACF/blocks/template-blocks/*.php')) as $filename) {
            include $filename;
        }
    }
}


if (ACF_ONLY_CP) {
    /** Disabled all Blocks Gutenberg */
    add_filter('allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2);
    function wpdocs_allowed_block_types($block_editor_context, $editor_context)
    {
        if (!empty($editor_context->post)) {
            return array();
        }

        return $block_editor_context;
    }

}


add_action('admin_notices', 'sp_display_admin_notice');
function sp_display_admin_notice()
{
    ?>
    <?php if (!class_exists('ACF')) : ?>
    <div class="notice notice-warning">
        <p>The current theme <code><?php echo esc_html(wp_get_theme()->get('Name')); ?></code> works with Advanced
            Custom Fields (ACF), please install it.</p>
    </div>
<?php endif; ?>

    <?php
}


/** Add flexible content subtitles */
add_filter('acf/fields/flexible_content/layout_title/name=layout_builder', 'my_acf_fields_flexible_content_layout_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=page_builder', 'my_acf_fields_flexible_content_layout_title', 10, 4);
function my_acf_fields_flexible_content_layout_title($title, $field, $layout, $i)
{

    // load text sub field
    if ($text = get_sub_field('section_name')) {
        $title .= '<b class="acf-section-name">' . esc_html($text) . '</b>';
    }
    return $title;
}

/** Add new toolbar group in 'wysiwyg' field */
add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{
    $toolbars['Very Simple'] = array();
    $toolbars['Very Simple'][1] = array('bold', 'italic', 'underline');

    if (($key = array_search('code', $toolbars['Full'][2])) !== false) {
        unset($toolbars['Full'][2][$key]);
    }

    unset($toolbars['Basic']);

    return $toolbars;
}


/** Advanced Custom Fields Modifications */
add_action('acf/input/admin_footer', 'sp_apply_acf_modifications');
function sp_apply_acf_modifications()
{
    ?>
    <style>
        .acf-editor-wrap iframe {
            min-height: 0;
        }
    </style>
    <script>
        (function ($) {
            $('.acf-editor-wrap.delay textarea').css('height', '100px');
            acf.add_filter('wysiwyg_tinymce_settings', function (mceInit, id, $field) {
                mceInit.wp_autoresize_on = true;
                return mceInit;
            });
            acf.add_action('wysiwyg_tinymce_init', function (ed, id, mceInit, $field) {
                ed.settings.autoresize_min_height = 100;
                $('.acf-editor-wrap iframe').css('height', '100px');
            });
        })(jQuery)
    </script>
    <?php
}