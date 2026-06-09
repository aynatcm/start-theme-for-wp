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

/** Allow SVG files — solo para administradores */
function enable_svg_upload($upload_mimes)
{
    if (current_user_can('manage_options')) {
        $upload_mimes['svg']  = 'image/svg+xml';
        $upload_mimes['svgz'] = 'image/svg+xml';
    }
    return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

/**
 * Sanitiza archivos SVG antes de guardarlos en el servidor.
 * Elimina elementos y atributos peligrosos usando DOMDocument + DOMXPath.
 * Se ejecuta antes de que WordPress mueva el archivo al directorio de uploads.
 */
function sanitize_svg_on_upload($file)
{
    if (!isset($file['tmp_name']) || !isset($file['type'])) {
        return $file;
    }

    $is_svg = ($file['type'] === 'image/svg+xml')
        || (isset($file['name']) && strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) === 'svg');

    if (!$is_svg) {
        return $file;
    }

    $content = file_get_contents($file['tmp_name']);
    if ($content === false) {
        $file['error'] = 'No se pudo leer el archivo SVG.';
        return $file;
    }

    // Elementos peligrosos a eliminar
    $dangerous_tags = [
        'script', 'iframe', 'object', 'embed', 'base',
        'foreignObject', 'animate', 'set',
    ];

    // Atributos de evento peligrosos (patrón)
    $dangerous_attr_patterns = [
        '/^on\w+/i',          // onload, onclick, onerror, etc.
        '/^xlink:href/i',     // puede apuntar a javascript:
        '/^href/i',
    ];

    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $loaded = $dom->loadXML($content, LIBXML_NONET);
    libxml_clear_errors();

    if (!$loaded) {
        $file['error'] = 'El archivo SVG no es XML válido y no pudo procesarse.';
        return $file;
    }

    // Eliminar tags peligrosos
    foreach ($dangerous_tags as $tag) {
        $nodes = $dom->getElementsByTagName($tag);
        foreach (iterator_to_array($nodes) as $node) {
            $node->parentNode->removeChild($node);
        }
    }

    // Eliminar atributos peligrosos en todos los elementos
    $xpath = new DOMXPath($dom);
    $all_elements = $xpath->query('//*');
    foreach ($all_elements as $element) {
        if (!$element instanceof DOMElement) {
            continue;
        }
        $attrs_to_remove = [];
        foreach ($element->attributes as $attr) {
            foreach ($dangerous_attr_patterns as $pattern) {
                if (preg_match($pattern, $attr->name)) {
                    $attrs_to_remove[] = $attr->name;
                    break;
                }
            }
            // Bloquear javascript: y data:text/html en cualquier valor
            if (preg_match('/(javascript:|data:\s*text\/html)/i', $attr->value)) {
                $attrs_to_remove[] = $attr->name;
            }
        }
        foreach ($attrs_to_remove as $attr_name) {
            $element->removeAttribute($attr_name);
        }
    }

    $sanitized = $dom->saveXML();
    file_put_contents($file['tmp_name'], $sanitized);

    return $file;
}
add_filter('wp_handle_upload_prefilter', 'sanitize_svg_on_upload');

// Allow custom logo
add_theme_support('custom-logo');
add_theme_support( 'title-tag' );
    
