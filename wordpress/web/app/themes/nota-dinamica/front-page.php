<?php
/**
 * Template Name: Portada Estilo Diario (Home)
 * Description: Página principal estructurada con consultas dinámicas para notas.
 */

get_header(); 
?>

<main class="contenido-principal portada-periodistica">

    <!-- =========================================
       1. NOTICIA DESTACADA (LEAD STORY)
       ========================================= -->
       <?php
    $args_principal = array(
        'posts_per_page' => 1,
        'post_status'    => 'publish'
    );
    $query_principal = new WP_Query($args_principal);

    if ($query_principal->have_posts()) :
        while ($query_principal->have_posts()) : $query_principal->the_post();
            
            // Extraer el primer párrafo del contenido o usar el extracto por defecto
            $content = apply_filters('the_content', get_the_content());
            preg_match('/<p[^>]*>(.*?)<\/p>/is', $content, $matches);
            $primer_texto = !empty($matches[1]) ? strip_tags($matches[1]) : get_the_excerpt();
    ?>
        <section class="seccion-lead-story">
            <div class="contenedor-lead">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="imagen-lead">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('large'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <div class="info-lead">
                    <span class="etiqueta-categoria">Destacada</span>
                    <h1 class="titulo-lead">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h1>
                    <p class="extracto-lead">
                        <?php echo wp_trim_words($primer_texto, 25); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="enlace-leer-mas">Leer nota completa &rarr;</a>
                </div>
            </div>
        </section>
    <?php 
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <!-- =========================================
       2. GRILLA DE ÚLTIMAS COBERTURAS
       ========================================= -->
    <section class="seccion-grilla-noticias">
        <div class="contenedor-grilla-header">
            <h2>Últimas Coberturas</h2>
        </div>
        
        <div class="grilla-secundaria">
            <?php
            $args_secundarias = array(
                'posts_per_page' => 3,
                'offset'         => 1, // Salta la primera noticia que ya está en destacadas
                'post_status'    => 'publish'
            );
            $query_secundarias = new WP_Query($args_secundarias);

            if ($query_secundarias->have_posts()) :
                while ($query_secundarias->have_posts()) : $query_secundarias->the_post();
            ?>
                <article class="tarjeta-noticia">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="tarjeta-imagen">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="tarjeta-contenido">
                        <h3 class="tarjeta-titulo">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <span class="fecha-tarjeta"><?php echo get_the_date(); ?></span>
                    </div>
                </article>
            <?php 
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>