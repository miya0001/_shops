<?php
/**
 * Plugin Name:     _shops
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     _shops
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         _shops
 */

namespace _Shops;

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

register_activation_hook( __FILE__, '\_Shops\activation' );

function activation() {
	CPT::get_instance()->register_post_type();
	flush_rewrite_rules();
}

add_action( 'plugins_loaded', function() {
	CPT::get_instance();
} );