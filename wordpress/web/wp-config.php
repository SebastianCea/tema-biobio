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
 * Authentication unique keys and salts.
 * IMPORTANTE: los valores por defecto de aquí abajo son solo un fallback de emergencia.
 * En producción SIEMPRE deben venir desde las variables de entorno (.env), que ahora
 * sí se pasan correctamente gracias al docker-compose.yml corregido.
 */
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'cambia-esto-genera-en-api.wordpress.org') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'cambia-esto-genera-en-api.wordpress.org') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'cambia-esto-genera-en-api.wordpress.org') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'cambia-esto-genera-en-api.wordpress.org') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'cambia-esto-genera-en-api.wordpress.org') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'cambia-esto-genera-en-api.wordpress.org') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'cambia-esto-genera-en-api.wordpress.org') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'cambia-esto-genera-en-api.wordpress.org') );

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