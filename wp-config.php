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
define('DB_NAME', 'odiney');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '29232923');

/** MySQL hostname */
define('DB_HOST', 'localhost:3307');

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
define('AUTH_KEY',         '$oXe;egFi7:nG#9F/@u7`N] D<X17m$+#.s&)Aa:PIN%c,_`+?^I-4!R8KB1]s>e');
define('SECURE_AUTH_KEY',  ';vC1|GbLGlJj.JXP1DJxfyr?+wq*FjWQh{QAZ<36mCHt!4ei~-V&-;V8-M~Dv*|@');
define('LOGGED_IN_KEY',    ':||RxX|kj-Y|M69PhC@+iQ`Oy%jKb.H%ir^#9L,R,,M7!yqZqMCcA IG0t@(Oqr]');
define('NONCE_KEY',        '!qOKj4A-OOgk,!R$4!AFcIIR%;!1ofO=b 1-HXB%V+~ i,*!TD<AwbMQ^^/P+6c#');
define('AUTH_SALT',        'hzJUI*R:V5fjj=p90e{*Nb3)=m*D2[d<mv*I.1^HMeJMwH.=tZTx-/-}^Qpv%K:{');
define('SECURE_AUTH_SALT', 'T:-xzj}Z~&ETNnj`-OkQ9|A/4DcFmpuT:p+4).8pC2B6kqd(JC_;M?e1]KUeih12');
define('LOGGED_IN_SALT',   '}p+aU!]z`^&FuNUh IoY~@5Ru;bm%39||,w*wmoFND-<,9~yR;/rrsr-Ku4lg^ZN');
define('NONCE_SALT',       '_y!?9z=]/<;u$?n;f`tt7%YmjM/LVXSSc3|fswz. VS#4dqnu{;766yID9p`Epgh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
