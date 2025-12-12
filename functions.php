<?php
/**
 * Theme Child functions and definitions
 *
 * @package Theme_Child
 */

// Prevenir acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Incluir archivo de registro de bloques ACF
 */
require_once get_stylesheet_directory() . '/inc/acf-blocks.php';

/**
 * Encolar estilos del tema padre y tema hijo
 */
function theme_child_enqueue_styles() {
    // Estilos de las fuentes personalizadas
    wp_enqueue_style(
        'theme-child-fonts',
        get_stylesheet_directory_uri() . '/assets/css/fonts.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Estilos del tema padre
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css',
        array('theme-child-fonts'),
        wp_get_theme('twentytwentyfive')->get('Version')
    );

    // Estilos del tema hijo
    wp_enqueue_style(
        'theme-child-style',
        get_stylesheet_uri(),
        array('twentytwentyfive-style'),
        wp_get_theme()->get('Version')
    );

    // Estilos personalizados adicionales
    wp_enqueue_style(
        'theme-child-custom',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array('theme-child-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'theme_child_enqueue_styles');

/**
 * Encolar estilos en el editor de bloques
 */
function theme_child_editor_styles() {
    add_editor_style('assets/css/fonts.css');
    add_editor_style('assets/css/custom.css');
}
add_action('after_setup_theme', 'theme_child_editor_styles');


