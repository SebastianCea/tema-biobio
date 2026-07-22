<?php
/**
 * Template Name: Portada Estilo Diario (Home)
 * Description: Portada avanzada estructurada. (Sin afectar header/footer global)
 */

get_header(); 
?>

<!-- SCRIPT PARA FORZAR MODO OSCURO SOLO EN LA PORTADA -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pintar el fondo del body de azul oscuro
    document.body.style.setProperty('background-color', '#022c54', 'important');
    
    // Forzar header a modo oscuro
    const header = document.querySelector('.header-principal');
    if(header) {
        header.style.setProperty('background-color', 'rgba(1, 22, 42, 0.95)', 'important');
        header.setAttribute('data-tema', 'oscuro');
    }
    
    // Forzar footer a modo oscuro
    const footer = document.querySelector('.footer-biobio');
    if(footer) {
        footer.style.setProperty('background-color', 'rgba(1, 22, 42, 1)', 'important');
        footer.setAttribute('data-tema', 'oscuro');
    }
});
</script>

<main class="contenido-principal portada-periodistica">

    <!-- =========================================
       1. SECCIÓN SUPERIOR: DESTACADA + ÚLTIMAS NOTAS
       ========================================= -->
    <div class="grid-portada-principal">
        
        <!-- Columna Izquierda: Noticia Destacada -->
        <div class="columna-lead">
            <?php
            $args_lead = array('posts_per_page' => 1, 'post_status' => 'publish');
            $query_lead = new WP_Query($args_lead);

            if ($query_lead->have_posts()) :
                while ($query_lead->have_posts()) : $query_lead->the_post();
                    $content = apply_filters('the_content', get_the_content());
                    preg_match('/<p[^>]*>(.*?)<\/p>/is', $content, $matches_p);
                    $primer_texto = !empty($matches_p[1]) ? strip_tags($matches_p[1]) : get_the_excerpt();
                    
                    preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $content, $matches_h);
                    $titulo_nota = !empty($matches_h[1]) ? strip_tags($matches_h[1]) : get_the_title();
            ?>
                <article class="noticia-lead-principal">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="imagen-lead">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="info-lead">
                        <span class="etiqueta-categoria">Destacado</span>
                        <h1 class="titulo-lead">
                            <a href="<?php the_permalink(); ?>"><?php echo esc_html($titulo_nota); ?></a>
                        </h1>
                        <p class="extracto-lead"><?php echo wp_trim_words($primer_texto, 25); ?></p>
                        <span class="fecha-lead"><?php echo get_the_date(); ?></span>
                    </div>
                </article>
            <?php 
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <!-- Columna Derecha: Últimas Notas -->
        <aside class="columna-ultimas-notas">
            <div class="header-ultimas">
                <h3>Últimas Notas</h3>
            </div>
            <div class="lista-ultimas">
                <?php
                $args_ultimas = array('posts_per_page' => 4, 'offset' => 1, 'post_status' => 'publish');
                $query_ultimas = new WP_Query($args_ultimas);

                if ($query_ultimas->have_posts()) :
                    while ($query_ultimas->have_posts()) : $query_ultimas->the_post();
                        $content = apply_filters('the_content', get_the_content());
                        preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $content, $matches_h);
                        $titulo_nota = !empty($matches_h[1]) ? strip_tags($matches_h[1]) : get_the_title();
                ?>
                    <div class="item-ultima-nota">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="miniatura-ultima">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="texto-ultima">
                            <h4><a href="<?php the_permalink(); ?>"><?php echo esc_html($titulo_nota); ?></a></h4>
                            <span class="fecha-item"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' atrás'; ?></span>
                        </div>
                    </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </aside>
    </div>

    <!-- =========================================
       2. SECCIONES POR CATEGORÍA
       ========================================= -->
    <?php
    $categorias_portada = array(
        array('slug' => 'deportes', 'nombre' => 'Deportes'),
        array('slug' => 'cultura', 'nombre' => 'Cultura'),
        array('slug' => 'entretencion', 'nombre' => 'Entretención')
    );

    foreach ($categorias_portada as $cat) :
        $args_cat = array('posts_per_page' => 3, 'category_name' => $cat['slug'], 'post_status' => 'publish');
        $query_cat = new WP_Query($args_cat);

        if ($query_cat->have_posts()) :
    ?>
        <section class="seccion-categoria-bloque">
            <div class="header-seccion-cat">
                <h2><?php echo esc_html($cat['nombre']); ?></h2>
                <!-- Se eliminó el botón "Ver más" -->
            </div>
            
            <div class="grilla-categoria">
                <?php 
                while ($query_cat->have_posts()) : $query_cat->the_post(); 
                    $content = apply_filters('the_content', get_the_content());
                    preg_match('/<h[1-3][^>]*>(.*?)<\/h[1-3]>/is', $content, $matches_h);
                    $titulo_nota = !empty($matches_h[1]) ? strip_tags($matches_h[1]) : get_the_title();
                ?>
                    <article class="tarjeta-categoria-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="imagen-cat-item">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="contenido-cat-item">
                            <h3><a href="<?php the_permalink(); ?>"><?php echo esc_html($titulo_nota); ?></a></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                            <span class="fecha-tarjeta"><?php echo get_the_date(); ?></span>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php 
        endif;
    endforeach; 
    ?>

</main>

<?php get_footer(); ?>