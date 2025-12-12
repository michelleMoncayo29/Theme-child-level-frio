<?php
/**
 * ACF Blocks Registration
 *
 * @package Theme_Child
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registrar bloques ACF
 */
function theme_child_register_acf_blocks() {
    // Verificar que ACF Pro está activo
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // Directorio de bloques
    $blocks_dir = get_stylesheet_directory() . '/blocks/';
    
    // Obtener todos los bloques disponibles
    $blocks = array_filter(glob($blocks_dir . '*'), 'is_dir');
    
    // Registrar cada bloque
    foreach ($blocks as $block) {
        $block_json = $block . '/block.json';
        
        if (file_exists($block_json)) {
            register_block_type($block);
        }
    }
}
add_action('init', 'theme_child_register_acf_blocks');

/**
 * Registrar categoría personalizada para bloques
 */
function theme_child_block_categories($categories, $post) {
    return array_merge(
        array(
            array(
                'slug'  => 'theme-child-blocks',
                'title' => __('Levelfrío Blocks', 'theme-child'),
                'icon'  => 'star-filled',
            ),
        ),
        $categories
    );
}
add_filter('block_categories_all', 'theme_child_block_categories', 10, 2);

/**
 * Encolar estilos de bloques en el editor
 */
function theme_child_enqueue_block_editor_assets() {
    // Estilos del editor para bloques
    wp_enqueue_style(
        'theme-child-blocks-editor',
        get_stylesheet_directory_uri() . '/assets/css/blocks-editor.css',
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('enqueue_block_editor_assets', 'theme_child_enqueue_block_editor_assets');

/**
 * Encolar estilos de bloques en el frontend
 */
function theme_child_enqueue_block_assets() {
    wp_enqueue_style(
        'theme-child-blocks',
        get_stylesheet_directory_uri() . '/assets/css/blocks.css',
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'theme_child_enqueue_block_assets');

/**
 * Función helper para renderizar campos ACF con valor por defecto
 */
function theme_child_get_field($field_name, $default = '') {
    $value = get_field($field_name);
    return $value ? $value : $default;
}

/**
 * Función helper para obtener clases del bloque
 */
function theme_child_get_block_classes($block, $additional_classes = array()) {
    $classes = array('acf-block');
    
    // Añadir nombre del bloque como clase
    if (!empty($block['name'])) {
        $classes[] = 'block-' . str_replace('acf/', '', $block['name']);
    }
    
    // Añadir clase de alineación
    if (!empty($block['align'])) {
        $classes[] = 'align' . $block['align'];
    }
    
    // Añadir clases personalizadas
    if (!empty($block['className'])) {
        $classes[] = $block['className'];
    }
    
    // Añadir clases adicionales
    $classes = array_merge($classes, $additional_classes);
    
    return implode(' ', $classes);
}

/**
 * Función helper para obtener ID único del bloque
 */
function theme_child_get_block_id($block) {
    if (!empty($block['anchor'])) {
        return $block['anchor'];
    }
    return 'block-' . $block['id'];
}


