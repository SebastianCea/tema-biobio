<?php get_header(); ?>

    <main class="contenido-principal">
        
        <?php 
        // EL LOOP DE WORDPRESS: Pregunta si hay artículos en la base de datos
        if ( have_posts() ) : 
            while ( have_posts() ) : the_post(); 
        ?>
            
            <?php the_content(); ?>

        <?php 
            endwhile; 
        else : 
        ?>
            <p>No se encontraron noticias.</p>
        <?php 
        endif; 
        ?>

    </main>

<?php get_footer(); ?>