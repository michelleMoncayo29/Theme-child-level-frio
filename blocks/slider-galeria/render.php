<?php
/**
 * Slider Galería Block Template
 * 
 * Bloque con campos ACF propios (no vinculado a campos de post)
 * El campo ACF 'galeria' retorna IDs de las imágenes
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or its parent block.
 */

// Obtener la galería del campo ACF del bloque (retorna IDs de imágenes)
$gallery = get_field('galeria');

// ID único para este slider
$block_id = !empty($block['anchor']) ? $block['anchor'] : 'slider-galeria-' . $block['id'];
$slider_id = 'mwmSliderGaleria-' . $block['id'];

// Clases del bloque
$block_classes = array('block-slider-galeria', 'mwm-slider');

if (!empty($block['className'])) {
    $block_classes[] = $block['className'];
}

if (!empty($block['align'])) {
    $block_classes[] = 'align' . $block['align'];
}

// Datos de ejemplo para preview
if ($is_preview && empty($gallery)) {
    $gallery = array(
        array('url' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200&h=600&fit=crop', 'alt' => 'Imagen 1'),
        array('url' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=1200&h=600&fit=crop', 'alt' => 'Imagen 2'),
        array('url' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1200&h=600&fit=crop', 'alt' => 'Imagen 3'),
        array('url' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=1200&h=600&fit=crop', 'alt' => 'Imagen 4'),
    );
    $is_preview_data = true;
} else {
    $is_preview_data = false;
}
?>

<?php if ($gallery && (is_array($gallery) && count($gallery) > 0)): ?>
    <section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $block_classes)); ?>">
        <div class="swiper mwmSlider" id="<?php echo esc_attr($slider_id); ?>">
            <div class="swiper-wrapper">
                <?php foreach ($gallery as $image_id):
                    // Si es preview con datos de ejemplo (array)
                    if ($is_preview_data && is_array($image_id)) {
                        $image_url = $image_id['url'];
                        $image_alt = $image_id['alt'];
                    } else {
                        // El campo retorna IDs - obtener URL y alt del attachment
                        $image_url = wp_get_attachment_image_url($image_id, 'large');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        
                        // Si no hay alt, usar el título
                        if (empty($image_alt)) {
                            $image_alt = get_the_title($image_id);
                        }
                    }

                    if (empty($image_url))
                        continue;
                    ?>
                    <div class="swiper-slide">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Navigation -->
        <div class="mwm-slider-nav">
            <div class="slider-btn-prev" data-slider="<?php echo esc_attr($slider_id); ?>">
                <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.5 10.5L0.5 5.5M0.5 5.5L5.5 0.5M0.5 5.5L12.5 5.5" stroke="#29ABE2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div class="slider-btn-next" data-slider="<?php echo esc_attr($slider_id); ?>">
                <svg width="13" height="11" viewBox="0 0 13 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 0.5L12.5 5.5M12.5 5.5L7.5 10.5M12.5 5.5L0.5 5.5" stroke="#29ABE2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </section>
<?php else: ?>
    <?php if ($is_preview): ?>
        <div class="slider-placeholder">
            <p>Añade imágenes a la galería desde el panel lateral.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

