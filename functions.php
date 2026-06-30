<?php
// -------------------------------------------------------------------
// 1. CARGA DE RECURSOS (Estilos y Scripts)
// -------------------------------------------------------------------
function cargar_recursos_biobio() {
    // 1. Font Awesome
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2' );
    
    // 2. Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,700;1,300;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap', array(), null );
    
    // 3. Tu style.css principal
    wp_enqueue_style( 'estilo-principal', get_stylesheet_uri(), array(), '1.0' );

    // 4. Tu script.js
    wp_enqueue_script( 'script-biobio', get_template_directory_uri() . '/js/script.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'cargar_recursos_biobio' );
add_filter('show_admin_bar', '__return_false');

// -------------------------------------------------------------------
// 2. SOPORTE DE PATRONES DE BLOQUE (El "motor" de plantillas)
// -------------------------------------------------------------------
function activar_soporte_biobio() {
    add_theme_support('core-block-patterns');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action( 'after_setup_theme', 'activar_soporte_biobio' );

function personalizar_biobio($wp_customize) {
    $wp_customize->add_setting('color_header', array(
        'default' => '#ffffff',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'color_header',
        array(
            'label' => 'Color del Header',
            'section' => 'colors',
        )
    ));
}
add_action('customize_register', 'personalizar_biobio');

function inyectar_colores_biobio() {
    $color_header = get_theme_mod('color_header', '#ffffff');
    echo '<style>
        body .header-principal {
            background-color: ' . esc_attr($color_header) . ' !important;
        }
    </style>';
}
add_action('wp_head', 'inyectar_colores_biobio');

function registrar_categoria_patrones_biobio() {
    register_block_pattern_category(
        'biobio-secciones',
        array( 'label' => 'Secciones BioBio' )
    );
}
add_action( 'init', 'registrar_categoria_patrones_biobio' );


/* ===================================================
   METABOX: COLORES INDEPENDIENTES (HEADER Y FOOTER)
   =================================================== */

// 1. Tu calculadora de luminancia
function biobio_calcular_luminancia($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $luminancia = ($r * 0.299) + ($g * 0.587) + ($b * 0.114);
    return ($luminancia > 150) ? 'claro' : 'oscuro';
}

// 2. Registrar la caja en el panel lateral
function biobio_agregar_metabox_tema() {
    add_meta_box(
        'biobio_tema_metabox',
        '🎨 Colores de la Estructura',
        'biobio_renderizar_metabox',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'biobio_agregar_metabox_tema');

// 3. Dibujar los DOS selectores de color en el panel
function biobio_renderizar_metabox($post) {
    $color_header = get_post_meta($post->ID, '_color_cabecera', true) ?: '#ffffff';
    $color_footer = get_post_meta($post->ID, '_color_footer', true) ?: '#ffffff';

    wp_nonce_field('guardar_tema_articulo', 'tema_articulo_nonce');

    echo '<p style="margin-bottom: 5px; font-weight: bold;">Color del Header:</p>';
    echo '<input type="color" name="color_cabecera" value="' . esc_attr($color_header) . '" style="width: 100%; height: 40px; cursor: pointer; border: 1px solid #ccc; margin-bottom: 15px;">';

    echo '<p style="margin-bottom: 5px; font-weight: bold;">Color del Footer:</p>';
    echo '<input type="color" name="color_footer" value="' . esc_attr($color_footer) . '" style="width: 100%; height: 40px; cursor: pointer; border: 1px solid #ccc;">';
    
    echo '<p style="font-size: 11px; color: #666; margin-top: 10px;">Cada sección calculará su propio contraste para adaptar logos y textos automáticamente.</p>';
}

// 4. Guardar AMBOS colores de forma independiente
function biobio_guardar_metabox_tema($post_id) {
    if (!isset($_POST['tema_articulo_nonce']) || !wp_verify_nonce($_POST['tema_articulo_nonce'], 'guardar_tema_articulo')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['color_cabecera'])) {
        update_post_meta($post_id, '_color_cabecera', sanitize_hex_color($_POST['color_cabecera']));
    }
    if (isset($_POST['color_footer'])) {
        update_post_meta($post_id, '_color_footer', sanitize_hex_color($_POST['color_footer']));
    }
}
add_action('save_post', 'biobio_guardar_metabox_tema');

/* ===================================================
   DESBLOQUEO DEL EDITOR: SECCIÓN DATO ANCLADO
   =================================================== */
function biobio_forzar_estilos_editor() {
    wp_register_style('biobio-editor-fix', false);
    wp_enqueue_style('biobio-editor-fix');
    
    // Usamos Sintaxis Heredoc (<<<CSS) para activar los colores en tu editor
    $css_editor = <<<CSS
        /* 1. Desarmamos el anclaje y le damos un tamaño fijo para poder tocar la foto */
        .seccion-pin-corregida .imagen-anclada { 
            position: relative !important; 
            height: 400px !important; 
            min-height: 400px !important; 
            top: auto !important;
            z-index: 1 !important; 
        }
        
        /* 2. Forzamos a que TODO el bloque Fondo reciba clics para que active su menú */
        .seccion-pin-corregida .imagen-anclada,
        .seccion-pin-corregida .imagen-anclada * { 
            pointer-events: auto !important; 
        }
        
        /* 3. Empujamos el texto hacia abajo eliminando el margen negativo */
        .seccion-pin-corregida .contenedor-del-cuadro { 
            position: relative !important;
            margin-top: 20px !important; 
            padding-top: 20px !important; 
            padding-bottom: 20px !important;
            z-index: 10 !important; 
        }
CSS;

    // Inyectamos la variable que contiene el CSS
    wp_add_inline_style('biobio-editor-fix', $css_editor);
}
add_action('enqueue_block_editor_assets', 'biobio_forzar_estilos_editor');

/* ===================================================
   ESTILOS PERSONALIZADOS PARA GALERÍAS
   =================================================== */
function biobio_estilos_galeria() {
    register_block_style('core/gallery', array('name' => 'estilo-grid', 'label' => 'Diseño Grid BioBio'));
    register_block_style('core/gallery', array('name' => 'estilo-masonry', 'label' => 'Diseño Masonry BioBio'));
    register_block_style('core/gallery', array('name' => 'estilo-carrusel', 'label' => 'Diseño Carrusel BioBio'));
}
    
    // Opcional: Puedes registrar otros si los necesitas a futuro
    // register_block_style('core/gallery', array('name' => 'estilo-slider', 'label' => 'Diseño Slider'));

add_action('init', 'biobio_estilos_galeria');

/* ===================================================
   CARGAR EXTENSIÓN DE REACT PARA EL EDITOR
   =================================================== */
function biobio_cargar_scripts_editor() {
    $ruta_js = '/js/extension-imagenes.js';
    
    wp_enqueue_script(
        'biobio-extension-imagenes',
        get_template_directory_uri() . $ruta_js,
        // Dependencias exactas de React y Gutenberg moderno:
        array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-compose', 'wp-hooks', 'lodash'),
        // Esto rompe la caché obligatoriamente cada vez que guardas el JS:
        filemtime(get_template_directory() . $ruta_js), 
        true
    );
}
add_action('enqueue_block_editor_assets', 'biobio_cargar_scripts_editor');

function biobio_estilos_bloques_nativos() {
    // 1. Portada exclusiva (Esta se queda solo para el Cover)
    register_block_style('core/cover', array(
        'name'  => 'portada-biobio',
        'label' => 'Portada BioBio'
    ));
    
    // 2. Arreglo de todos los bloques que pueden actuar como "Secciones"
    $bloques_seccion = array(
        'core/cover',      // Fondo
        'core/group',      // Grupo
        'core/columns',    // Columnas
        'core/media-text', // Medios y Texto
        'core/image'       // Imagen individual
    );

    // 3. Ciclo automático para inyectar los botones en todos esos bloques
    foreach ( $bloques_seccion as $bloque ) {
        register_block_style( $bloque, array(
            'name'  => 'fundido-oscuro',
            'label' => 'Fundido (Abajo)'
        ));
        register_block_style( $bloque, array(
            'name'  => 'fundido-superior',
            'label' => 'Fundido (Arriba)'
        ));
        // NUEVO: Botón para aplicar ambos efectos a la vez
        register_block_style( $bloque, array(
            'name'  => 'fundido-ambos',
            'label' => 'Fundido (Ambos)'
        ));
    }
}
add_action('init', 'biobio_estilos_bloques_nativos');

// PEGAR TEMPORALMENTE EN functions.php — QUITAR DESPUÉS DE RECARGAR
// Fuerza a WordPress a releer todos los patrones desde disco
add_action('init', function() {
    delete_transient('wp_block_patterns');
    delete_transient('wp_remote_block_patterns');
}, 1);