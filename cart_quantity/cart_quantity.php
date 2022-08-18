<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Cart_quantity
 *
 * @wordpress-plugin
 * Plugin Name:       cart Quantity
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Harrys
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cart_quantity
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CART_QUANTITY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cart_quantity-activator.php
 */
function activate_cart_quantity() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cart_quantity-activator.php';
	Cart_quantity_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cart_quantity-deactivator.php
 */
function deactivate_cart_quantity() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cart_quantity-deactivator.php';
	Cart_quantity_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cart_quantity' );
register_deactivation_hook( __FILE__, 'deactivate_cart_quantity' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cart_quantity.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cart_quantity() {

	$plugin = new Cart_quantity();
	$plugin->run();

}
function updateQty(){
	add_action( 'wp_head' , function() {

	?>
		<style>
		.woocommerce button[ name = "update_cart" ],
		.woocommerce input[ name=  "update_cart" ] {
			display: none;
		}
		</style>
	<?php
		
	} );
	
	add_action( 'wp_footer', function() {

		?><script>
		jQuery( function( $ ) {
			let timeout;
			$( '.woocommerce' ).on( 'change' , 'input.qty' , function() {
				if ( timeout !== undefined ) {
					clearTimeout( timeout );
				}
				timeout = setTimeout(function() {
					$( "[name='update_cart']" ).trigger( "click" ); 
				}, 2000 ); 
			});
		} );
		</script><?php
		
	} );

}
updateQty();
run_cart_quantity();
