<?php
/**
 * Template Name: Single Nota Seguro (Ancho Completo y Patrones Multimedia)
 * Description: Plantilla para entradas individuales con margen superior correcto para el header fijo.
 */

get_header(); 
?>

<style>
    /* Empuja toda la página hacia abajo para que el header fijo de 60px no tape el contenido */
    body {
        padding-top: 60px !important;
        margin: 0;
    }

    /* Contenedor fluido para respetar tus patrones multimedia y scrolltelling */
    .main-article-container {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }
    .article-content-body {
        width: 100%;
    }

    /* Estilos del carrusel inferior y tarjetas */
    .evento-card-wrapper {
        background: #01162a;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .evento-img-container {
        overflow: hidden;
        height: 180px;
        width: 100%;
    }
    .evento-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .evento-card-wrapper:hover .evento-img-container img {
        transform: scale(1.08);
    }
    .evento-nombre-texto {
        font-family: 'Merriweather', serif;
        font-size: 1rem;
        color: #ffffff;
        font-weight: bold !important;
        margin: 0;
        line-height: 1.3;
    }
    .swiper-slide {
        height: auto;
    }
</style>

<!-- Librería CSS de Swiper -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

<div class="main-wrapper" style="width: 100%;">
    <main class="evento-main-layout" style="width: 100%;">
        <div class="main-content" style="width: 100%;">

            <?php if (have_posts()):
                while (have_posts()):
                    the_post(); ?>

                    <!-- RENDERIZADO NATIVO DE PATRONES Y SCROLLTELLING -->
                    <article class="main-article-container">
                        <div class="article-content-body">
                            <?php the_content(); ?>
                        </div>
                    </article>

                <?php endwhile; endif; ?>

            <!-- ANUNCIO MIDDLE -->
            <div class="ad-middle1-container mx-auto" id="ad_middle1" style="display: none;">
                <script>
                    googletag.cmd.push(() => {
                        googletag.defineSlot('/1098385/biobiocl/ad_middle1', [], 'ad_middle1')
                            .defineSizeMapping(googletag.sizeMapping()
                                .addSize([0, 0], [300, 400])
                                .build())
                            .addService(googletag.pubads());
                        googletag.display("ad_middle1");
                    });
                </script>
            </div>

            <!-- =========================================
               BOTONES DE NAVEGACIÓN FINAL
               ========================================= -->
            <div class="botones-navegacion-final" style="max-width: 800px; margin: 40px auto; padding: 0 20px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                
                <a href="<?php echo home_url('/'); ?>" class="btn-regresar-home" style="background-color: #01162a; color: #ffffff; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; border: 1px solid rgba(255,255,255,0.2); transition: background 0.3s ease;">
                    &larr; Volver al Home
                </a>

                <a href="https://www.biobiochile.cl" target="_blank" class="btn-ir-biobio" style="background-color: #004687; color: #ffffff; padding: 12px 25px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: background 0.3s ease;">
                    Ir a BioBioChile &rarr;
                </a>

            </div>

        </div>

        <!-- NAVEGACION ENTRE POSTS -->
        <section class="siguiente-evento">
            <div class="evento-nav-top">
                <?php $prev = get_previous_post(); ?>
                <?php if ($prev): ?>
                    <a class="nav-btn prev" href="<?php echo get_permalink($prev->ID); ?>">
                        <span class="arrow">&lt;</span>
                        <div class="nav-text">
                            <p class="label">Anterior</p>
                            <p class="nombre"><?php echo $prev->post_title; ?></p>
                        </div>
                    </a>
                <?php endif; ?>

                <?php $next = get_next_post(); ?>
                <?php if ($next): ?>
                    <a class="nav-btn next" href="<?php echo get_permalink($next->ID); ?>">
                        <span class="arrow">&gt;</span>
                        <div class="nav-text">
                            <p class="label">Siguiente</p>
                            <p class="nombre"><?php echo $next->post_title; ?></p>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </section>

        <!-- Carrusel inferior -->
        <div class="text-revisa-los-ultimos mx-auto" style="text-align: center; font-size: 1.5rem; font-family: 'Merriweather', serif; color: #ffffff; margin: 40px 0 25px 0;">
            <strong>Revisa las últimas notas</strong>
        </div>

        <section class="eventos-section" style="max-width: 1300px; margin: 0 auto 50px auto; padding: 0 20px;">
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

                            $content_post = apply_filters('the_content', get_the_content());
                            preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $content_post, $matches_h);
                            $titulo_nota = !empty($matches_h[1]) ? strip_tags($matches_h[1]) : get_the_title();

                            if (has_post_thumbnail()) {
                                $img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            } else {
                                $img = get_template_directory_uri() . '/assets/img/default-evento.png';
                            }
                    ?>
                            <div class="swiper-slide">
                                <div class="evento-card-wrapper">
                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                                        <div class="evento-img-container">
                                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($titulo_nota); ?>">
                                        </div>
                                        <div style="padding: 15px; flex-grow: 1; display: flex; align-items: center;">
                                            <p class="evento-nombre-texto"><?php echo esc_html($titulo_nota); ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
        </section>

    </main>

    <aside class="ad-right-container">
        <div class="ad-right" id="ad_sky" style="display: none;">
            <script>
                googletag.cmd.push(() => {
                    googletag.defineSlot('/1098385/biobiocl/ad_sky', [], 'ad_sky')
                        .defineSizeMapping(googletag.sizeMapping()
                            .addSize([992, 0], [160, 600])
                            .build())
                        .addService(googletag.pubads());
                    googletag.display("ad_sky");
                });
            </script>
        </div>
    </aside>
</div>

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