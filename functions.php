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

    // Swiper CSS
    wp_enqueue_style(
        'swiper',
        get_stylesheet_directory_uri() . '/assets/js/swiper/swiper-bundle.min.css',
        array(),
        '11.0.0'
    );

    // Swiper JS
    wp_enqueue_script(
        'swiper',
        get_stylesheet_directory_uri() . '/assets/js/swiper/swiper-bundle.min.js',
        array(),
        '11.0.0',
        true
    );

    // Scripts personalizados
    wp_enqueue_script(
        'theme-child-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array('swiper'),
        wp_get_theme()->get('Version'),
        true
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

/**
 * ACF JSON - Ruta de guardado
 * Guarda los campos ACF en la carpeta acf-json del tema
 */
function theme_child_acf_json_save_point($path) {
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'theme_child_acf_json_save_point');

/**
 * ACF JSON - Ruta de carga
 * Carga los campos ACF desde la carpeta acf-json del tema
 */
function theme_child_acf_json_load_point($paths) {
    // Eliminar la ruta original (opcional)
    unset($paths[0]);
    
    // Añadir nuestra ruta
    $paths[] = get_stylesheet_directory() . '/acf-json';
    
    return $paths;
}
add_filter('acf/settings/load_json', 'theme_child_acf_json_load_point');

/**
 * Registrar estilos de botones personalizados MWM
 */
function theme_child_register_button_styles() {
    // Registrar estilos para el bloque de botón
    register_block_style('core/button', array(
        'name'  => 'mwm-primary',
        'label' => __('MWM Primary', 'theme-child'),
    ));

    register_block_style('core/button', array(
        'name'  => 'mwm-secondary',
        'label' => __('MWM Secondary', 'theme-child'),
    ));

    register_block_style('core/button', array(
        'name'  => 'mwm-secondary-dark',
        'label' => __('MWM Secondary Dark', 'theme-child'),
    ));

    register_block_style('core/button', array(
        'name'  => 'mwm-ghost',
        'label' => __('MWM Ghost', 'theme-child'),
    ));
}
add_action('init', 'theme_child_register_button_styles');


