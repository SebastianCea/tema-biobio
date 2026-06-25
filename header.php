<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php wp_head(); ?> 
</head>

<?php 
// Lógica exclusiva para el HEADER
$color_header = '#ffffff';
$tema_header = 'claro';

if ( is_singular() ) {
    $color_guardado_header = get_post_meta(get_the_ID(), '_color_cabecera', true);
    if (!empty($color_guardado_header)) {
        $color_header = $color_guardado_header;
    }
}

if (function_exists('biobio_calcular_luminancia')) {
    $tema_header = biobio_calcular_luminancia($color_header);
}

list($hr, $hg, $hb) = sscanf($color_header, "#%02x%02x%02x");
$color_header_rgba = "rgba($hr, $hg, $hb, 0.95)";
?>

<body <?php body_class(); ?> data-tema="<?php echo esc_attr($tema_header); ?>">

    <div id="panel-simulador" style="display: flex; flex-direction: column; gap: 10px;">
    </div>

    <header class="header-principal" data-tema="<?php echo esc_attr($tema_header); ?>" style="background-color: <?php echo esc_attr($color_header_rgba); ?> !important;">
        <div class="contenedor-header">
            <div class="logo-sitio">
                <a href="https://biobiochile.cl" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/logo-biobio.png" alt="BioBioChile" class="imagen-logo">
                </a>
            </div>

            <div class="redes-sociales">
                <a href="https://www.facebook.com/RadioBioBio" class="icono-red" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://x.com/biobio" class="icono-red" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://www.instagram.com/biobiochile/" class="icono-red" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCuvM3c8rmdApmk-g22shZ7w" class="icono-red" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                <a href="https://www.linkedin.com/company/biobiochile/" class="icono-red" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>
    </header>