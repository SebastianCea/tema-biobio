document.addEventListener("DOMContentLoaded", function() {
    console.log("Iniciando motor de Scrolltelling BioBio...");

    // 1. OPTIMIZACIÓN: PAUSA INTELIGENTE MULTI-VIDEO
    const seccionesConVideo = document.querySelectorAll('.seccion-video-full, .seccion-pin-corregida');
    
    seccionesConVideo.forEach(seccion => {
        const videoFondo = seccion.querySelector('video');
        if (videoFondo) {
            const observadorVideo = new IntersectionObserver((entradas) => {
                entradas.forEach(entrada => {
                    if (entrada.isIntersecting) {
                        const promesaReproduccion = videoFondo.play();
                        if (promesaReproduccion !== undefined) {
                            promesaReproduccion.catch(() => { /* Ignorar error de carga rápida */ });
                        }
                    } else {
                        videoFondo.pause();
                    }
                });
            }, { threshold: 0 });
            observadorVideo.observe(seccion);
        }
    });

    // 2. EFECTOS DE APARICIÓN AL SCROLL (Efecto Aparecer)
    const elementosAnimables = document.querySelectorAll('.efecto-aparecer');
    const observadorDeScroll = new IntersectionObserver((entradas, observador) => {
        entradas.forEach(entrada => {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visible');
                observador.unobserve(entrada.target); 
            }
        });
    }, { threshold: 0.1, rootMargin: "0px" });

    elementosAnimables.forEach(elemento => observadorDeScroll.observe(elemento));

    // 3. MOTOR SCROLLTELLING (Aparición de Secciones)
    const elementosAAnimar = document.querySelectorAll(
        '.bloque-editorial, .modulo-flexible, .seccion-normal, .seccion-parallax, .wp-block-gallery, .seccion-pin-corregida'
    );

    elementosAAnimar.forEach(elemento => elemento.classList.add('animacion-scroll'));

    const vigilanteDeScroll = new IntersectionObserver((entradas, observador) => {
        entradas.forEach(entrada => {
            if (entrada.isIntersecting) {
                entrada.target.classList.add('visible');
                observador.unobserve(entrada.target);
            }
        });
    }, { root: null, rootMargin: '0px', threshold: 0.15 });

    elementosAAnimar.forEach(elemento => vigilanteDeScroll.observe(elemento));
});