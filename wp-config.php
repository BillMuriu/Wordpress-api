<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'U<4~> KL{:8i`HG&^ezgCa>kl;^%-#<g+:BBn>@1&vQB_ 7xK:PoKG$K7g1?`98i' );
define( 'SECURE_AUTH_KEY',   'BnT*}t@>1gGB~=I7G-k77d5L]WHp}_}#Ld qlbAfqx_x&}f4O~Lx*4on=Q_).B,g' );
define( 'LOGGED_IN_KEY',     'q^6gd`e^$PX,_!hLj^  :m!9wilC+,Cpa|Z>10D:.+;Ko^Z6Z9U)x!L[(8h$Ba&i' );
define( 'NONCE_KEY',         'OxOHRPJN6|9YyUK*#UebDOz{ytx5:ywy.kd*U9SC-~pX;>(,0!=1|XTb|&P%VcfY' );
define( 'AUTH_SALT',         'F?dX>|H#9! Ve%ZbC$U9517a0~cjTJ~l=vGR*{?[v;WC}Wc:0AZq_]<5-v`<,y;X' );
define( 'SECURE_AUTH_SALT',  '(bp5nce:Wz73&C|ou9RwXgS+55l6fCf b/zFuDyI;<4e@p?b^(0@a`qMDW=067Z@' );
define( 'LOGGED_IN_SALT',    '6A&^+,&Xj0PR4PxSSo.amY>EGLL]RE.>WCw[@K4**wdw0N8Y3e+=3T7fvzppt$ M' );
define( 'NONCE_SALT',        'fj[8xX+1sR>pRy1; =.HEBd[QDXG-$#n^ZXxw!0ar^h]V)d+4|,AaF(=Rv@-Dj,!' );
define( 'WP_CACHE_KEY_SALT', '?%_7.9t]v[e/.*}]VU7Ug+qnE54~-}r0<8(|U_sv[4QjL4?eEa)n{{m;}Qt8<%S,' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
