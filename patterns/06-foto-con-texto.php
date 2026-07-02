<?php
/**
 * Title: Foto con Texto
 * Slug: biobio/foto-con-texto
 * Categories: biobio-secciones
 * Description: Una foto al lado de un bloque de texto. El periodista puede invertir la posición.
 */
?>
<!-- wp:columns {"className":"modulo-flexible texto-izquierda"} -->
<div class="wp-block-columns modulo-flexible texto-izquierda">
    <!-- wp:column {"className":"caja-texto"} -->
    <div class="wp-block-column caja-texto">
        <!-- wp:heading {"level":3,"className":"comillas-gigantes"} -->
        <h3 class="wp-block-heading comillas-gigantes">"</h3>
        <!-- /wp:heading -->
        
        <!-- wp:paragraph {"className":"texto-modulo"} -->
        <p class="texto-modulo">Escribe aquí el texto que acompaña a la foto. Puede ser una cita, un dato relevante o un párrafo de la nota.</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"className":"caja-media"} -->
    <div class="wp-block-column caja-media">
        <!-- wp:image -->
        <figure class="wp-block-image"><img src="/wordpress/wp-content/themes/tema-biobio/images/imagen-prueba2.jpg" alt="Sube tu imagen aquí"/></figure>
        <!-- /wp:image -->
    </div>
    <!-- /wp:column -->
</div>
<!-- /wp:columns -->