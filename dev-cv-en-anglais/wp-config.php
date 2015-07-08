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
define('DB_NAME', 'sw2c_wp455');

/** MySQL database username */
define('DB_USER', 'sw2c_wp455');

/** MySQL database password */
define('DB_PASSWORD', 'sc1dPf70pS');

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
define('AUTH_KEY',         '4qqpfsn9kgoqrougizvw9vlyd5jifw7nl3bgejzzxjaiakg1hyz4sv15qjou66wl');
define('SECURE_AUTH_KEY',  'y9doavmegoamewf25zhhqipn1g4i7dkn3cqzy9tntm6rpgp0r1oo5vyau1ejkbeg');
define('LOGGED_IN_KEY',    '7cpgn526xkgr4ktirt1mr6dn4abfhrd5rns1oot6cudzggwkc6owoymelfey8unc');
define('NONCE_KEY',        '1hwwvhpapiqdoqe6bihoesitcy5iqydxtrcziis4rnyr5sgmypdmav5rgulqbxpw');
define('AUTH_SALT',        '4ghcbuxwlvidgbr1mk2co1r7tqq5pkvulywhg46uorposjh6rs6ulhy2hxiuh12y');
define('SECURE_AUTH_SALT', 'hdvekeiuqlrcn4lfqmdxzviiabmtkxemslxwezfkux4qhorkr5h3xismbtlvvkhf');
define('LOGGED_IN_SALT',   'uqgbsygrmitczudvvvlaugphhcyhxoolj8jsercsya0hlkfybbn4z8gtufil6hsr');
define('NONCE_SALT',       '8u4ftu5vmf2uehavctjh9pmclblcqfd2wmmry1ryzzseqi27fk7isxzmwsewjykh');

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
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
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