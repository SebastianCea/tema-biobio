<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @package WordPress
 */

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** Database settings ** //
define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'bbcl_dinamicas') );
define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'wpuser') );
define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'wppassword') );
define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'sebadb') );
define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8mb4') );
define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );

/**
 * Authentication unique keys and salts
 */
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'r|,O.{1|}rUB9g%a#Rprui0F~]dTnJ`]9xVIC jY#-mdRR-4{`r&ux}!^BS)&]5x') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'eW<Ok_wddeBIX(]7GEI4r=7,6jc8AbBhOPk>D8w-VvkB&VDp:4/u:fjX**_JP/M*') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    '<m0t7a])juU:Z7x2wGVP<HKNl`mjC>s|zuu;*+ub$bS`YiJBbtW#FW9P}8#KqHBP') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        '8apg-q|Vs0,%?]hQz?c&q|Fucc[l):LX-z_rbU=gU~/]Vy5Vwdj{!Ptc]KIE|:kk') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        '#g#F2$An|]sZs!%?~H,W8umh;V<q.&Ti6_<8o]#(OT(&<oC0X3w-5-K?-8A}/Z8p') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', ')P8_f |~C?D|8B 7>*fyS+{T5R7x[mA-ThzUig[iq*o?L=&-[PCP>^VJi|h6|:O4') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   '2NwEL)viJoY:%`So&%>@P.e9<2O)W+Q4as2< X2+*?WegGpN>T-$i-kYBm3soDal') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '?Fzr|:8*jS*E}vVF:f,5+./pV)3lVpyW,?ln1jM._{3Qs$}scF:`82u`-Y$x?%>m') );

/**
 * WordPress database table prefix.
 */
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

/**
 * For developers: WordPress debugging mode.
 * En producción esto debe quedar en '' (falso) — así llega por defecto desde el .env.
 */
define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', '') );

/* Add any custom values between this line and the "stop editing" line. */

// Si estamos detrás de un proxy inverso y usando HTTPS, avisarle a WordPress
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

// Definir la carpeta de contenido personalizada
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/app' );

// Detectar el protocolo real (http o https) en vez de forzar siempre http://
// Esto es importante porque el sitio corre con ads y debería servirse por HTTPS.
$biobio_protocolo = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) ? 'https://' : 'http://';

define( 'WP_CONTENT_URL', $biobio_protocolo . $_SERVER['HTTP_HOST'] . '/app' );
define( 'WP_HOME', $biobio_protocolo . $_SERVER['HTTP_HOST'] );
define( 'WP_SITEURL', $biobio_protocolo . $_SERVER['HTTP_HOST'] );
define('FS_METHOD', 'direct');
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';