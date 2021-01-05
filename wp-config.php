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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '?0MAjB-mKu@1Cgr-qQ.-@-qy)cqI#Y0Vti0_DyGYX$h}OW2bp9mhnB46qi_U5Q?u' );
define( 'SECURE_AUTH_KEY',  '6u84@jA(#Esm]c[U|=p=$;l@LR6Z7-hOnClCP`xv,o:bZNA@V6soZGk9.a3 V`K+' );
define( 'LOGGED_IN_KEY',    'alS!)lY$2YN5#zTMd6_!n!EOWKi3yyZqMWO%s+6#B()wK968_PBZt${&Qmtz^tvx' );
define( 'NONCE_KEY',        '8fS8/<c{6_CJ#Ytwzhpi~en&C-iro?cly}.rOp>T[NZHKp(ep)L4`@LB^kFFZQ|f' );
define( 'AUTH_SALT',        'XWwYEk:?S/@8PV~txP2eGGIs>,$G]^ZFLf/#Jiyw`?ML&I^O5W{t3AObGQjwQb8e' );
define( 'SECURE_AUTH_SALT', 'yE36C%zJb4ADkMGl?T</G]GUnl<i%#&]vBvILuSi-6o#[8(Jc}n_W_Yw`SjOVuJ.' );
define( 'LOGGED_IN_SALT',   'bg?Z/]`[dcRmv9(SU E,_jIz9~C~A[/p:P,AVM;lcQc`=dW^pycaTOerk1D8^%7]' );
define( 'NONCE_SALT',       'IZz&F:iim?=Q`yT0WZGZu;G/Cx,7{07&^DDOyx,t JY*zK{d[=wyUXr=HAw>fY8*' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
