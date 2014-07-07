<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'victoryb_wpdb');

/** MySQL database username */
//define('DB_USER', 'victoryb_wpuser');
define('DB_USER', 'victoryb_wpuser2');

/** MySQL database password */
//define('DB_PASSWORD', 'Password69');
define('DB_PASSWORD', 'Password696');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'O)Y|$(-X}5LKV*doJ#<-O*XlZ@s;aVeFlsqa8iE8{.2Bp}e5|^e($;^aq0l*brSA');
define('SECURE_AUTH_KEY',  'yx{gas>hoDr-:Ah3$>r*wz>lbEmIy+I$Cp#lq;IFN1:H8|^+oY</<H)^LwQ%t<`~');
define('LOGGED_IN_KEY',    'd9Lk[l)`@,%|^@{(xkt/($Kpjc{1CA&y5EDPq{[+f={NI3em97p*4X>|[!s!&dxT');
define('NONCE_KEY',        'TfOtHtG&sJ,NZ~?7YHj8?*/>TyE.g`R]&=`WtG}] ;9+Xiah-R9)TAg.N-EY$&GX');
define('AUTH_SALT',        'e xV[w=nGOzxFISFESsJWDiiWt>IkA~V |*4jk`gJ)eXCi70VhU}lpk9Y.u*b78J');
define('SECURE_AUTH_SALT', '^]Ojg6Jd-xFWm{;)[KS^lAz_#{!|EV@y9#E[CEZ7niWs2sTIU%t[koMlT|*rmYS7');
define('LOGGED_IN_SALT',   'a#t|P>}%|{=g8@T{+=.&h?`^Ut]Oqz uZ}}%/ji)c|Enyi-xLXr$Kc46UL@_k(Rb');
define('NONCE_SALT',       '`MKeUT<yzr_>+)Mx;&<M.U+,UU*5-azj #Z(m@.@CbY^kG3f#D3|#DrKKw`*Q~J5');



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
