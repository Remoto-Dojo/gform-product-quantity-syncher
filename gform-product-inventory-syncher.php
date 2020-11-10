<?php
/**
 * Plugin Name: Gravity Forms Product And Quantity Syncher
 * Plugin URI: https://github.com/Remoto-Dojo/gform-product-quantity-syncher
 * Description: A syncher service for Gravity Forms Product with Gravity Forms Quantity Limits as inventory.
 * Author: RemotoDojo
 * Author URI: https://remotodojo.com
 * Version: 0.1.0
 *
 * @package RemotoDojo\GformProductInventorySyncher
 */

namespace RemotoDojo\GFormProductInventorySyncher;

if ( ! class_exists( 'RemotoDojo\GFormProductInventorySyncher\Plugin' ) ) {
	try {
		require_once plugin_dir_path( __FILE__ ) . 'src/autoload.php';

		spl_autoload_register( __NAMESPACE__ . '\autoload' );
	} catch ( \Throwable $e ) {
		// @TODO Implement actual error handling.
		return;
	}
}

//add_action( 'plugins_loaded', [ new Plugin(), 'run' ] );

// If Gravity Forms is loaded, bootstrap our plugin service.
add_action( 'gform_loaded', [ new Plugin(), 'run' ], 5 );
