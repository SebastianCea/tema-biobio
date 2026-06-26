// Nos aseguramos de que el HTML cargue completamente antes de ejecutar el JS
document.addEventListener('DOMContentLoaded', () => {

    // 
    // LÓGICA DE COLORES MODULARES

    // 1. Función matemática que evalúa si un color es claro u oscuro
    function obtenerContraste(colorHex) {
        const hex = colorHex.replace('#', '');
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        
        const luminancia = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
        return luminancia > 0.5 ? 'claro' : 'oscuro';
    }

    // 2. Controladores del Header
    const header = document.querySelector('.header-principal');
    const inputHeader = document.getElementById('color-header');
    
    if (inputHeader && header) {
        function actualizarHeader(color) {
            header.style.backgroundColor = color + 'CC'; // 'CC' le da 80% de transparencia
            header.setAttribute('data-tema', obtenerContraste(color));
        }
        // Escucha los cambios
        inputHeader.addEventListener('input', (e) => actualizarHeader(e.target.value));
        actualizarHeader(inputHeader.value); // Pinta al inicio
    }

    // 3. Controladores del Body (Fondo General)
    const body = document.body;
    const inputBody = document.getElementById('color-body');
    const cuadroFlotante = document.querySelector('.cuadro-flotante');
    
    if (inputBody && body) {
        function actualizarBody(color) {
            body.style.backgroundColor = color;
            body.setAttribute('data-tema', obtenerContraste(color));
            
            // Si existe el cuadro del Efecto Pin, le aplicamos el color de fondo con transparencia
            if (cuadroFlotante) {
                cuadroFlotante.style.backgroundColor = color + 'E6'; // 'E6' le da 90% de transparencia
            }
        }
        // Escucha los cambios
        inputBody.addEventListener('input', (e) => actualizarBody(e.target.value));
        actualizarBody(inputBody.value); // Pinta al inicio
    }

    // 4. Controladores del Footer
    const footer = document.querySelector('.footer-biobio');
    const inputFooter = document.getElementById('color-footer');
    
    if (inputFooter && footer) {
        function actualizarFooter(color) {
            footer.style.backgroundColor = color;
            footer.setAttribute('data-tema', obtenerContraste(color));
        }
        // Escucha los cambios
        inputFooter.addEventListener('input', (e) => actualizarFooter(e.target.value));
        actualizarFooter(inputFooter.value); // Pinta al inicio
    }


    // REGLAS DE NEGOCIO (Editor)

   // --- LÓGICA DE REGLA 1: TEXTO LIBRE ---
    const bloqueLibre = document.querySelector('.bloque-texto-libre');
    
    // Controles de Tamaño
    const inputTamano = document.getElementById('simulador-tamano-texto');
    if (bloqueLibre && inputTamano) {
        inputTamano.addEventListener('input', (e) => {
            bloqueLibre.style.fontSize = e.target.value + 'px';
        });
    }

    // Controles de Color
    const inputColorTexto = document.getElementById('color-texto-libre');
    if (bloqueLibre && inputColorTexto) {
        inputColorTexto.addEventListener('input', (e) => {
            bloqueLibre.style.color = e.target.value;
        });
        // Sincroniza al iniciar
        bloqueLibre.style.color = inputColorTexto.value;
    }

    // Controles de Alineación
    const btnIzq = document.getElementById('btn-align-left');
    const btnCentro = document.getElementById('btn-align-center');
    const btnDer = document.getElementById('btn-align-right');
    
    if (bloqueLibre) {
        if (btnIzq) {
            btnIzq.addEventListener('click', () => { bloqueLibre.style.textAlign = 'left'; });
        }
        if (btnCentro) {
            btnCentro.addEventListener('click', () => { bloqueLibre.style.textAlign = 'center'; });
        }
        if (btnDer) {
            btnDer.addEventListener('click', () => { bloqueLibre.style.textAlign = 'right'; });
        }
    }

    // NUEVO: Controles de Estilos (Negrita, Cursiva, Subrayado)
    const btnNegrita = document.getElementById('btn-negrita');
    const btnCursiva = document.getElementById('btn-cursiva');
    const btnSubrayado = document.getElementById('btn-subrayado');

    if (bloqueLibre) {
        if (btnNegrita) {
            btnNegrita.addEventListener('click', () => {
                bloqueLibre.classList.toggle('texto-negrita');
            });
        }
        if (btnCursiva) {
            btnCursiva.addEventListener('click', () => {
                bloqueLibre.classList.toggle('texto-cursiva');
            });
        }
        if (btnSubrayado) {
            btnSubrayado.addEventListener('click', () => {
                bloqueLibre.classList.toggle('texto-subrayado');
            });
        }
    }

    // --- LÓGICA DE REGLA 2: MÓDULO FLEXIBLE ---
    const bloquePPT = document.getElementById('bloque-ppt-1');
    const btnInvertir = document.getElementById('btn-invertir-bloque');

    if (bloquePPT && btnInvertir) {
        btnInvertir.addEventListener('click', () => {
            // Revisa si tiene la clase "texto-izquierda" y la cambia
            if (bloquePPT.classList.contains('texto-izquierda')) {
                bloquePPT.classList.remove('texto-izquierda');
                bloquePPT.classList.add('texto-derecha');
            } else {
                bloquePPT.classList.remove('texto-derecha');
                bloquePPT.classList.add('texto-izquierda');
            }
        });
    }

    // --- NUEVO: Control de Texto Manual para el Módulo ---
    const inputColorModulo = document.getElementById('color-texto-modulo');
    const btnModNegrita = document.getElementById('btn-mod-negrita');
    const btnModCursiva = document.getElementById('btn-mod-cursiva');
    const btnModSubrayado = document.getElementById('btn-mod-subrayado');
    
    // Atrapamos la caja completa y los textos específicos por dentro
    const cajaTextoModulo = document.querySelector('#bloque-ppt-1 .caja-texto');
    const comillasModulo = document.querySelector('#bloque-ppt-1 .comillas-gigantes');
    const parrafoModulo = document.querySelector('#bloque-ppt-1 .texto-modulo');

    // Cambiar Color
    if (inputColorModulo) {
        inputColorModulo.addEventListener('input', (e) => {
            // Aplicamos el color forzado, rompiendo la herencia del modo oscuro automático
            if (comillasModulo) comillasModulo.style.color = e.target.value;
            if (parrafoModulo) parrafoModulo.style.color = e.target.value;
        });
    }

    // Cambiar Formato (B, I, U)
    if (cajaTextoModulo) {
        if (btnModNegrita) {
            btnModNegrita.addEventListener('click', () => cajaTextoModulo.classList.toggle('texto-negrita'));
        }
        if (btnModCursiva) {
            btnModCursiva.addEventListener('click', () => cajaTextoModulo.classList.toggle('texto-cursiva'));
        }
        if (btnModSubrayado) {
            btnModSubrayado.addEventListener('click', () => cajaTextoModulo.classList.toggle('texto-subrayado'));
        }
    }

    // --- LÓGICA DE REGLA 3: ALINEACIÓN DE PERFIL ---
    const bloquePerfil = document.getElementById('bloque-perfil-1');
    const btnPerfilIzq = document.getElementById('btn-perfil-izq');
    const btnPerfilCentro = document.getElementById('btn-perfil-centro');
    const btnPerfilDer = document.getElementById('btn-perfil-der');

    if (bloquePerfil) {
        if (btnPerfilIzq) {
            btnPerfilIzq.addEventListener('click', () => {
                bloquePerfil.className = 'contenedor-perfil alinear-izq';
            });
        }
        if (btnPerfilCentro) {
            btnPerfilCentro.addEventListener('click', () => {
                bloquePerfil.className = 'contenedor-perfil alinear-centro';
            });
        }
        if (btnPerfilDer) {
            btnPerfilDer.addEventListener('click', () => {
                bloquePerfil.className = 'contenedor-perfil alinear-der';
            });
        }
    }
    // --- LÓGICA DE COLOR PARA EL PERFIL ---
    // Atrapamos la cápsula que está DENTRO del contenedor
    const perfilCapsula = document.querySelector('.perfil-periodista-horizontal');
    const inputColorPerfil = document.getElementById('color-perfil');

    if (inputColorPerfil && perfilCapsula) {
        function actualizarColorPerfil(color) {
            perfilCapsula.style.backgroundColor = color;
            // Usamos la misma función matemática que ya creaste arriba
            perfilCapsula.setAttribute('data-tema', obtenerContraste(color)); 
        }
        
        // Escucha cuando el usuario cambia el color
        inputColorPerfil.addEventListener('input', (e) => actualizarColorPerfil(e.target.value));
        
        // Pinta el color inicial al cargar la página
        actualizarColorPerfil(inputColorPerfil.value);
    }

// --- LÓGICA DE FONDOS INDIVIDUALES ---
    const parallax1 = document.getElementById('parallax-1');
    const parallax2 = document.getElementById('parallax-2');
    const moduloFlex = document.getElementById('bloque-ppt-1');

    const inputColorP1 = document.getElementById('color-parallax-1');
    const inputColorP2 = document.getElementById('color-parallax-2');
    const inputColorMod = document.getElementById('color-modulo-1');

    // Función constructora para aplicar el fondo y verificar el contraste
    function aplicarFondoIndividual(elemento, colorInput) {
        if (elemento && colorInput) {
            colorInput.addEventListener('input', (e) => {
                const colorSeleccionado = e.target.value;
                
                // Si el color es blanco puro o casi blanco, lo hacemos transparente en el parallax para que la foto se vea normal
                if (elemento.classList.contains('seccion-parallax') && colorSeleccionado.toUpperCase() === '#FFFFFF') {
                    elemento.style.backgroundColor = 'transparent';
                } else {
                    elemento.style.backgroundColor = colorSeleccionado;
                }
                
                // Solo le aplicamos el cambio de color de texto al Módulo Flexible, 
                // ya que el Parallax siempre usa letras blancas con sombra.
                if (!elemento.classList.contains('seccion-parallax')) {
                    elemento.setAttribute('data-tema', obtenerContraste(colorSeleccionado));
                }
            });
        }
    }

    // NUEVO: LÓGICA DE PUNTO FOCAL (Encuadre de imagen)
    const selectFocoP1 = document.getElementById('foco-parallax-1');
    const selectFocoP2 = document.getElementById('foco-parallax-2');

    // Función constructora para aplicar el punto focal
    function aplicarFocoIndividual(elemento, selectElement) {
        if (elemento && selectElement) {
            // Usamos 'change' en lugar de 'input' porque es un <select>
            selectElement.addEventListener('change', (e) => {
                elemento.style.backgroundPosition = e.target.value;
            });
            // Aplicar el estado inicial (Centro) por si acaso
            elemento.style.backgroundPosition = selectElement.value;
        }
    }

    // Activamos la función para cada sección
    aplicarFondoIndividual(parallax1, inputColorP1);
    aplicarFondoIndividual(parallax2, inputColorP2);
    aplicarFondoIndividual(moduloFlex, inputColorMod);

    // Activamos la función para los dos Parallax
    aplicarFocoIndividual(parallax1, selectFocoP1);
    aplicarFocoIndividual(parallax2, selectFocoP2);

    // --- LÓGICA DE OPTIMIZACIÓN: PAUSA INTELIGENTE MULTI-VIDEO ---
    // Buscamos todas las secciones que sepamos que contienen videos gigantes
    const seccionesConVideo = document.querySelectorAll('.seccion-video-full, .seccion-pin-corregida');
    
    seccionesConVideo.forEach(seccion => {
        const videoFondo = seccion.querySelector('video');
        
        if (videoFondo) {
            const observadorVideo = new IntersectionObserver((entradas) => {
                entradas.forEach(entrada => {
                    if (entrada.isIntersecting) {
                        const promesaReproduccion = videoFondo.play();
                        if (promesaReproduccion !== undefined) {
                            promesaReproduccion.catch(error => {
                                // Ignora el error de scroll ultrarrápido
                            });
                        }
                    } else {
                        videoFondo.pause();
                    }
                });
            }, {
                threshold: 0 
            });

            observadorVideo.observe(seccion);
        }
    });

    // --- LÓGICA DE REGLA 4: EFECTOS DE APARICIÓN AL SCROLL ---
    
    // 1. Buscamos todo lo que tenga la clase para animar
    const elementosAnimables = document.querySelectorAll('.efecto-aparecer');

    // 2. Configuramos el "espía" (Intersection Observer)
    const observadorDeScroll = new IntersectionObserver((entradas, observador) => {
        entradas.forEach(entrada => {
            // Si el elemento entra en la pantalla...
            if (entrada.isIntersecting) {
                // Le agregamos la clase que hace la animación
                entrada.target.classList.add('visible');
                // Dejamos de observarlo para que no se anime 100 veces si subes y bajas
                observador.unobserve(entrada.target); 
            }
        });
    }, {
        // threshold: 0.1 significa "actívate cuando al menos el 10% del elemento sea visible"
        threshold: 0.1,
        // rootMargin adelanta o retrasa el disparo. Aquí no lo usamos.
        rootMargin: "0px" 
    });

    // 3. Le decimos al espía que vigile cada elemento
    elementosAnimables.forEach(elemento => {
        observadorDeScroll.observe(elemento);
    });

    // --- LÓGICA DE REGLA 6: EFECTOS DE IMAGEN ---
    // Atrapamos la imagen específica del módulo flexible
    const imagenModulo = document.querySelector('.caja-media img');
    const selectFiltro = document.getElementById('simulador-filtro-imagen');
    const btnBorde = document.getElementById('btn-toggle-borde');

    if (imagenModulo) {
        // Control de Filtros (Color)
        if (selectFiltro) {
            selectFiltro.addEventListener('change', (e) => {
                // Primero limpiamos posibles filtros anteriores
                imagenModulo.classList.remove('filtro-imagen-bn', 'filtro-imagen-sepia');
                
                // Si elige algo que no sea "none", aplicamos la nueva clase
                if (e.target.value !== 'none') {
                    imagenModulo.classList.add(e.target.value);
                }
            });
        }

        // Control de Borde Redondeado (Toggle)
        if (btnBorde) {
            btnBorde.addEventListener('click', () => {
                imagenModulo.classList.toggle('borde-suavizado');
            });
        }
    }

    // --- LÓGICA DE REGLA 7: GALERÍA MULTI-ESTILO ---
    const galeria = document.getElementById('galeria-noticia');
    const selectTipoGaleria = document.getElementById('simulador-tipo-galeria');

    if (galeria && selectTipoGaleria) {
        selectTipoGaleria.addEventListener('change', (e) => {
            // Reemplazamos la clase dinámicamente manteniendo la clase base
            galeria.className = 'galeria-dinamica ' + e.target.value;
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    
    console.log("Iniciando motor de Scrolltelling BioBio...");

    // 1. Seleccionamos automáticamente todos los bloques que queremos que tengan el efecto.
    // Si a futuro creas nuevas secciones, solo agregas su clase a esta lista.
    const elementosAAnimar = document.querySelectorAll(
        '.bloque-editorial, .modulo-flexible, .seccion-normal, .seccion-parallax, .wp-block-gallery, .seccion-pin-corregida'
    );

    // 2. Les inyectamos la clase CSS que los vuelve invisibles por defecto
    elementosAAnimar.forEach(elemento => {
        elemento.classList.add('animacion-scroll');
    });

    // 3. Configuramos el vigilante (Intersection Observer)
    const opciones = {
        root: null, // Usa la pantalla completa como marco de referencia
        rootMargin: '0px',
        threshold: 0.15 // Se activa cuando el 15% del bloque ya entró a la pantalla
    };

    const vigilanteDeScroll = new IntersectionObserver((entradas, observador) => {
        entradas.forEach(entrada => {
            // Si el bloque entró a la pantalla...
            if (entrada.isIntersecting) {
                // Le agregamos la clase que le devuelve la opacidad al 100%
                entrada.target.classList.add('visible');
                
                // Opcional: Una vez que apareció, dejamos de vigilarlo para que 
                // se quede fijo y no vuelva a desaparecer si el usuario sube a leer de nuevo.
                observador.unobserve(entrada.target);
            }
        });
    }, opciones);

    // 4. Ponemos a trabajar al vigilante sobre cada elemento de nuestra lista
    elementosAAnimar.forEach(elemento => {
        vigilanteDeScroll.observe(elemento);
    });

});

