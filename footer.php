<?php 
// Lógica exclusiva para el FOOTER
$color_footer = '#ffffff';
$tema_footer = 'claro';

if ( is_singular() ) {
    $color_guardado_footer = get_post_meta(get_the_ID(), '_color_footer', true);
    if (!empty($color_guardado_footer)) {
        $color_footer = $color_guardado_footer;
    }
}

if (function_exists('biobio_calcular_luminancia')) {
    $tema_footer = biobio_calcular_luminancia($color_footer);
}

list($fr, $fg, $fb) = sscanf($color_footer, "#%02x%02x%02x");
$color_footer_rgba = "rgba($fr, $fg, $fb, 1)"; 
?>

<footer class="footer-biobio" data-tema="<?php echo esc_attr($tema_footer); ?>" style="background-color: <?php echo esc_attr($color_footer_rgba); ?> !important;">
    <div class="footer-contenido">
        
        <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/biobio.png" alt="BioBioChile" class="logo-footer">
        
        <p class="texto-footer">© <?php echo date('Y'); ?> BioBioChile - Todos los derechos reservados</p>
        
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>