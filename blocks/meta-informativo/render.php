<?php
/**
 * Meta Informativo Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or its parent block.
 */

// Obtener el ID del post actual
$current_post_id = $post_id ?: get_the_ID();

// Campos ACF
$year = get_field('acf_year_proyect', $current_post_id);
$address = get_field('acf_address_proyect', $current_post_id);

// Obtener categorías del proyecto
$categories = get_the_terms($current_post_id, 'category');
$category_names = array();

if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $category) {
        $category_names[] = $category->name;
    }
}

$category_text = !empty($category_names) ? implode(', ', $category_names) : '';

// Ruta de los iconos
$icons_path = get_stylesheet_directory_uri() . '/blocks/meta-informativo/images/';

// Clases del bloque
$block_classes = array('block-meta-informativo');

// Estilo del bloque
if (!empty($block['className'])) {
    $block_classes[] = $block['className'];
}

// Alineación del bloque
if (!empty($block['align'])) {
    $block_classes[] = 'align' . $block['align'];
}

// ID del bloque
$block_id = !empty($block['anchor']) ? $block['anchor'] : 'meta-informativo-' . $block['id'];

// Datos para preview en el editor
if ($is_preview && empty($year) && empty($address) && empty($category_text)) {
    $year = '2020';
    $address = 'Conil de la Frontera';
    $category_text = 'Alimentación y hostelería';
}
?>

<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $block_classes)); ?>">
    
    <?php if ($year) : ?>
        <div class="meta-informativo__item">
            <span class="meta-informativo__icon">
                <img src="<?php echo esc_url($icons_path . 'icon-calendar.svg'); ?>" alt="Año" width="24" height="24" loading="lazy">
            </span>
            <span class="meta-informativo__content">
                <span class="meta-informativo__label">Año:</span>
                <span class="meta-informativo__value"><?php echo esc_html($year); ?></span>
            </span>
        </div>
    <?php endif; ?>
    
    <?php if ($address) : ?>
        <div class="meta-informativo__item">
            <span class="meta-informativo__icon">
                <img src="<?php echo esc_url($icons_path . 'icon-location.svg'); ?>" alt="Ubicación" width="24" height="24" loading="lazy">
            </span>
            <span class="meta-informativo__content">
                <span class="meta-informativo__value"><?php echo esc_html($address); ?></span>
            </span>
        </div>
    <?php endif; ?>
    
    <?php if ($category_text) : ?>
        <div class="meta-informativo__item">
            <span class="meta-informativo__icon">
                <img src="<?php echo esc_url($icons_path . 'icon-briefcase.svg'); ?>" alt="Categoría" width="24" height="24" loading="lazy">
            </span>
            <span class="meta-informativo__content">
                <span class="meta-informativo__value"><?php echo esc_html($category_text); ?></span>
            </span>
        </div>
    <?php endif; ?>
    
    <?php if ($is_preview && empty($year) && empty($address) && empty($category_text)) : ?>
        <div class="meta-informativo__preview-notice">
            <p>Configura los campos ACF del proyecto para ver la información.</p>
        </div>
    <?php endif; ?>
    
</div>

