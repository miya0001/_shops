<?php
/**
 * Plugin Name:     _shops
 * Plugin URI:      https://github.com/miya0001/_shops
 * Author:          Takayuki Miyauchi
 * Author URI:      https://github.com/miya0001/
 * Text Domain:     _shops
 * Domain Path:     /languages
 * Version:         nightly
 *
 * @package         _shops
 */

namespace _Shops;

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

add_action( 'init', '_Shops\activate_autoupdate' );

function activate_autoupdate() {
	$plugin_slug = plugin_basename( __FILE__ ); // e.g. `hello/hello.php`.
	$gh_user = 'miya0001';                      // The user name of GitHub.
	$gh_repo = '_shops';       // The repository name of your plugin.

	// Activate automatic update.
	new \Miya\WP\GH_Auto_Updater( $plugin_slug, $gh_user, $gh_repo );
}

register_activation_hook( __FILE__, '\_Shops\activation' );

function activation() {
	CPT::get_instance()->register_post_type();
	flush_rewrite_rules();
}

add_action( 'plugins_loaded', function() {
	CPT::get_instance();
} );
