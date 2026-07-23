<?php
/**
 * Template Name: Portada Estilo Sociales
 * Description: Portada con carrusel Swiper responsivo y logo ajustado en la parte superior.
 */

if ( is_404() ) {
    status_header(404);
    get_template_part( '404' );
    exit;
}
?>

<?php get_header(); ?>

<!-- Librería CSS de Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

<!-- padding-top reducido a 65px para acercarlo más al header fijo -->
<main class="main-layout portada-sociales-estilo" style="padding-top: 65px; min-height: calc(100vh - 100px); display: flex; flex-direction: column; justify-content: flex-start;"> 

    <div class="main-content" style="width: 100%; padding: 20px 0;">

        <!-- Logo / Imagen de portada: Más grande (60px), blanca y centrada -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/bbcl-logo.svg" alt="Logo Portada" style="height: 60px; width: auto; filter: brightness(0) invert(1); display: inline-block;">
        </div>

        <div class="text-revisa-los-ultimos mx-auto" style="margin-bottom: 30px;">
            <strong>Revisa las últimas notas</strong>
        </div>

        <!-- CARRUSEL DE NOTAS RESPONSIVO -->
        <section class="eventos-section" style="max-width: 1300px; margin: 0 auto; padding: 0 20px;">
            <div class="swiper eventos-swiper">
                <div class="swiper-wrapper">

                    <?php
                    $eventos = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 10,
                        'post_status'    => 'publish'
                    ]);

                    if ($eventos->have_posts()):
                        while ($eventos->have_posts()):
                            $eventos->the_post();

                            $content = apply_filters('the_content', get_the_content());
                            preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $content, $matches_h);
                            $titulo_nota = !empty($matches_h[1]) ? strip_tags($matches_h[1]) : get_the_title();

                            if (has_post_thumbnail()) {
                                $img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            } else {
                                $img = get_template_directory_uri() . '/assets/img/default-evento.png';
                            }
                    ?>
                            <div class="swiper-slide">
                                <div class="evento-card-wrapper">
                                    <a href="<?php the_permalink(); ?>" class="evento-link">
                                        <div class="evento-img-container">
                                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($titulo_nota); ?>">
                                        </div>
                                        <div class="evento-texto-link">
                                            <p class="evento-nombre-texto"><?php echo esc_html($titulo_nota); ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo "<p style='text-align:center; color:#fff;'>No hay notas disponibles.</p>";
                    endif;
                    ?>

                </div>
            </div>
        </section>

    </div>

</main>

<!-- Script inicializador de Swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof Swiper !== 'undefined') {
            new Swiper('.eventos-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                breakpoints: {
                    576: { slidesPerView: 2, spaceBetween: 20 },
                    992: { slidesPerView: 3, spaceBetween: 25 },
                    1200: { slidesPerView: 4, spaceBetween: 25 }
                },
                loop: false
            });
        }
    });
</script>

<?php get_footer(); ?>