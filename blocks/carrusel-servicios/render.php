<?php
/**
 * Carrusel de Servicios Block Template
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during backend preview render.
 * @param int $post_id The post ID the block is rendering content against.
 * @param array $context The context provided to the block by the post or its parent block.
 */

// Campos ACF
$titulo = get_field('titulo') ?: 'Nuestros servicios';
$subtitulo = get_field('subtitulo') ?: '';
$descripcion = get_field('descripcion') ?: '';
$color_fondo_panel = get_field('color_fondo_panel') ?: '#e8f4f8';
$servicios = get_field('servicios');

// ID único para este carrusel
$block_id = !empty($block['anchor']) ? $block['anchor'] : 'carrusel-servicios-' . $block['id'];
$swiper_id = 'swiper-' . $block['id'];

// Clases del bloque
$block_classes = array('block-carrusel-servicios', 'mwm-carrusel');

if (!empty($block['className'])) {
    $block_classes[] = $block['className'];
}

if (!empty($block['align'])) {
    $block_classes[] = 'align' . $block['align'];
}

// Datos de ejemplo para preview
if ($is_preview && empty($servicios)) {
    $servicios = array(
        array(
            'imagen' => array('url' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=600&h=400&fit=crop', 'alt' => 'Servicio 1'),
            'titulo' => 'Frío comercial e industrial',
            'descripcion' => 'Conservación eficiente, instalaciones robustas.'
        ),
        array(
            'imagen' => array('url' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&h=400&fit=crop', 'alt' => 'Servicio 2'),
            'titulo' => 'Alimentación y hostelería',
            'descripcion' => 'Equipamiento integral, marcas líderes.'
        ),
        array(
            'imagen' => array('url' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600&h=400&fit=crop', 'alt' => 'Servicio 3'),
            'titulo' => 'Climatización y ventilación',
            'descripcion' => 'Confort térmico, aire de calidad.'
        ),
        array(
            'imagen' => array('url' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=600&h=400&fit=crop', 'alt' => 'Servicio 4'),
            'titulo' => 'Energía solar',
            'descripcion' => 'Instalaciones fotovoltaicas eficientes.'
        ),
    );
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr(implode(' ', $block_classes)); ?>">
    <div class="container-carrusel">
        <div class="carrusel-columns">
            <!-- Panel izquierdo con información -->
            <div class="info-panel" style="background-color: <?php echo esc_attr($color_fondo_panel); ?>;">
                <?php if ($titulo) : ?>
                    <h2 class="section-title"><?php echo nl2br(esc_html($titulo)); ?></h2>
                <?php endif; ?>
                
                <?php if ($subtitulo) : ?>
                    <h3 class="section-subtitle"><?php echo nl2br(esc_html($subtitulo)); ?></h3>
                <?php endif; ?>
                
                <?php if ($descripcion) : ?>
                    <p class="section-description"><?php echo esc_html($descripcion); ?></p>
                <?php endif; ?>
                
                <div class="nav-controls">
                    <div class="swiper-button-prev" data-swiper="<?php echo esc_attr($swiper_id); ?>">
                        <svg viewBox="0 0 24 24">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper-pagination" data-swiper="<?php echo esc_attr($swiper_id); ?>"></div>
                    <div class="swiper-button-next" data-swiper="<?php echo esc_attr($swiper_id); ?>">
                        <svg viewBox="0 0 24 24">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Panel derecho con carrusel -->
            <div class="carousel-panel">
                <?php if ($servicios && is_array($servicios)) : ?>
                    <div class="swiper mwm-swiper-servicios" id="<?php echo esc_attr($swiper_id); ?>">
                        <div class="swiper-wrapper">
                            <?php foreach ($servicios as $index => $servicio) : 
                                $imagen = $servicio['imagen'] ?? null;
                                $titulo_servicio = $servicio['titulo'] ?? '';
                                $descripcion_servicio = $servicio['descripcion'] ?? '';
                            ?>
                                <div class="swiper-slide">
                                    <div class="service-card">
                                        <?php if ($imagen) : ?>
                                            <div class="service-card-image">
                                                <img 
                                                    src="<?php echo esc_url(is_array($imagen) ? $imagen['url'] : $imagen); ?>" 
                                                    alt="<?php echo esc_attr(is_array($imagen) && isset($imagen['alt']) ? $imagen['alt'] : $titulo_servicio); ?>"
                                                    loading="lazy"
                                                >
                                            </div>
                                        <?php endif; ?>
                                        <div class="service-card-content">
                                            <?php if ($titulo_servicio) : ?>
                                                <h4 class="service-card-title"><?php echo esc_html($titulo_servicio); ?></h4>
                                            <?php endif; ?>
                                            <?php if ($descripcion_servicio) : ?>
                                                <p class="service-card-description"><?php echo esc_html($descripcion_servicio); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="carousel-placeholder">
                        <p>Añade servicios desde el panel lateral para ver el carrusel.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

