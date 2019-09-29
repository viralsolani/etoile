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
define( 'DB_NAME', 'wp_etoile' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'August@2019' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/e((g#aAd<e+`_5$c:;V.shiN5Jxa.oq0mm6xQH&$<l9Vm)]p q)/rtNgds,/x}o' );
define( 'SECURE_AUTH_KEY',  'kNwoqFn;PrDzgsYvD.9n(=<ciG>nbEHZ~U AMl&H[};K=|]nGv IC]u_g2O2+LmY' );
define( 'LOGGED_IN_KEY',    'hBVr#y##heDbGT.nm}+-bs[i;R__+!5r[]W5g>gb3$wYU-k1QIXTjb9x}oU.{--U' );
define( 'NONCE_KEY',        '*$JSW!s.0ue&uMc}SPK#!Vh ^K2D DjUmZ!@LP9xZ (ag?I ceu%{h`>Jkj$b2Uj' );
define( 'AUTH_SALT',        '#X[,F8tRA+&}JXQtlm{#@zC2en6W;N= o53S[()x8r~#jY-W@?SHCX!(SG.Ic^NW' );
define( 'SECURE_AUTH_SALT', 'S2=53gj+O0X*6&Y!GGr`_Ut2@Z._Z[7K0!(8apj.wayuIWB*G}]2xI.)$q&3F{EF' );
define( 'LOGGED_IN_SALT',   'Iv|BJqvmIS_&1/$%3w_p&#Vl+E7@+L}DQ=N=k8-`f`MJ@~g8[~>bj<gw_u4oxe8t' );
define( 'NONCE_SALT',       'R^o)1%qvA+5i0cNk&`?cJ=k{;#0qg26e]q|]g>~[Yp7;brImV5$F#KlM{4C|2{Ih' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

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
define( 'WP_DEBUG', false );
define( 'WP_AUTO_UPDATE_CORE', false );
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}


