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
define('DB_NAME', 'im_photoravel');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define( 'WP_AUTO_UPDATE_CORE', false );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '?}H&H`vo~}R)OP]If7R,E.#?AWsV<3Z*owTd(=3]=0s)2F5#TP,IsL5V.ue/kv:}');
define('SECURE_AUTH_KEY',  '|G6*4hx =erBK8uLm<`=7nl^JuU7~vmW/,psVHP3>jnzzKWkiIJ5?fH34J8#A&i ');
define('LOGGED_IN_KEY',    ';+1]BsVI7x`[lZVS(HZpfJ7K[`JEgcB%k(M;xj8!0z]o@~$/8i4vl0)k d:-#`vK');
define('NONCE_KEY',        'W_d3lI%hr-E;_0I@(!%cj#EH_TW)tzh-(BoHepZXG`;#?8T2O4pJms+9aTfG9t9%');
define('AUTH_SALT',        '1Qy,l}pV>VJoI0qv|J$_1c|q^.&oJy(u~7))San&)@/Q:y[+Ru9i 27(xn={wL!A');
define('SECURE_AUTH_SALT', 'lORi$.cuJx>1G)Pq`VqcPvt4j1J7>>ac46:r@+p2W4RU_z*FOK37gAa^XFBWa,4I');
define('LOGGED_IN_SALT',   'phM$*v~S-oELLvHku6LslH<xDKicz1T.s_VknbtMpAjh66:FZ:Xl}dC)*|CJ>6VE');
define('NONCE_SALT',       'umq?T}?+LjcU`r&Jgp.Ixz3JuF=ZA>TVK)1ss@6>WYd[u.@EV/J~o}Nc-h#&*v_D');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'im_';

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
