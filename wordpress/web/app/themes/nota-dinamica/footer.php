<?php
// -------------------------------------------------------------------
// Lógica exclusiva para el FOOTER (igual criterio que header.php)
// -------------------------------------------------------------------
$color_footer = '#01162a';
$tema_footer  = 'oscuro';

if ( is_singular() ) {
    $color_guardado_footer = get_post_meta( get_the_ID(), '_color_footer', true );
    if ( ! empty( $color_guardado_footer ) ) {
        $color_footer = $color_guardado_footer;
    }
}

if ( function_exists( 'biobio_calcular_luminancia' ) ) {
    $tema_footer = biobio_calcular_luminancia( $color_footer );
}
?>

<footer class="footer-biobio" data-tema="<?php echo esc_attr( $tema_footer ); ?>"
        style="width: 100%; background-color: <?php echo esc_attr( $color_footer ); ?>; border-top: 1px solid rgba(255, 255, 255, 0.15); margin-top: auto;">

    <!-- Wrapper que apila el logo SOBRE el texto (footer-biobio es flex-row, footer-contenido es flex-column) -->
    <div class="footer-contenido">

        <div class="bbcl-footer-logo">
            <a href="https://www.biobiochile.cl/" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/biobio.png"
                     alt="bbcl-footer-logo"
                     class="logo-footer"
                     style="height: 25px; width: auto;">
            </a>
        </div>

        <div class="footer-text texto-footer" style="font-family: 'Roboto', sans-serif;">
            Desarrollado por Bío Bío Comunicaciones
            <br>
            Concepción - Chile
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>