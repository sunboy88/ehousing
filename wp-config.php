<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'thuechun_hanoi');

/** MySQL database username */
define('DB_USER', 'thuechun_thanhwp');

/** MySQL database password */
define('DB_PASSWORD', 'thanh123467ok');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'de[UF]ALh^ Fg~b/Q0{>{fu>/GW/4*7Gp>2)c{DRB9BJ[UvxxeK%KRYkcLn#P@AD');
define('SECURE_AUTH_KEY',  'i4PuhBg+(g@dEE1-E7AymFYc.Ydxx8B-4TS~|!#Tj64^rnF=cUo^s>_^^f>Zk^p#');
define('LOGGED_IN_KEY',    'MIopiwk5PkIs@*suoTVRm`46<C=3]gbbhf]W3X<?o]RCIN#%I]Rch3.^-&(&I5Z?');
define('NONCE_KEY',        'bSLCx@=le52-lWokd5hgI=W_YWIP#WC2b@)@>myI]@`seK&,4PIar&u, Uc!2/U ');
define('AUTH_SALT',        '%F_,?#993xJ3$Eo{x*J|TZ_K0t|Cj&#M;O>sr%9^hLQL@~@7{szL-M*PTAr/l?)#');
define('SECURE_AUTH_SALT', 'HjYJ7%2Jq1Ca/~xG$|7tmD=x6Do8-FqME8g0eX=bfmRzxoYQKv`!$)lVS<P03:(^');
define('LOGGED_IN_SALT',   'Kn=)b@zr(UM(F3/!fr!M=9oAJN4dEdRh>&TRSniLC8f~ew,bI$CzSQ?^YYgM2UX%');
define('NONCE_SALT',       'V# a|n9P@f57U=DcVR(Hc*N08G.f?}|8 u#]n64 ;pACNgQ93Ox/nZT%3w(ce[Ia');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'thanh_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
