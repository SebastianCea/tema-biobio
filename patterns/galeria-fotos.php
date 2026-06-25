<?php
/**
 * Title: Galería de Fotos
 * Slug: biobio/galeria-fotos-v3
 * Categories: biobio-secciones
 * Description: Galería de imágenes con diseño dinámico.
 */
?>
<!-- wp:group {"tagName":"section","className":"seccion-normal","layout":{"type":"constrained"}} -->
<section class="wp-block-group seccion-normal">
    
    <!-- wp:gallery {"columns":3,"linkTo":"none","className":"galeria-dinamica"} -->
    <figure class="wp-block-gallery has-nested-images columns-3 is-cropped galeria-dinamica">
        
        <!-- wp:image -->
        <figure class="wp-block-image"><img src="/wordpress/wp-content/themes/tema-biobio/images/imagen-prueba.png" alt="Foto 1"/></figure>
        <!-- /wp:image -->

        <!-- wp:image -->
        <figure class="wp-block-image"><img src="/wordpress/wp-content/themes/tema-biobio/images/imagen-prueba2.jpg" alt="Foto 2"/></figure>
        <!-- /wp:image -->

        <!-- wp:image -->
        <figure class="wp-block-image"><img src="/wordpress/wp-content/themes/tema-biobio/images/imagen-prueba.png" alt="Foto 3"/></figure>
        <!-- /wp:image -->

    </figure>
    <!-- /wp:gallery -->

</section>
<!-- /wp:group -->