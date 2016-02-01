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
define('DB_NAME', 'uppload-files');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '_Iwn$@+TX!vpB`5.`*G;q~vWIk&_bVqbx&hsF4%Q^-cR-jFY5vMe!xX&|K3Tu.+-');
define('SECURE_AUTH_KEY',  'dDc=WP9%gZ/^3N~zld3/W%@,U1`-3BE}b_U_YUTS<Q1F,yi-a{:bPOK3IVR+FJ93');
define('LOGGED_IN_KEY',    'vzi?6u]{([|~1,:FfIPKkCp7Z}{h`##+P]##~Y-5Nk8ok|T.^a/qCNzRbc#3[(dq');
define('NONCE_KEY',        '2]zsJ %o92e)`*v@tNb T|hB1j8H 9hV*xBD7%OL=-d/YXYsGx:y(]5q+Bz!-`QW');
define('AUTH_SALT',        '2gvgh/S-fZzJ%8h-#R)l!Hecl^f{J-&.J,_,J%2ajQ$)Tq~Ma@x0PU>X|Lpa?G_a');
define('SECURE_AUTH_SALT', '7fuR<qtO21L2;ZB/+E~0-P- tD>0hsTIfTWoL[<p+?6r!fml<pN.s~:7U(dl+k7/');
define('LOGGED_IN_SALT',   'Sg-1R>m*xQ7P0D+2ayL+hUWy@x9.$0WQ!p`41b=kJ,UC(TQ5_vf}#Qh=bln2IzLK');
define('NONCE_SALT',       ')J%4g7a_T4:fpfV~/[HR1>T.V8ujyme[ZUnm%VD,-^vbi3.R+J<X-g2fH+KmT^Ba');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
