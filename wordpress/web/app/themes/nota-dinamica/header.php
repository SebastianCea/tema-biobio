<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://libs.biobiochile.cl/bbcl/fontawesome-pro-5.0.9/css/fontawesome-all.min.css" />
    <?php wp_head(); ?> 
</head>

<?php 
// Lógica exclusiva para el HEADER
$color_header = '#01162a'; 
$tema_header = 'oscuro';

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

    <!-- ESTILOS AUTOCONTENIDOS DEL HEADER (Ancho completo, centrado y zoom en redes) -->
    <style>
        .header-principal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 60px !important;
            z-index: 1000 !important;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        .contenedor-header {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            box-sizing: border-box;
        }
        .logo-sitio {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
        }
        .burger-btn {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.4rem;
            cursor: pointer;
            z-index: 100;
        }

        /* EFECTO ZOOM EN REDES SOCIALES */
        .rrss-menu a, .mobile-rrss a {
            display: inline-block;
            transition: transform 0.3s ease;
        }
        .rrss-menu a:hover, .mobile-rrss a:hover {
            transform: scale(1.25);
        }

        @media (max-width: 768px) {
            .burger-btn {
                display: block !important;
                position: absolute !important;
                right: 15px !important;
            }
            .rrss-menu, .search-desktop, .search-icon, .header-divider {
                display: none !important;
            }
            .contenedor-header {
                padding: 0 15px !important;
            }
        }
    </style>

    <header class="header-principal" data-tema="<?php echo esc_attr($tema_header); ?>" style="background-color: <?php echo esc_attr($color_header_rgba); ?> !important;">
        <div class="contenedor-header">
            
            <!-- Logo principal al centro -->
            <div class="logo-sitio">
                <a href="<?php echo home_url('/'); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/BioBio/logo-biobio.png" alt="BioBioChile" class="imagen-logo" style="height: 25px; width: auto; filter: brightness(0) invert(1);">
                </a>
            </div>

            <!-- BOTÓN BURGER (Móvil) -->
            <button class="burger-btn" id="burgerToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- HEADER ESCRITORIO ITEMS -->
            <div class="header-right" style="display: flex; align-items: center; gap: 20px; margin-left: auto; z-index: 10;">

                <!-- Buscador Desktop Plegable -->
                <div class="search-desktop" id="searchDesktop" style="display: none; width: 200px;">
                    <form action="<?php echo home_url('/'); ?>" method="get" style="display: flex;">
                        <input type="text" name="s" placeholder="Buscar nota..." class="input-buscar" style="width: 100%; padding: 5px 10px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.3); background: rgba(0,0,0,0.3); color: #fff; font-size: 0.85rem; outline: none;">
                    </form>
                </div>

                <button class="search-icon" id="searchToggle" style="background: none; border: none; color: #fff; font-size: 1.1rem; cursor: pointer;" title="Buscar">
                    <i class="fal fa-search"></i>
                </button>

                <span class="header-divider" style="width: 1px; height: 18px; background: rgba(255,255,255,0.2);"></span>

                <!-- Redes sociales con efecto zoom integrado -->
                <nav class="rrss-menu" style="display: flex; gap: 22px; align-items: center;">
                    <a href="https://www.facebook.com/RadioBioBio" target="_blank" style="color: #fff; font-size: 0.9rem; text-decoration: none;"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/biobio" target="_blank" style="color: #fff; font-size: 0.9rem; text-decoration: none;"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/biobiochile/" target="_blank" style="color: #fff; font-size: 0.9rem; text-decoration: none;"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCuvM3c8rmdApmk-g22shZ7w" target="_blank" style="color: #fff; font-size: 0.9rem; text-decoration: none;"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.linkedin.com/company/biobiochile/" target="_blank" style="color: #fff; font-size: 0.9rem; text-decoration: none;"><i class="fab fa-linkedin-in"></i></a>
                </nav>

            </div>
        </div>
    </header>

    <!-- Overlay oscuro para menú móvil -->
    <div id="menuOverlay" class="menu-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.6); z-index: 1050;"></div>

    <!-- Menú lateral deslizable (Móvil) -->
    <div id="sideMenu" class="side-menu" style="position: fixed; top: 0; right: -300px; width: 280px; height: 100vh; background: #01162a; z-index: 1100; transition: right 0.3s ease; box-shadow: -5px 0 25px rgba(0,0,0,0.5); padding: 25px; display: flex; flex-direction: column; gap: 25px;">
        
        <div class="side-menu-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 15px;">
            <span style="color: #fff; font-weight: bold; font-size: 1.1rem; font-family: 'Merriweather', serif;">Menú</span>
            <button id="closeMenu" class="close-btn" style="background: none; border: none; color: #fff; font-size: 1.3rem; cursor: pointer;">✕</button>
        </div>

        <div class="side-menu-content" style="display: flex; flex-direction: column; gap: 25px;">
            
            <!-- Buscador en menú móvil -->
            <form action="<?php echo home_url('/'); ?>" method="get" style="display: flex; gap: 5px;">
                <input type="text" name="s" placeholder="Buscar nota..." style="flex: 1; padding: 10px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.3); background: rgba(0,0,0,0.3); color: #fff; outline: none;">
                <button type="submit" style="background: #004687; color: #fff; border: none; padding: 0 15px; border-radius: 4px; font-weight: bold; cursor: pointer;"><i class="fal fa-search"></i></button>
            </form>

            <!-- Redes sociales en menú móvil -->
            <div class="mobile-rrss" style="display: flex; justify-content: space-around; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.15);">
                <a href="https://www.facebook.com/RadioBioBio" target="_blank" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-facebook-f"></i></a>
                <a href="https://x.com/biobio" target="_blank" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.instagram.com/biobiochile/" target="_blank" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCuvM3c8rmdApmk-g22shZ7w" target="_blank" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-youtube"></i></a>
                <a href="https://www.linkedin.com/company/biobiochile/" target="_blank" style="color: #fff; font-size: 1.2rem;"><i class="fab fa-linkedin-in"></i></a>
            </div>

        </div>
    </div>

    <!-- Script JavaScript interactivo -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchToggle = document.getElementById('searchToggle');
        const searchDesktop = document.getElementById('searchDesktop');
        const burgerToggle = document.getElementById('burgerToggle');
        const sideMenu = document.getElementById('sideMenu');
        const closeMenu = document.getElementById('closeMenu');
        const menuOverlay = document.getElementById('menuOverlay');

        if (searchToggle && searchDesktop) {
            searchToggle.addEventListener('click', function() {
                if (searchDesktop.style.display === 'none' || searchDesktop.style.display === '') {
                    searchDesktop.style.display = 'block';
                    searchDesktop.querySelector('input').focus();
                } else {
                    searchDesktop.style.display = 'none';
                }
            });
        }

        if (burgerToggle && sideMenu && menuOverlay) {
            burgerToggle.addEventListener('click', function() {
                sideMenu.style.right = '0';
                menuOverlay.style.display = 'block';
            });
        }

        function cerrarMenu() {
            if (sideMenu && menuOverlay) {
                sideMenu.style.right = '-300px';
                menuOverlay.style.display = 'none';
            }
        }

        if (closeMenu) closeMenu.addEventListener('click', cerrarMenu);
        if (menuOverlay) menuOverlay.addEventListener('click', cerrarMenu);
    });
    </script>