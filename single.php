<?php 
// 1. OBTENEMOS LAS VARIABLES DESDE TU PANEL DE WORDPRESS
$color_cabecera = get_post_meta(get_the_ID(), '_color_cabecera', true) ?: '#ffffff';
$color_footer   = get_post_meta(get_the_ID(), '_color_footer', true) ?: '#ffffff';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?> - Entorno de Pruebas Local</title>
    
    <!-- Librerías de Fuentes e Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,700;1,300;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- ESTILOS DE TU NUEVO TEMA DINÁMICO (Llama al style.css de tu tema local) -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>?v=1.0"> 
    
    <?php wp_head(); // Gancho vital de WordPress ?>
</head>

<body <?php body_class(); ?>>

    <!-- HEADER PERSONALIZADO -->
    <header class="header-principal" id="header-dinamico" style="background-color: <?php echo esc_attr($color_cabecera); ?> !important;">
        <div class="contenedor-header">
            <div class="logo-sitio">
                <a href="#">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/logo-biobio.png" alt="BioBioChile" class="imagen-logo">
                </a>
            </div>
            <!-- Redes sociales resumidas para la prueba -->
            <div class="redes-sociales">
                <a href="#" class="icono-red"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icono-red"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
        </div>
    </header>

    <!-- CONTENEDOR PRINCIPAL: AQUÍ VIVE TU CÓDIGO GUTENBERG -->
    <main class="contenido-principal">
        <div class="nota-content-dinamica">
            
            <?php 
            // Esto imprime los patrones y bloques que armaste en el editor
            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    the_content(); 
                endwhile; 
            endif; 
            ?>

        </div>
    </main>

    <!-- FOOTER PERSONALIZADO -->
    <footer class="footer-biobio" id="footer-dinamico" style="background-color: <?php echo esc_attr($color_footer); ?> !important;">
        <div class="footer-contenido">
            <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/biobio.png" alt="BioBio" class="logo-footer">
            <p class="texto-footer">Prueba Local - Analista Programador</p>
        </div>
    </footer>

    <!-- SCRIPT DE CÁLCULO DE CONTRASTE Y JS FINAL -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function adaptarContraste(elementoId, colorHex) {
                const elemento = document.getElementById(elementoId);
                if (!elemento || !colorHex || colorHex.trim() === '') return;
                
                let hex = colorHex.replace('#', '');
                if (hex.length === 3) hex = hex.split('').map(char => char + char).join('');
                if (hex.length !== 6) return;
                
                let r = parseInt(hex.substring(0, 2), 16);
                let g = parseInt(hex.substring(2, 4), 16);
                let b = parseInt(hex.substring(4, 6), 16);
                
                let luminancia = (r * 0.299) + (g * 0.587) + (b * 0.114);
                elemento.setAttribute('data-tema', luminancia > 150 ? 'claro' : 'oscuro');
            }

            // Alimentamos el script con las variables de WordPress
            adaptarContraste('header-dinamico', '<?php echo esc_js($color_cabecera); ?>');
            adaptarContraste('footer-dinamico', '<?php echo esc_js($color_footer); ?>');
        });
    </script>

    <!-- SCRIPT PRINCIPAL (Tus animaciones de scroll) -->
    <script defer src="<?php echo get_template_directory_uri(); ?>/js/script.js?v=1.0"></script>

    <?php wp_footer(); ?>
</body>
</html>