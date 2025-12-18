/**
 * Theme Child Level Frío - Scripts
 * 
 * Inicialización de Swiper y otros scripts personalizados
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Inicializar todos los carruseles de servicios
    initCarruselServicios();
    
    // Inicializar todos los sliders de proyectos
    initSliderProyects();
    
});

/**
 * Inicializar Carrusel de Servicios (Swiper)
 */
function initCarruselServicios() {
    const carruseles = document.querySelectorAll('.mwm-swiper-servicios');
    
    carruseles.forEach(function(carruselElement) {
        const swiperId = carruselElement.id;
        
        // Buscar los controles asociados a este swiper
        const prevButton = document.querySelector('.swiper-button-prev[data-swiper="' + swiperId + '"]');
        const nextButton = document.querySelector('.swiper-button-next[data-swiper="' + swiperId + '"]');
        const pagination = document.querySelector('.swiper-pagination[data-swiper="' + swiperId + '"]');
        
        const swiper = new Swiper('#' + swiperId, {
            slidesPerView: 1.2,
            spaceBetween: 16,
            freeMode: false,
            grabCursor: true,
            loop: true,
            pagination: {
                el: pagination,
                type: 'fraction',
            },
            navigation: {
                nextEl: nextButton,
                prevEl: prevButton,
            },
            breakpoints: {
                576: {
                    slidesPerView: 1.5,
                },
                1200: {
                    slidesPerView: 2,
                },
            }
        });
    });
}

/**
 * Inicializar Slider de Proyectos (Swiper)
 */
function initSliderProyects() {
    const sliders = document.querySelectorAll('.mwm-slider .mwmSlider');
    
    sliders.forEach(function(sliderElement) {
        const sliderId = sliderElement.id;
        
        // Buscar los controles asociados a este slider
        const prevButton = sliderElement.closest('.mwm-slider').querySelector('.slider-btn-prev');
        const nextButton = sliderElement.closest('.mwm-slider').querySelector('.slider-btn-next');
        
        const swiper = new Swiper('#' + sliderId, {
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: nextButton,
                prevEl: prevButton,
            },
        });
    });
}

/**
 * Re-inicializar carruseles después de que se cargue nuevo contenido
 * Útil para el editor de WordPress
 */
if (typeof wp !== 'undefined' && wp.domReady) {
    wp.domReady(function() {
        // Observar cambios en el DOM para reinicializar carruseles
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length) {
                    setTimeout(function() {
                        initCarruselServicios();
                        initSliderProyects();
                    }, 100);
                }
            });
        });
        
        const editorWrapper = document.querySelector('.editor-styles-wrapper');
        if (editorWrapper) {
            observer.observe(editorWrapper, { childList: true, subtree: true });
        }
    });
}



