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
define('DB_NAME', 'wp-new34');

/** MySQL database username */
define('DB_USER', 'knew22__.cvenang');

/** MySQL database password */
define('DB_PASSWORD', 'Kk__)&%22');

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
define('AUTH_KEY',         'Y-+^YW1ZsYd=#+2|5SBPCgs6%v%*-kDOXH%q1pNew:S>Fs)&-8Y>irT3!x@Cx84#');
define('SECURE_AUTH_KEY',  'q)r%k(CxIegD s97H]Y^1qCT|YQJy>YAT %^&w+-*CYU[dOIU`mm@Xx[9P66F}[&');
define('LOGGED_IN_KEY',    '--H7~*?W|+RF8cQe[H|XgT%(ZDoYr3|o$@Klkv~w*!t+bIsC]9v,|+330xx^{;5R');
define('NONCE_KEY',        'J&mYiQU:u,}7<3H|YBZE{WxK[xK4<HHcW_tTbB|7 =A&M^-pej:P@{}Ii:~v?|Tz');
define('AUTH_SALT',        'ObaXJ|:Sp07a+7RD :}:I99n6H~b|v^$XI,E|i-;ZPQNJ#i*5Q~~U,md&D]NSjF#');
define('SECURE_AUTH_SALT', 'GUo|FW&W8@GhvN#T%LgHvao-8.sJb*Q1d5xy!oYp) 6&W2j|!Ct cqz}|XC%svAy');
define('LOGGED_IN_SALT',   '_9gy>i&mqH4pX0IwG;hCoq7rQ+;eY:GmdLiJ@l-VUp,sMWn,OeTC6e.~t+Nu`pq+');
define('NONCE_SALT',       'ap*XZO_a3?K4fE}b/=NFC(%#E)F/|W8scHXqu1j}z>]:xzdMV9mM/8{dRC!&+!m;');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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


